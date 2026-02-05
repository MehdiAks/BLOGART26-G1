<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$pageStyles = [ROOT_URL . '/src/css/club-structure.css'];

require_once 'header.php';

sql_connect();

$ba_bec_players = [];
try {
    $playersQuery = "SELECT
            j.numJoueur,
            j.prenomJoueur,
            j.nomJoueur,
            j.urlPhotoJoueur,
            j.dateNaissance,
            a.numMaillot,
            p.libPoste,
            s.libSaison,
            e.libEquipe,
            clubs.clubsPrecedents
        FROM JOUEUR j
        LEFT JOIN (
            SELECT numJoueur, MAX(numAffectation) AS latestAffectation
            FROM JOUEUR_AFFECTATION
            GROUP BY numJoueur
        ) latest ON j.numJoueur = latest.numJoueur
        LEFT JOIN JOUEUR_AFFECTATION a ON a.numAffectation = latest.latestAffectation
        LEFT JOIN POSTE p ON a.numPoste = p.numPoste
        LEFT JOIN SAISON s ON a.numSaison = s.numSaison
        LEFT JOIN EQUIPE e ON a.numEquipe = e.numEquipe
        LEFT JOIN (
            SELECT jc.numJoueur, GROUP_CONCAT(c.nomClub ORDER BY c.nomClub SEPARATOR ', ') AS clubsPrecedents
            FROM JOUEUR_CLUB jc
            INNER JOIN CLUB c ON jc.numClub = c.numClub
            GROUP BY jc.numJoueur
        ) clubs ON clubs.numJoueur = j.numJoueur
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
                        <p class="club-card-meta">Numéro : <?php echo htmlspecialchars($player['numMaillot'] ?? 'Non renseigné'); ?></p>
                        <p class="club-card-meta">Poste : <?php echo htmlspecialchars($player['libPoste'] ?? 'Non renseigné'); ?></p>
                        <p class="club-card-meta">Âge : <?php echo htmlspecialchars(format_age($player['dateNaissance'])); ?></p>
                        <p class="club-card-meta">Saison : <?php echo htmlspecialchars($player['libSaison'] ?? 'Non renseignée'); ?></p>
                        <?php if (!empty($player['libEquipe'])) : ?>
                            <p class="club-card-meta">Équipe : <?php echo htmlspecialchars($player['libEquipe']); ?></p>
                        <?php endif; ?>
                        <p class="club-card-meta">Clubs précédents : <?php echo htmlspecialchars(format_clubs($player['clubsPrecedents'])); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php require_once 'footer.php'; ?>
