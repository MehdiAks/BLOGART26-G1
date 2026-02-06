#!/usr/bin/env python3
import argparse
import os
import subprocess
from difflib import SequenceMatcher
from typing import Dict, List, Tuple

PROTECTED_TABLES = {
    "THEMATIQUE",
    "STATUT",
    "MOTCLEARTICLE",
    "MOTCLE",
    "MEMBRE",
    "LIKEART",
    "COMMENT",
}

LOGO_TABLE_PATTERNS = ("logo", "logos", "image_logo", "logotype")


def parse_args() -> argparse.Namespace:
    parser = argparse.ArgumentParser(description="Migrate data from old dump to new schema.")
    parser.add_argument("--old-dump", default="/mnt/data/saves.sql")
    parser.add_argument("--new-dump", default="/mnt/data/BLOGART26.sql")
    parser.add_argument("--mysql-host", default=os.getenv("MYSQL_HOST", "127.0.0.1"))
    parser.add_argument("--mysql-port", type=int, default=int(os.getenv("MYSQL_PORT", "3306")))
    parser.add_argument("--mysql-user", default=os.getenv("MYSQL_USER", "root"))
    parser.add_argument("--mysql-password", default=os.getenv("MYSQL_PASSWORD", ""))
    parser.add_argument("--mysql-socket", default=os.getenv("MYSQL_SOCKET", ""))
    parser.add_argument("--old-db", default="old_db")
    parser.add_argument("--new-db", default="new_db")
    parser.add_argument(
        "--strategy",
        choices=["upsert", "truncate"],
        default="upsert",
        help="Idempotency strategy: upsert uses INSERT IGNORE, truncate clears target tables first.",
    )
    parser.add_argument(
        "--dry-run",
        action="store_true",
        help="Generate mapping and SQL without executing inserts.",
    )
    return parser.parse_args()


def mysql_base_cmd(args: argparse.Namespace) -> List[str]:
    cmd = [
        "mysql",
        f"--host={args.mysql_host}",
        f"--port={args.mysql_port}",
        f"--user={args.mysql_user}",
    ]
    if args.mysql_socket:
        cmd.append(f"--socket={args.mysql_socket}")
    return cmd


def run_mysql(args: argparse.Namespace, sql: str, database: str = "") -> None:
    cmd = mysql_base_cmd(args)
    if database:
        cmd.append(database)
    env = os.environ.copy()
    if args.mysql_password:
        env["MYSQL_PWD"] = args.mysql_password
    subprocess.run(cmd, input=sql.encode("utf-8"), env=env, check=True)


def mysql_query(args: argparse.Namespace, sql: str, database: str = "") -> List[List[str]]:
    cmd = mysql_base_cmd(args)
    cmd.extend(["-N", "-B"])
    if database:
        cmd.append(database)
    env = os.environ.copy()
    if args.mysql_password:
        env["MYSQL_PWD"] = args.mysql_password
    result = subprocess.run(cmd, input=sql.encode("utf-8"), env=env, check=True, capture_output=True)
    output = result.stdout.decode("utf-8").strip()
    if not output:
        return []
    rows = [line.split("\t") for line in output.splitlines()]
    return rows


def import_dump(args: argparse.Namespace, database: str, dump_path: str) -> None:
    cmd = mysql_base_cmd(args)
    cmd.append(database)
    env = os.environ.copy()
    if args.mysql_password:
        env["MYSQL_PWD"] = args.mysql_password
    with open(dump_path, "rb") as handle:
        subprocess.run(cmd, stdin=handle, env=env, check=True)


def should_skip_table(name: str) -> bool:
    lowered = name.lower()
    return any(pattern in lowered for pattern in LOGO_TABLE_PATTERNS)


def load_schema(args: argparse.Namespace, schema: str) -> Tuple[Dict[str, Dict[str, Dict[str, str]]], Dict[str, List[Tuple[str, str, str, str]]]]:
    tables = mysql_query(
        args,
        """
        SELECT TABLE_NAME
        FROM information_schema.tables
        WHERE table_schema = %s
        ORDER BY TABLE_NAME
        """ % ("'" + schema + "'"),
    )
    table_names = [row[0] for row in tables]
    columns = mysql_query(
        args,
        """
        SELECT TABLE_NAME, COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE, COLUMN_KEY, EXTRA
        FROM information_schema.columns
        WHERE table_schema = %s
        ORDER BY TABLE_NAME, ORDINAL_POSITION
        """ % ("'" + schema + "'"),
    )
    col_map: Dict[str, Dict[str, Dict[str, str]]] = {name: {} for name in table_names}
    for table_name, column_name, column_type, is_nullable, column_key, extra in columns:
        col_map.setdefault(table_name, {})[column_name] = {
            "type": column_type,
            "nullable": is_nullable,
            "key": column_key,
            "extra": extra,
        }

    fks = mysql_query(
        args,
        """
        SELECT kcu.TABLE_NAME, kcu.COLUMN_NAME, kcu.REFERENCED_TABLE_NAME, kcu.REFERENCED_COLUMN_NAME
        FROM information_schema.key_column_usage kcu
        WHERE kcu.table_schema = %s AND kcu.REFERENCED_TABLE_NAME IS NOT NULL
        ORDER BY kcu.TABLE_NAME
        """ % ("'" + schema + "'"),
    )
    fk_map: Dict[str, List[Tuple[str, str, str, str]]] = {}
    for table_name, column_name, ref_table, ref_column in fks:
        fk_map.setdefault(table_name, []).append((column_name, ref_table, ref_column, table_name))
    return col_map, fk_map


def similarity(a: str, b: str) -> float:
    return SequenceMatcher(None, a.lower(), b.lower()).ratio()


def column_similarity(old_cols: List[str], new_cols: List[str]) -> float:
    if not old_cols or not new_cols:
        return 0.0
    common = set(col.lower() for col in old_cols) & set(col.lower() for col in new_cols)
    return len(common) / max(len(old_cols), len(new_cols))


def guess_table_mapping(old_schema: Dict[str, Dict[str, Dict[str, str]]], new_schema: Dict[str, Dict[str, Dict[str, str]]]) -> Dict[str, str]:
    mapping: Dict[str, str] = {}
    old_tables = [t for t in old_schema.keys() if not should_skip_table(t)]
    new_tables = [t for t in new_schema.keys() if not should_skip_table(t)]

    old_set = set(old_tables)
    for new_table in new_tables:
        if new_table in old_set:
            mapping[new_table] = new_table
            continue
        best_match = ""
        best_score = 0.0
        new_cols = list(new_schema[new_table].keys())
        for old_table in old_tables:
            score = similarity(new_table, old_table)
            score = max(score, column_similarity(list(old_schema[old_table].keys()), new_cols))
            if score > best_score:
                best_score = score
                best_match = old_table
        if best_match and best_score >= 0.55:
            mapping[new_table] = best_match
    return mapping


def guess_column_mapping(old_cols: Dict[str, Dict[str, str]], new_cols: Dict[str, Dict[str, str]]) -> Dict[str, str]:
    mapping: Dict[str, str] = {}
    old_names = list(old_cols.keys())
    for new_name in new_cols.keys():
        if new_name in old_cols:
            mapping[new_name] = new_name
            continue
        best_match = ""
        best_score = 0.0
        for old_name in old_names:
            score = similarity(new_name, old_name)
            if score > best_score:
                best_score = score
                best_match = old_name
        if best_match and best_score >= 0.6:
            mapping[new_name] = best_match
    return mapping


def build_insert_sql(
    target_table: str,
    source_table: str,
    column_map: Dict[str, str],
    new_columns: Dict[str, Dict[str, str]],
    strategy: str,
) -> str:
    target_cols = []
    source_cols = []
    for new_col, new_meta in new_columns.items():
        if new_col in column_map:
            target_cols.append(f"`{new_col}`")
            source_cols.append(f"`{column_map[new_col]}`")
        else:
            if new_meta["nullable"] == "YES":
                continue
            if "auto_increment" in new_meta["extra"]:
                continue
            target_cols.append(f"`{new_col}`")
            source_cols.append("DEFAULT")
    if not target_cols:
        return ""
    insert_clause = "INSERT IGNORE" if strategy == "upsert" else "INSERT"
    return (
        f"{insert_clause} INTO `{target_table}` ({', '.join(target_cols)}) "
        f"SELECT {', '.join(source_cols)} FROM `{source_table}`;"
    )


def report_table_status(old_tables: List[str], new_tables: List[str], mapping: Dict[str, str]) -> List[str]:
    lines = []
    old_set = set(old_tables)
    new_set = set(new_tables)
    for new_table in new_tables:
        if should_skip_table(new_table):
            continue
        if new_table in mapping:
            if mapping[new_table] == new_table:
                status = "identical"
            else:
                status = f"renamed from {mapping[new_table]}"
        else:
            status = "new"
        lines.append(f"{new_table}\t{status}")
    for old_table in old_tables:
        if should_skip_table(old_table):
            continue
        if old_table not in new_set and old_table not in mapping.values():
            lines.append(f"{old_table}\tremoved")
    return lines


def main() -> None:
    args = parse_args()

    run_mysql(args, f"DROP DATABASE IF EXISTS `{args.old_db}`; CREATE DATABASE `{args.old_db}`;")
    run_mysql(args, f"DROP DATABASE IF EXISTS `{args.new_db}`; CREATE DATABASE `{args.new_db}`;")

    import_dump(args, args.old_db, args.old_dump)
    import_dump(args, args.new_db, args.new_dump)

    old_schema, old_fks = load_schema(args, args.old_db)
    new_schema, new_fks = load_schema(args, args.new_db)

    old_tables = sorted(old_schema.keys())
    new_tables = sorted(new_schema.keys())

    table_mapping = guess_table_mapping(old_schema, new_schema)

    status_lines = report_table_status(old_tables, new_tables, table_mapping)
    print("Table\tStatus")
    for line in status_lines:
        print(line)

    migration_sql: List[str] = []
    per_table_report: List[str] = []

    run_mysql(args, "SET FOREIGN_KEY_CHECKS=0;", args.new_db)

    for new_table in new_tables:
        if should_skip_table(new_table):
            continue
        source_table = table_mapping.get(new_table)
        if not source_table:
            per_table_report.append(f"{new_table}\tSKIPPED (no source match)")
            continue
        new_cols = new_schema[new_table]
        old_cols = old_schema.get(source_table, {})
        column_map = guess_column_mapping(old_cols, new_cols)
        insert_sql = build_insert_sql(new_table, source_table, column_map, new_cols, args.strategy)
        if not insert_sql:
            per_table_report.append(f"{new_table}\tSKIPPED (no columns matched)")
            continue
        migration_sql.append(insert_sql)
        if args.dry_run:
            per_table_report.append(f"{new_table}\tDRY-RUN")
            continue
        if args.strategy == "truncate":
            run_mysql(args, f"TRUNCATE TABLE `{new_table}`;", args.new_db)
        run_mysql(args, insert_sql, args.new_db)
        rows = mysql_query(args, "SELECT ROW_COUNT();", args.new_db)
        row_count = rows[0][0] if rows else "0"
        per_table_report.append(f"{new_table}\t{row_count} rows")

    run_mysql(args, "SET FOREIGN_KEY_CHECKS=1;", args.new_db)

    print("\nMigration report")
    for line in per_table_report:
        print(line)

    print("\nCount checks")
    for new_table in new_tables:
        if should_skip_table(new_table):
            continue
        source_table = table_mapping.get(new_table)
        if not source_table:
            continue
        old_count = mysql_query(args, f"SELECT COUNT(*) FROM `{source_table}`;", args.old_db)
        new_count = mysql_query(args, f"SELECT COUNT(*) FROM `{new_table}`;", args.new_db)
        print(f"{source_table}\t{old_count[0][0] if old_count else 0}\t{new_table}\t{new_count[0][0] if new_count else 0}")

    if migration_sql:
        with open("migration_generated.sql", "w", encoding="utf-8") as handle:
            handle.write("\n".join(migration_sql))


if __name__ == "__main__":
    main()
