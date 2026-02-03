<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$pageStyles = [
    ROOT_URL . '/src/css/style.css',
    ROOT_URL . '/src/css/styleactu.css',
];

require_once 'header.php';

sql_connect();

$search = trim($_GET['search'] ?? '');
$ba_bec_keyword = trim($_GET['keyword'] ?? '');
$theme = isset($_GET['theme']) ? (int) $_GET['theme'] : 0;

$themeStmt = $DB->prepare('SELECT numThem, libThem FROM THEMATIQUE ORDER BY libThem ASC');
$themeStmt->execute();
$ba_bec_thematiques = $themeStmt->fetchAll(PDO::FETCH_ASSOC);

$conditions = [];
$params = [];

if ($theme > 0) {
    $conditions[] = 'a.numThem = :theme';
    $params[':theme'] = $theme;
}

if ($search !== '') {
    $conditions[] = 'a.libTitrArt LIKE :search';
    $params[':search'] = '%' . $search . '%';
}

if ($ba_bec_keyword !== '') {
    $conditions[] = '(a.libChapoArt LIKE :keyword OR a.libAccrochArt LIKE :keyword OR a.parag1Art LIKE :keyword OR a.parag2Art LIKE :keyword OR a.parag3Art LIKE :keyword)';
    $params[':keyword'] = '%' . $ba_bec_keyword . '%';
}

$query = 'SELECT a.numArt, a.libTitrArt, a.libChapoArt, a.urlPhotArt, t.libThem FROM ARTICLE a INNER JOIN THEMATIQUE t ON a.numThem = t.numThem';
if (!empty($conditions)) {
    $query .= ' WHERE ' . implode(' AND ', $conditions);
}
$query .= ' ORDER BY a.dtCreaArt DESC';

$articleStmt = $DB->prepare($query);
$articleStmt->execute($params);
$ba_bec_articles = $articleStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container py-5">
    <section class="news-summary">
        <p class="news-summary__eyebrow">Actualités</p>
        <h1 class="news-summary__title">Restez au plus près de la vie du club</h1>
        <p class="news-summary__text">
            Entre résultats, interviews, moments forts et coulisses, retrouvez ici l'ensemble des actualités du BEC.
            Ce fil éditorial met en avant les histoires qui font vibrer la communauté, avec des mises à jour régulières
            pour ne rien manquer des temps forts.
        </p>
    </section>

    <section class="news-filters" aria-label="Filtres des actualités">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-12 col-lg-4">
                <label for="theme" class="form-label">Thématique</label>
                <select id="theme" name="theme" class="form-select">
                    <option value="0">Toutes les thématiques</option>
                    <?php foreach ($ba_bec_thematiques as $ba_bec_thematique): ?>
                        <option value="<?php echo (int) $ba_bec_thematique['numThem']; ?>" <?php echo $theme === (int) $ba_bec_thematique['numThem'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($ba_bec_thematique['libThem']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-lg-4">
                <label for="search" class="form-label">Recherche par titre</label>
                <input
                    type="search"
                    id="search"
                    name="search"
                    class="form-control"
                    placeholder="Ex: victoire, équipe, match"
                    value="<?php echo htmlspecialchars($search, ENT_QUOTES); ?>"
                />
            </div>
            <div class="col-12 col-lg-4">
                <label for="keyword" class="form-label">Mots-clés</label>
                <input
                    type="text"
                    id="keyword"
                    name="keyword"
                    class="form-control"
                    placeholder="Ex: entraînement, événement"
                    value="<?php echo htmlspecialchars($ba_bec_keyword, ENT_QUOTES); ?>"
                />
            </div>
            <div class="col-12 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-primary">Appliquer les filtres</button>
                <a class="btn btn-outline-secondary" href="<?php echo ROOT_URL . '/actualites.php'; ?>">Réinitialiser</a>
                <p class="news-filters__count ms-lg-auto mb-0">
                    <?php echo count($ba_bec_articles); ?> actualité<?php echo count($ba_bec_articles) > 1 ? 's' : ''; ?> trouvée<?php echo count($ba_bec_articles) > 1 ? 's' : ''; ?>
                </p>
            </div>
        </form>
    </section>

    <section class="news-grid" aria-live="polite">
        <div class="row g-4">
            <?php if (!empty($ba_bec_articles)): ?>
                <?php foreach ($ba_bec_articles as $ba_bec_article): ?>
                    <?php
                    $ba_bec_imagePath = !empty($ba_bec_article['urlPhotArt'])
                        ? ROOT_URL . '/src/uploads/' . htmlspecialchars($ba_bec_article['urlPhotArt'])
                        : ROOT_URL . '/src/images/article.png';
                    $chapo = $ba_bec_article['libChapoArt'] ?? '';
                    $maxLength = 140;
                    $excerptBase = function_exists('mb_substr') ? mb_substr($chapo, 0, $maxLength) : substr($chapo, 0, $maxLength);
                    $chapoLength = function_exists('mb_strlen') ? mb_strlen($chapo) : strlen($chapo);
                    $excerpt = $excerptBase . ($chapoLength > $maxLength ? '...' : '');
                    ?>
                    <div class="col-12 col-lg-6">
                        <div class="card news-card h-100">
                            <div class="ratio ratio-4x3 news-card__media">
                                <img src="<?php echo $ba_bec_imagePath; ?>" class="news-card__image" alt="<?php echo htmlspecialchars($ba_bec_article['libTitrArt']); ?>">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="news-card__meta">
                                    <span class="badge text-bg-light"><?php echo htmlspecialchars($ba_bec_article['libThem']); ?></span>
                                </div>
                                <h2 class="card-title news-card__title">
                                    <?php echo htmlspecialchars($ba_bec_article['libTitrArt']); ?>
                                </h2>
                                <p class="card-text news-card__excerpt">
                                    <?php echo htmlspecialchars($excerpt); ?>
                                </p>
                                <a href="<?php echo ROOT_URL . '/article.php?numArt=' . (int) $ba_bec_article['numArt']; ?>" class="btn btn-outline-primary mt-auto">Lire la suite</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-light border news-empty" role="status">
                        Aucune actualité ne correspond à vos filtres pour le moment.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
require_once 'footer.php';
?>
