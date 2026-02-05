<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';
include '../../header.php';

function ensure_upload_dir(string $path): void
{
    if (!is_dir($path)) {
        mkdir($path, 0775, true);
    }
}

function sanitize_code_equipe(string $codeEquipe): string
{
    $sanitized = preg_replace('/[^A-Za-z0-9_-]+/', '', $codeEquipe);
    return $sanitized !== '' ? $sanitized : 'equipe';
}

function upload_team_photo(string $fileKey, string $codeEquipe, string $suffix, array &$errors): ?string
{
    if (!isset($_FILES[$fileKey]) || $_FILES[$fileKey]['error'] !== 0) {
        return null;
    }

    $tmpName = $_FILES[$fileKey]['tmp_name'];
    $name = $_FILES[$fileKey]['name'];
    $size = $_FILES[$fileKey]['size'];
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'avif', 'svg'];
    $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/avif',
        'image/svg+xml',
        'image/svg',
        'text/xml',
        'application/xml',
    ];

    if ($size > 10000000) {
        $errors[] = "Le fichier est trop volumineux.";
        return null;
    }

    $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    if (!in_array($extension, $allowedExtensions, true)) {
        $errors[] = "Format d'image non autorisé.";
        return null;
    }

    $mimeType = null;
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo) {
            $mimeType = finfo_file($finfo, $tmpName);
            finfo_close($finfo);
        }
    }

    if ($mimeType && !in_array($mimeType, $allowedMimeTypes, true)) {
        $errors[] = "Format d'image non autorisé.";
        return null;
    }

    if (!in_array($extension, ['svg', 'avif'], true)) {
        $dimensions = getimagesize($tmpName);
        if ($dimensions === false) {
            $errors[] = "Le fichier n'est pas une image valide.";
            return null;
        }
    }

    $codeEquipeSafe = sanitize_code_equipe($codeEquipe);
    $fileName = $codeEquipeSafe . '-' . $suffix . '.' . $extension;
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/photos-equipes/';
    ensure_upload_dir($uploadDir);
    $destination = $uploadDir . $fileName;

    if (!move_uploaded_file($tmpName, $destination)) {
        $errors[] = "Erreur lors de l'upload de l'image.";
        return null;
    }

    return 'photos-equipes/' . $fileName;
}

function process_equipe_upload(string $fileKey, string $codeEquipe, string $suffix, array &$errors): ?string
{
    return upload_team_photo($fileKey, $codeEquipe, $suffix, $errors);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    sql_connect();

    $ba_bec_errors = [];
    if (empty($_POST) && empty($_FILES)) {
        $ba_bec_errors[] = 'Le formulaire est vide. Vérifiez la taille des fichiers envoyés et réessayez.';
    }

    $ba_bec_codeEquipe = ctrlSaisies($_POST['codeEquipe'] ?? '');
    $ba_bec_libEquipe = ctrlSaisies($_POST['libEquipe'] ?? '');
    $ba_bec_libEquipeComplet = ctrlSaisies($_POST['libEquipeComplet'] ?? '');
    $ba_bec_descriptionEquipe = ctrlSaisies($_POST['descriptionEquipe'] ?? '');
    $ba_bec_urlPhotoEquipe = ctrlSaisies($_POST['urlPhotoEquipe'] ?? '');
    $ba_bec_urlPhotoStaff = ctrlSaisies($_POST['urlPhotoStaff'] ?? '');
    $ba_bec_nomClub = ctrlSaisies($_POST['nomClub'] ?? '');
    $ba_bec_categorieEquipe = ctrlSaisies($_POST['categorieEquipe'] ?? '');
    $ba_bec_sectionEquipe = ctrlSaisies($_POST['sectionEquipe'] ?? '');
    $ba_bec_niveauEquipe = ctrlSaisies($_POST['niveauEquipe'] ?? '');

    if (empty($ba_bec_errors) && ($ba_bec_libEquipe === '' || $ba_bec_codeEquipe === '')) {
        $ba_bec_errors[] = 'Le code et le nom de l\'équipe sont obligatoires.';
    }
    if (empty($ba_bec_errors) && $ba_bec_nomClub === '') {
        $ba_bec_errors[] = 'Le club est obligatoire.';
    }

    $ba_bec_photoEquipe = null;
    $ba_bec_photoStaff = null;
    if (empty($ba_bec_errors)) {
        $ba_bec_photoEquipe = process_equipe_upload('photoEquipe', $ba_bec_codeEquipe, 'photo-equipe', $ba_bec_errors);
        $ba_bec_photoStaff = process_equipe_upload('photoStaff', $ba_bec_codeEquipe, 'photo-staff', $ba_bec_errors);
    }

    if (empty($ba_bec_errors)) {
        $clubStmt = $DB->prepare('SELECT numClub FROM CLUB WHERE nomClub = :nomClub LIMIT 1');
        $clubStmt->execute([':nomClub' => $ba_bec_nomClub]);
        $numClub = $clubStmt->fetchColumn();
        if ($numClub === false) {
            $insertClub = $DB->prepare('INSERT INTO CLUB (nomClub) VALUES (:nomClub)');
            $insertClub->execute([':nomClub' => $ba_bec_nomClub]);
            $numClub = $DB->lastInsertId();
        }

        $referenceLookup = static function (string $table, string $column, string $value) use ($DB): int {
            $idColumnMap = [
                'CATEGORIE_EQUIPE' => 'numCategorie',
                'SECTION_EQUIPE' => 'numSection',
                'NIVEAU_EQUIPE' => 'numNiveau',
            ];
            $idColumn = $idColumnMap[$table] ?? ("num" . ucfirst(strtolower(str_replace('_', '', $table))));
            $stmt = $DB->prepare("SELECT {$idColumn} FROM {$table} WHERE {$column} = :value LIMIT 1");
            $stmt->execute([':value' => $value]);
            $found = $stmt->fetchColumn();
            if ($found !== false) {
                return (int) $found;
            }
            $insert = $DB->prepare("INSERT INTO {$table} ({$column}) VALUES (:value)");
            $insert->execute([':value' => $value]);
            return (int) $DB->lastInsertId();
        };

        $numCategorie = $referenceLookup('CATEGORIE_EQUIPE', 'libCategorie', $ba_bec_categorieEquipe !== '' ? $ba_bec_categorieEquipe : 'Non renseigné', 'numCategorie');
        $numSection = $referenceLookup('SECTION_EQUIPE', 'libSection', $ba_bec_sectionEquipe !== '' ? $ba_bec_sectionEquipe : 'Non renseigné', 'numSection');
        $numNiveau = $referenceLookup('NIVEAU_EQUIPE', 'libNiveau', $ba_bec_niveauEquipe !== '' ? $ba_bec_niveauEquipe : 'Non renseigné', 'numNiveau');

        $insertEquipe = $DB->prepare(
            'INSERT INTO EQUIPE (numClub, codeEquipe, libEquipe, libEquipeComplet, numCategorie, numSection, numNiveau, descriptionEquipe, urlPhotoEquipe, urlPhotoStaff)
             VALUES (:numClub, :codeEquipe, :libEquipe, :libEquipeComplet, :numCategorie, :numSection, :numNiveau, :descriptionEquipe, :photoEquipe, :photoStaff)'
        );
        $insertEquipe->execute([
            ':numClub' => $numClub,
            ':codeEquipe' => $ba_bec_codeEquipe,
            ':libEquipe' => $ba_bec_libEquipe,
            ':libEquipeComplet' => $ba_bec_libEquipeComplet !== '' ? $ba_bec_libEquipeComplet : null,
            ':numCategorie' => $numCategorie,
            ':numSection' => $numSection,
            ':numNiveau' => $numNiveau,
            ':descriptionEquipe' => $ba_bec_descriptionEquipe !== '' ? $ba_bec_descriptionEquipe : null,
            ':photoEquipe' => $ba_bec_photoEquipe,
            ':photoStaff' => $ba_bec_photoStaff,
        ]);
        header('Location: ../../views/backend/equipes/list.php');
        exit();
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($ba_bec_errors ?? [])): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($ba_bec_errors as $ba_bec_error): ?>
                            <li><?= $ba_bec_error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <a href="<?php echo ROOT_URL . '/views/backend/equipes/create.php'; ?>" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</div>
