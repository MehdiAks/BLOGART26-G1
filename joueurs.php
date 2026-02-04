<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$pageStyles = [ROOT_URL . '/src/css/club-structure.css'];
require_once 'header.php';

$dbAvailable = getenv('DB_HOST') && getenv('DB_USER') && getenv('DB_DATABASE');

if ($dbAvailable) {
    sql_connect();

    $playersStmt = $DB->prepare(
        'SELECT j.numJoueur, j.prenomJoueur, j.nomJoueur, j.urlPhotoJoueur, j.posteJoueur, j.numMaillot, j.anneeArrivee, j.clubsPrecedents,
            j.dateNaissance, GROUP_CONCAT(e.libEquipe ORDER BY e.libEquipe SEPARATOR ", ") AS equipes
        FROM JOUEUR j
        LEFT JOIN EQUIPE_JOUEUR ej ON j.numJoueur = ej.numJoueur
        LEFT JOIN EQUIPE e ON ej.numEquipe = e.numEquipe
        GROUP BY j.numJoueur
        ORDER BY j.nomJoueur ASC'
    );
    $playersStmt->execute();
    $players = $playersStmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $players = [];
}

$defaultPhoto = ROOT_URL . '/src/images/logo.png';

function format_age(?string $birthDate): string
{
    if (!$birthDate) {
        return 'Âge non renseigné';
    }
    $birth = new DateTime($birthDate);
    $today = new DateTime();
    $age = $today->diff($birth)->y;
    return $age . ' ans';
}

function format_clubs(?string $clubs): string
{
    if (!$clubs) {
        return 'Non renseignés';
    }
    $list = preg_split('/\\r\\n|\\r|\\n|\\s*\\|\\s*/', $clubs);
    $list = array_values(array_filter(array_map('trim', $list), 'strlen'));
    return $list ? implode(' · ', $list) : 'Non renseignés';
}

function player_photo_url(?string $photo, string $defaultPhoto): string
{
    if (!$photo) {
        return $defaultPhoto;
    }
    if (preg_match('/^(https?:\\/\\/|\\/)/', $photo)) {
        return $photo;
    }
    return ROOT_URL . '/src/uploads/' . $photo;
}
?>

<section class="club-page">
    <header class="club-header">
        <h1>Joueurs du club</h1>
        <p class="lead">
            Retrouvez les joueurs du BEC, leurs postes, leurs parcours et l'équipe dans laquelle ils évoluent.
        </p>
    </header>

    <?php if (empty($players)) : ?>
        <div class="empty-state">
            <p>Aucun joueur n'est encore enregistré. Les fiches seront ajoutées prochainement.</p>
        </div>
    <?php else : ?>
        <div class="club-grid">
            <?php foreach ($players as $player) : ?>
                <article class="club-card">
                    <img src="<?php echo htmlspecialchars(player_photo_url($player['urlPhotoJoueur'], $defaultPhoto)); ?>" alt="<?php echo htmlspecialchars($player['prenomJoueur'] . ' ' . $player['nomJoueur']); ?>">
                    <div class="club-card-body">
                        <h2 class="club-card-title">
                            <?php echo htmlspecialchars($player['prenomJoueur'] . ' ' . $player['nomJoueur']); ?>
                        </h2>
                        <p class="club-card-meta">Numéro : <?php echo htmlspecialchars($player['numMaillot'] ?: 'Non renseigné'); ?></p>
                        <p class="club-card-meta">Poste : <?php echo htmlspecialchars($player['posteJoueur'] ?: 'Non renseigné'); ?></p>
                        <p class="club-card-meta">Âge : <?php echo htmlspecialchars(format_age($player['dateNaissance'])); ?></p>
                        <p class="club-card-meta">Arrivé au club : <?php echo htmlspecialchars($player['anneeArrivee'] ?: 'Non renseignée'); ?></p>
                        <p class="club-card-meta">Clubs précédents : <?php echo htmlspecialchars(format_clubs($player['clubsPrecedents'])); ?></p>
                        <?php if (!empty($player['equipes'])) : ?>
                            <p class="club-card-meta">Équipe(s) : <?php echo htmlspecialchars($player['equipes']); ?></p>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php
require_once 'footer.php';
?>
