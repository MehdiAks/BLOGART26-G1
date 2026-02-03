<?php
require_once 'header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/ctrlSaisies.php';

// Vérification de la présence de numArt
if (!isset($_GET['numArt']) || empty($_GET['numArt'])) {
    die("Aucun article sélectionné.");
}

$ba_bec_numArt = (int)$_GET['numArt'];
$articleData = sql_select("ARTICLE", "*", "numArt = $ba_bec_numArt");

// Vérification si l'article existe
if (empty($articleData)) {
    die("Article non trouvé.");
}

$ba_bec_article = $articleData[0];
$ba_bec_thematiques = sql_select("THEMATIQUE", "*");
$ba_bec_keywords = sql_select("MOTCLE", "*");
$ba_bec_selectedKeywords = sql_select("MOTCLEARTICLE", "*", "numArt = $ba_bec_numArt");

// Liste des mots-clés liés à l'article
$ba_bec_listMot = sql_select(
    'ARTICLE
    INNER JOIN MOTCLEARTICLE ON ARTICLE.numArt = MOTCLEARTICLE.numArt
    INNER JOIN MOTCLE ON MOTCLEARTICLE.numMotCle = MOTCLE.numMotCle',
    'ARTICLE.numArt, libMotCle',
    "ARTICLE.numArt = '$ba_bec_numArt'"
);

$ba_bec_article = $articleData[0];

// Récupération des statistiques likes/dislikes
$likeCount = sql_select("LIKEART", "COUNT(*) as count", "numArt = $ba_bec_numArt AND likeA = 1")[0]['count'] ?? 0;
$dislikeCount = sql_select("LIKEART", "COUNT(*) as count", "numArt = $ba_bec_numArt AND likeA = 0")[0]['count'] ?? 0;

// Vérification du vote de l'utilisateur
$userVote = null;
$ba_bec_libCom = isset($_POST['libCom']) ? ($_POST['libCom']) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error'] = "Vous devez être connecté pour ajouter un commentaire ou un like.";
        header("Location: " . ROOT_URL . "/views/backend/security/login.php");
        exit();
    }

    // Vérifie si c'est un like/dislike ou un commentaire
    if (isset($_POST['libCom'])) {
        // Récupérer l'ID du membre connecté et les autres données
        $ba_bec_numMemb = $_SESSION['user_id'];
        $ba_bec_libCom = ($_POST['libCom']);
        $ba_bec_numArt = (int)$_POST['numArt'];
        if (!empty($ba_bec_libCom) && !empty($ba_bec_numArt) && !empty($ba_bec_numMemb)) {
            sql_insert('comment', 'libCom, numArt, numMemb', "'$ba_bec_libCom', '$ba_bec_numArt', '$ba_bec_numMemb'");
            echo "<p style='color: green;'>Commentaire ajouté avec succès !</p>";
        } else {
            echo "<p style='color: red;'>Erreur : tous les champs doivent être remplis correctement.</p>";
        }
    } else {

    
        // Le reste du code existant pour le traitement du like...
        $ba_bec_numMemb = $_SESSION['user_id'];
        $ba_bec_likeA = (int)$_POST['likeA'];

        // Vérifier si l'utilisateur a déjà voté
        $existingVote = sql_select("LIKEART", "*", "numArt = $ba_bec_numArt AND numMemb = $ba_bec_numMemb");

        if (!empty($existingVote)) {
            // Mettre à jour le vote
            sql_update("LIKEART", "likeA = $ba_bec_likeA", "numArt = $ba_bec_numArt AND numMemb = $ba_bec_numMemb");
        } else {
            // Insérer un nouveau vote
            sql_insert("LIKEART", "numArt, numMemb, likeA", "'$ba_bec_numArt', '$ba_bec_numMemb', '$ba_bec_likeA'");
        }

        // Recharger la page pour mettre à jour le nombre de likes/dislikes
        header("Location: article.php?numArt=$ba_bec_numArt");
        exit();
    }
}



// Récupérer l'article actuel avec ses commentaires
$ba_bec_numArt = $_GET['numArt']; // Assure-toi d'avoir l'ID de l'article dans l'URL
$comments = sql_select("comment c 
                        INNER JOIN membre m ON c.numMemb = m.numMemb 
                        WHERE c.numArt = $ba_bec_numArt 
                        AND c.delLogiq = 0", 
                        "c.libCom, c.dtCreaCom, m.pseudoMemb");
$comments = sql_select("comment c 
                        INNER JOIN membre m ON c.numMemb = m.numMemb 
                        WHERE c.numArt = $ba_bec_numArt 
                        AND c.delLogiq = 0
                        AND c.attModOK = 1", 
                        "c.libCom, c.dtCreaCom, m.pseudoMemb");
// Afficher l'article et ses commentaires
$ba_bec_article = sql_select("article", "*", "numArt = $ba_bec_numArt")[0];





// Vérification du vote de l'utilisateur
$userVote = null;
if (isset($_SESSION['user_id'])) {
    $ba_bec_numMemb = $_SESSION['user_id'];
    $userVoteData = sql_select("LIKEART", "likeA", "numArt = $ba_bec_numArt AND numMemb = $ba_bec_numMemb");
    $userVote = !empty($userVoteData) ? $userVoteData[0]['likeA'] : null;
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo ROOT_URL; ?>/src/css/css-propre/fonts.css" rel="stylesheet"/>
    <link href="<?php echo ROOT_URL; ?>/src/css/stylearticle.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            overflow-x: hidden;
        }
    </style>
</head>

<body>
    <div class="article-page">
        <header class="article-hero" style="--hero-image: url('<?php echo ROOT_URL . '/src/uploads/' . ($ba_bec_article['urlPhotArt']); ?>')">
            <div class="article-hero__overlay">
                <p class="article-kicker">Actualités</p>
                <h1 class="article-title">
                    <?php echo ($ba_bec_article['libTitrArt']); ?>
                </h1>
                <div class="article-meta">
                    <span><?php echo ($ba_bec_article['dtCreaArt']); ?></span>
                    <span class="article-meta__dot">•</span>
                    <span>Lecture 2 min</span>
                </div>
            </div>
        </header>

        <section class="article-body">
            <div class="container">
                <div class="article-lead">
                    <?php echo ($ba_bec_article['libChapoArt']); ?> 
                </div>

                <div class="row g-4">
                    <div class="col-12 col-lg-8">
                        <article class="bg-white">
                        <h2 class="phraseaccroche">
                            <?php echo ($ba_bec_article['libAccrochArt']); ?> 
                        </h2>
                        <p class="paragraphe">
                            <?php echo ($ba_bec_article['parag1Art']); ?> 
                        </p>
                        <figure class="article-figure">
                            <img class="image2 img-fluid w-100" src="<?php echo ROOT_URL . '/src/uploads/' . ($ba_bec_article['urlPhotArt']); ?>" alt="Image article">
                            <figcaption class="article-caption">
                                © Groupe 1 Bordeaux étudiant club + Description de l’image
                            </figcaption>
                        </figure>

                        <div class="text-with-line">
                            <?php echo ($ba_bec_article['libSsTitr1Art']); ?> 
                        </div>

                        <p class="paragraphe2">
                            <?php echo ($ba_bec_article['parag2Art']); ?>
                        </p>

                        <div class="text-with-line">
                            <?php echo ($ba_bec_article['libSsTitr2Art']); ?>
                        </div>

                        <p class="paragraphe3">
                            <?php echo ($ba_bec_article['parag3Art']); ?>
                        </p>

                        <p class="conclusion">
                            <?php echo ($ba_bec_article['libConclArt']); ?>
                        </p>
                    </article>

                    <div class="comments-block">
                        <h2>Ajouter un commentaire</h2>
                        <form action="article.php?numArt=<?php echo $ba_bec_numArt; ?>" method="post" class="comment-form">
                            <div class="champ">
                                <textarea id="libCom" name="libCom" class="form-control" type="text" required></textarea>
                            </div>
                            <input type="hidden" name="numArt" value="<?php echo $ba_bec_numArt; ?>" />
                            <div class="btn-se-connecter">
                                <button type="submit" class="btn btn-primary">Envoyer</button>
                            </div>  
                        </form>
                    </div>

                    <div class="comments-block">
                        <h2>Commentaires</h2>
                        <?php if (!empty($comments)): ?>
                            <ul class="comments-list">
                                <?php foreach ($comments as $ba_bec_comment): ?>
                                    <li class="commentairesaf">
                                        <div class="comment-meta">
                                            <span class="username"><?php echo ($ba_bec_comment['pseudoMemb']); ?></span> 
                                            <span class="date"><?php echo ($ba_bec_comment['dtCreaCom']); ?></span>
                                        </div>
                                        <p class="commentaire"><?php echo nl2br(($ba_bec_comment['libCom'])); ?></p>
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
                        $randomArticles = sql_select("ARTICLE", "*", "1=1 ORDER BY RAND() LIMIT 3");

                        if (!empty($randomArticles)):
                            foreach ($randomArticles as $randomArticle): ?>
                                <div class="random-article">
                                    <img class="imagedroite img-fluid w-100" src="<?php echo ROOT_URL . '/src/uploads/' . ($randomArticle['urlPhotArt']); ?>" alt="Image article">
                                    <h3 class="titredroite">
                                        <?php echo ($randomArticle['libTitrArt']); ?>
                                    </h3>
                                    <p class="txtdroite">
                                        <?php echo ($randomArticle['libChapoArt']); ?>
                                    </p>
                                    <a href="article.php?numArt=<?php echo $randomArticle['numArt']; ?>" class="btn btn-outline-primary btn-sm">Lire l'article →</a>
                                </div>
                            <?php endforeach;
                        else: ?>
                            <p>Aucun article disponible.</p>
                        <?php endif; ?>
                        <div class="likes-section">
                            <h2>Évaluer cet article</h2>
                            <div class="vote-buttons d-flex gap-3">
                                <form action="article.php?numArt=<?php echo $ba_bec_numArt; ?>" method="post">
                                    <input type="hidden" name="numArt" value="<?php echo $ba_bec_numArt; ?>">
                                    <input type="hidden" name="likeA" value="1">
                                    <button type="submit" class="btn btn-light d-flex align-items-center gap-2 <?php echo $userVote === 1 ? 'active-like' : ''; ?>">
                                        <img src="<?php echo ROOT_URL; ?>/src/images/pnglike.png" alt="Like">
                                        <span><?php echo $likeCount; ?></span>
                                    </button>
                                </form>

                                <form action="article.php?numArt=<?php echo $ba_bec_numArt; ?>" method="post">
                                    <input type="hidden" name="numArt" value="<?php echo $ba_bec_numArt; ?>">
                                    <input type="hidden" name="likeA" value="0">
                                    <button type="submit" class="btn btn-light d-flex align-items-center gap-2 <?php echo $userVote === 0 ? 'active-dislike' : ''; ?>">
                                        <img src="<?php echo ROOT_URL; ?>/src/images/pngdislike.png" alt="Dislike">
                                        <span><?php echo $dislikeCount; ?></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
?>
