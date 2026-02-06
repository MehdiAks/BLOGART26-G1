<?php
/*
 * Endpoint API: api/equipes/update.php
 * Rôle: met à jour un(e) equipe existant(e).
 *
 * Déroulé détaillé:
 * 1) Charge la configuration applicative et les helpers (session/DB/sanitisation).
 * 2) Récupère les paramètres POST (et éventuellement FILES) puis les nettoie via ctrlSaisies.
 * 3) Valide les contraintes métier (champs obligatoires, types, formats, tailles).
 * 4) Exécute la requête SQL adaptée (INSERT/UPDATE/DELETE) avec les valeurs préparées.
 * 5) Gère le feedback (flash/session/erreur) et redirige l'utilisateur vers l'écran cible.
 */
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

function ensure_upload_dir(string $path): void
{
    if (!is_dir($path)) {
        mkdir($path, 0775, true);
    }
}

function team_upload_dir(): string
{
    $baseDir = realpath(__DIR__ . '/../../');
    if ($baseDir === false) {
        $baseDir = dirname(__DIR__, 2);
    }
    return rtrim($baseDir, '/') . '/src/uploads/photos-equipes/';
}

function uploads_root_dir(): string
{
    $baseDir = realpath(__DIR__ . '/../../');
    if ($baseDir === false) {
        $baseDir = dirname(__DIR__, 2);
    }
    return rtrim($baseDir, '/') . '/src/uploads/';
}

function normalize_upload_path(?string $path): ?string
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

function sanitize_code_equipe(string $codeEquipe): string
{
    $sanitized = preg_replace('/[^A-Za-z0-9_-]+/', '', $codeEquipe);
    return $sanitized !== '' ? $sanitized : 'equipe';
}

function upload_error_message(int $errorCode): string
{
    return match ($errorCode) {
        UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'Le fichier est trop volumineux.',
        UPLOAD_ERR_PARTIAL => 'Le fichier a été envoyé partiellement.',
        UPLOAD_ERR_NO_FILE => 'Aucun fichier n’a été envoyé.',
        UPLOAD_ERR_NO_TMP_DIR => 'Dossier temporaire manquant.',
        UPLOAD_ERR_CANT_WRITE => 'Impossible d’écrire le fichier sur le disque.',
        UPLOAD_ERR_EXTENSION => 'Envoi stoppé par une extension PHP.',
        default => 'Erreur lors de l’envoi du fichier.',
    };
}

function upload_team_photo(string $fileKey, string $codeEquipe, string $suffix, array &$errors): ?string
{
    if (!isset($_FILES[$fileKey])) {
        return null;
    }

    if ($_FILES[$fileKey]['error'] !== UPLOAD_ERR_OK) {
        if ($_FILES[$fileKey]['error'] !== UPLOAD_ERR_NO_FILE) {
            $errors[] = upload_error_message($_FILES[$fileKey]['error']);
        }
        return null;
    }

    $tmpName = $_FILES[$fileKey]['tmp_name'];
    $name = $_FILES[$fileKey]['name'];
    $size = $_FILES[$fileKey]['size'];
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'avif', 'svg', 'webp', 'gif'];
    $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/avif',
        'image/webp',
        'image/gif',
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
    $uploadDir = team_upload_dir();
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

function rename_team_photo_variants(string $oldCode, string $newCode, string $suffix): void
{
    $extensions = ['jpg', 'jpeg', 'png', 'avif', 'svg', 'webp', 'gif'];
    $uploadDir = team_upload_dir();
    foreach ($extensions as $extension) {
        $oldPath = $uploadDir . $oldCode . '-' . $suffix . '.' . $extension;
        $newPath = $uploadDir . $newCode . '-' . $suffix . '.' . $extension;
        if (file_exists($oldPath)) {
            ensure_upload_dir($uploadDir);
            rename($oldPath, $newPath);
        }
    }
}

function delete_team_photo_variants(string $codeEquipe, string $suffix): void
{
    $extensions = ['jpg', 'jpeg', 'png', 'avif', 'svg', 'webp', 'gif'];
    $uploadDir = team_upload_dir();
    foreach ($extensions as $extension) {
        $path = $uploadDir . $codeEquipe . '-' . $suffix . '.' . $extension;
        if (file_exists($path)) {
            unlink($path);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    sql_connect();

    $ba_bec_errors = [];
    if (empty($_POST) && empty($_FILES)) {
        $ba_bec_errors[] = 'Le formulaire est vide. Vérifiez la taille des fichiers envoyés et réessayez.';
    }

    $ba_bec_numEquipe = (int) ($_POST['numEquipe'] ?? 0);
    $ba_bec_codeEquipe = ctrlSaisies($_POST['codeEquipe'] ?? '');
    $ba_bec_nomEquipe = ctrlSaisies($_POST['nomEquipe'] ?? '');
    $ba_bec_club = ctrlSaisies($_POST['club'] ?? '');
    $ba_bec_descriptionEquipe = ctrlSaisies($_POST['descriptionEquipe'] ?? '');
    $ba_bec_categorieEquipe = ctrlSaisies($_POST['categorie'] ?? '');
    $ba_bec_sectionEquipe = ctrlSaisies($_POST['section'] ?? '');
    $ba_bec_niveauEquipe = ctrlSaisies($_POST['niveau'] ?? '');

    if (empty($ba_bec_errors) && ($ba_bec_numEquipe <= 0 || $ba_bec_nomEquipe === '' || $ba_bec_codeEquipe === '')) {
        $ba_bec_errors[] = 'Le code et le nom de l\'équipe sont obligatoires.';
    }
    if (empty($ba_bec_errors) && $ba_bec_club === '') {
        $ba_bec_errors[] = 'Le club est obligatoire.';
    }

    $ba_bec_existingPhotos = null;
    if ($ba_bec_numEquipe > 0) {
        $photoStmt = $DB->prepare('SELECT photoDLequipe, photoStaff FROM EQUIPE WHERE numEquipe = :numEquipe');
        $photoStmt->execute([':numEquipe' => $ba_bec_numEquipe]);
        $ba_bec_existingPhotos = $photoStmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    $ba_bec_photoEquipe = $ba_bec_existingPhotos['photoDLequipe'] ?? null;
    $ba_bec_photoStaff = $ba_bec_existingPhotos['photoStaff'] ?? null;

    if (empty($ba_bec_errors)) {
        $ba_bec_photoEquipeUploaded = process_equipe_upload('photoDLequipe', $ba_bec_codeEquipe, 'photo-equipe', $ba_bec_errors);
        $ba_bec_photoStaffUploaded = process_equipe_upload('photoStaff', $ba_bec_codeEquipe, 'photo-staff', $ba_bec_errors);

        if ($ba_bec_photoEquipeUploaded) {
            $oldRelative = normalize_upload_path($ba_bec_photoEquipe);
            if ($oldRelative) {
                $oldPath = uploads_root_dir() . $oldRelative;
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
                    $safeCode = sanitize_code_equipe($ba_bec_codeEquipe);
                    $targetRelative = 'photos-equipes/' . $safeCode . '-photo-equipe.' . $extension;
                    if ($oldRelative !== $targetRelative) {
                        $oldPath = uploads_root_dir() . $oldRelative;
                        $newDir = team_upload_dir();
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
                $oldPath = uploads_root_dir() . $oldRelative;
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
                    $safeCode = sanitize_code_equipe($ba_bec_codeEquipe);
                    $targetRelative = 'photos-equipes/' . $safeCode . '-photo-staff.' . $extension;
                    if ($oldRelative !== $targetRelative) {
                        $oldPath = uploads_root_dir() . $oldRelative;
                        $newDir = team_upload_dir();
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
        $ba_bec_existingCode = '';
        if ($ba_bec_numEquipe > 0) {
            $codeStmt = $DB->prepare('SELECT codeEquipe FROM EQUIPE WHERE numEquipe = :numEquipe LIMIT 1');
            $codeStmt->execute([':numEquipe' => $ba_bec_numEquipe]);
            $ba_bec_existingCode = (string) $codeStmt->fetchColumn();
        }
        $ba_bec_existingCodeSafe = $ba_bec_existingCode !== '' ? sanitize_code_equipe($ba_bec_existingCode) : '';
        $ba_bec_codeEquipeSafe = sanitize_code_equipe($ba_bec_codeEquipe);

        $hasEquipeUpload = isset($_FILES['photoDLequipe']) && $_FILES['photoDLequipe']['error'] === 0;
        $hasStaffUpload = isset($_FILES['photoStaff']) && $_FILES['photoStaff']['error'] === 0;

        if ($ba_bec_existingCodeSafe && $ba_bec_existingCodeSafe !== $ba_bec_codeEquipeSafe) {
            if (!$hasEquipeUpload) {
                rename_team_photo_variants($ba_bec_existingCodeSafe, $ba_bec_codeEquipeSafe, 'photo-equipe');
            }
            if (!$hasStaffUpload) {
                rename_team_photo_variants($ba_bec_existingCodeSafe, $ba_bec_codeEquipeSafe, 'photo-staff');
            }
        }

        if ($hasEquipeUpload) {
            if ($ba_bec_existingCodeSafe) {
                delete_team_photo_variants($ba_bec_existingCodeSafe, 'photo-equipe');
            }
        }
        if ($hasStaffUpload) {
            if ($ba_bec_existingCodeSafe) {
                delete_team_photo_variants($ba_bec_existingCodeSafe, 'photo-staff');
            }
        }
    }

    if (empty($ba_bec_errors)) {
        $updateEquipe = $DB->prepare(
            'UPDATE EQUIPE
                SET codeEquipe = :codeEquipe,
                    nomEquipe = :nomEquipe,
                    club = :club,
                    categorie = :categorie,
                    section = :section,
                    niveau = :niveau,
                    descriptionEquipe = :descriptionEquipe,
                    photoDLequipe = :photoEquipe,
                    photoStaff = :photoStaff
             WHERE numEquipe = :numEquipe'
        );
        $updateEquipe->execute([
            ':codeEquipe' => $ba_bec_codeEquipe,
            ':nomEquipe' => $ba_bec_nomEquipe,
            ':club' => $ba_bec_club,
            ':categorie' => $ba_bec_categorieEquipe !== '' ? $ba_bec_categorieEquipe : 'Non renseigné',
            ':section' => $ba_bec_sectionEquipe !== '' ? $ba_bec_sectionEquipe : 'Non renseigné',
            ':niveau' => $ba_bec_niveauEquipe !== '' ? $ba_bec_niveauEquipe : 'Non renseigné',
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
