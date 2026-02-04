<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$pageStyles = [ROOT_URL . '/src/css/club-structure.css'];
require_once 'header.php';

$dbAvailable = getenv('DB_HOST') && getenv('DB_USER') && getenv('DB_DATABASE');

if ($dbAvailable) {
    sql_connect();

    $branchesStmt = $DB->prepare('SELECT numBranche, libBranche FROM BRANCHE_PERSONNEL ORDER BY libBranche ASC');
    $branchesStmt->execute();
    $branches = $branchesStmt->fetchAll(PDO::FETCH_ASSOC);

    $staffStmt = $DB->prepare(
        'SELECT p.numPersonnel, p.prenomPersonnel, p.nomPersonnel, p.urlPhotoPersonnel, b.numBranche, b.libBranche, a.libPoste
         FROM PERSONNEL p
         INNER JOIN AFFECTATION_PERSONNEL a ON p.numPersonnel = a.numPersonnel
         INNER JOIN BRANCHE_PERSONNEL b ON a.numBranche = b.numBranche
         ORDER BY b.libBranche ASC, p.nomPersonnel ASC'
    );
    $staffStmt->execute();
    $staff = $staffStmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $branches = [];
    $staff = [];
}

if (empty($branches)) {
    $branches = [
        ['numBranche' => 0, 'libBranche' => 'Bureau'],
        ['numBranche' => 0, 'libBranche' => 'Équipe technique'],
        ['numBranche' => 0, 'libBranche' => 'Équipe animation'],
        ['numBranche' => 0, 'libBranche' => 'Équipe communication'],
    ];
}

$staffByBranch = [];
foreach ($staff as $member) {
    $branchKey = $member['libBranche'];
    if (!isset($staffByBranch[$branchKey])) {
        $staffByBranch[$branchKey] = [];
    }
    $staffByBranch[$branchKey][] = $member;
}

$branchDescriptions = [
    'Bureau' => 'Le bureau pilote la vie du club et définit les orientations stratégiques.',
    'Équipe technique' => 'L\'équipe technique encadre les coachs et structure la performance sportive.',
    'Équipe animation' => 'L\'équipe animation coordonne les événements et l\'ambiance au sein du club.',
    'Équipe communication' => 'L\'équipe communication valorise les actions du club et relaie les informations.',
];

$defaultPhoto = ROOT_URL . '/src/images/logo.png';

function branch_id(string $label): string
{
    $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $label);
    $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $slug));
    return trim($slug, '-');
}
?>

<section class="club-page">
    <header class="club-header">
        <h1>Organigramme &amp; bénévoles</h1>
        <p class="lead">
            Découvrez les personnes engagées dans la vie du club, des membres du bureau aux équipes techniques,
            animation et communication. Plusieurs bénévoles peuvent intervenir sur différentes missions.
        </p>
    </header>

    <?php foreach ($branches as $branch) : ?>
        <?php
        $branchName = $branch['libBranche'];
        $branchMembers = $staffByBranch[$branchName] ?? [];
        ?>
        <?php $branchAnchor = branch_id($branchName); ?>
        <section class="club-section" aria-labelledby="branch-<?php echo htmlspecialchars($branchAnchor); ?>">
            <div class="club-section-header">
                <h2 id="branch-<?php echo htmlspecialchars($branchAnchor); ?>"><?php echo htmlspecialchars($branchName); ?></h2>
                <p><?php echo htmlspecialchars($branchDescriptions[$branchName] ?? ''); ?></p>
            </div>

            <?php if (empty($branchMembers)) : ?>
                <div class="empty-state">
                    <p>Aucun bénévole n'est encore renseigné pour cette branche.</p>
                </div>
            <?php else : ?>
                <div class="club-grid">
                    <?php foreach ($branchMembers as $member) : ?>
                        <article class="club-card">
                            <img src="<?php echo htmlspecialchars($member['urlPhotoPersonnel'] ?: $defaultPhoto); ?>" alt="<?php echo htmlspecialchars($member['prenomPersonnel'] . ' ' . $member['nomPersonnel']); ?>">
                            <div class="club-card-body">
                                <h3 class="club-card-title">
                                    <?php echo htmlspecialchars($member['prenomPersonnel'] . ' ' . $member['nomPersonnel']); ?>
                                </h3>
                                <p class="club-card-meta"><?php echo htmlspecialchars($member['libPoste']); ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    <?php endforeach; ?>
</section>

<?php
require_once 'footer.php';
?>
