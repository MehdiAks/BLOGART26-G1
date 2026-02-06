<!-- Cette ligne contient: <?php -->
<?php
// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Ligne vide pour aération.

// Cette ligne contient: $pageStyles = [ROOT_URL . '/src/css/club-structure.css'];
$pageStyles = [ROOT_URL . '/src/css/club-structure.css'];
// Ligne vide pour aération.

// Cette ligne contient: function is_missing_table(PDOException $exception): bool
function is_missing_table(PDOException $exception): bool
// Cette ligne contient: {
{
// Cette ligne contient: $errorInfo = $exception->errorInfo ?? [];
    $errorInfo = $exception->errorInfo ?? [];
// Ligne vide pour aération.

// Cette ligne contient: return $exception->getCode() === '42S02'
    return $exception->getCode() === '42S02'
// Cette ligne contient: || (isset($errorInfo[1]) && (int) $errorInfo[1] === 1146);
        || (isset($errorInfo[1]) && (int) $errorInfo[1] === 1146);
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: $dbAvailable = getenv('DB_HOST') && getenv('DB_USER') && getenv('DB_DATABASE');
$dbAvailable = getenv('DB_HOST') && getenv('DB_USER') && getenv('DB_DATABASE');
// Ligne vide pour aération.

// Cette ligne contient: $branches = [
$branches = [
// Cette ligne contient: ['numBranche' => 1, 'libBranche' => 'Bureau'],
    ['numBranche' => 1, 'libBranche' => 'Bureau'],
// Cette ligne contient: ['numBranche' => 2, 'libBranche' => 'Équipe technique'],
    ['numBranche' => 2, 'libBranche' => 'Équipe technique'],
// Cette ligne contient: ['numBranche' => 3, 'libBranche' => 'Équipe animation'],
    ['numBranche' => 3, 'libBranche' => 'Équipe animation'],
// Cette ligne contient: ['numBranche' => 4, 'libBranche' => 'Équipe communication'],
    ['numBranche' => 4, 'libBranche' => 'Équipe communication'],
// Cette ligne contient: ];
];
// Ligne vide pour aération.

// Cette ligne contient: if ($dbAvailable) {
if ($dbAvailable) {
// Cette ligne contient: try {
    try {
// Cette ligne contient: sql_connect();
        sql_connect();
// Ligne vide pour aération.

// Cette ligne contient: $staffStmt = $DB->prepare(
        $staffStmt = $DB->prepare(
// Cette ligne contient: 'SELECT numPersonnel, prenomPersonnel, nomPersonnel, urlPhotoPersonnel,
            'SELECT numPersonnel, prenomPersonnel, nomPersonnel, urlPhotoPersonnel,
// Cette ligne contient: estDirection, posteDirection,
                    estDirection, posteDirection,
// Cette ligne contient: estCommissionTechnique, posteCommissionTechnique,
                    estCommissionTechnique, posteCommissionTechnique,
// Cette ligne contient: estCommissionAnimation, posteCommissionAnimation,
                    estCommissionAnimation, posteCommissionAnimation,
// Cette ligne contient: estCommissionCommunication, posteCommissionCommunication
                    estCommissionCommunication, posteCommissionCommunication
// Cette ligne contient: FROM PERSONNEL
                FROM PERSONNEL
// Cette ligne contient: WHERE estDirection = 1
                WHERE estDirection = 1
// Cette ligne contient: OR estCommissionTechnique = 1
                    OR estCommissionTechnique = 1
// Cette ligne contient: OR estCommissionAnimation = 1
                    OR estCommissionAnimation = 1
// Cette ligne contient: OR estCommissionCommunication = 1
                    OR estCommissionCommunication = 1
// Cette ligne contient: ORDER BY nomPersonnel ASC, prenomPersonnel ASC'
                ORDER BY nomPersonnel ASC, prenomPersonnel ASC'
// Cette ligne contient: );
        );
// Cette ligne contient: $staffStmt->execute();
        $staffStmt->execute();
// Cette ligne contient: $staff = $staffStmt->fetchAll(PDO::FETCH_ASSOC);
        $staff = $staffStmt->fetchAll(PDO::FETCH_ASSOC);
// Cette ligne contient: } catch (PDOException $exception) {
    } catch (PDOException $exception) {
// Cette ligne contient: if (is_missing_table($exception)) {
        if (is_missing_table($exception)) {
// Cette ligne contient: $staff = [];
            $staff = [];
// Cette ligne contient: } else {
        } else {
// Cette ligne contient: throw $exception;
            throw $exception;
// Cette ligne contient: }
        }
// Cette ligne contient: }
    }
// Cette ligne contient: } else {
} else {
// Cette ligne contient: $staff = [];
    $staff = [];
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: $staffByBranch = [];
$staffByBranch = [];
// Cette ligne contient: foreach ($branches as $branch) {
foreach ($branches as $branch) {
// Cette ligne contient: $staffByBranch[$branch['libBranche']] = [];
    $staffByBranch[$branch['libBranche']] = [];
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: $roleLabels = [
$roleLabels = [
// Cette ligne contient: 'Bureau' => 'Membre du bureau',
    'Bureau' => 'Membre du bureau',
// Cette ligne contient: 'Équipe technique' => 'Commission technique',
    'Équipe technique' => 'Commission technique',
// Cette ligne contient: 'Équipe animation' => 'Commission animation',
    'Équipe animation' => 'Commission animation',
// Cette ligne contient: 'Équipe communication' => 'Commission communication',
    'Équipe communication' => 'Commission communication',
// Cette ligne contient: ];
];
// Ligne vide pour aération.

// Cette ligne contient: foreach ($staff as $member) {
foreach ($staff as $member) {
// Cette ligne contient: if (!empty($member['estDirection'])) {
    if (!empty($member['estDirection'])) {
// Cette ligne contient: $poste = trim((string) ($member['posteDirection'] ?? ''));
        $poste = trim((string) ($member['posteDirection'] ?? ''));
// Cette ligne contient: $staffByBranch['Bureau'][] = array_merge(
        $staffByBranch['Bureau'][] = array_merge(
// Cette ligne contient: $member,
            $member,
// Cette ligne contient: ['libPoste' => $poste !== '' ? $poste : $roleLabels['Bureau']]
            ['libPoste' => $poste !== '' ? $poste : $roleLabels['Bureau']]
// Cette ligne contient: );
        );
// Cette ligne contient: }
    }
// Cette ligne contient: if (!empty($member['estCommissionTechnique'])) {
    if (!empty($member['estCommissionTechnique'])) {
// Cette ligne contient: $poste = trim((string) ($member['posteCommissionTechnique'] ?? ''));
        $poste = trim((string) ($member['posteCommissionTechnique'] ?? ''));
// Cette ligne contient: $staffByBranch['Équipe technique'][] = array_merge(
        $staffByBranch['Équipe technique'][] = array_merge(
// Cette ligne contient: $member,
            $member,
// Cette ligne contient: ['libPoste' => $poste !== '' ? $poste : $roleLabels['Équipe technique']]
            ['libPoste' => $poste !== '' ? $poste : $roleLabels['Équipe technique']]
// Cette ligne contient: );
        );
// Cette ligne contient: }
    }
// Cette ligne contient: if (!empty($member['estCommissionAnimation'])) {
    if (!empty($member['estCommissionAnimation'])) {
// Cette ligne contient: $poste = trim((string) ($member['posteCommissionAnimation'] ?? ''));
        $poste = trim((string) ($member['posteCommissionAnimation'] ?? ''));
// Cette ligne contient: $staffByBranch['Équipe animation'][] = array_merge(
        $staffByBranch['Équipe animation'][] = array_merge(
// Cette ligne contient: $member,
            $member,
// Cette ligne contient: ['libPoste' => $poste !== '' ? $poste : $roleLabels['Équipe animation']]
            ['libPoste' => $poste !== '' ? $poste : $roleLabels['Équipe animation']]
// Cette ligne contient: );
        );
// Cette ligne contient: }
    }
// Cette ligne contient: if (!empty($member['estCommissionCommunication'])) {
    if (!empty($member['estCommissionCommunication'])) {
// Cette ligne contient: $poste = trim((string) ($member['posteCommissionCommunication'] ?? ''));
        $poste = trim((string) ($member['posteCommissionCommunication'] ?? ''));
// Cette ligne contient: $staffByBranch['Équipe communication'][] = array_merge(
        $staffByBranch['Équipe communication'][] = array_merge(
// Cette ligne contient: $member,
            $member,
// Cette ligne contient: ['libPoste' => $poste !== '' ? $poste : $roleLabels['Équipe communication']]
            ['libPoste' => $poste !== '' ? $poste : $roleLabels['Équipe communication']]
// Cette ligne contient: );
        );
// Cette ligne contient: }
    }
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: $branchDescriptions = [
$branchDescriptions = [
// Cette ligne contient: 'Bureau' => 'Le bureau pilote la vie du club et définit les orientations stratégiques.',
    'Bureau' => 'Le bureau pilote la vie du club et définit les orientations stratégiques.',
// Cette ligne contient: 'Équipe technique' => 'L\'équipe technique encadre les coachs et structure la performance sportive.',
    'Équipe technique' => 'L\'équipe technique encadre les coachs et structure la performance sportive.',
// Cette ligne contient: 'Équipe animation' => 'L\'équipe animation coordonne les événements et l\'ambiance au sein du club.',
    'Équipe animation' => 'L\'équipe animation coordonne les événements et l\'ambiance au sein du club.',
// Cette ligne contient: 'Équipe communication' => 'L\'équipe communication valorise les actions du club et relaie les informations.',
    'Équipe communication' => 'L\'équipe communication valorise les actions du club et relaie les informations.',
// Cette ligne contient: ];
];
// Ligne vide pour aération.

// Cette ligne contient: $defaultPhoto = ROOT_URL . '/src/images/image-defaut.jpeg';
$defaultPhoto = ROOT_URL . '/src/images/image-defaut.jpeg';
// Ligne vide pour aération.

// Cette ligne contient: function branch_id(string $label): string
function branch_id(string $label): string
// Cette ligne contient: {
{
// Cette ligne contient: $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $label);
    $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $label);
// Cette ligne contient: $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $slug));
    $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $slug));
// Cette ligne contient: return trim($slug, '-');
    return trim($slug, '-');
// Cette ligne contient: }
}
// Cette ligne contient: ?>
?>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php'; ?> -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php'; ?>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <section class="club-page"> -->
<section class="club-page">
<!-- Cette ligne contient: <header class="club-header"> -->
    <header class="club-header">
<!-- Cette ligne contient: <h1>Organigramme &amp; bénévoles</h1> -->
        <h1>Organigramme &amp; bénévoles</h1>
<!-- Cette ligne contient: <p class="lead"> -->
        <p class="lead">
<!-- Cette ligne contient: Découvrez les personnes engagées dans la vie du club, des membres du bureau aux équipes techniques, -->
            Découvrez les personnes engagées dans la vie du club, des membres du bureau aux équipes techniques,
<!-- Cette ligne contient: animation et communication. Plusieurs bénévoles peuvent intervenir sur différentes missions. -->
            animation et communication. Plusieurs bénévoles peuvent intervenir sur différentes missions.
<!-- Cette ligne contient: </p> -->
        </p>
<!-- Cette ligne contient: </header> -->
    </header>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <?php foreach ($branches as $branch) : ?> -->
    <?php foreach ($branches as $branch) : ?>
<!-- Cette ligne contient: <?php -->
        <?php
// Cette ligne contient: $branchName = $branch['libBranche'];
        $branchName = $branch['libBranche'];
// Cette ligne contient: $branchMembers = $staffByBranch[$branchName] ?? [];
        $branchMembers = $staffByBranch[$branchName] ?? [];
// Cette ligne contient: ?>
        ?>
<!-- Cette ligne contient: <?php $branchAnchor = branch_id($branchName); ?> -->
        <?php $branchAnchor = branch_id($branchName); ?>
<!-- Cette ligne contient: <section class="club-section" aria-labelledby="branch-<?php echo htmlspecialchars($branchAnchor); ?>"> -->
        <section class="club-section" aria-labelledby="branch-<?php echo htmlspecialchars($branchAnchor); ?>">
<!-- Cette ligne contient: <div class="club-section-header"> -->
            <div class="club-section-header">
<!-- Cette ligne contient: <h2 id="branch-<?php echo htmlspecialchars($branchAnchor); ?>"><?php echo htmlspecialchars($branchName); ?></h2> -->
                <h2 id="branch-<?php echo htmlspecialchars($branchAnchor); ?>"><?php echo htmlspecialchars($branchName); ?></h2>
<!-- Cette ligne contient: <p><?php echo htmlspecialchars($branchDescriptions[$branchName] ?? ''); ?></p> -->
                <p><?php echo htmlspecialchars($branchDescriptions[$branchName] ?? ''); ?></p>
<!-- Cette ligne contient: </div> -->
            </div>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <?php if (empty($branchMembers)) : ?> -->
            <?php if (empty($branchMembers)) : ?>
<!-- Cette ligne contient: <div class="empty-state"> -->
                <div class="empty-state">
<!-- Cette ligne contient: <p>Aucun bénévole n'est encore renseigné pour cette branche.</p> -->
                    <p>Aucun bénévole n'est encore renseigné pour cette branche.</p>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: <?php else : ?> -->
            <?php else : ?>
<!-- Cette ligne contient: <div class="club-grid"> -->
                <div class="club-grid">
<!-- Cette ligne contient: <?php foreach ($branchMembers as $member) : ?> -->
                    <?php foreach ($branchMembers as $member) : ?>
<!-- Cette ligne contient: <article class="club-card"> -->
                        <article class="club-card">
<!-- Cette ligne contient: <img src="<?php echo htmlspecialchars($member['urlPhotoPersonnel'] ?: $defaultPhoto); ?>" alt="<?php echo htmlspecialchars($member['prenomPersonnel'] . ' ' . $member['nomPersonnel']); ?>"> -->
                            <img src="<?php echo htmlspecialchars($member['urlPhotoPersonnel'] ?: $defaultPhoto); ?>" alt="<?php echo htmlspecialchars($member['prenomPersonnel'] . ' ' . $member['nomPersonnel']); ?>">
<!-- Cette ligne contient: <div class="club-card-body"> -->
                            <div class="club-card-body">
<!-- Cette ligne contient: <h3 class="club-card-title"> -->
                                <h3 class="club-card-title">
<!-- Cette ligne contient: <?php echo htmlspecialchars($member['prenomPersonnel'] . ' ' . $member['nomPersonnel']); ?> -->
                                    <?php echo htmlspecialchars($member['prenomPersonnel'] . ' ' . $member['nomPersonnel']); ?>
<!-- Cette ligne contient: </h3> -->
                                </h3>
<!-- Cette ligne contient: <p class="club-card-meta"><?php echo htmlspecialchars($member['libPoste']); ?></p> -->
                                <p class="club-card-meta"><?php echo htmlspecialchars($member['libPoste']); ?></p>
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
<!-- Cette ligne contient: <?php endforeach; ?> -->
    <?php endforeach; ?>
<!-- Cette ligne contient: </section> -->
</section>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <?php -->
<?php
// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
// Cette ligne contient: ?>
?>
