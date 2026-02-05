<?php

function ba_bec_resolve_equipe_id_from_section(?string $section): ?int
{
    global $DB;

    if ($section === null) {
        return null;
    }

    $section = strtoupper(trim($section));

    $map = [
        'SG1' => ['libEquipe' => 'Sénior 1', 'sectionEquipe' => 'Masculin'],
        'SG2' => ['libEquipe' => 'Sénior 2', 'sectionEquipe' => 'Masculin'],
        'SG3' => ['libEquipe' => 'Sénior 3', 'sectionEquipe' => 'Masculin'],
        'SG4' => ['libEquipe' => 'Sénior 4', 'sectionEquipe' => 'Masculin'],
        'SF1' => ['libEquipe' => 'SF1', 'sectionEquipe' => 'Féminin'],
        'SF2' => ['libEquipe' => 'SF2', 'sectionEquipe' => 'Féminin'],
        'SF3' => ['libEquipe' => 'SF3', 'sectionEquipe' => 'Féminin'],
    ];

    if (!array_key_exists($section, $map)) {
        return null;
    }

    $stmt = $DB->prepare(
        'SELECT numEquipe FROM EQUIPE WHERE libEquipe = :libEquipe AND sectionEquipe = :sectionEquipe LIMIT 1'
    );
    $stmt->execute([
        ':libEquipe' => $map[$section]['libEquipe'],
        ':sectionEquipe' => $map[$section]['sectionEquipe'],
    ]);

    $numEquipe = $stmt->fetchColumn();

    return $numEquipe !== false ? (int) $numEquipe : null;
}

function ba_bec_update_equipe_points(?int $numEquipe): void
{
    global $DB;

    if (!$numEquipe) {
        return;
    }

    $stmt = $DB->prepare(
        'UPDATE EQUIPE e
        SET pointsMarquesDomicile = (
                SELECT COALESCE(SUM(Score_BEC), 0)
                FROM bec_matches m
                WHERE m.numEquipe = e.numEquipe
                    AND m.Competition = e.niveauEquipe
                    AND m.Domicile_Exterieur = "Domicile"
            ),
            pointsEncaissesDomicile = (
                SELECT COALESCE(SUM(Score_Adversaire), 0)
                FROM bec_matches m
                WHERE m.numEquipe = e.numEquipe
                    AND m.Competition = e.niveauEquipe
                    AND m.Domicile_Exterieur = "Domicile"
            ),
            pointsMarquesExterieur = (
                SELECT COALESCE(SUM(Score_BEC), 0)
                FROM bec_matches m
                WHERE m.numEquipe = e.numEquipe
                    AND m.Competition = e.niveauEquipe
                    AND m.Domicile_Exterieur = "Extérieur"
            ),
            pointsEncaissesExterieur = (
                SELECT COALESCE(SUM(Score_Adversaire), 0)
                FROM bec_matches m
                WHERE m.numEquipe = e.numEquipe
                    AND m.Competition = e.niveauEquipe
                    AND m.Domicile_Exterieur = "Extérieur"
            )
        WHERE e.numEquipe = :numEquipe'
    );
    $stmt->execute([':numEquipe' => $numEquipe]);
}
