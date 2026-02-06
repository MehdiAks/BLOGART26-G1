<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$pageStyles = [ROOT_URL . '/src/css/club-structure.css'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php';

sql_connect();

$ba_bec_players = [];
try {
    $playersQuery = "SELECT
            j.numJoueur,
            j.prenomJoueur,
            j.nomJoueur,
            j.urlPhotoJoueur,
            j.dateNaissance,
            j.numeroMaillot,
            j.posteJoueur,
            j.clubsPrecedents,
            e.nomEquipe
        FROM JOUEUR j
        LEFT JOIN EQUIPE e ON j.codeEquipe = e.codeEquipe
        ORDER BY j.nomJoueur ASC";

    $playersStmt = $DB->prepare($playersQuery);
    $playersStmt->execute();
    $ba_bec_players = $playersStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $exception) {
    $ba_bec_players = [];
}

$defaultPhoto = ROOT_URL . '/src/images/image-defaut.jpeg';

function player_photo_url(?string $photo, string $defaultPhoto): string
{
    if (!$photo) {
        return $defaultPhoto;
    }

    if (preg_match('/^(https?:\/\/|\/)/', $photo)) {
        return $photo;
    }

    return ROOT_URL . '/src/uploads/' . $photo;
}

function format_age(?string $birthDate): string
{
    if (!$birthDate) {
        return 'Non renseigné';
    }
    $date = DateTime::createFromFormat('Y-m-d', $birthDate);
    if (!$date) {
        return 'Non renseigné';
    }
    return (string) $date->diff(new DateTime())->y;
}

function format_clubs(?string $clubs): string
{
    if (!$clubs) {
        return 'Non renseigné';
    }
    return $clubs;
}

function format_poste(?int $poste): string
{
    $labels = [
        1 => 'Meneur',
        2 => 'Arrière',
        3 => 'Ailier',
        4 => 'Ailier fort',
        5 => 'Pivot',
    ];
    if (!$poste) {
        return 'Non renseigné';
    }
    return $labels[$poste] ?? ('Poste ' . $poste);
}
?>

<section class="club-page">
    <header class="club-header">
        <h1>Joueurs du club</h1>
        <p>
            Retrouvez les joueurs du BEC, leurs postes, leurs parcours et l'équipe dans laquelle ils évoluent.
        </p>
    </header>

    <?php if (empty($ba_bec_players)) : ?>
        <p>Aucun joueur n'est encore enregistré. Les fiches seront ajoutées prochainement.</p>
    <?php else : ?>
        <div class="club-grid">
            <?php foreach ($ba_bec_players as $player) : ?>
                <article class="club-card">
                    <img src="<?php echo htmlspecialchars(player_photo_url($player['urlPhotoJoueur'], $defaultPhoto)); ?>" alt="<?php echo htmlspecialchars($player['prenomJoueur'] . ' ' . $player['nomJoueur']); ?>">
                    <div class="club-card-body">
                        <h2 class="club-card-title">
                            <?php echo htmlspecialchars($player['prenomJoueur'] . ' ' . $player['nomJoueur']); ?>
                        </h2>
                        <p class="club-card-meta">Numéro : <?php echo htmlspecialchars($player['numeroMaillot'] ?? 'Non renseigné'); ?></p>
                        <p class="club-card-meta">Poste : <?php echo htmlspecialchars(format_poste($player['posteJoueur'] ?? null)); ?></p>
                        <p class="club-card-meta">Âge : <?php echo htmlspecialchars(format_age($player['dateNaissance'])); ?></p>
                        <?php if (!empty($player['nomEquipe'])) : ?>
                            <p class="club-card-meta">Équipe : <?php echo htmlspecialchars($player['nomEquipe']); ?></p>
                        <?php endif; ?>
                        <p class="club-card-meta">Clubs précédents : <?php echo htmlspecialchars(format_clubs($player['clubsPrecedents'] ?? null)); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?>
