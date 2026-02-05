<?php
function sql_set_last_error(?string $message): void {
    if ($message === null) {
        unset($GLOBALS['SQL_LAST_ERROR']);
        return;
    }
    $GLOBALS['SQL_LAST_ERROR'] = $message;
}

function sql_get_last_error(): ?string {
    return $GLOBALS['SQL_LAST_ERROR'] ?? null;
}

function sql_clear_last_error(): void {
    unset($GLOBALS['SQL_LAST_ERROR']);
}
?>
