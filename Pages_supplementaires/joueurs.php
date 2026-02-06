<!-- Cette ligne contient: <?php -->
<?php
// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Ligne vide pour aération.

// Cette ligne contient: $pageStyles = [ROOT_URL . '/src/css/club-structure.css'];
$pageStyles = [ROOT_URL . '/src/css/club-structure.css'];
// Ligne vide pour aération.

// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php';
// Ligne vide pour aération.

// Cette ligne contient: sql_connect();
sql_connect();
// Ligne vide pour aération.

// Cette ligne contient: $ba_bec_players = [];
$ba_bec_players = [];
// Cette ligne contient: try {
try {
// Cette ligne contient: $playersQuery = "SELECT
    $playersQuery = "SELECT
// Cette ligne contient: j.numJoueur,
            j.numJoueur,
// Cette ligne contient: j.prenomJoueur,
            j.prenomJoueur,
// Cette ligne contient: j.nomJoueur,
            j.nomJoueur,
// Cette ligne contient: j.urlPhotoJoueur,
            j.urlPhotoJoueur,
// Cette ligne contient: j.dateNaissance,
            j.dateNaissance,
// Cette ligne contient: j.numeroMaillot,
            j.numeroMaillot,
// Cette ligne contient: j.posteJoueur,
            j.posteJoueur,
// Cette ligne contient: j.clubsPrecedents,
            j.clubsPrecedents,
// Cette ligne contient: e.nomEquipe
            e.nomEquipe
// Cette ligne contient: FROM JOUEUR j
        FROM JOUEUR j
// Cette ligne contient: LEFT JOIN EQUIPE e ON j.codeEquipe = e.codeEquipe
        LEFT JOIN EQUIPE e ON j.codeEquipe = e.codeEquipe
// Cette ligne contient: ORDER BY j.nomJoueur ASC";
        ORDER BY j.nomJoueur ASC";
// Ligne vide pour aération.

// Cette ligne contient: $playersStmt = $DB->prepare($playersQuery);
    $playersStmt = $DB->prepare($playersQuery);
// Cette ligne contient: $playersStmt->execute();
    $playersStmt->execute();
// Cette ligne contient: $ba_bec_players = $playersStmt->fetchAll(PDO::FETCH_ASSOC);
    $ba_bec_players = $playersStmt->fetchAll(PDO::FETCH_ASSOC);
// Cette ligne contient: } catch (PDOException $exception) {
} catch (PDOException $exception) {
// Cette ligne contient: $ba_bec_players = [];
    $ba_bec_players = [];
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: $defaultPhoto = ROOT_URL . '/src/images/image-defaut.jpeg';
$defaultPhoto = ROOT_URL . '/src/images/image-defaut.jpeg';
// Ligne vide pour aération.

// Cette ligne contient: function player_photo_url(?string $photo, string $defaultPhoto): string
function player_photo_url(?string $photo, string $defaultPhoto): string
// Cette ligne contient: {
{
// Cette ligne contient: if (!$photo) {
    if (!$photo) {
// Cette ligne contient: return $defaultPhoto;
        return $defaultPhoto;
// Cette ligne contient: }
    }
// Ligne vide pour aération.

// Cette ligne contient: if (preg_match('/^(https?:\/\/|\/)/', $photo)) {
    if (preg_match('/^(https?:\/\/|\/)/', $photo)) {
// Cette ligne contient: return $photo;
        return $photo;
// Cette ligne contient: }
    }
// Ligne vide pour aération.

// Cette ligne contient: return ROOT_URL . '/src/uploads/' . $photo;
    return ROOT_URL . '/src/uploads/' . $photo;
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: function format_age(?string $birthDate): string
function format_age(?string $birthDate): string
// Cette ligne contient: {
{
// Cette ligne contient: if (!$birthDate) {
    if (!$birthDate) {
// Cette ligne contient: return 'Non renseigné';
        return 'Non renseigné';
// Cette ligne contient: }
    }
// Cette ligne contient: $date = DateTime::createFromFormat('Y-m-d', $birthDate);
    $date = DateTime::createFromFormat('Y-m-d', $birthDate);
// Cette ligne contient: if (!$date) {
    if (!$date) {
// Cette ligne contient: return 'Non renseigné';
        return 'Non renseigné';
// Cette ligne contient: }
    }
// Cette ligne contient: return (string) $date->diff(new DateTime())->y;
    return (string) $date->diff(new DateTime())->y;
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: function format_clubs(?string $clubs): string
function format_clubs(?string $clubs): string
// Cette ligne contient: {
{
// Cette ligne contient: if (!$clubs) {
    if (!$clubs) {
// Cette ligne contient: return 'Non renseigné';
        return 'Non renseigné';
// Cette ligne contient: }
    }
// Cette ligne contient: return $clubs;
    return $clubs;
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: function format_poste(?int $poste): string
function format_poste(?int $poste): string
// Cette ligne contient: {
{
// Cette ligne contient: $labels = [
    $labels = [
// Cette ligne contient: 1 => 'Meneur',
        1 => 'Meneur',
// Cette ligne contient: 2 => 'Arrière',
        2 => 'Arrière',
// Cette ligne contient: 3 => 'Ailier',
        3 => 'Ailier',
// Cette ligne contient: 4 => 'Ailier fort',
        4 => 'Ailier fort',
// Cette ligne contient: 5 => 'Pivot',
        5 => 'Pivot',
// Cette ligne contient: ];
    ];
// Cette ligne contient: if (!$poste) {
    if (!$poste) {
// Cette ligne contient: return 'Non renseigné';
        return 'Non renseigné';
// Cette ligne contient: }
    }
// Cette ligne contient: return $labels[$poste] ?? ('Poste ' . $poste);
    return $labels[$poste] ?? ('Poste ' . $poste);
// Cette ligne contient: }
}
// Cette ligne contient: ?>
?>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <section class="club-page"> -->
<section class="club-page">
<!-- Cette ligne contient: <header class="club-header"> -->
    <header class="club-header">
<!-- Cette ligne contient: <h1>Joueurs du club</h1> -->
        <h1>Joueurs du club</h1>
<!-- Cette ligne contient: <p> -->
        <p>
<!-- Cette ligne contient: Retrouvez les joueurs du BEC, leurs postes, leurs parcours et l'équipe dans laquelle ils évoluent. -->
            Retrouvez les joueurs du BEC, leurs postes, leurs parcours et l'équipe dans laquelle ils évoluent.
<!-- Cette ligne contient: </p> -->
        </p>
<!-- Cette ligne contient: </header> -->
    </header>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <?php if (empty($ba_bec_players)) : ?> -->
    <?php if (empty($ba_bec_players)) : ?>
<!-- Cette ligne contient: <p>Aucun joueur n'est encore enregistré. Les fiches seront ajoutées prochainement.</p> -->
        <p>Aucun joueur n'est encore enregistré. Les fiches seront ajoutées prochainement.</p>
<!-- Cette ligne contient: <?php else : ?> -->
    <?php else : ?>
<!-- Cette ligne contient: <div class="club-grid"> -->
        <div class="club-grid">
<!-- Cette ligne contient: <?php foreach ($ba_bec_players as $player) : ?> -->
            <?php foreach ($ba_bec_players as $player) : ?>
<!-- Cette ligne contient: <article class="club-card"> -->
                <article class="club-card">
<!-- Cette ligne contient: <img src="<?php echo htmlspecialchars(player_photo_url($player['urlPhotoJoueur'], $defaultPhoto)); ?>" alt="<?php echo htmlspecialchars($player['prenomJoueur'] . ' ' . $player['nomJoueur']); ?>"> -->
                    <img src="<?php echo htmlspecialchars(player_photo_url($player['urlPhotoJoueur'], $defaultPhoto)); ?>" alt="<?php echo htmlspecialchars($player['prenomJoueur'] . ' ' . $player['nomJoueur']); ?>">
<!-- Cette ligne contient: <div class="club-card-body"> -->
                    <div class="club-card-body">
<!-- Cette ligne contient: <h2 class="club-card-title"> -->
                        <h2 class="club-card-title">
<!-- Cette ligne contient: <?php echo htmlspecialchars($player['prenomJoueur'] . ' ' . $player['nomJoueur']); ?> -->
                            <?php echo htmlspecialchars($player['prenomJoueur'] . ' ' . $player['nomJoueur']); ?>
<!-- Cette ligne contient: </h2> -->
                        </h2>
<!-- Cette ligne contient: <p class="club-card-meta">Numéro : <?php echo htmlspecialchars($player['numeroMaillot'] ?? 'Non renseigné'); ?></p> -->
                        <p class="club-card-meta">Numéro : <?php echo htmlspecialchars($player['numeroMaillot'] ?? 'Non renseigné'); ?></p>
<!-- Cette ligne contient: <p class="club-card-meta">Poste : <?php echo htmlspecialchars(format_poste($player['posteJoueur'] ?? null)); ?></p> -->
                        <p class="club-card-meta">Poste : <?php echo htmlspecialchars(format_poste($player['posteJoueur'] ?? null)); ?></p>
<!-- Cette ligne contient: <p class="club-card-meta">Âge : <?php echo htmlspecialchars(format_age($player['dateNaissance'])); ?></p> -->
                        <p class="club-card-meta">Âge : <?php echo htmlspecialchars(format_age($player['dateNaissance'])); ?></p>
<!-- Cette ligne contient: <?php if (!empty($player['nomEquipe'])) : ?> -->
                        <?php if (!empty($player['nomEquipe'])) : ?>
<!-- Cette ligne contient: <p class="club-card-meta">Équipe : <?php echo htmlspecialchars($player['nomEquipe']); ?></p> -->
                            <p class="club-card-meta">Équipe : <?php echo htmlspecialchars($player['nomEquipe']); ?></p>
<!-- Cette ligne contient: <?php endif; ?> -->
                        <?php endif; ?>
<!-- Cette ligne contient: <p class="club-card-meta">Clubs précédents : <?php echo htmlspecialchars(format_clubs($player['clubsPrecedents'] ?? null)); ?></p> -->
                        <p class="club-card-meta">Clubs précédents : <?php echo htmlspecialchars(format_clubs($player['clubsPrecedents'] ?? null)); ?></p>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: </article> -->
                </article>
<!-- Cette ligne contient: <?php endforeach; ?> -->
            <?php endforeach; ?>
<!-- Cette ligne contient: </div> -->
        </div>
<!-- Cette ligne contient: <?php endif; ?> -->
    <?php endif; ?>
<!-- Cette ligne contient: </section> -->
</section>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?> -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?>
