<?php
// Inclut la configuration globale du site en utilisant le chemin racine du serveur.
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Définit la liste des feuilles de style à charger pour cette page.
$pageStyles = [
    // Ajoute le CSS global du site.
    ROOT_URL . '/src/css/style.css',
    // Ajoute le CSS spécifique à la page actualités.
    ROOT_URL . '/src/css/actualites.css',
];

// Inclut l'en-tête du site.
require_once 'header.php';

// Ouvre la connexion à la base de données.
sql_connect();

// Récupère et nettoie le terme de recherche depuis l'URL.
$search = trim($_GET['search'] ?? '');
// Récupère et nettoie le mot-clé depuis l'URL.
$ba_bec_keyword = trim($_GET['keyword'] ?? '');
// Récupère l'identifiant de thématique depuis l'URL et le convertit en entier.
$theme = isset($_GET['theme']) ? (int) $_GET['theme'] : 0;
// Récupère le mode de tri depuis l'URL.
$sort = $_GET['sort'] ?? 'recent';
// Détermine si la requête est partielle (AJAX).
$isPartial = isset($_GET['partial']) && $_GET['partial'] === '1';

// Déclare une fonction qui résout l'URL d'image d'un article.
function resolve_article_image_url(?string $path, string $defaultImage): string
{
    // Si aucun chemin n'est fourni, on renvoie l'image par défaut.
    if (!$path) {
        // Retourne l'URL de l'image par défaut.
        return $defaultImage;
    }

    // Si le chemin est déjà une URL HTTP/HTTPS, on le renvoie tel quel.
    if (preg_match('/^https?:\/\//', $path)) {
        // Retourne l'URL externe telle quelle.
        return $path;
    }

    // Vérifie si le chemin contient le dossier d'uploads.
    if (strpos($path, '/src/uploads/') !== false) {
        // Extrait la partie relative après /src/uploads/.
        $relative = substr($path, strpos($path, '/src/uploads/') + strlen('/src/uploads/'));
    } else {
        // Nettoie le chemin pour en faire une forme relative.
        $relative = ltrim($path, '/');
    }

    // Construit le chemin complet sur le disque.
    $filePath = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $relative;
    // Si le fichier existe sur le disque, on renvoie son URL publique.
    if (file_exists($filePath)) {
        // Retourne l'URL du fichier uploadé.
        return ROOT_URL . '/src/uploads/' . $relative;
    }

    // Si le fichier n'existe pas, on renvoie l'image par défaut.
    return $defaultImage;
}

// Déclare une fonction qui formate le compteur d'actualités.
function format_news_count(int $count): string
{
    // Ajoute un suffixe "s" si le nombre est supérieur à 1.
    $suffix = $count > 1 ? 's' : '';
    // Construit la phrase de compteur avec accord pluriel.
    return $count . ' actualité' . $suffix . ' trouvée' . $suffix;
}

// Prépare la requête pour obtenir les thématiques.
$themeStmt = $DB->prepare('SELECT numThem, libThem FROM THEMATIQUE ORDER BY libThem ASC');
// Exécute la requête des thématiques.
$themeStmt->execute();
// Récupère toutes les thématiques sous forme de tableau associatif.
$ba_bec_thematiques = $themeStmt->fetchAll(PDO::FETCH_ASSOC);

// Prépare la requête pour obtenir les mots-clés.
$keywordStmt = $DB->prepare('SELECT libMotCle FROM MOTCLE ORDER BY libMotCle ASC');
// Exécute la requête des mots-clés.
$keywordStmt->execute();
// Récupère les mots-clés, les nettoie et supprime les entrées vides.
$ba_bec_keywords = array_values(array_filter(array_map('trim', $keywordStmt->fetchAll(PDO::FETCH_COLUMN)), 'strlen'));

// Initialise le tableau des conditions SQL.
$conditions = [];
// Initialise le tableau des paramètres SQL.
$params = [];

// Ajoute un filtre de thématique si une thématique est sélectionnée.
if ($theme > 0) {
    // Ajoute la condition SQL pour la thématique.
    $conditions[] = 'a.numThem = :theme';
    // Ajoute le paramètre de thématique.
    $params[':theme'] = $theme;
}

// Ajoute un filtre de recherche si le champ n'est pas vide.
if ($search !== '') {
    // Ajoute la condition SQL de recherche sur le titre.
    $conditions[] = 'a.libTitrArt LIKE :search';
    // Ajoute le paramètre de recherche avec jokers.
    $params[':search'] = '%' . $search . '%';
}

// Ajoute un filtre de mot-clé si le champ n'est pas vide.
if ($ba_bec_keyword !== '') {
    // Ajoute la condition SQL sur plusieurs champs de texte.
    $conditions[] = '(a.libChapoArt LIKE :keyword OR a.libAccrochArt LIKE :keyword OR a.parag1Art LIKE :keyword OR a.parag2Art LIKE :keyword OR a.parag3Art LIKE :keyword)';
    // Ajoute le paramètre de mot-clé avec jokers.
    $params[':keyword'] = '%' . $ba_bec_keyword . '%';
}

// Définit la correspondance entre options de tri et clause SQL.
$orderMap = [
    // Tri par date décroissante.
    'recent' => 'a.dtCreaArt DESC',
    // Tri par date croissante.
    'oldest' => 'a.dtCreaArt ASC',
    // Tri par nombre de likes puis date.
    'liked' => 'likeCount DESC, a.dtCreaArt DESC',
];
// Sélectionne la clause ORDER BY selon le tri demandé.
$orderBy = $orderMap[$sort] ?? $orderMap['recent'];

// Construit la requête SQL de base pour récupérer les articles.
$query = 'SELECT a.numArt, a.libTitrArt, a.libChapoArt, a.urlPhotArt, t.libThem, COALESCE(l.likeCount, 0) as likeCount FROM ARTICLE a INNER JOIN THEMATIQUE t ON a.numThem = t.numThem LEFT JOIN (SELECT numArt, COUNT(*) as likeCount FROM LIKEART WHERE likeA = 1 GROUP BY numArt) l ON a.numArt = l.numArt';
// Ajoute les conditions WHERE si elles existent.
if (!empty($conditions)) {
    // Concatène les conditions avec AND.
    $query .= ' WHERE ' . implode(' AND ', $conditions);
}
// Ajoute la clause ORDER BY.
$query .= ' ORDER BY ' . $orderBy;

// Prépare la requête finale.
$articleStmt = $DB->prepare($query);
// Exécute la requête avec les paramètres.
$articleStmt->execute($params);
// Récupère toutes les actualités.
$ba_bec_articles = $articleStmt->fetchAll(PDO::FETCH_ASSOC);

// Déclare une fonction qui génère la grille d'actualités.
function render_news_grid(array $ba_bec_articles): string
{
    // Calcule le nombre d'articles.
    $articleCount = count($ba_bec_articles);
    // Génère le libellé du compteur.
    $countLabel = format_news_count($articleCount);
    // Démarre la mise en mémoire tampon de la sortie.
    ob_start();
    ?>
    <!-- Déclare la section contenant la grille d'actualités. -->
    <section class="news-grid" aria-live="polite" data-news-count="<?php echo $articleCount; ?>" data-news-count-label="<?php echo htmlspecialchars($countLabel, ENT_QUOTES); ?>">
        <!-- Ouvre une rangée Bootstrap pour les cartes. -->
        <div class="row g-4">
            <!-- Vérifie s'il y a des articles à afficher. -->
            <?php if (!empty($ba_bec_articles)): ?>
                <!-- Démarre la boucle sur les articles. -->
                <?php foreach ($ba_bec_articles as $ba_bec_article): ?>
                    <?php
                    // Définit l'image par défaut.
                    $defaultImagePath = ROOT_URL . '/src/images/image-defaut.jpeg';
                    // Résout l'image de l'article.
                    $ba_bec_imagePath = resolve_article_image_url($ba_bec_article['urlPhotArt'] ?? null, $defaultImagePath);
                    // Récupère le chapô.
                    $chapo = $ba_bec_article['libChapoArt'] ?? '';
                    // Définit la longueur max de l'extrait.
                    $maxLength = 140;
                    // Calcule la base de l'extrait avec gestion des multioctets.
                    $excerptBase = function_exists('mb_substr') ? mb_substr($chapo, 0, $maxLength) : substr($chapo, 0, $maxLength);
                    // Calcule la longueur du chapô avec gestion des multioctets.
                    $chapoLength = function_exists('mb_strlen') ? mb_strlen($chapo) : strlen($chapo);
                    // Ajoute des points de suspension si nécessaire.
                    $excerpt = $excerptBase . ($chapoLength > $maxLength ? '...' : '');
                    ?>
                    <!-- Colonne responsive pour chaque carte. -->
                    <div class="col-12 col-lg-6">
                        <!-- Carte d'actualité. -->
                        <div class="card news-card h-100">
                            <!-- Conteneur de ratio pour l'image. -->
                            <div class="ratio ratio-4x3 news-card__media">
                                <!-- Image de l'article. -->
                                <img src="<?php echo $ba_bec_imagePath; ?>" class="news-card__image" alt="<?php echo htmlspecialchars($ba_bec_article['libTitrArt']); ?>">
                            </div>
                            <!-- Corps de la carte. -->
                            <div class="card-body d-flex flex-column">
                                <!-- Métadonnées de la carte. -->
                                <div class="news-card__meta">
                                    <!-- Badge de thématique. -->
                                    <span class="badge text-bg-light"><?php echo htmlspecialchars($ba_bec_article['libThem']); ?></span>
                                </div>
                                <!-- Titre de l'article. -->
                                <h2 class="card-title news-card__title">
                                    <?php echo htmlspecialchars($ba_bec_article['libTitrArt']); ?>
                                </h2>
                                <!-- Extrait de l'article. -->
                                <p class="card-text news-card__excerpt">
                                    <?php echo htmlspecialchars($excerpt); ?>
                                </p>
                                <!-- Lien vers la page de l'article. -->
                                <a href="<?php echo ROOT_URL . '/article.php?numArt=' . (int) $ba_bec_article['numArt']; ?>" class="btn btn-outline-primary mt-auto">Lire la suite</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Affiche un message si aucun article n'est trouvé. -->
                <div class="col-12">
                    <!-- Alerte de vide. -->
                    <div class="alert alert-light border news-empty" role="status">
                        Aucune actualité ne correspond à vos filtres pour le moment.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php
    // Retourne le HTML généré.
    return ob_get_clean();
}

// Si la requête est partielle, on renvoie uniquement la grille.
if ($isPartial) {
    // Affiche la grille filtrée.
    echo render_news_grid($ba_bec_articles);
    // Stoppe le script.
    exit;
}
?>

<!-- Débute la zone principale de la page. -->
<main class="container py-5">
    <!-- Section de résumé des actualités. -->
    <section class="news-summary">
        <!-- Ligne d'accroche. -->
        <p class="news-summary__eyebrow">Actualités</p>
        <!-- Titre principal. -->
        <h1 class="news-summary__title">Restez au plus près de la vie du club</h1>
        <!-- Paragraphe descriptif. -->
        <p class="news-summary__text">
            Entre résultats, interviews, moments forts et coulisses, retrouvez ici l'ensemble des actualités du BEC.
            Ce fil éditorial met en avant les histoires qui font vibrer la communauté, avec des mises à jour régulières
            pour ne rien manquer des temps forts.
        </p>
    </section>

    <!-- Section des filtres d'actualités. -->
    <section class="news-filters" aria-label="Filtres des actualités">
        <!-- Formulaire de filtres. -->
        <form method="get" class="row g-3 align-items-end">
            <!-- Colonne thématique. -->
            <div class="col-12 col-lg-3">
                <!-- Label du select. -->
                <label for="theme" class="form-label">Thématique</label>
                <!-- Select des thématiques. -->
                <select id="theme" name="theme" class="form-select">
                    <!-- Option toutes thématiques. -->
                    <option value="0">Toutes les thématiques</option>
                    <!-- Boucle sur les thématiques. -->
                    <?php foreach ($ba_bec_thematiques as $ba_bec_thematique): ?>
                        <!-- Option de thématique. -->
                        <option value="<?php echo (int) $ba_bec_thematique['numThem']; ?>" <?php echo $theme === (int) $ba_bec_thematique['numThem'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($ba_bec_thematique['libThem']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Colonne recherche titre. -->
            <div class="col-12 col-lg-3">
                <!-- Label du champ recherche. -->
                <label for="search" class="form-label">Recherche par titre</label>
                <!-- Champ de recherche. -->
                <input
                    type="search"
                    id="search"
                    name="search"
                    class="form-control"
                    placeholder="Ex: victoire, équipe, match"
                    value="<?php echo htmlspecialchars($search, ENT_QUOTES); ?>"
                />
            </div>
            <!-- Colonne mots-clés. -->
            <div class="col-12 col-lg-3">
                <!-- Label du champ mots-clés. -->
                <label for="keyword" class="form-label">Mots-clés</label>
                <!-- Champ texte pour mots-clés. -->
                <input
                    type="text"
                    id="keyword"
                    name="keyword"
                    class="form-control"
                    placeholder="Ex: entraînement, événement"
                    list="keyword-options"
                    data-keywords="<?php echo htmlspecialchars(json_encode($ba_bec_keywords, JSON_UNESCAPED_UNICODE), ENT_QUOTES); ?>"
                    value="<?php echo htmlspecialchars($ba_bec_keyword, ENT_QUOTES); ?>"
                />
                <!-- Liste de suggestions pour les mots-clés. -->
                <datalist id="keyword-options">
                    <!-- Boucle sur les options de mots-clés. -->
                    <?php foreach ($ba_bec_keywords as $ba_bec_keyword_option): ?>
                        <!-- Option de suggestion. -->
                        <option value="<?php echo htmlspecialchars($ba_bec_keyword_option, ENT_QUOTES); ?>"></option>
                    <?php endforeach; ?>
                </datalist>
            </div>
            <!-- Colonne tri. -->
            <div class="col-12 col-lg-3">
                <!-- Label du select tri. -->
                <label for="sort" class="form-label">Trier</label>
                <!-- Select de tri. -->
                <select id="sort" name="sort" class="form-select">
                    <!-- Option tri récent. -->
                    <option value="recent" <?php echo $sort === 'recent' ? 'selected' : ''; ?>>Plus récent</option>
                    <!-- Option tri ancien. -->
                    <option value="oldest" <?php echo $sort === 'oldest' ? 'selected' : ''; ?>>Plus ancien</option>
                    <!-- Option tri plus likés. -->
                    <option value="liked" <?php echo $sort === 'liked' ? 'selected' : ''; ?>>Les plus likés</option>
                </select>
            </div>
            <!-- Ligne pour les boutons et le compteur. -->
            <div class="col-12 d-flex flex-wrap gap-2">
                <!-- Bouton de réinitialisation. -->
                <button type="button" class="btn btn-outline-secondary" id="news-reset">Réinitialiser</button>
                <!-- Bouton d'envoi des filtres. -->
                <button type="submit" class="btn btn-primary">Appliquer les filtres</button>
                <!-- Compteur d'actualités. -->
                <p class="news-filters__count ms-lg-auto mb-0" id="news-count">
                    <?php echo format_news_count(count($ba_bec_articles)); ?>
                </p>
            </div>
        </form>
    </section>

    <!-- Insère la grille d'actualités. -->
    <?php echo render_news_grid($ba_bec_articles); ?>
</main>

<!-- Démarre le script de gestion des filtres. -->
<script>
// Attend que le DOM soit prêt.
document.addEventListener('DOMContentLoaded', () => {
    // Sélectionne le formulaire de filtres.
    const form = document.querySelector('.news-filters form');
    // Sélectionne la grille d'actualités.
    let grid = document.querySelector('.news-grid');
    // Sélectionne le bouton de réinitialisation.
    const resetButton = document.getElementById('news-reset');
    // Sélectionne le champ des mots-clés.
    const keywordInput = document.getElementById('keyword');
    // Sélectionne la datalist des mots-clés.
    const keywordOptions = document.getElementById('keyword-options');
    // Vérifie la disponibilité des éléments et de fetch.
    if (!form || !grid || typeof window.fetch !== 'function') {
        // Quitte si les prérequis ne sont pas présents.
        return;
    }

    // Lit la liste des mots-clés depuis l'attribut data.
    const keywordList = keywordInput?.dataset.keywords
        ? JSON.parse(keywordInput.dataset.keywords)
        : [];

    // Met à jour les suggestions de mots-clés.
    const updateKeywordOptions = (value) => {
        // Si la datalist n'existe pas, on ne fait rien.
        if (!keywordOptions) {
            // Quitte la fonction.
            return;
        }
        // Nettoie la valeur saisie pour le filtrage.
        const query = value.trim().toLowerCase();
        // Calcule les correspondances selon la saisie.
        const matches = query === ''
            ? keywordList
            : keywordList.filter((item) => item.toLowerCase().includes(query));
        // Remplit la datalist avec les correspondances.
        keywordOptions.innerHTML = matches
            .map((item) => `<option value="${item.replace(/"/g, '&quot;')}"></option>`)
            .join('');
    };

    // Déclare un timer pour le debounce.
    let debounceTimer;
    // Crée une fonction qui temporise la requête.
    const debounceFetch = () => {
        // Annule le timer précédent.
        window.clearTimeout(debounceTimer);
        // Planifie un nouvel appel.
        debounceTimer = window.setTimeout(() => {
            // Soumet les filtres avec un délai.
            submitFilters();
        }, 300);
    };

    // Construit l'URL de requête avec ou sans mode partiel.
    const buildUrl = (includePartial) => {
        // Récupère les données du formulaire.
        const formData = new FormData(form);
        // Ajoute l'indicateur de requête partielle si nécessaire.
        if (includePartial) {
            // Ajoute le paramètre partial=1.
            formData.append('partial', '1');
        }
        // Transforme les données en paramètres d'URL.
        const params = new URLSearchParams(formData);
        // Détermine l'action du formulaire ou l'URL courante.
        const action = form.getAttribute('action') || window.location.pathname;
        // Retourne l'URL complète.
        return `${action}?${params.toString()}`;
    };

    // Soumet les filtres via AJAX.
    const submitFilters = async () => {
        // Construit l'URL de requête partielle.
        const url = buildUrl(true);
        try {
            // Envoie la requête fetch avec un header AJAX.
            const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            // Vérifie la validité de la réponse.
            if (!response.ok) {
                // Lance une erreur si la réponse n'est pas OK.
                throw new Error('Network response was not ok');
            }
            // Lit le HTML retourné.
            const html = await response.text();
            // Crée un conteneur temporaire.
            const temp = document.createElement('div');
            // Insère le HTML dans le conteneur.
            temp.innerHTML = html;
            // Récupère la nouvelle grille depuis le HTML.
            const newGrid = temp.querySelector('.news-grid');
            // Vérifie que la grille existe.
            if (!newGrid) {
                // Lance une erreur si aucune grille n'est trouvée.
                throw new Error('No grid found in response');
            }
            // Remplace l'ancienne grille par la nouvelle.
            grid.replaceWith(newGrid);
            // Met à jour la référence à la grille.
            grid = newGrid;
            // Sélectionne le compteur d'actualités.
            const countElement = document.getElementById('news-count');
            // Met à jour le compteur si possible.
            if (countElement && newGrid.dataset.newsCountLabel) {
                // Modifie le texte du compteur.
                countElement.textContent = newGrid.dataset.newsCountLabel;
            }
            // Construit l'URL sans mode partiel pour l'historique.
            const historyUrl = buildUrl(false);
            // Met à jour l'URL dans l'historique du navigateur.
            window.history.replaceState({}, '', historyUrl);
        } catch (error) {
            // En cas d'erreur, soumet le formulaire normalement.
            form.submit();
        }
    };

    // Intercepte la soumission du formulaire.
    form.addEventListener('submit', (event) => {
        // Empêche l'envoi classique du formulaire.
        event.preventDefault();
        // Soumet les filtres en AJAX.
        submitFilters();
    });

    // Déclenche un filtrage lors d'un changement de select.
    form.addEventListener('change', (event) => {
        // Vérifie que l'élément modifié est un select.
        if (event.target.matches('select')) {
            // Soumet les filtres.
            submitFilters();
        }
    });

    // Déclenche un filtrage lors de la saisie.
    form.addEventListener('input', (event) => {
        // Vérifie que l'élément est un champ texte/recherche.
        if (event.target.matches('input[type="search"], input[type="text"]')) {
            // Met à jour la liste de mots-clés si nécessaire.
            if (event.target === keywordInput) {
                // Met à jour les options de mots-clés.
                updateKeywordOptions(event.target.value);
            }
            // Lance un fetch temporisé.
            debounceFetch();
        }
    });

    // Ajoute le comportement du bouton de réinitialisation.
    if (resetButton) {
        // Écoute le clic sur le bouton.
        resetButton.addEventListener('click', () => {
            // Réinitialise le formulaire.
            form.reset();
            // Met à jour les options si le champ existe.
            if (keywordInput) {
                // Met à jour les suggestions de mots-clés.
                updateKeywordOptions(keywordInput.value);
            }
            // Relance le filtrage.
            submitFilters();
        });
    }

    // Initialise les suggestions si le champ existe.
    if (keywordInput) {
        // Remplit la datalist dès le chargement.
        updateKeywordOptions(keywordInput.value);
    }
});
</script>

<?php
// Inclut le pied de page du site.
require_once 'footer.php';
?>
