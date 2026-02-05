<?php

function ba_bec_resolve_equipe_id_from_code(?string $codeEquipe): ?int
{
    global $DB;

    if ($codeEquipe === null) {
        return null;
    }

    $codeEquipe = strtoupper(trim($codeEquipe));

    $stmt = $DB->prepare(
        'SELECT numEquipe FROM EQUIPE WHERE codeEquipe = :codeEquipe LIMIT 1'
    );
    $stmt->execute([
        ':codeEquipe' => $codeEquipe,
    ]);

    $numEquipe = $stmt->fetchColumn();

    return $numEquipe !== false ? (int) $numEquipe : null;
}
