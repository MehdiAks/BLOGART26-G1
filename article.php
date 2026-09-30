<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/ctrlSaisies.php';

function resolve_article_image_url(?string $path, string $defaultImage): string
{
    return uploaded_file_url($path, $defaultImage);
}

// Vérification de la présence de numArt
if (!isset($_GET['numArt']) || empty($_GET['numArt'])) {
    die("Aucun article sélectionné.");
}

$ba_bec_numArt = (int)$_GET['numArt'];
$articleData = sql_select('ARTICLE', '*', 'numArt = ?', null, null, '1', [$ba_bec_numArt]);

// Vérification si l'article existe
if (empty($articleData)) {
    die("Article non trouvé.");
}

$ba_bec_article = $articleData[0];
$defaultImagePath = ROOT_URL . '/src/images/image-defaut.jpeg';
$ba_bec_articleImageUrl = resolve_article_image_url($ba_bec_article['urlPhotArt'] ?? null, $defaultImagePath);
$ba_bec_thematiques = sql_select("THEMATIQUE", "*");
$ba_bec_keywords = sql_select("MOTCLE", "*");
$ba_bec_selectedKeywords = sql_select('MOTCLEARTICLE', '*', 'numArt = ?', null, null, null, [$ba_bec_numArt]);

// Liste des mots-clés liés à l'article
$ba_bec_listMot = sql_select(
    'ARTICLE
    INNER JOIN MOTCLEARTICLE ON ARTICLE.numArt = MOTCLEARTICLE.numArt
    INNER JOIN MOTCLE ON MOTCLEARTICLE.numMotCle = MOTCLE.numMotCle',
    'ARTICLE.numArt, libMotCle',
    'ARTICLE.numArt = ?',
    null,
    null,
    null,
    [$ba_bec_numArt]
);

$ba_bec_article = $articleData[0];
$ba_bec_thematique = [];
if (!empty($ba_bec_article['numThem'])) {
    $ba_bec_thematique = sql_select('THEMATIQUE', '*', 'numThem = ?', null, null, '1', [(int) $ba_bec_article['numThem']])[0] ?? [];
}

// Récupération des statistiques likes/dislikes
$likeCount = sql_select('LIKEART', 'COUNT(*) as count', 'numArt = ? AND likeA = ?', null, null, null, [$ba_bec_numArt, 1])[0]['count'] ?? 0;
$dislikeCount = sql_select('LIKEART', 'COUNT(*) as count', 'numArt = ? AND likeA = ?', null, null, null, [$ba_bec_numArt, 0])[0]['count'] ?? 0;

// Vérification du vote de l'utilisateur
$userVote = null;
$ba_bec_libCom = isset($_POST['libCom']) ? ctrlSaisies($_POST['libCom']) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'utilisateur est connecté
    if (current_user_id() === null) {
        $_SESSION['error'] = "Vous devez être connecté pour ajouter un commentaire ou un like.";
        header("Location: " . ROOT_URL . "/views/backend/security/login.php");
        exit();
    }

    // Vérifie si c'est un like/dislike ou un commentaire
    if (isset($_POST['libCom'])) {
        // Récupérer l'ID du membre connecté et les autres données
        $ba_bec_numMemb = current_user_id();
        $ba_bec_libCom = ctrlSaisies($_POST['libCom']);
        $ba_bec_postedArticleId = (int) ($_POST['numArt'] ?? 0);
        if ($ba_bec_postedArticleId !== $ba_bec_numArt) {
            http_response_code(400);
            exit('Article invalide.');
        }
        if (!empty($ba_bec_libCom) && !empty($ba_bec_numArt) && !empty($ba_bec_numMemb)) {
            $ba_bec_commentResult = sql_insert('COMMENT', 'libCom, numArt, numMemb', '?, ?, ?', [$ba_bec_libCom, $ba_bec_numArt, $ba_bec_numMemb]);
            $ba_bec_commentResult['success']
                ? flash_success('Commentaire ajouté avec succès.')
                : flash_error('Impossible d’ajouter le commentaire.');
        } else {
            flash_error('Tous les champs du commentaire doivent être remplis.');
        }
        // Applique le modèle POST-Redirect-GET pour éviter une double soumission.
        header('Location: ' . ROOT_URL . '/article.php?numArt=' . $ba_bec_numArt . '#commentaires');
        exit();
    } else {

    
        // Le reste du code existant pour le traitement du like...
        $ba_bec_numMemb = current_user_id();
        $ba_bec_likeA = (int) ($_POST['likeA'] ?? -1);
        if (!in_array($ba_bec_likeA, [0, 1], true)) {
            http_response_code(400);
            exit('Vote invalide.');
        }

        // Vérifier si l'utilisateur a déjà voté
        $existingVote = sql_select('LIKEART', '*', 'numArt = ? AND numMemb = ?', null, null, '1', [$ba_bec_numArt, $ba_bec_numMemb]);

        if (!empty($existingVote)) {
            // Mettre à jour le vote
            $ba_bec_voteResult = sql_update('LIKEART', 'likeA = ?', 'numArt = ? AND numMemb = ?', [$ba_bec_likeA, $ba_bec_numArt, $ba_bec_numMemb]);
        } else {
            // Insérer un nouveau vote
            $ba_bec_voteResult = sql_insert('LIKEART', 'numArt, numMemb, likeA', '?, ?, ?', [$ba_bec_numArt, $ba_bec_numMemb, $ba_bec_likeA]);
        }

        $ba_bec_voteResult['success']
            ? flash_success('Votre vote a été enregistré.')
            : flash_error('Impossible d’enregistrer votre vote.');
        // Applique le modèle POST-Redirect-GET pour éviter une double soumission.
        header('Location: ' . ROOT_URL . '/article.php?numArt=' . $ba_bec_numArt . '#commentaires');
        exit();
    }
}

// Récupérer l'article actuel avec ses commentaires
$ba_bec_numArt = (int) $_GET['numArt']; // Assure-toi d'avoir l'ID de l'article dans l'URL
$comments = sql_select(
    'COMMENT c INNER JOIN MEMBRE m ON c.numMemb = m.numMemb',
    'c.libCom, c.dtCreaCom, m.pseudoMemb',
    'c.numArt = ? AND c.delLogiq = 0 AND c.attModOK = 1',
    null,
    null,
    null,
    [$ba_bec_numArt]
);
// Afficher l'article et ses commentaires
$ba_bec_article = sql_select('ARTICLE', '*', 'numArt = ?', null, null, '1', [$ba_bec_numArt])[0];





// Vérification du vote de l'utilisateur
$userVote = null;
if (current_user_id() !== null) {
    $ba_bec_numMemb = current_user_id();
    $userVoteData = sql_select('LIKEART', 'likeA', 'numArt = ? AND numMemb = ?', null, null, '1', [$ba_bec_numArt, $ba_bec_numMemb]);
    $userVote = !empty($userVoteData) ? $userVoteData[0]['likeA'] : null;
}
$ba_bec_articleFlash = flash_get();

$pageStyles = [
    ROOT_URL . '/src/css/css-propre/fonts.css',
    ROOT_URL . '/src/css/stylearticle.css',
];
$pageTitle = strip_tags((string) $ba_bec_article['libTitrArt']);
$pageDescription = strip_tags((string) $ba_bec_article['libChapoArt']);
require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php';
?>
    <div class="article-page">
        <header class="article-hero container">
                <h1 class="article-title">
                    <?php echo renderBbcode($ba_bec_article['libTitrArt']); ?>
                </h1>
                <div class="article-meta">
                    <span><?php echo e(format_date_fr($ba_bec_article['dtCreaArt'])); ?></span>
                </div>
        </header>

        <section class="article-body">
            <div class="container">
                <div class="article-lead">
                    <?php echo renderBbcode($ba_bec_article['libChapoArt']); ?> 
                </div>
                <figure class="article-figure article-figure--lead">
                    <img class="img-fluid w-100" src="<?php echo e($ba_bec_articleImageUrl); ?>" alt="<?php echo e(strip_tags((string) $ba_bec_article['libTitrArt'])); ?>" loading="lazy" decoding="async">
                </figure>
                <div class="article-taxonomy mb-4">
                    <p class="article-theme mb-1">
                        <strong>Thématique :</strong>
                        <?php echo !empty($ba_bec_thematique['libThem']) ? htmlspecialchars($ba_bec_thematique['libThem']) : 'Non renseignée'; ?>
                    </p>
                    <p class="article-keywords mb-0">
                        <strong>Mots-clés :</strong>
                        <?php if (!empty($ba_bec_listMot)): ?>
                            <?php
                            $ba_bec_keywordLabels = array_map(
                                static fn($ba_bec_mot) => htmlspecialchars($ba_bec_mot['libMotCle']),
                                $ba_bec_listMot
                            );
                            echo implode(', ', $ba_bec_keywordLabels);
                            ?>
                        <?php else: ?>
                            Aucun mot-clé.
                        <?php endif; ?>
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-lg-8">
                        <article class="bg-white">
                        <h2 class="phraseaccroche">
                            <?php echo renderBbcode($ba_bec_article['libAccrochArt']); ?> 
                        </h2>
                        <p class="paragraphe">
                            <?php echo renderBbcode($ba_bec_article['parag1Art']); ?> 
                        </p>
                        <div class="text-with-line">
                            <?php echo renderBbcode($ba_bec_article['libSsTitr1Art']); ?> 
                        </div>

                        <p class="paragraphe2">
                            <?php echo renderBbcode($ba_bec_article['parag2Art']); ?>
                        </p>

                        <div class="text-with-line">
                            <?php echo renderBbcode($ba_bec_article['libSsTitr2Art']); ?>
                        </div>

                        <p class="paragraphe3">
                            <?php echo renderBbcode($ba_bec_article['parag3Art']); ?>
                        </p>

                        <p class="conclusion">
                            <?php echo renderBbcode($ba_bec_article['libConclArt']); ?>
                        </p>
                    </article>

                    <div class="likes-section">
                        <h2>Évaluer cet article</h2>
                        <p class="likes-count">Nombre de likes : <?php echo (int) $likeCount; ?> · Dislikes : <?php echo (int) $dislikeCount; ?></p>
                        <div class="vote-buttons d-flex gap-3">
                            <form action="article.php?numArt=<?php echo (int) $ba_bec_numArt; ?>" method="post">
                                <input type="hidden" name="numArt" value="<?php echo (int) $ba_bec_numArt; ?>">
                                <input type="hidden" name="likeA" value="1">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-light d-flex align-items-center gap-2 btn-vote <?php echo $userVote === 1 ? 'active-like' : ''; ?>">
                                    <img src="<?php echo ROOT_URL . '/src/images/icon/pnglike.png'; ?>" alt="Like" loading="lazy" decoding="async">
                                    <span><?php echo (int) $likeCount; ?></span>
                                </button>
                            </form>

                            <form action="article.php?numArt=<?php echo (int) $ba_bec_numArt; ?>" method="post">
                                <input type="hidden" name="numArt" value="<?php echo (int) $ba_bec_numArt; ?>">
                                <input type="hidden" name="likeA" value="0">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-light d-flex align-items-center gap-2 btn-vote <?php echo $userVote === 0 ? 'active-dislike' : ''; ?>">
                                    <img src="<?php echo ROOT_URL . '/src/images/icon/pngdislike.png'; ?>" alt="Dislike" loading="lazy" decoding="async">
                                    <span><?php echo (int) $dislikeCount; ?></span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="comments-block">
                        <h2>Ajouter un commentaire</h2>
                        <form action="article.php?numArt=<?php echo (int) $ba_bec_numArt; ?>" method="post" class="comment-form">
                            <div class="champ">
                                <textarea id="libCom" name="libCom" class="form-control" type="text" required></textarea>
                            </div>
                            <input type="hidden" name="numArt" value="<?php echo (int) $ba_bec_numArt; ?>" />
                            <?= csrf_field() ?>
                            <div class="btn-se-connecter">
                                <button type="submit" class="btn btn-primary">Envoyer</button>
                            </div>  
                        </form>
                    </div>

                    <div class="comments-block" id="commentaires">
                        <h2>Commentaires</h2>
                        <?php foreach ($ba_bec_articleFlash as $ba_bec_flash): ?>
                            <?php $ba_bec_alertClass = ($ba_bec_flash['type'] ?? '') === 'success' ? 'success' : 'danger'; ?>
                            <div class="alert alert-<?php echo $ba_bec_alertClass; ?>" role="alert">
                                <?php echo e($ba_bec_flash['message'] ?? ''); ?>
                            </div>
                        <?php endforeach; ?>
                        <?php if (!empty($comments)): ?>
                            <ul class="comments-list">
                                <?php foreach ($comments as $ba_bec_comment): ?>
                                    <li class="commentairesaf">
                                        <div class="comment-meta">
                                            <span class="username"><?php echo htmlspecialchars($ba_bec_comment['pseudoMemb']); ?></span> 
                                            <span class="date"><?php echo e(format_date_fr($ba_bec_comment['dtCreaCom'], true)); ?></span>
                                        </div>
                                        <p class="commentaire"><?php echo renderBbcode($ba_bec_comment['libCom']); ?></p>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>Il n'y a pas encore de commentaires pour cet article.</p>
                        <?php endif; ?>
                    </div>
                    </div>

                    <aside class="article-sidebar col-12 col-lg-4">
                        <h2>Autres articles</h2>
                        <?php
                        $randomArticles = sql_select('ARTICLE', '*', null, null, 'RAND()', '3');

                        if (!empty($randomArticles)):
                            foreach ($randomArticles as $randomArticle): ?>
                                <?php
                                $randomImageUrl = resolve_article_image_url(
                                    $randomArticle['urlPhotArt'] ?? null,
                                    $defaultImagePath
                                );
                                ?>
                                <div class="random-article">
                                    <img class="imagedroite img-fluid w-100" src="<?php echo e($randomImageUrl); ?>" alt="Image article" loading="lazy" decoding="async">
                                    <h3 class="titredroite">
                                        <?php echo renderBbcode($randomArticle['libTitrArt']); ?>
                                    </h3>
                                    <p class="txtdroite">
                                        <?php echo renderBbcode($randomArticle['libChapoArt']); ?>
                                    </p>
                                    <a href="article.php?numArt=<?php echo (int) $randomArticle['numArt']; ?>" class="btn btn-outline-primary btn-sm">Lire l'article →</a>
                                </div>
                            <?php endforeach;
                        else: ?>
                            <p>Aucun article disponible.</p>
                        <?php endif; ?>
                    </aside>
                </div>
            </div>
        </section>
    </div>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
?>
