<?php

class ArticleController
{
    private function ensureUploadDirectory(string $path): void
    {
        if (!is_dir($path)) {
            mkdir($path, 0775, true);
        }
    }

    private function buildArticleImagePath(int $numArt, string $extension): string
    {
        return 'article/article-' . $numArt . '.' . $extension;
    }

    private function normalizeUploadPath(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (strpos($path, '/src/uploads/') !== false) {
            $relative = substr($path, strpos($path, '/src/uploads/') + strlen('/src/uploads/'));
            return ltrim($relative, '/');
        }

        return ltrim($path, '/');
    }
    private function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require_once __DIR__ . '/../config.php';
        include __DIR__ . '/../header.php';
        include __DIR__ . '/../' . $view;
        include __DIR__ . '/../footer.php';
    }

    public function list(): void
    {
        require_once __DIR__ . '/../config.php';

        $ba_bec_articles = sql_select('ARTICLE', '*');
        $ba_bec_keywords = sql_select('MOTCLE', '*');
        $ba_bec_keywordsart = sql_select('MOTCLEARTICLE', '*');
        $ba_bec_thematiques = sql_select('THEMATIQUE', '*');

        $this->render('views/backend/articles/list.php', [
            'ba_bec_articles' => $ba_bec_articles,
            'ba_bec_keywords' => $ba_bec_keywords,
            'ba_bec_keywordsart' => $ba_bec_keywordsart,
            'ba_bec_thematiques' => $ba_bec_thematiques,
        ]);
    }

    public function create(): void
    {
        require_once __DIR__ . '/../config.php';

        $pageStyles = [
            ROOT_URL . '/src/css/stylearticle.css',
            ROOT_URL . '/src/css/article-editor.css',
        ];

        $ba_bec_thematiques = sql_select('THEMATIQUE', '*');
        $ba_bec_keywords = sql_select('MOTCLE', '*');

        $this->render('views/backend/articles/create.php', [
            'pageStyles' => $pageStyles,
            'ba_bec_thematiques' => $ba_bec_thematiques,
            'ba_bec_keywords' => $ba_bec_keywords,
        ]);
    }

    public function store(): void
    {
        require_once __DIR__ . '/../config.php';
        require_once __DIR__ . '/../functions/ctrlSaisies.php';

        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $ba_bec_nom_image = null;
        $ba_bec_imagePayload = null;

        $ba_bec_libTitrArt = ctrlSaisies($_POST['libTitrArt'] ?? '');
        $ba_bec_libChapoArt = ctrlSaisies($_POST['libChapoArt'] ?? '');
        $ba_bec_libAccrochArt = ctrlSaisies($_POST['libAccrochArt'] ?? '');
        $ba_bec_parag1Art = ctrlSaisies($_POST['parag1Art'] ?? '');
        $ba_bec_libSsTitr1Art = ctrlSaisies($_POST['libSsTitr1Art'] ?? '');
        $ba_bec_parag2Art = ctrlSaisies($_POST['parag2Art'] ?? '');
        $ba_bec_libSsTitr2Art = ctrlSaisies($_POST['libSsTitr2Art'] ?? '');
        $ba_bec_parag3Art = ctrlSaisies($_POST['parag3Art'] ?? '');
        $ba_bec_libConclArt = ctrlSaisies($_POST['libConclArt'] ?? '');
        $ba_bec_numThem = ctrlSaisies($_POST['numThem'] ?? '');

        if (function_exists('mb_substr')) {
            $ba_bec_libAccrochArt = mb_substr($ba_bec_libAccrochArt, 0, 100);
        } else {
            $ba_bec_libAccrochArt = substr($ba_bec_libAccrochArt, 0, 100);
        }

        $ba_bec_numMotCle = isset($_POST['motCle']) ? (array) $_POST['motCle'] : [];
        if (isset($_FILES['urlPhotArt']) && $_FILES['urlPhotArt']['error'] === 0) {
            $ba_bec_tmpName = $_FILES['urlPhotArt']['tmp_name'];
            $ba_bec_name = $_FILES['urlPhotArt']['name'];
            $ba_bec_size = $_FILES['urlPhotArt']['size'];
            $ba_bec_allowedExtensions = ['jpg', 'jpeg', 'png', 'avif', 'svg'];
            $ba_bec_allowedMimeTypes = [
                'image/jpeg',
                'image/png',
                'image/avif',
                'image/svg+xml',
                'image/svg',
                'text/xml',
                'application/xml',
            ];

            if ($ba_bec_size > 10000000) {
                die('Le fichier est trop volumineux.');
            }

            $ba_bec_extension = strtolower(pathinfo($ba_bec_name, PATHINFO_EXTENSION));
            if (!in_array($ba_bec_extension, $ba_bec_allowedExtensions, true)) {
                die("Format d'image non autorisé.");
            }

            $ba_bec_mimeType = null;
            if (function_exists('finfo_open')) {
                $ba_bec_finfo = finfo_open(FILEINFO_MIME_TYPE);
                if ($ba_bec_finfo) {
                    $ba_bec_mimeType = finfo_file($ba_bec_finfo, $ba_bec_tmpName);
                    finfo_close($ba_bec_finfo);
                }
            }

            if ($ba_bec_mimeType && !in_array($ba_bec_mimeType, $ba_bec_allowedMimeTypes, true)) {
                die("Format d'image non autorisé.");
            }

            if (!in_array($ba_bec_extension, ['svg', 'avif'], true)) {
                $ba_bec_dimensions = getimagesize($ba_bec_tmpName);
                if ($ba_bec_dimensions === false) {
                    die("Le fichier n'est pas une image valide.");
                }
                [$ba_bec_width, $ba_bec_height] = $ba_bec_dimensions;
                if ($ba_bec_width > 5000 || $ba_bec_height > 5000) {
                    die("L'image est trop grande.");
                }
            }

            $ba_bec_imagePayload = [
                'tmpName' => $ba_bec_tmpName,
                'extension' => $ba_bec_extension,
            ];
        }

        if ($ba_bec_numThem === '' || !is_numeric($ba_bec_numThem)) {
            http_response_code(400);
            echo 'Veuillez sélectionner une thématique valide.';
            exit;
        }

        sql_insert(
            'ARTICLE',
            'libTitrArt, libChapoArt, libAccrochArt, parag1Art, libSsTitr1Art, parag2Art, libSsTitr2Art, parag3Art, libConclArt, urlPhotArt, numThem',
            "'$ba_bec_libTitrArt', '$ba_bec_libChapoArt', '$ba_bec_libAccrochArt', '$ba_bec_parag1Art', '$ba_bec_libSsTitr1Art', '$ba_bec_parag2Art', '$ba_bec_libSsTitr2Art', '$ba_bec_parag3Art', '$ba_bec_libConclArt', NULL, '$ba_bec_numThem'"
        );
        $ba_bec_lastArt = sql_select('ARTICLE', 'numArt', null, null, 'numArt DESC', '1')[0]['numArt'];

        if ($ba_bec_imagePayload) {
            $ba_bec_uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/article/';
            $this->ensureUploadDirectory($ba_bec_uploadDir);
            $ba_bec_nom_image = $this->buildArticleImagePath((int) $ba_bec_lastArt, $ba_bec_imagePayload['extension']);
            $ba_bec_destination = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $ba_bec_nom_image;

            if (!move_uploaded_file($ba_bec_imagePayload['tmpName'], $ba_bec_destination)) {
                die("Erreur lors de l'upload de l'image.");
            }

            sql_update('ARTICLE', "urlPhotArt = '$ba_bec_nom_image'", "numArt = '$ba_bec_lastArt'");
        }

        foreach ($ba_bec_numMotCle as $ba_bec_mot) {
            sql_insert('MOTCLEARTICLE', 'numArt, numMotCle', "$ba_bec_lastArt, $ba_bec_mot");
        }

        header('Location: ' . ROOT_URL . '/public/index.php?controller=article&action=list');
        exit;
    }

    public function edit(): void
    {
        require_once __DIR__ . '/../config.php';

        $pageStyles = [
            ROOT_URL . '/src/css/stylearticle.css',
            ROOT_URL . '/src/css/article-editor.css',
        ];

        $ba_bec_numArt = isset($_GET['numArt']) ? (int) $_GET['numArt'] : 0;
        $ba_bec_article = $ba_bec_numArt ? (sql_select('ARTICLE', '*', "numArt = $ba_bec_numArt")[0] ?? []) : [];
        $ba_bec_thematiques = sql_select('THEMATIQUE', '*');
        $ba_bec_keywords = sql_select('MOTCLE', '*');
        $ba_bec_selectedKeywords = $ba_bec_numArt ? sql_select('MOTCLEARTICLE', '*', "numArt = $ba_bec_numArt") : [];
        $ba_bec_urlPhotArt = $ba_bec_article['urlPhotArt'] ?? '';

        $this->render('views/backend/articles/edit.php', [
            'pageStyles' => $pageStyles,
            'ba_bec_numArt' => $ba_bec_numArt,
            'ba_bec_article' => $ba_bec_article,
            'ba_bec_thematiques' => $ba_bec_thematiques,
            'ba_bec_keywords' => $ba_bec_keywords,
            'ba_bec_selectedKeywords' => $ba_bec_selectedKeywords,
            'ba_bec_urlPhotArt' => $ba_bec_urlPhotArt,
        ]);
    }

    public function update(): void
    {
        require_once __DIR__ . '/../config.php';
        require_once __DIR__ . '/../functions/ctrlSaisies.php';

        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $ba_bec_dtMajArt = date('Y-m-d H:i:s');
        $ba_bec_libTitrArt = ctrlSaisies($_POST['libTitrArt'] ?? '');
        $ba_bec_libChapoArt = ctrlSaisies($_POST['libChapoArt'] ?? '');
        $ba_bec_libAccrochArt = ctrlSaisies($_POST['libAccrochArt'] ?? '');
        $ba_bec_parag1Art = ctrlSaisies($_POST['parag1Art'] ?? '');
        $ba_bec_libSsTitr1Art = ctrlSaisies($_POST['libSsTitr1Art'] ?? '');
        $ba_bec_parag2Art = ctrlSaisies($_POST['parag2Art'] ?? '');
        $ba_bec_libSsTitr2Art = ctrlSaisies($_POST['libSsTitr2Art'] ?? '');
        $ba_bec_parag3Art = ctrlSaisies($_POST['parag3Art'] ?? '');
        $ba_bec_libConclArt = ctrlSaisies($_POST['libConclArt'] ?? '');
        $ba_bec_numThem = ctrlSaisies($_POST['numThem'] ?? '');
        $ba_bec_numArt = ctrlSaisies($_POST['numArt'] ?? '');
        $ba_bec_numMotCle = isset($_POST['motCle']) ? (array) $_POST['motCle'] : [];

        if (function_exists('mb_substr')) {
            $ba_bec_libAccrochArt = mb_substr($ba_bec_libAccrochArt, 0, 100);
        } else {
            $ba_bec_libAccrochArt = substr($ba_bec_libAccrochArt, 0, 100);
        }

        $ba_bec_article = sql_select('ARTICLE', 'urlPhotArt', "numArt = '$ba_bec_numArt'")[0] ?? [];
        $ba_bec_ancienneImage = $this->normalizeUploadPath($ba_bec_article['urlPhotArt'] ?? null);

        if (isset($_FILES['urlPhotArt']) && $_FILES['urlPhotArt']['error'] === 0) {
            $ba_bec_tmpName = $_FILES['urlPhotArt']['tmp_name'];
            $ba_bec_name = $_FILES['urlPhotArt']['name'];
            $ba_bec_size = $_FILES['urlPhotArt']['size'];
            $ba_bec_allowedExtensions = ['jpg', 'jpeg', 'png', 'avif', 'svg'];
            $ba_bec_allowedMimeTypes = [
                'image/jpeg',
                'image/png',
                'image/avif',
                'image/svg+xml',
                'image/svg',
                'text/xml',
                'application/xml',
            ];

            if ($ba_bec_size > 10000000) {
                die('Le fichier est trop volumineux.');
            }

            $ba_bec_extension = strtolower(pathinfo($ba_bec_name, PATHINFO_EXTENSION));
            if (!in_array($ba_bec_extension, $ba_bec_allowedExtensions, true)) {
                die("Format d'image non autorisé.");
            }

            $ba_bec_mimeType = null;
            if (function_exists('finfo_open')) {
                $ba_bec_finfo = finfo_open(FILEINFO_MIME_TYPE);
                if ($ba_bec_finfo) {
                    $ba_bec_mimeType = finfo_file($ba_bec_finfo, $ba_bec_tmpName);
                    finfo_close($ba_bec_finfo);
                }
            }

            if ($ba_bec_mimeType && !in_array($ba_bec_mimeType, $ba_bec_allowedMimeTypes, true)) {
                die("Format d'image non autorisé.");
            }

            if (!in_array($ba_bec_extension, ['svg', 'avif'], true)) {
                $ba_bec_dimensions = getimagesize($ba_bec_tmpName);
                if ($ba_bec_dimensions === false) {
                    die("Le fichier n'est pas une image valide.");
                }
                [$ba_bec_width, $ba_bec_height] = $ba_bec_dimensions;
                if ($ba_bec_width > 5000 || $ba_bec_height > 5000) {
                    die("L'image est trop grande.");
                }
            }

            $ba_bec_nom_image = $this->buildArticleImagePath((int) $ba_bec_numArt, $ba_bec_extension);
            $ba_bec_uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/article/';
            $this->ensureUploadDirectory($ba_bec_uploadDir);
            $ba_bec_destination = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $ba_bec_nom_image;

            if (!move_uploaded_file($ba_bec_tmpName, $ba_bec_destination)) {
                die("Erreur lors de l'upload de l'image.");
            }

            if ($ba_bec_ancienneImage) {
                $ba_bec_oldPath = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $ba_bec_ancienneImage;
                if (file_exists($ba_bec_oldPath)) {
                    unlink($ba_bec_oldPath);
                }
            }
            $ba_bec_nom_image = $ba_bec_relativePath;
        } else {
            $ba_bec_nom_image = $ba_bec_ancienneImage;
            if ($ba_bec_nom_image && strpos($ba_bec_nom_image, 'article/') !== 0) {
                $ba_bec_legacyPath = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $ba_bec_nom_image;
                if (file_exists($ba_bec_legacyPath)) {
                    $ba_bec_extension = strtolower(pathinfo($ba_bec_nom_image, PATHINFO_EXTENSION));
                    $ba_bec_nom_image = $this->buildArticleImagePath((int) $ba_bec_numArt, $ba_bec_extension);
                    $ba_bec_uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/article/';
                    $this->ensureUploadDirectory($ba_bec_uploadDir);
                    $ba_bec_destination = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $ba_bec_nom_image;
                    if (!rename($ba_bec_legacyPath, $ba_bec_destination)) {
                        $ba_bec_nom_image = $ba_bec_ancienneImage;
                    }
                }
            }
        }

        $ba_bec_set_art = "dtMajArt = '$ba_bec_dtMajArt',
libTitrArt = '$ba_bec_libTitrArt',
libChapoArt = '$ba_bec_libChapoArt',
libAccrochArt = '$ba_bec_libAccrochArt',
parag1Art = '$ba_bec_parag1Art',
libSsTitr1Art = '$ba_bec_libSsTitr1Art',
parag2Art = '$ba_bec_parag2Art',
libSsTitr2Art = '$ba_bec_libSsTitr2Art',
parag3Art = '$ba_bec_parag3Art',
libConclArt = '$ba_bec_libConclArt',
urlPhotArt = '$ba_bec_nom_image',
numThem = '$ba_bec_numThem'";

        $ba_bec_where_num = "numArt = '$ba_bec_numArt'";

        sql_update('ARTICLE', $ba_bec_set_art, $ba_bec_where_num);

        sql_delete('MOTCLEARTICLE', $ba_bec_where_num);
        foreach ($ba_bec_numMotCle as $ba_bec_mot) {
            sql_insert('MOTCLEARTICLE', 'numArt, numMotCle', "$ba_bec_numArt, $ba_bec_mot");
        }

        header('Location: ' . ROOT_URL . '/public/index.php?controller=article&action=list');
        exit;
    }

    public function delete(): void
    {
        require_once __DIR__ . '/../config.php';

        $ba_bec_numArt = isset($_GET['numArt']) ? (int) $_GET['numArt'] : 0;
        $ba_bec_article = $ba_bec_numArt ? (sql_select('ARTICLE', '*', "numArt = $ba_bec_numArt")[0] ?? []) : [];

        $ba_bec_thematique = [];
        if (!empty($ba_bec_article['numThem'])) {
            $ba_bec_thematique = sql_select('THEMATIQUE', '*', 'numThem = ' . $ba_bec_article['numThem'])[0] ?? [];
        }

        $ba_bec_keywords = $ba_bec_numArt ? sql_select('MOTCLEARTICLE', '*', "numArt = $ba_bec_numArt") : [];
        $ba_bec_keywordsList = [];
        foreach ($ba_bec_keywords as $ba_bec_keyword) {
            $ba_bec_keywordInfo = sql_select('MOTCLE', '*', 'numMotCle = ' . $ba_bec_keyword['numMotCle'])[0] ?? [];
            if (!empty($ba_bec_keywordInfo['libMotCle'])) {
                $ba_bec_keywordsList[] = $ba_bec_keywordInfo['libMotCle'];
            }
        }

        $this->render('views/backend/articles/delete.php', [
            'ba_bec_article' => $ba_bec_article,
            'ba_bec_thematique' => $ba_bec_thematique,
            'ba_bec_keywordsList' => $ba_bec_keywordsList,
        ]);
    }

    public function destroy(): void
    {
        require_once __DIR__ . '/../config.php';
        require_once __DIR__ . '/../functions/ctrlSaisies.php';

        $ba_bec_numArt = ctrlSaisies($_POST['numArt'] ?? '');

        $ba_bec_article = sql_select('ARTICLE', 'urlPhotArt', "numArt = '$ba_bec_numArt'")[0] ?? [];
        $ba_bec_ancienneImage = $this->normalizeUploadPath($ba_bec_article['urlPhotArt'] ?? '');

        $ba_bec_uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/';

        if ($ba_bec_ancienneImage) {
            $ba_bec_oldPath = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $ba_bec_ancienneImage;
            if (file_exists($ba_bec_oldPath)) {
                unlink($ba_bec_oldPath);
            }
        }

        sql_delete('MOTCLEARTICLE', "numArt = '$ba_bec_numArt'");
        sql_delete('ARTICLE', "numArt = '$ba_bec_numArt'");

        header('Location: ' . ROOT_URL . '/public/index.php?controller=article&action=list');
        exit;
    }
}
