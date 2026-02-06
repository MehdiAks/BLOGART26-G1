<?php
// Importe la configuration globale du site depuis la racine du document.
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Importe la fonction de nettoyage des saisies utilisateur.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/ctrlSaisies.php';

// Déclare une fonction utilitaire pour résoudre l'URL d'une image d'article.
function resolve_article_image_url(?string $path, string $defaultImage): string
{
    // Si aucun chemin n'est fourni, on retourne l'image par défaut.
    if (!$path) {
        // Retourne l'image par défaut lorsque le chemin est vide.
        return $defaultImage;
    }

    // Si le chemin est déjà une URL absolue HTTP(S), on le renvoie tel quel.
    if (preg_match('/^https?:\/\//', $path)) {
        // Retourne directement l'URL absolue détectée.
        return $path;
    }

    // Si le chemin contient déjà /src/uploads/, on calcule la partie relative.
    if (strpos($path, '/src/uploads/') !== false) {
        // Extrait la partie relative située après /src/uploads/.
        $relative = substr($path, strpos($path, '/src/uploads/') + strlen('/src/uploads/'));
    } else {
        // Sinon, on retire un éventuel slash initial pour obtenir un chemin relatif.
        $relative = ltrim($path, '/');
    }

    // Construit le chemin fichier complet sur le disque serveur.
    $filePath = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $relative;
    // Vérifie si le fichier existe effectivement sur le serveur.
    if (file_exists($filePath)) {
        // Retourne l'URL publique de l'image si elle existe.
        return ROOT_URL . '/src/uploads/' . $relative;
    }

    // Si le fichier est introuvable, on retourne l'image par défaut.
    return $defaultImage;
}

// Vérifie que le paramètre numArt est bien présent dans l'URL.
if (!isset($_GET['numArt']) || empty($_GET['numArt'])) {
    // Interrompt l'exécution si aucun article n'est sélectionné.
    die("Aucun article sélectionné.");
}

// Convertit l'identifiant d'article en entier pour sécuriser la requête.
$ba_bec_numArt = (int)$_GET['numArt'];
// Récupère les données de l'article depuis la base de données.
$articleData = sql_select("ARTICLE", "*", "numArt = $ba_bec_numArt");

// Vérifie si l'article existe en base.
if (empty($articleData)) {
    // Interrompt l'exécution si l'article n'est pas trouvé.
    die("Article non trouvé.");
}

// Stocke l'article récupéré dans une variable dédiée.
$ba_bec_article = $articleData[0];
// Définit le chemin de l'image par défaut.
$defaultImagePath = ROOT_URL . '/src/images/image-defaut.jpeg';
// Calcule l'URL de l'image de l'article avec fallback sur l'image par défaut.
$ba_bec_articleImageUrl = resolve_article_image_url($ba_bec_article['urlPhotArt'] ?? null, $defaultImagePath);
// Charge toutes les thématiques disponibles.
$ba_bec_thematiques = sql_select("THEMATIQUE", "*");
// Charge tous les mots-clés disponibles.
$ba_bec_keywords = sql_select("MOTCLE", "*");
// Charge les mots-clés associés à l'article courant.
$ba_bec_selectedKeywords = sql_select("MOTCLEARTICLE", "*", "numArt = $ba_bec_numArt");

// Liste les mots-clés liés à l'article via une jointure.
$ba_bec_listMot = sql_select(
    // Définit les tables et jointures pour récupérer les mots-clés.
    'ARTICLE
    INNER JOIN MOTCLEARTICLE ON ARTICLE.numArt = MOTCLEARTICLE.numArt
    INNER JOIN MOTCLE ON MOTCLEARTICLE.numMotCle = MOTCLE.numMotCle',
    // Sélectionne l'identifiant de l'article et le libellé des mots-clés.
    'ARTICLE.numArt, libMotCle',
    // Filtre les résultats sur l'article courant.
    "ARTICLE.numArt = '$ba_bec_numArt'"
);

// Réaffecte l'article courant pour s'assurer de la variable locale.
$ba_bec_article = $articleData[0];
// Initialise la thématique à un tableau vide par défaut.
$ba_bec_thematique = [];
// Vérifie si l'article a une thématique associée.
if (!empty($ba_bec_article['numThem'])) {
    // Récupère la thématique correspondante en base.
    $ba_bec_thematique = sql_select('THEMATIQUE', '*', 'numThem = ' . $ba_bec_article['numThem'])[0] ?? [];
}

// Récupère le nombre de likes associés à l'article.
$likeCount = sql_select("LIKEART", "COUNT(*) as count", "numArt = $ba_bec_numArt AND likeA = 1")[0]['count'] ?? 0;
// Récupère le nombre de dislikes associés à l'article.
$dislikeCount = sql_select("LIKEART", "COUNT(*) as count", "numArt = $ba_bec_numArt AND likeA = 0")[0]['count'] ?? 0;

// Initialise la variable de vote utilisateur à null.
$userVote = null;
// Nettoie le commentaire envoyé si présent, sinon null.
$ba_bec_libCom = isset($_POST['libCom']) ? ctrlSaisies($_POST['libCom']) : null;

// Vérifie si la requête actuelle est une soumission POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifie que l'utilisateur est connecté.
    if (!isset($_SESSION['user_id'])) {
        // Enregistre un message d'erreur dans la session.
        $_SESSION['error'] = "Vous devez être connecté pour ajouter un commentaire ou un like.";
        // Redirige vers la page de connexion.
        header("Location: " . ROOT_URL . "/views/backend/security/login.php");
        // Arrête l'exécution après la redirection.
        exit();
    }

    // Vérifie si la soumission est un commentaire.
    if (isset($_POST['libCom'])) {
        // Récupère l'identifiant du membre connecté.
        $ba_bec_numMemb = $_SESSION['user_id'];
        // Nettoie le commentaire reçu.
        $ba_bec_libCom = ctrlSaisies($_POST['libCom']);
        // Récupère l'identifiant d'article posté.
        $ba_bec_numArt = (int)$_POST['numArt'];
        // Vérifie que le commentaire, l'article et le membre sont présents.
        if (!empty($ba_bec_libCom) && !empty($ba_bec_numArt) && !empty($ba_bec_numMemb)) {
            // Insère le commentaire en base de données.
            sql_insert('comment', 'libCom, numArt, numMemb', "'$ba_bec_libCom', '$ba_bec_numArt', '$ba_bec_numMemb'");
            // Affiche un message de succès.
            echo "<p style='color: green;'>Commentaire ajouté avec succès !</p>";
        } else {
            // Affiche un message d'erreur si les champs sont invalides.
            echo "<p style='color: red;'>Erreur : tous les champs doivent être remplis correctement.</p>";
        }
    } else {

    
        // Débute le traitement du like/dislike.
        $ba_bec_numMemb = $_SESSION['user_id'];
        // Récupère la valeur du vote (like ou dislike).
        $ba_bec_likeA = (int)$_POST['likeA'];

        // Vérifie si l'utilisateur a déjà voté pour cet article.
        $existingVote = sql_select("LIKEART", "*", "numArt = $ba_bec_numArt AND numMemb = $ba_bec_numMemb");

        // Si un vote existe déjà, on met à jour.
        if (!empty($existingVote)) {
            // Met à jour la valeur du vote existant.
            sql_update("LIKEART", "likeA = $ba_bec_likeA", "numArt = $ba_bec_numArt AND numMemb = $ba_bec_numMemb");
        } else {
            // Sinon, insère un nouveau vote en base.
            sql_insert("LIKEART", "numArt, numMemb, likeA", "'$ba_bec_numArt', '$ba_bec_numMemb', '$ba_bec_likeA'");
        }

        // Redirige pour rafraîchir le nombre de likes/dislikes affiché.
        header("Location: article.php?numArt=$ba_bec_numArt");
        // Arrête l'exécution après redirection.
        exit();
    }
}

// Récupère l'article actuel avec ses commentaires.
$ba_bec_numArt = (int) $_GET['numArt']; // Assure-toi d'avoir l'ID de l'article dans l'URL.
// Récupère les commentaires associés à l'article avec les informations des membres.
$comments = sql_select(
    // Définit la jointure entre commentaires et membres.
    "comment c 
    INNER JOIN membre m ON c.numMemb = m.numMemb 
    WHERE c.numArt = $ba_bec_numArt 
    AND c.delLogiq = 0
    AND c.attModOK = 1",
    // Sélectionne le contenu et les métadonnées du commentaire.
    "c.libCom, c.dtCreaCom, m.pseudoMemb"
);
// Affiche l'article et ses commentaires.
$ba_bec_article = sql_select("article", "*", "numArt = $ba_bec_numArt")[0];





// Vérification du vote de l'utilisateur.
$userVote = null;
// Si un utilisateur est connecté, on récupère son vote.
if (isset($_SESSION['user_id'])) {
    // Stocke l'identifiant du membre connecté.
    $ba_bec_numMemb = $_SESSION['user_id'];
    // Récupère le vote de l'utilisateur pour cet article.
    $userVoteData = sql_select("LIKEART", "likeA", "numArt = $ba_bec_numArt AND numMemb = $ba_bec_numMemb");
    // Définit le vote utilisateur s'il existe.
    $userVote = !empty($userVoteData) ? $userVoteData[0]['likeA'] : null;
}

// Définit les feuilles de style spécifiques à la page.
$pageStyles = [
    // Ajoute la feuille de styles des polices.
    ROOT_URL . '/src/css/css-propre/fonts.css',
    // Ajoute la feuille de styles dédiée à l'article.
    ROOT_URL . '/src/css/stylearticle.css',
];
// Inclut l'en-tête du site.
require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php';
?>
    <!-- Conteneur principal de la page d'article. -->
    <div class="article-page">
        <!-- En-tête visuel de l'article avec image de fond. -->
        <header class="article-hero" style="--hero-image: url('<?php echo $ba_bec_articleImageUrl; ?>')">
            <!-- Calque de fond pour améliorer la lisibilité. -->
            <div class="article-hero__overlay">
                <!-- Libellé de rubrique affiché en haut. -->
                <p class="article-kicker">Actualités</p>
                <!-- Titre principal de l'article. -->
                <h1 class="article-title">
                    <!-- Affiche le titre de l'article après rendu BBCode. -->
                    <?php echo renderBbcode($ba_bec_article['libTitrArt']); ?>
                </h1>
                <!-- Zone des métadonnées de l'article. -->
                <div class="article-meta">
                    <!-- Affiche la date de création de l'article. -->
                    <span><?php echo ($ba_bec_article['dtCreaArt']); ?></span>
                    <!-- Séparateur visuel entre métadonnées. -->
                    <span class="article-meta__dot">•</span>
                    <!-- Affiche une durée de lecture fixe. -->
                    <span>Lecture 2 min</span>
                </div>
            </div>
        </header>

        <!-- Section contenant le corps de l'article. -->
        <section class="article-body">
            <!-- Conteneur central pour la mise en page. -->
            <div class="container">
                <!-- Chapeau de l'article. -->
                <div class="article-lead">
                    <!-- Affiche le chapeau avec rendu BBCode. -->
                    <?php echo renderBbcode($ba_bec_article['libChapoArt']); ?> 
                </div>
                <!-- Bloc des informations de taxonomie (thématique et mots-clés). -->
                <div class="article-taxonomy mb-4">
                    <!-- Ligne pour la thématique. -->
                    <p class="article-theme mb-1">
                        <!-- Libellé fixe pour la thématique. -->
                        <strong>Thématique :</strong>
                        <!-- Affiche la thématique si elle existe, sinon un texte par défaut. -->
                        <?php echo !empty($ba_bec_thematique['libThem']) ? htmlspecialchars($ba_bec_thematique['libThem']) : 'Non renseignée'; ?>
                    </p>
                    <!-- Ligne pour les mots-clés. -->
                    <p class="article-keywords mb-0">
                        <!-- Libellé fixe pour les mots-clés. -->
                        <strong>Mots-clés :</strong>
                        <!-- Vérifie si des mots-clés sont disponibles. -->
                        <?php if (!empty($ba_bec_listMot)): ?>
                            <!-- Démarre un bloc PHP pour formater les libellés. -->
                            <?php
                            // Transforme chaque mot-clé en libellé HTML échappé.
                            $ba_bec_keywordLabels = array_map(
                                // Fonction anonyme statique pour échapper les libellés.
                                static fn($ba_bec_mot) => htmlspecialchars($ba_bec_mot['libMotCle']),
                                // Tableau des mots-clés à transformer.
                                $ba_bec_listMot
                            );
                            // Affiche les mots-clés séparés par des virgules.
                            echo implode(', ', $ba_bec_keywordLabels);
                            ?>
                        <?php else: ?>
                            <!-- Texte affiché lorsqu'aucun mot-clé n'est présent. -->
                            Aucun mot-clé.
                        <?php endif; ?>
                    </p>
                </div>

                <!-- Début de la grille de mise en page avec espacement. -->
                <div class="row g-4">
                    <!-- Colonne principale pour le contenu de l'article. -->
                    <div class="col-12 col-lg-8">
                        <!-- Élément article contenant le contenu texte. -->
                        <article class="bg-white">
                        <!-- Sous-titre d'accroche de l'article. -->
                        <h2 class="phraseaccroche">
                            <!-- Affiche l'accroche avec rendu BBCode. -->
                            <?php echo renderBbcode($ba_bec_article['libAccrochArt']); ?> 
                        </h2>
                        <!-- Premier paragraphe de l'article. -->
                        <p class="paragraphe">
                            <!-- Affiche le premier paragraphe avec rendu BBCode. -->
                            <?php echo renderBbcode($ba_bec_article['parag1Art']); ?> 
                        </p>
                        <!-- Bloc figure pour l'image de l'article. -->
                        <figure class="article-figure">
                            <!-- Image principale de l'article. -->
                            <img class="image2 img-fluid w-100" src="<?php echo $ba_bec_articleImageUrl; ?>" alt="Image article">
                            <!-- Légende de l'image. -->
                            <figcaption class="article-caption">
                                <!-- Texte de copyright et description d'image. -->
                                © Groupe 1 Bordeaux étudiant club + Description de l’image
                            </figcaption>
                        </figure>

                        <!-- Zone de texte avec ligne décorative. -->
                        <div class="text-with-line">
                            <!-- Affiche le premier sous-titre avec rendu BBCode. -->
                            <?php echo renderBbcode($ba_bec_article['libSsTitr1Art']); ?> 
                        </div>

                        <!-- Deuxième paragraphe de l'article. -->
                        <p class="paragraphe2">
                            <!-- Affiche le deuxième paragraphe avec rendu BBCode. -->
                            <?php echo renderBbcode($ba_bec_article['parag2Art']); ?>
                        </p>

                        <!-- Zone de texte avec ligne décorative pour le second sous-titre. -->
                        <div class="text-with-line">
                            <!-- Affiche le second sous-titre avec rendu BBCode. -->
                            <?php echo renderBbcode($ba_bec_article['libSsTitr2Art']); ?>
                        </div>

                        <!-- Troisième paragraphe de l'article. -->
                        <p class="paragraphe3">
                            <!-- Affiche le troisième paragraphe avec rendu BBCode. -->
                            <?php echo renderBbcode($ba_bec_article['parag3Art']); ?>
                        </p>

                        <!-- Conclusion de l'article. -->
                        <p class="conclusion">
                            <!-- Affiche la conclusion avec rendu BBCode. -->
                            <?php echo renderBbcode($ba_bec_article['libConclArt']); ?>
                        </p>
                    </article>

                    <!-- Section d'évaluation (likes/dislikes). -->
                    <div class="likes-section">
                        <!-- Titre de la section d'évaluation. -->
                        <h2>Évaluer cet article</h2>
                        <!-- Affiche le nombre de likes et dislikes. -->
                        <p class="likes-count">Nombre de likes : <?php echo $likeCount; ?> · Dislikes : <?php echo $dislikeCount; ?></p>
                        <!-- Conteneur pour les boutons de vote. -->
                        <div class="vote-buttons d-flex gap-3">
                            <!-- Formulaire pour voter "like". -->
                            <form action="article.php?numArt=<?php echo $ba_bec_numArt; ?>" method="post">
                                <!-- Champ caché pour l'identifiant d'article. -->
                                <input type="hidden" name="numArt" value="<?php echo $ba_bec_numArt; ?>">
                                <!-- Champ caché indiquant un like. -->
                                <input type="hidden" name="likeA" value="1">
                                <!-- Bouton de vote avec style conditionnel. -->
                                <button type="submit" class="btn btn-light d-flex align-items-center gap-2 btn-vote <?php echo $userVote === 1 ? 'active-like' : ''; ?>">
                                    <!-- Icône de like. -->
                                    <img src="<?php echo ROOT_URL . '/src/images/icon/pnglike.png'; ?>" alt="Like">
                                    <!-- Affiche le compteur de likes. -->
                                    <span><?php echo $likeCount; ?></span>
                                </button>
                            </form>

                            <!-- Formulaire pour voter "dislike". -->
                            <form action="article.php?numArt=<?php echo $ba_bec_numArt; ?>" method="post">
                                <!-- Champ caché pour l'identifiant d'article. -->
                                <input type="hidden" name="numArt" value="<?php echo $ba_bec_numArt; ?>">
                                <!-- Champ caché indiquant un dislike. -->
                                <input type="hidden" name="likeA" value="0">
                                <!-- Bouton de vote avec style conditionnel. -->
                                <button type="submit" class="btn btn-light d-flex align-items-center gap-2 btn-vote <?php echo $userVote === 0 ? 'active-dislike' : ''; ?>">
                                    <!-- Icône de dislike. -->
                                    <img src="<?php echo ROOT_URL . '/src/images/icon/pngdislike.png'; ?>"  alt="Dislike">
                                    <!-- Affiche le compteur de dislikes. -->
                                    <span><?php echo $dislikeCount; ?></span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Bloc de formulaire pour ajouter un commentaire. -->
                    <div class="comments-block">
                        <!-- Titre du bloc d'ajout de commentaire. -->
                        <h2>Ajouter un commentaire</h2>
                        <!-- Formulaire de commentaire. -->
                        <form action="article.php?numArt=<?php echo $ba_bec_numArt; ?>" method="post" class="comment-form">
                            <!-- Conteneur du champ de texte. -->
                            <div class="champ">
                                <!-- Zone de saisie du commentaire. -->
                                <textarea id="libCom" name="libCom" class="form-control" type="text" required></textarea>
                            </div>
                            <!-- Champ caché pour l'identifiant de l'article. -->
                            <input type="hidden" name="numArt" value="<?php echo $ba_bec_numArt; ?>" />
                            <!-- Conteneur du bouton d'envoi. -->
                            <div class="btn-se-connecter">
                                <!-- Bouton de soumission du commentaire. -->
                                <button type="submit" class="btn btn-primary">Envoyer</button>
                            </div>  
                        </form>
                    </div>

                    <!-- Bloc listant les commentaires existants. -->
                    <div class="comments-block">
                        <!-- Titre du bloc des commentaires. -->
                        <h2>Commentaires</h2>
                        <!-- Vérifie s'il y a des commentaires à afficher. -->
                        <?php if (!empty($comments)): ?>
                            <!-- Liste des commentaires. -->
                            <ul class="comments-list">
                                <!-- Boucle sur chaque commentaire. -->
                                <?php foreach ($comments as $ba_bec_comment): ?>
                                    <!-- Élément de liste pour un commentaire. -->
                                    <li class="commentairesaf">
                                        <!-- Métadonnées du commentaire. -->
                                        <div class="comment-meta">
                                            <!-- Affiche le pseudo de l'auteur. -->
                                            <span class="username"><?php echo htmlspecialchars($ba_bec_comment['pseudoMemb']); ?></span> 
                                            <!-- Affiche la date du commentaire. -->
                                            <span class="date"><?php echo htmlspecialchars($ba_bec_comment['dtCreaCom']); ?></span>
                                        </div>
                                        <!-- Affiche le contenu du commentaire. -->
                                        <p class="commentaire"><?php echo renderBbcode($ba_bec_comment['libCom']); ?></p>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <!-- Message lorsque la liste de commentaires est vide. -->
                            <p>Il n'y a pas encore de commentaires pour cet article.</p>
                        <?php endif; ?>
                    </div>
                    </div>

                    <!-- Colonne latérale pour afficher d'autres articles. -->
                    <aside class="article-sidebar col-12 col-lg-4">
                        <!-- Titre de la section autres articles. -->
                        <h2>Autres articles</h2>
                        <!-- Début du bloc PHP pour récupérer des articles aléatoires. -->
                        <?php
                        // Récupère trois articles aléatoires.
                        $randomArticles = sql_select("ARTICLE", "*", "1=1 ORDER BY RAND() LIMIT 3");

                        // Vérifie s'il y a des articles à afficher.
                        if (!empty($randomArticles)):
                            // Boucle sur chaque article aléatoire.
                            foreach ($randomArticles as $randomArticle): ?>
                                <?php
                                // Calcule l'URL de l'image de l'article aléatoire.
                                $randomImageUrl = resolve_article_image_url(
                                    // Passe l'image éventuelle de l'article.
                                    $randomArticle['urlPhotArt'] ?? null,
                                    // Utilise l'image par défaut si besoin.
                                    $defaultImagePath
                                );
                                ?>
                                <!-- Bloc visuel pour un article aléatoire. -->
                                <div class="random-article">
                                    <!-- Image de l'article aléatoire. -->
                                    <img class="imagedroite img-fluid w-100" src="<?php echo $randomImageUrl; ?>" alt="Image article">
                                    <!-- Titre de l'article aléatoire. -->
                                    <h3 class="titredroite">
                                        <!-- Affiche le titre avec rendu BBCode. -->
                                        <?php echo renderBbcode($randomArticle['libTitrArt']); ?>
                                    </h3>
                                    <!-- Chapeau de l'article aléatoire. -->
                                    <p class="txtdroite">
                                        <!-- Affiche le chapeau avec rendu BBCode. -->
                                        <?php echo renderBbcode($randomArticle['libChapoArt']); ?>
                                    </p>
                                    <!-- Lien pour lire l'article complet. -->
                                    <a href="article.php?numArt=<?php echo $randomArticle['numArt']; ?>" class="btn btn-outline-primary btn-sm">Lire l'article →</a>
                                </div>
                            <?php endforeach;
                        else: ?>
                            <!-- Message si aucun article n'est disponible. -->
                            <p>Aucun article disponible.</p>
                        <?php endif; ?>
                    </aside>
                </div>
            </div>
        </section>
    </div>
<?php
// Inclut le pied de page du site.
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
?>
