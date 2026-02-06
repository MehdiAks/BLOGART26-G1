<?php
/*
 * Endpoint API: api/benevoles/create.php
 * Rôle: crée un(e) benevole en base.
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ba_bec_prenomPersonnel = ctrlSaisies($_POST['prenomPersonnel'] ?? '');
    $ba_bec_nomPersonnel = ctrlSaisies($_POST['nomPersonnel'] ?? '');
    $ba_bec_estCoach = !empty($_POST['estCoach']) ? 1 : 0;
    $ba_bec_numEquipeCoachee = ctrlSaisies($_POST['numEquipeCoachee'] ?? '');
    $ba_bec_estDirection = !empty($_POST['estDirection']) ? 1 : 0;
    $ba_bec_estCommissionTechnique = !empty($_POST['estCommissionTechnique']) ? 1 : 0;
    $ba_bec_estCommissionAnimation = !empty($_POST['estCommissionAnimation']) ? 1 : 0;
    $ba_bec_estCommissionCommunication = !empty($_POST['estCommissionCommunication']) ? 1 : 0;

    $ba_bec_errors = [];
    $ba_bec_photoPath = null;

    $ba_bec_normalize = static function (string $value): string {
        $normalized = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
        if ($normalized === false) {
            $normalized = $value;
        }
        $normalized = strtolower($normalized);
        $normalized = preg_replace('/[^a-z0-9]/', '', $normalized);
        return $normalized ?? '';
    };

    if (isset($_FILES['photoPersonnel']) && $_FILES['photoPersonnel']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['photoPersonnel']['error'] !== UPLOAD_ERR_OK) {
            $ba_bec_errors[] = "Erreur lors de l'upload de la photo.";
        } else {
            $ba_bec_tmpName = $_FILES['photoPersonnel']['tmp_name'];
            $ba_bec_name = $_FILES['photoPersonnel']['name'];
            $ba_bec_size = $_FILES['photoPersonnel']['size'];
            $ba_bec_allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            $ba_bec_allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $ba_bec_maxSize = 5 * 1024 * 1024;

            if ($ba_bec_size > $ba_bec_maxSize) {
                $ba_bec_errors[] = "Le fichier est trop volumineux.";
            } else {
                $ba_bec_extension = strtolower(pathinfo($ba_bec_name, PATHINFO_EXTENSION));
                if (!in_array($ba_bec_extension, $ba_bec_allowedExtensions, true)) {
                    $ba_bec_errors[] = "Format d'image non autorisé.";
                } else {
                    $ba_bec_mimeType = null;
                    if (function_exists('finfo_open')) {
                        $ba_bec_finfo = finfo_open(FILEINFO_MIME_TYPE);
                        if ($ba_bec_finfo) {
                            $ba_bec_mimeType = finfo_file($ba_bec_finfo, $ba_bec_tmpName);
                            finfo_close($ba_bec_finfo);
                        }
                    }

                    if ($ba_bec_mimeType && !in_array($ba_bec_mimeType, $ba_bec_allowedMimeTypes, true)) {
                        $ba_bec_errors[] = "Format d'image non autorisé.";
                    } elseif (getimagesize($ba_bec_tmpName) === false) {
                        $ba_bec_errors[] = "Le fichier n'est pas une image valide.";
                    }
                }
            }

            if (empty($ba_bec_errors)) {
                $ba_bec_nomNormalise = $ba_bec_normalize($ba_bec_nomPersonnel);
                $ba_bec_prenomNormalise = $ba_bec_normalize($ba_bec_prenomPersonnel);
                $ba_bec_prefix = substr($ba_bec_nomNormalise, 0, 2);
                if ($ba_bec_prefix === '') {
                    $ba_bec_prefix = 'xx';
                }
                if ($ba_bec_prenomNormalise === '') {
                    $ba_bec_prenomNormalise = 'prenom';
                }
                $ba_bec_fileName = $ba_bec_prefix . '.' . $ba_bec_prenomNormalise . '.' . $ba_bec_extension;
                $ba_bec_uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/photos-benevoles/';
                if (!is_dir($ba_bec_uploadDir)) {
                    mkdir($ba_bec_uploadDir, 0775, true);
                }
                $ba_bec_destination = $ba_bec_uploadDir . $ba_bec_fileName;
                if (!move_uploaded_file($ba_bec_tmpName, $ba_bec_destination)) {
                    $ba_bec_errors[] = "Erreur lors de l'upload de la photo.";
                } else {
                    $ba_bec_photoPath = '/src/uploads/photos-benevoles/' . $ba_bec_fileName;
                }
            }
        }
    }

    if ($ba_bec_prenomPersonnel === '' || $ba_bec_nomPersonnel === '') {
        $ba_bec_errors[] = 'Le prénom et le nom sont obligatoires.';
    }

    if ($ba_bec_estCoach && $ba_bec_numEquipeCoachee === '') {
        $ba_bec_errors[] = 'Veuillez sélectionner une équipe coachée.';
    }

    if (empty($ba_bec_errors)) {
        if ($ba_bec_estCoach) {
            $ba_bec_estCommissionTechnique = 1;
        }
        $ba_bec_currentMax = sql_select('PERSONNEL', 'MAX(numPersonnel) AS maxPersonnel');
        $ba_bec_nextNumPersonnel = 1;
        if (!empty($ba_bec_currentMax) && isset($ba_bec_currentMax[0]['maxPersonnel'])) {
            $ba_bec_nextNumPersonnel = (int) $ba_bec_currentMax[0]['maxPersonnel'] + 1;
        }
        $ba_bec_photoValue = $ba_bec_photoPath !== null ? "'" . $ba_bec_photoPath . "'" : 'NULL';
        $ba_bec_equipeValue = $ba_bec_numEquipeCoachee !== '' ? "'" . (int) $ba_bec_numEquipeCoachee . "'" : 'NULL';
        if (!$ba_bec_estCoach) {
            $ba_bec_equipeValue = 'NULL';
        }
        sql_insert(
            'PERSONNEL',
            'numPersonnel, prenomPersonnel, nomPersonnel, urlPhotoPersonnel, estCoach, numEquipeCoachee, estDirection, estCommissionTechnique, estCommissionAnimation, estCommissionCommunication',
            "'$ba_bec_nextNumPersonnel', '$ba_bec_prenomPersonnel', '$ba_bec_nomPersonnel', $ba_bec_photoValue, '$ba_bec_estCoach', $ba_bec_equipeValue, '$ba_bec_estDirection', '$ba_bec_estCommissionTechnique', '$ba_bec_estCommissionAnimation', '$ba_bec_estCommissionCommunication'"
        );
        header('Location: ../../views/backend/benevoles/list.php');
        exit();
    }
}
?>

<?php include '../../header.php'; ?>

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
            <a href="<?php echo ROOT_URL . '/views/backend/benevoles/create.php'; ?>" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</div>
