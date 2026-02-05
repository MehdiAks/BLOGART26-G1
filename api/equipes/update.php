<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

function normalize_upload_path(?string $path): ?string
{
    if (!$path) {
        return null;
    }

    $path = trim($path);
    $uploadsMarker = 'src/uploads/';
    $markerPos = strpos($path, $uploadsMarker);
    if ($markerPos !== false) {
        $path = substr($path, $markerPos + strlen($uploadsMarker));
    } elseif (preg_match('/^(https?:\\/\\/|\\/)/', $path)) {
        return null;
    }

    $path = ltrim($path, '/');
    return $path !== '' ? $path : null;
}

function sanitize_equipe_code(string $code): string
{
    $code = preg_replace('/[^a-z0-9-]+/i', '-', $code);
    $code = trim($code, '-');
    return $code !== '' ? $code : 'equipe';
}

function process_equipe_upload(string $field, string $codeEquipe, string $suffix, array &$errors): ?string
{
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== 0) {
        return null;
    }

    $tmpName = $_FILES[$field]['tmp_name'];
    $name = $_FILES[$field]['name'];
    $size = $_FILES[$field]['size'];
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

    $safeCode = sanitize_equipe_code($codeEquipe);
    $fileName = $safeCode . '-' . $suffix . '.' . $extension;
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/photos-equipes/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $destination = $uploadDir . $fileName;
    if (!move_uploaded_file($tmpName, $destination)) {
        $errors[] = "Erreur lors de l'upload de l'image.";
        return null;
    }

    return 'photos-equipes/' . $fileName;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    sql_connect();

    $ba_bec_numEquipe = (int) ($_POST['numEquipe'] ?? 0);
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

    $ba_bec_errors = [];

    if ($ba_bec_numEquipe <= 0 || $ba_bec_libEquipe === '' || $ba_bec_codeEquipe === '') {
        $ba_bec_errors[] = 'Le code et le nom de l\'équipe sont obligatoires.';
    }
    if ($ba_bec_nomClub === '') {
        $ba_bec_errors[] = 'Le club est obligatoire.';
    }

    $ba_bec_existingPhotos = null;
    if ($ba_bec_numEquipe > 0) {
        $photoStmt = $DB->prepare('SELECT urlPhotoEquipe, urlPhotoStaff FROM EQUIPE WHERE numEquipe = :numEquipe');
        $photoStmt->execute([':numEquipe' => $ba_bec_numEquipe]);
        $ba_bec_existingPhotos = $photoStmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    $ba_bec_photoEquipe = $ba_bec_existingPhotos['urlPhotoEquipe'] ?? null;
    $ba_bec_photoStaff = $ba_bec_existingPhotos['urlPhotoStaff'] ?? null;

    if (empty($ba_bec_errors)) {
        $ba_bec_photoEquipeUploaded = process_equipe_upload('photoEquipe', $ba_bec_codeEquipe, 'photo-equipe', $ba_bec_errors);
        $ba_bec_photoStaffUploaded = process_equipe_upload('photoStaff', $ba_bec_codeEquipe, 'photo-staff', $ba_bec_errors);

        if ($ba_bec_photoEquipeUploaded) {
            $oldRelative = normalize_upload_path($ba_bec_photoEquipe);
            if ($oldRelative) {
                $oldPath = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $oldRelative;
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $ba_bec_photoEquipe = $ba_bec_photoEquipeUploaded;
        } elseif ($ba_bec_photoEquipe) {
            $oldRelative = normalize_upload_path($ba_bec_photoEquipe);
            if ($oldRelative) {
                $extension = strtolower(pathinfo($oldRelative, PATHINFO_EXTENSION));
                if ($extension !== '') {
                    $safeCode = sanitize_equipe_code($ba_bec_codeEquipe);
                    $targetRelative = 'photos-equipes/' . $safeCode . '-photo-equipe.' . $extension;
                    if ($oldRelative !== $targetRelative) {
                        $oldPath = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $oldRelative;
                        $newDir = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/photos-equipes/';
                        if (!is_dir($newDir)) {
                            mkdir($newDir, 0755, true);
                        }
                        $newPath = $newDir . $safeCode . '-photo-equipe.' . $extension;
                        if (file_exists($oldPath) && rename($oldPath, $newPath)) {
                            $ba_bec_photoEquipe = $targetRelative;
                        }
                    } else {
                        $ba_bec_photoEquipe = $oldRelative;
                    }
                }
            }
        }

        if ($ba_bec_photoStaffUploaded) {
            $oldRelative = normalize_upload_path($ba_bec_photoStaff);
            if ($oldRelative) {
                $oldPath = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $oldRelative;
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $ba_bec_photoStaff = $ba_bec_photoStaffUploaded;
        } elseif ($ba_bec_photoStaff) {
            $oldRelative = normalize_upload_path($ba_bec_photoStaff);
            if ($oldRelative) {
                $extension = strtolower(pathinfo($oldRelative, PATHINFO_EXTENSION));
                if ($extension !== '') {
                    $safeCode = sanitize_equipe_code($ba_bec_codeEquipe);
                    $targetRelative = 'photos-equipes/' . $safeCode . '-photo-staff.' . $extension;
                    if ($oldRelative !== $targetRelative) {
                        $oldPath = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $oldRelative;
                        $newDir = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/photos-equipes/';
                        if (!is_dir($newDir)) {
                            mkdir($newDir, 0755, true);
                        }
                        $newPath = $newDir . $safeCode . '-photo-staff.' . $extension;
                        if (file_exists($oldPath) && rename($oldPath, $newPath)) {
                            $ba_bec_photoStaff = $targetRelative;
                        }
                    } else {
                        $ba_bec_photoStaff = $oldRelative;
                    }
                }
            }
        }
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
            $stmt = $DB->prepare("SELECT num" . ucfirst(strtolower(str_replace('_', '', $table))) . " FROM {$table} WHERE {$column} = :value LIMIT 1");
            $stmt->execute([':value' => $value]);
            $found = $stmt->fetchColumn();
            if ($found !== false) {
                return (int) $found;
            }
            $insert = $DB->prepare("INSERT INTO {$table} ({$column}) VALUES (:value)");
            $insert->execute([':value' => $value]);
            return (int) $DB->lastInsertId();
        };

        $numCategorie = $referenceLookup('CATEGORIE_EQUIPE', 'libCategorie', $ba_bec_categorieEquipe !== '' ? $ba_bec_categorieEquipe : 'Non renseigné');
        $numSection = $referenceLookup('SECTION_EQUIPE', 'libSection', $ba_bec_sectionEquipe !== '' ? $ba_bec_sectionEquipe : 'Non renseigné');
        $numNiveau = $referenceLookup('NIVEAU_EQUIPE', 'libNiveau', $ba_bec_niveauEquipe !== '' ? $ba_bec_niveauEquipe : 'Non renseigné');

        $updateEquipe = $DB->prepare(
            'UPDATE EQUIPE
                SET numClub = :numClub,
                    codeEquipe = :codeEquipe,
                    libEquipe = :libEquipe,
                    libEquipeComplet = :libEquipeComplet,
                    numCategorie = :numCategorie,
                    numSection = :numSection,
                    numNiveau = :numNiveau,
                    descriptionEquipe = :descriptionEquipe,
                    urlPhotoEquipe = :photoEquipe,
                    urlPhotoStaff = :photoStaff
             WHERE numEquipe = :numEquipe'
        );
        $updateEquipe->execute([
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
            ':numEquipe' => $ba_bec_numEquipe,
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
            <a href="<?php echo ROOT_URL . '/views/backend/equipes/list.php'; ?>" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</div>
