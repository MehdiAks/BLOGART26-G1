<!-- Cette ligne contient le balisage/texte : <?php -->
<?php
<!-- Cette ligne contient le balisage/texte : /* -->
/*
<!-- Cette ligne contient le balisage/texte : * Vue d'administration (édition) pour le module articles. -->
 * Vue d'administration (édition) pour le module articles.
<!-- Cette ligne contient le balisage/texte : * - Le formulaire réutilise la structure de création mais avec des valeurs pré-remplies côté serveur. -->
 * - Le formulaire réutilise la structure de création mais avec des valeurs pré-remplies côté serveur.
<!-- Cette ligne contient le balisage/texte : * - Les identifiants nécessaires (ID) sont passés via la query string ou des champs cachés. -->
 * - Les identifiants nécessaires (ID) sont passés via la query string ou des champs cachés.
<!-- Cette ligne contient le balisage/texte : * - L'action du formulaire cible la route de mise à jour correspondante. -->
 * - L'action du formulaire cible la route de mise à jour correspondante.
<!-- Cette ligne contient le balisage/texte : * - Les sections HTML isolent les groupes d'attributs pour une édition guidée. -->
 * - Les sections HTML isolent les groupes d'attributs pour une édition guidée.
<!-- Cette ligne contient le balisage/texte : * - Les actions secondaires permettent de revenir à la liste sans enregistrer. -->
 * - Les actions secondaires permettent de revenir à la liste sans enregistrer.
<!-- Cette ligne contient le balisage/texte : */ -->
 */
<!-- Cette ligne contient le balisage/texte : require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; -->
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
<!-- Cette ligne contient le balisage/texte : require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; -->
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';

<!-- Cette ligne contient le balisage/texte : $pageStyles = [ -->
$pageStyles = [
<!-- Cette ligne contient le balisage/texte : ROOT_URL . '/src/css/stylearticle.css', -->
    ROOT_URL . '/src/css/stylearticle.css',
<!-- Cette ligne contient le balisage/texte : ROOT_URL . '/src/css/article-editor.css', -->
    ROOT_URL . '/src/css/article-editor.css',
<!-- Cette ligne contient le balisage/texte : ]; -->
];

<!-- Cette ligne contient le balisage/texte : require_once ROOT . '/header.php'; -->
require_once ROOT . '/header.php';

<!-- Cette ligne contient le balisage/texte : if (isset($_GET['numArt'])) { -->
if (isset($_GET['numArt'])) {
<!-- Cette ligne contient le balisage/texte : $ba_bec_numArt = (int) $_GET['numArt']; -->
    $ba_bec_numArt = (int) $_GET['numArt'];
<!-- Cette ligne contient le balisage/texte : $ba_bec_article = sql_select("ARTICLE", "*", "numArt = $ba_bec_numArt")[0]; -->
    $ba_bec_article = sql_select("ARTICLE", "*", "numArt = $ba_bec_numArt")[0];
<!-- Cette ligne contient le balisage/texte : $ba_bec_thematiques = sql_select("THEMATIQUE", "*"); -->
    $ba_bec_thematiques = sql_select("THEMATIQUE", "*");
<!-- Cette ligne contient le balisage/texte : $ba_bec_keywords = sql_select("MOTCLE", "*"); -->
    $ba_bec_keywords = sql_select("MOTCLE", "*");
<!-- Cette ligne contient le balisage/texte : $ba_bec_selectedKeywords = sql_select("MOTCLEARTICLE", "*", "numArt = $ba_bec_numArt"); -->
    $ba_bec_selectedKeywords = sql_select("MOTCLEARTICLE", "*", "numArt = $ba_bec_numArt");
<!-- Cette ligne contient le balisage/texte : $ba_bec_selectedKeywordIds = array_map('intval', array_column($ba_bec_selectedKeywords, 'numMotCle')); -->
    $ba_bec_selectedKeywordIds = array_map('intval', array_column($ba_bec_selectedKeywords, 'numMotCle'));
<!-- Cette ligne contient le balisage/texte : $ba_bec_numArt = $_GET['numArt']; -->
    $ba_bec_numArt = $_GET['numArt'];
<!-- Cette ligne contient le balisage/texte : $ba_bec_urlPhotArt = $ba_bec_article['urlPhotArt']; -->
    $ba_bec_urlPhotArt = $ba_bec_article['urlPhotArt'];
<!-- Cette ligne contient le balisage/texte : $ba_bec_defaultImage = ROOT_URL . '/src/images/article.png'; -->
    $ba_bec_defaultImage = ROOT_URL . '/src/images/article.png';
<!-- Cette ligne contient le balisage/texte : if (!empty($ba_bec_urlPhotArt)) { -->
    if (!empty($ba_bec_urlPhotArt)) {
<!-- Cette ligne contient le balisage/texte : $ba_bec_photoUrl = preg_match('/^(https?:\/\/|\/)/', $ba_bec_urlPhotArt) -->
        $ba_bec_photoUrl = preg_match('/^(https?:\/\/|\/)/', $ba_bec_urlPhotArt)
<!-- Cette ligne contient le balisage/texte : ? $ba_bec_urlPhotArt -->
            ? $ba_bec_urlPhotArt
<!-- Cette ligne contient le balisage/texte : : ROOT_URL . '/src/uploads/' . $ba_bec_urlPhotArt; -->
            : ROOT_URL . '/src/uploads/' . $ba_bec_urlPhotArt;
<!-- Cette ligne contient le balisage/texte : } else { -->
    } else {
<!-- Cette ligne contient le balisage/texte : $ba_bec_photoUrl = $ba_bec_defaultImage; -->
        $ba_bec_photoUrl = $ba_bec_defaultImage;
<!-- Cette ligne contient le balisage/texte : } -->
    }
<!-- Cette ligne contient le balisage/texte : } -->
}
<!-- Cette ligne contient le balisage/texte : ?> -->
?>

<!-- Cette ligne contient le balisage/texte : <div class="article-editor-page"> -->
<div class="article-editor-page">
<!-- Cette ligne contient le balisage/texte : <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4"> -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
<!-- Cette ligne contient le balisage/texte : <div> -->
        <div>
<!-- Cette ligne contient le balisage/texte : <h1>Éditer un article</h1> -->
            <h1>Éditer un article</h1>
<!-- Cette ligne contient le balisage/texte : <p class="text-muted mb-0"> -->
            <p class="text-muted mb-0">
<!-- Cette ligne contient le balisage/texte : Modifiez le contenu directement dans la mise en page finale, les champs se mettent à jour -->
                Modifiez le contenu directement dans la mise en page finale, les champs se mettent à jour
<!-- Cette ligne contient le balisage/texte : automatiquement. -->
                automatiquement.
<!-- Cette ligne contient le balisage/texte : </p> -->
            </p>
<!-- Cette ligne contient le balisage/texte : </div> -->
        </div>
<!-- Cette ligne contient le balisage/texte : <button type="submit" form="article-edit-form" class="btn btn-primary">Confirmer la mise à jour</button> -->
        <button type="submit" form="article-edit-form" class="btn btn-primary">Confirmer la mise à jour</button>
<!-- Cette ligne contient le balisage/texte : </div> -->
    </div>

<!-- Cette ligne contient le balisage/texte : <form id="article-edit-form" action="<?php echo ROOT_URL . '/public/index.php?controller=article&action=update'; ?>" method="post" -->
    <form id="article-edit-form" action="<?php echo ROOT_URL . '/public/index.php?controller=article&action=update'; ?>" method="post"
<!-- Cette ligne contient le balisage/texte : enctype="multipart/form-data"> -->
        enctype="multipart/form-data">
<!-- Cette ligne contient le balisage/texte : <input id="numArt" name="numArt" type="hidden" value="<?php echo $ba_bec_article['numArt']; ?>" -->
        <input id="numArt" name="numArt" type="hidden" value="<?php echo $ba_bec_article['numArt']; ?>"
<!-- Cette ligne contient le balisage/texte : readonly="readonly" /> -->
            readonly="readonly" />

<!-- Cette ligne contient le balisage/texte : <section class="article-page article-editor"> -->
        <section class="article-page article-editor">
<!-- Cette ligne contient le balisage/texte : <header class="article-hero" -->
            <header class="article-hero"
<!-- Cette ligne contient le balisage/texte : style="- -hero-image: url('<?php echo htmlspecialchars($ba_bec_photoUrl); ?>')"> -->
                style="--hero-image: url('<?php echo htmlspecialchars($ba_bec_photoUrl); ?>')">
<!-- Cette ligne contient le balisage/texte : <div class="article-hero__overlay"> -->
                <div class="article-hero__overlay">
<!-- Cette ligne contient le balisage/texte : <p class="article-kicker">Actualités</p> -->
                    <p class="article-kicker">Actualités</p>
<!-- Cette ligne contient le balisage/texte : <div class="article-editor-field article-editor-field- -light"> -->
                    <div class="article-editor-field article-editor-field--light">
<!-- Cette ligne contient le balisage/texte : <h1 id="preview-title" class="article-title article-editor-display article-editor-display- -title" -->
                        <h1 id="preview-title" class="article-title article-editor-display article-editor-display--title"
<!-- Cette ligne contient le balisage/texte : data-placeholder="Titre de l’article"></h1> -->
                            data-placeholder="Titre de l’article"></h1>
<!-- Cette ligne contient le balisage/texte : <input id="libTitrArt" name="libTitrArt" class="article-editor-input article-editor-input- -light" -->
                        <input id="libTitrArt" name="libTitrArt" class="article-editor-input article-editor-input--light"
<!-- Cette ligne contient le balisage/texte : type="text" maxlength="100" required data-preview-target="preview-title" -->
                            type="text" maxlength="100" required data-preview-target="preview-title"
<!-- Cette ligne contient le balisage/texte : value="<?php echo $ba_bec_article['libTitrArt']; ?>" placeholder="Titre de l’article" /> -->
                            value="<?php echo $ba_bec_article['libTitrArt']; ?>" placeholder="Titre de l’article" />
<!-- Cette ligne contient le balisage/texte : </div> -->
                    </div>
<!-- Cette ligne contient le balisage/texte : <div class="article-meta"> -->
                    <div class="article-meta">
<!-- Cette ligne contient le balisage/texte : <span>Publié le</span> -->
                        <span>Publié le</span>
<!-- Cette ligne contient le balisage/texte : <span class="article-editor-field article-editor-field- -light article-editor-field- -inline"> -->
                        <span class="article-editor-field article-editor-field--light article-editor-field--inline">
<!-- Cette ligne contient le balisage/texte : <span id="preview-date" class="article-editor-display article-editor-display- -meta" -->
                            <span id="preview-date" class="article-editor-display article-editor-display--meta"
<!-- Cette ligne contient le balisage/texte : data-placeholder="Date de publication"></span> -->
                                data-placeholder="Date de publication"></span>
<!-- Cette ligne contient le balisage/texte : <input id="dtCreaArt" name="dtCreaArt" -->
                            <input id="dtCreaArt" name="dtCreaArt"
<!-- Cette ligne contient le balisage/texte : class="article-editor-input article-editor-input- -light" type="datetime-local" required -->
                                class="article-editor-input article-editor-input--light" type="datetime-local" required
<!-- Cette ligne contient le balisage/texte : data-preview-target="preview-date" -->
                                data-preview-target="preview-date"
<!-- Cette ligne contient le balisage/texte : value="<?php echo $ba_bec_article['dtCreaArt']; ?>" placeholder="JJ/MM/AAAA HH:MM" /> -->
                                value="<?php echo $ba_bec_article['dtCreaArt']; ?>" placeholder="JJ/MM/AAAA HH:MM" />
<!-- Cette ligne contient le balisage/texte : </span> -->
                        </span>
<!-- Cette ligne contient le balisage/texte : <span class="article-meta__dot">•</span> -->
                        <span class="article-meta__dot">•</span>
<!-- Cette ligne contient le balisage/texte : <span>Lecture 2 min</span> -->
                        <span>Lecture 2 min</span>
<!-- Cette ligne contient le balisage/texte : </div> -->
                    </div>
<!-- Cette ligne contient le balisage/texte : </div> -->
                </div>
<!-- Cette ligne contient le balisage/texte : </header> -->
            </header>

<!-- Cette ligne contient le balisage/texte : <section class="article-body"> -->
            <section class="article-body">
<!-- Cette ligne contient le balisage/texte : <div class="container"> -->
                <div class="container">
<!-- Cette ligne contient le balisage/texte : <div class="article-editor-field"> -->
                    <div class="article-editor-field">
<!-- Cette ligne contient le balisage/texte : <p id="preview-chapo" class="article-lead article-editor-display article-editor-display- -lead" -->
                        <p id="preview-chapo" class="article-lead article-editor-display article-editor-display--lead"
<!-- Cette ligne contient le balisage/texte : data-placeholder="Ajoutez le chapeau de l’article pour donner le ton."></p> -->
                            data-placeholder="Ajoutez le chapeau de l’article pour donner le ton."></p>
<!-- Cette ligne contient le balisage/texte : <textarea id="libChapoArt" name="libChapoArt" class="article-editor-input" maxlength="500" -->
                        <textarea id="libChapoArt" name="libChapoArt" class="article-editor-input" maxlength="500"
<!-- Cette ligne contient le balisage/texte : required data-preview-target="preview-chapo" -->
                            required data-preview-target="preview-chapo"
<!-- Cette ligne contient le balisage/texte : placeholder="Ajoutez le chapeau de l’article pour donner le ton."><?php echo $ba_bec_article['libChapoArt']; ?></textarea> -->
                            placeholder="Ajoutez le chapeau de l’article pour donner le ton."><?php echo $ba_bec_article['libChapoArt']; ?></textarea>
<!-- Cette ligne contient le balisage/texte : </div> -->
                    </div>

<!-- Cette ligne contient le balisage/texte : <div class="row g-4"> -->
                    <div class="row g-4">
<!-- Cette ligne contient le balisage/texte : <div class="col-12 col-lg-8"> -->
                        <div class="col-12 col-lg-8">
<!-- Cette ligne contient le balisage/texte : <article class="bg-white"> -->
                            <article class="bg-white">
<!-- Cette ligne contient le balisage/texte : <div class="article-editor-field"> -->
                                <div class="article-editor-field">
<!-- Cette ligne contient le balisage/texte : <h2 id="preview-accroche" -->
                                    <h2 id="preview-accroche"
<!-- Cette ligne contient le balisage/texte : class="phraseaccroche article-editor-display article-editor-display- -accroche" -->
                                        class="phraseaccroche article-editor-display article-editor-display--accroche"
<!-- Cette ligne contient le balisage/texte : data-placeholder="Ajoutez l’accroche principale."></h2> -->
                                        data-placeholder="Ajoutez l’accroche principale."></h2>
<!-- Cette ligne contient le balisage/texte : <input id="libAccrochArt" name="libAccrochArt" class="article-editor-input" -->
                                    <input id="libAccrochArt" name="libAccrochArt" class="article-editor-input"
<!-- Cette ligne contient le balisage/texte : type="text" maxlength="100" required data-preview-target="preview-accroche" -->
                                        type="text" maxlength="100" required data-preview-target="preview-accroche"
<!-- Cette ligne contient le balisage/texte : value="<?php echo $ba_bec_article['libAccrochArt']; ?>" -->
                                        value="<?php echo $ba_bec_article['libAccrochArt']; ?>"
<!-- Cette ligne contient le balisage/texte : placeholder="Accroche principale..." /> -->
                                        placeholder="Accroche principale..." />
<!-- Cette ligne contient le balisage/texte : </div> -->
                                </div>

<!-- Cette ligne contient le balisage/texte : <div class="article-editor-field"> -->
                                <div class="article-editor-field">
<!-- Cette ligne contient le balisage/texte : <p id="preview-parag1" -->
                                    <p id="preview-parag1"
<!-- Cette ligne contient le balisage/texte : class="paragraphe article-editor-display article-editor-display- -paragraph" -->
                                        class="paragraphe article-editor-display article-editor-display--paragraph"
<!-- Cette ligne contient le balisage/texte : data-placeholder="Premier paragraphe : racontez l’essentiel ici."></p> -->
                                        data-placeholder="Premier paragraphe : racontez l’essentiel ici."></p>
<!-- Cette ligne contient le balisage/texte : <textarea id="parag1Art" name="parag1Art" class="article-editor-input" -->
                                    <textarea id="parag1Art" name="parag1Art" class="article-editor-input"
<!-- Cette ligne contient le balisage/texte : maxlength="1200" required data-preview-target="preview-parag1" -->
                                        maxlength="1200" required data-preview-target="preview-parag1"
<!-- Cette ligne contient le balisage/texte : placeholder="Premier paragraphe : racontez l’essentiel ici."><?php echo $ba_bec_article['parag1Art']; ?></textarea> -->
                                        placeholder="Premier paragraphe : racontez l’essentiel ici."><?php echo $ba_bec_article['parag1Art']; ?></textarea>
<!-- Cette ligne contient le balisage/texte : </div> -->
                                </div>

<!-- Cette ligne contient le balisage/texte : <figure class="article-figure article-editor-figure"> -->
                                <figure class="article-figure article-editor-figure">
<!-- Cette ligne contient le balisage/texte : <img class="image2 img-fluid w-100" -->
                                    <img class="image2 img-fluid w-100"
<!-- Cette ligne contient le balisage/texte : src="<?php echo htmlspecialchars($ba_bec_photoUrl); ?>" -->
                                        src="<?php echo htmlspecialchars($ba_bec_photoUrl); ?>"
<!-- Cette ligne contient le balisage/texte : alt="Image de l'article"> -->
                                        alt="Image de l'article">
<!-- Cette ligne contient le balisage/texte : <figcaption class="article-caption"> -->
                                    <figcaption class="article-caption">
<!-- Cette ligne contient le balisage/texte : © Groupe 1 Bordeaux étudiant club + Description de l’image -->
                                        © Groupe 1 Bordeaux étudiant club + Description de l’image
<!-- Cette ligne contient le balisage/texte : </figcaption> -->
                                    </figcaption>
<!-- Cette ligne contient le balisage/texte : </figure> -->
                                </figure>

<!-- Cette ligne contient le balisage/texte : <div class="article-editor-field"> -->
                                <div class="article-editor-field">
<!-- Cette ligne contient le balisage/texte : <div id="preview-subtitle1" -->
                                    <div id="preview-subtitle1"
<!-- Cette ligne contient le balisage/texte : class="text-with-line article-editor-display article-editor-display- -subtitle" -->
                                        class="text-with-line article-editor-display article-editor-display--subtitle"
<!-- Cette ligne contient le balisage/texte : data-placeholder="Sous-titre 1"></div> -->
                                        data-placeholder="Sous-titre 1"></div>
<!-- Cette ligne contient le balisage/texte : <input id="libSsTitr1Art" name="libSsTitr1Art" class="article-editor-input" -->
                                    <input id="libSsTitr1Art" name="libSsTitr1Art" class="article-editor-input"
<!-- Cette ligne contient le balisage/texte : type="text" maxlength="100" required data-preview-target="preview-subtitle1" -->
                                        type="text" maxlength="100" required data-preview-target="preview-subtitle1"
<!-- Cette ligne contient le balisage/texte : value="<?php echo $ba_bec_article['libSsTitr1Art']; ?>" -->
                                        value="<?php echo $ba_bec_article['libSsTitr1Art']; ?>"
<!-- Cette ligne contient le balisage/texte : placeholder="Sous-titre 1" /> -->
                                        placeholder="Sous-titre 1" />
<!-- Cette ligne contient le balisage/texte : </div> -->
                                </div>

<!-- Cette ligne contient le balisage/texte : <div class="article-editor-field"> -->
                                <div class="article-editor-field">
<!-- Cette ligne contient le balisage/texte : <p id="preview-parag2" -->
                                    <p id="preview-parag2"
<!-- Cette ligne contient le balisage/texte : class="paragraphe2 article-editor-display article-editor-display- -paragraph" -->
                                        class="paragraphe2 article-editor-display article-editor-display--paragraph"
<!-- Cette ligne contient le balisage/texte : data-placeholder="Deuxième paragraphe : développez votre idée."></p> -->
                                        data-placeholder="Deuxième paragraphe : développez votre idée."></p>
<!-- Cette ligne contient le balisage/texte : <textarea id="parag2Art" name="parag2Art" class="article-editor-input" -->
                                    <textarea id="parag2Art" name="parag2Art" class="article-editor-input"
<!-- Cette ligne contient le balisage/texte : maxlength="1200" required data-preview-target="preview-parag2" -->
                                        maxlength="1200" required data-preview-target="preview-parag2"
<!-- Cette ligne contient le balisage/texte : placeholder="Deuxième paragraphe : développez votre idée."><?php echo $ba_bec_article['parag2Art']; ?></textarea> -->
                                        placeholder="Deuxième paragraphe : développez votre idée."><?php echo $ba_bec_article['parag2Art']; ?></textarea>
<!-- Cette ligne contient le balisage/texte : </div> -->
                                </div>

<!-- Cette ligne contient le balisage/texte : <div class="article-editor-field"> -->
                                <div class="article-editor-field">
<!-- Cette ligne contient le balisage/texte : <div id="preview-subtitle2" -->
                                    <div id="preview-subtitle2"
<!-- Cette ligne contient le balisage/texte : class="text-with-line article-editor-display article-editor-display- -subtitle" -->
                                        class="text-with-line article-editor-display article-editor-display--subtitle"
<!-- Cette ligne contient le balisage/texte : data-placeholder="Sous-titre 2"></div> -->
                                        data-placeholder="Sous-titre 2"></div>
<!-- Cette ligne contient le balisage/texte : <input id="libSsTitr2Art" name="libSsTitr2Art" class="article-editor-input" -->
                                    <input id="libSsTitr2Art" name="libSsTitr2Art" class="article-editor-input"
<!-- Cette ligne contient le balisage/texte : type="text" maxlength="100" required data-preview-target="preview-subtitle2" -->
                                        type="text" maxlength="100" required data-preview-target="preview-subtitle2"
<!-- Cette ligne contient le balisage/texte : value="<?php echo $ba_bec_article['libSsTitr2Art']; ?>" -->
                                        value="<?php echo $ba_bec_article['libSsTitr2Art']; ?>"
<!-- Cette ligne contient le balisage/texte : placeholder="Sous-titre 2" /> -->
                                        placeholder="Sous-titre 2" />
<!-- Cette ligne contient le balisage/texte : </div> -->
                                </div>

<!-- Cette ligne contient le balisage/texte : <div class="article-editor-field"> -->
                                <div class="article-editor-field">
<!-- Cette ligne contient le balisage/texte : <p id="preview-parag3" -->
                                    <p id="preview-parag3"
<!-- Cette ligne contient le balisage/texte : class="paragraphe3 article-editor-display article-editor-display- -paragraph" -->
                                        class="paragraphe3 article-editor-display article-editor-display--paragraph"
<!-- Cette ligne contient le balisage/texte : data-placeholder="Troisième paragraphe : concluez votre développement."></p> -->
                                        data-placeholder="Troisième paragraphe : concluez votre développement."></p>
<!-- Cette ligne contient le balisage/texte : <textarea id="parag3Art" name="parag3Art" class="article-editor-input" -->
                                    <textarea id="parag3Art" name="parag3Art" class="article-editor-input"
<!-- Cette ligne contient le balisage/texte : maxlength="1200" required data-preview-target="preview-parag3" -->
                                        maxlength="1200" required data-preview-target="preview-parag3"
<!-- Cette ligne contient le balisage/texte : placeholder="Troisième paragraphe : concluez votre développement."><?php echo $ba_bec_article['parag3Art']; ?></textarea> -->
                                        placeholder="Troisième paragraphe : concluez votre développement."><?php echo $ba_bec_article['parag3Art']; ?></textarea>
<!-- Cette ligne contient le balisage/texte : </div> -->
                                </div>

<!-- Cette ligne contient le balisage/texte : <div class="article-editor-field"> -->
                                <div class="article-editor-field">
<!-- Cette ligne contient le balisage/texte : <p id="preview-concl" -->
                                    <p id="preview-concl"
<!-- Cette ligne contient le balisage/texte : class="conclusion article-editor-display article-editor-display- -conclusion" -->
                                        class="conclusion article-editor-display article-editor-display--conclusion"
<!-- Cette ligne contient le balisage/texte : data-placeholder="Conclusion : terminez sur une note forte."></p> -->
                                        data-placeholder="Conclusion : terminez sur une note forte."></p>
<!-- Cette ligne contient le balisage/texte : <textarea id="libConclArt" name="libConclArt" class="article-editor-input" -->
                                    <textarea id="libConclArt" name="libConclArt" class="article-editor-input"
<!-- Cette ligne contient le balisage/texte : maxlength="800" required data-preview-target="preview-concl" -->
                                        maxlength="800" required data-preview-target="preview-concl"
<!-- Cette ligne contient le balisage/texte : placeholder="Conclusion : terminez sur une note forte."><?php echo $ba_bec_article['libConclArt']; ?></textarea> -->
                                        placeholder="Conclusion : terminez sur une note forte."><?php echo $ba_bec_article['libConclArt']; ?></textarea>
<!-- Cette ligne contient le balisage/texte : </div> -->
                                </div>
<!-- Cette ligne contient le balisage/texte : </article> -->
                            </article>
<!-- Cette ligne contient le balisage/texte : </div> -->
                        </div>

<!-- Cette ligne contient le balisage/texte : <aside class="col-12 col-lg-4 article-editor__panel"> -->
                        <aside class="col-12 col-lg-4 article-editor__panel">
<!-- Cette ligne contient le balisage/texte : <div class="card shadow-sm mb-4"> -->
                            <div class="card shadow-sm mb-4">
<!-- Cette ligne contient le balisage/texte : <div class="card-body"> -->
                                <div class="card-body">
<!-- Cette ligne contient le balisage/texte : <h2 class="h5 mb-3">Paramètres de publication</h2> -->
                                    <h2 class="h5 mb-3">Paramètres de publication</h2>
<!-- Cette ligne contient le balisage/texte : <div class="mb-3"> -->
                                    <div class="mb-3">
<!-- Cette ligne contient le balisage/texte : <label for="urlPhotArt" class="form-label">Image actuelle</label> -->
                                        <label for="urlPhotArt" class="form-label">Image actuelle</label>
<!-- Cette ligne contient le balisage/texte : <img class="img-fluid rounded mb-2" -->
                                        <img class="img-fluid rounded mb-2"
<!-- Cette ligne contient le balisage/texte : src="<?php echo htmlspecialchars($ba_bec_photoUrl); ?>" -->
                                            src="<?php echo htmlspecialchars($ba_bec_photoUrl); ?>"
<!-- Cette ligne contient le balisage/texte : alt="Image de l'article"> -->
                                            alt="Image de l'article">
<!-- Cette ligne contient le balisage/texte : <input type="file" id="urlPhotArt" name="urlPhotArt" class="form-control" -->
                                        <input type="file" id="urlPhotArt" name="urlPhotArt" class="form-control"
<!-- Cette ligne contient le balisage/texte : accept=".png, .jpeg, .jpg, .avif, .svg" maxlength="80000"> -->
                                            accept=".png, .jpeg, .jpg, .avif, .svg" maxlength="80000">
<!-- Cette ligne contient le balisage/texte : <p class="form-text">Extensions acceptées : .png, .jpeg, .jpg, .avif, .svg.</p> -->
                                        <p class="form-text">Extensions acceptées : .png, .jpeg, .jpg, .avif, .svg.</p>
<!-- Cette ligne contient le balisage/texte : </div> -->
                                    </div>

<!-- Cette ligne contient le balisage/texte : <div class="mb-3"> -->
                                    <div class="mb-3">
<!-- Cette ligne contient le balisage/texte : <label for="numThem" class="form-label">Thématique</label> -->
                                        <label for="numThem" class="form-label">Thématique</label>
<!-- Cette ligne contient le balisage/texte : <select id="numThem" name="numThem" class="form-select" required> -->
                                        <select id="numThem" name="numThem" class="form-select" required>
<!-- Cette ligne contient le balisage/texte : <option value="">- - Choisissez une thématique - -</option> -->
                                            <option value="">-- Choisissez une thématique --</option>
<!-- Cette ligne contient le balisage/texte : <?php foreach ($ba_bec_thematiques as $ba_bec_thematique) { ?> -->
                                            <?php foreach ($ba_bec_thematiques as $ba_bec_thematique) { ?>
<!-- Cette ligne contient le balisage/texte : <option value="<?= $ba_bec_thematique['numThem'] ?>" <?php echo $ba_bec_thematique['numThem'] == $ba_bec_article['numThem'] ? 'selected' : ''; ?>> -->
                                                <option value="<?= $ba_bec_thematique['numThem'] ?>" <?php echo $ba_bec_thematique['numThem'] == $ba_bec_article['numThem'] ? 'selected' : ''; ?>>
<!-- Cette ligne contient le balisage/texte : <?= $ba_bec_thematique['libThem'] ?> -->
                                                    <?= $ba_bec_thematique['libThem'] ?>
<!-- Cette ligne contient le balisage/texte : </option> -->
                                                </option>
<!-- Cette ligne contient le balisage/texte : <?php } ?> -->
                                            <?php } ?>
<!-- Cette ligne contient le balisage/texte : </select> -->
                                        </select>
<!-- Cette ligne contient le balisage/texte : </div> -->
                                    </div>

<!-- Cette ligne contient le balisage/texte : <div class="mb-3"> -->
                                    <div class="mb-3">
<!-- Cette ligne contient le balisage/texte : <label class="form-label">Mots-clés liés à l'article</label> -->
                                        <label class="form-label">Mots-clés liés à l'article</label>
<!-- Cette ligne contient le balisage/texte : <div class="row g-2"> -->
                                        <div class="row g-2">
<!-- Cette ligne contient le balisage/texte : <div class="col-12"> -->
                                            <div class="col-12">
<!-- Cette ligne contient le balisage/texte : <select name="addMotCle" id="addMotCle" class="form-select" size="5"> -->
                                                <select name="addMotCle" id="addMotCle" class="form-select" size="5">
<!-- Cette ligne contient le balisage/texte : <?php -->
                                                    <?php
<!-- Cette ligne contient le balisage/texte : foreach ($ba_bec_keywords as $ba_bec_req) { -->
                                                    foreach ($ba_bec_keywords as $ba_bec_req) {
<!-- Cette ligne contient le balisage/texte : if (in_array((int) $ba_bec_req['numMotCle'], $ba_bec_selectedKeywordIds, true)) { -->
                                                        if (in_array((int) $ba_bec_req['numMotCle'], $ba_bec_selectedKeywordIds, true)) {
<!-- Cette ligne contient le balisage/texte : continue; -->
                                                            continue;
<!-- Cette ligne contient le balisage/texte : } -->
                                                        }
<!-- Cette ligne contient le balisage/texte : echo '<option id="mot" value="' . $ba_bec_req['numMotCle'] . '">' . $ba_bec_req['libMotCle'] . '</option>'; -->
                                                        echo '<option id="mot" value="' . $ba_bec_req['numMotCle'] . '">' . $ba_bec_req['libMotCle'] . '</option>';
<!-- Cette ligne contient le balisage/texte : } -->
                                                    }
<!-- Cette ligne contient le balisage/texte : ?> -->
                                                    ?>
<!-- Cette ligne contient le balisage/texte : </select> -->
                                                </select>
<!-- Cette ligne contient le balisage/texte : </div> -->
                                            </div>
<!-- Cette ligne contient le balisage/texte : <div class="col-12"> -->
                                            <div class="col-12">
<!-- Cette ligne contient le balisage/texte : <select id="newMotCle" name="motCle[]" class="form-select" size="5" -->
                                                <select id="newMotCle" name="motCle[]" class="form-select" size="5"
<!-- Cette ligne contient le balisage/texte : multiple> -->
                                                    multiple>
<!-- Cette ligne contient le balisage/texte : <?php -->
                                                    <?php
<!-- Cette ligne contient le balisage/texte : foreach ($ba_bec_keywords as $ba_bec_req) { -->
                                                    foreach ($ba_bec_keywords as $ba_bec_req) {
<!-- Cette ligne contient le balisage/texte : if (!in_array((int) $ba_bec_req['numMotCle'], $ba_bec_selectedKeywordIds, true)) { -->
                                                        if (!in_array((int) $ba_bec_req['numMotCle'], $ba_bec_selectedKeywordIds, true)) {
<!-- Cette ligne contient le balisage/texte : continue; -->
                                                            continue;
<!-- Cette ligne contient le balisage/texte : } -->
                                                        }
<!-- Cette ligne contient le balisage/texte : echo '<option id="mot" value="' . $ba_bec_req['numMotCle'] . '" selected>' . $ba_bec_req['libMotCle'] . '</option>'; -->
                                                        echo '<option id="mot" value="' . $ba_bec_req['numMotCle'] . '" selected>' . $ba_bec_req['libMotCle'] . '</option>';
<!-- Cette ligne contient le balisage/texte : } -->
                                                    }
<!-- Cette ligne contient le balisage/texte : ?> -->
                                                    ?>
<!-- Cette ligne contient le balisage/texte : </select> -->
                                                </select>
<!-- Cette ligne contient le balisage/texte : </div> -->
                                            </div>
<!-- Cette ligne contient le balisage/texte : </div> -->
                                        </div>
<!-- Cette ligne contient le balisage/texte : </div> -->
                                    </div>

<!-- Cette ligne contient le balisage/texte : <button type="submit" class="btn btn-primary w-100">Confirmer la mise à jour</button> -->
                                    <button type="submit" class="btn btn-primary w-100">Confirmer la mise à jour</button>
<!-- Cette ligne contient le balisage/texte : </div> -->
                                </div>
<!-- Cette ligne contient le balisage/texte : </div> -->
                            </div>
<!-- Cette ligne contient le balisage/texte : </aside> -->
                        </aside>
<!-- Cette ligne contient le balisage/texte : </div> -->
                    </div>
<!-- Cette ligne contient le balisage/texte : </div> -->
                </div>
<!-- Cette ligne contient le balisage/texte : </section> -->
            </section>
<!-- Cette ligne contient le balisage/texte : </section> -->
        </section>
<!-- Cette ligne contient le balisage/texte : </form> -->
    </form>
<!-- Cette ligne contient le balisage/texte : </div> -->
</div>

<!-- Cette ligne ouvre une balise script pour le JavaScript. -->
<script>
// Cette ligne contient l'instruction JavaScript : const addMotCle = document.getElementById('addMotCle');
    const addMotCle = document.getElementById('addMotCle');
// Cette ligne contient l'instruction JavaScript : const newMotCle = document.getElementById('newMotCle');
    const newMotCle = document.getElementById('newMotCle');
// Cette ligne contient l'instruction JavaScript : const newOptions = newMotCle?.options;
    const newOptions = newMotCle?.options;

// Cette ligne contient l'instruction JavaScript : if (addMotCle && newMotCle) {
    if (addMotCle && newMotCle) {
// Cette ligne contient l'instruction JavaScript : addMotCle.addEventListener('click', (e) => {
        addMotCle.addEventListener('click', (e) => {
// Cette ligne contient l'instruction JavaScript : if (e.target.tagName !== "OPTION") {
            if (e.target.tagName !== "OPTION") {
// Cette ligne contient l'instruction JavaScript : return;
                return;
// Cette ligne contient l'instruction JavaScript : }
            }
// Cette ligne contient l'instruction JavaScript : e.target.setAttribute('selected', true);
            e.target.setAttribute('selected', true);
// Cette ligne contient l'instruction JavaScript : newMotCle.appendChild(e.target);
            newMotCle.appendChild(e.target);
// Cette ligne contient l'instruction JavaScript : });
        });

// Cette ligne contient l'instruction JavaScript : newMotCle.addEventListener('click', (e) => {
        newMotCle.addEventListener('click', (e) => {
// Cette ligne contient l'instruction JavaScript : if (e.target.tagName !== "OPTION") {
            if (e.target.tagName !== "OPTION") {
// Cette ligne contient l'instruction JavaScript : return;
                return;
// Cette ligne contient l'instruction JavaScript : }
            }
// Cette ligne contient l'instruction JavaScript : e.stopPropagation();
            e.stopPropagation();
// Cette ligne contient l'instruction JavaScript : e.preventDefault();
            e.preventDefault();
// Cette ligne contient l'instruction JavaScript : e.stopImmediatePropagation();
            e.stopImmediatePropagation();
// Cette ligne contient l'instruction JavaScript : e.target.setAttribute('selected', false);
            e.target.setAttribute('selected', false);
// Cette ligne contient l'instruction JavaScript : addMotCle.appendChild(e.target);
            addMotCle.appendChild(e.target);
// Cette ligne contient l'instruction JavaScript : for (let option of newMotCle.children) {
            for (let option of newMotCle.children) {
// Cette ligne contient l'instruction JavaScript : option.setAttribute('selected', true);
                option.setAttribute('selected', true);
// Cette ligne contient l'instruction JavaScript : }
            }
// Cette ligne contient l'instruction JavaScript : });
        });
// Cette ligne contient l'instruction JavaScript : }
    }

// Cette ligne contient l'instruction JavaScript : const formatDateTime = (value) => {
    const formatDateTime = (value) => {
// Cette ligne contient l'instruction JavaScript : if (!value) {
        if (!value) {
// Cette ligne contient l'instruction JavaScript : return '';
            return '';
// Cette ligne contient l'instruction JavaScript : }
        }
// Cette ligne contient l'instruction JavaScript : const date = new Date(value);
        const date = new Date(value);
// Cette ligne contient l'instruction JavaScript : if (Number.isNaN(date.getTime())) {
        if (Number.isNaN(date.getTime())) {
// Cette ligne contient l'instruction JavaScript : return value;
            return value;
// Cette ligne contient l'instruction JavaScript : }
        }
// Cette ligne contient l'instruction JavaScript : const datePart = date.toLocaleDateString('fr-FR');
        const datePart = date.toLocaleDateString('fr-FR');
// Cette ligne contient l'instruction JavaScript : const timePart = date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
        const timePart = date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
// Cette ligne contient l'instruction JavaScript : return `${datePart} ${timePart}`;
        return `${datePart} ${timePart}`;
// Cette ligne contient l'instruction JavaScript : };
    };

// Cette ligne contient l'instruction JavaScript : const updatePreview = (input, target) => {
    const updatePreview = (input, target) => {
// Cette ligne contient l'instruction JavaScript : const placeholder = target.dataset.placeholder || '';
        const placeholder = target.dataset.placeholder || '';
// Cette ligne contient l'instruction JavaScript : const rawValue = input.value.trim();
        const rawValue = input.value.trim();
// Cette ligne contient l'instruction JavaScript : const formattedValue = input.type === 'datetime-local' ? formatDateTime(rawValue) : rawValue;
        const formattedValue = input.type === 'datetime-local' ? formatDateTime(rawValue) : rawValue;
// Cette ligne contient l'instruction JavaScript : const nextValue = formattedValue || placeholder;
        const nextValue = formattedValue || placeholder;

// Cette ligne contient l'instruction JavaScript : target.textContent = nextValue;
        target.textContent = nextValue;
// Cette ligne contient l'instruction JavaScript : target.classList.toggle('is-placeholder', !formattedValue);
        target.classList.toggle('is-placeholder', !formattedValue);
// Cette ligne contient l'instruction JavaScript : };
    };

// Cette ligne contient l'instruction JavaScript : document.querySelectorAll('[data-preview-target]').forEach((input) => {
    document.querySelectorAll('[data-preview-target]').forEach((input) => {
// Cette ligne contient l'instruction JavaScript : const target = document.getElementById(input.dataset.previewTarget);
        const target = document.getElementById(input.dataset.previewTarget);
// Cette ligne contient l'instruction JavaScript : if (!target) {
        if (!target) {
// Cette ligne contient l'instruction JavaScript : return;
            return;
// Cette ligne contient l'instruction JavaScript : }
        }
// Cette ligne contient l'instruction JavaScript : const handler = () => updatePreview(input, target);
        const handler = () => updatePreview(input, target);
// Cette ligne contient l'instruction JavaScript : input.addEventListener('input', handler);
        input.addEventListener('input', handler);
// Cette ligne contient l'instruction JavaScript : input.addEventListener('change', handler);
        input.addEventListener('change', handler);
// Cette ligne contient l'instruction JavaScript : handler();
        handler();
// Cette ligne contient l'instruction JavaScript : });
    });
// Cette ligne ferme le bloc JavaScript avant la balise de fermeture.
</script>
