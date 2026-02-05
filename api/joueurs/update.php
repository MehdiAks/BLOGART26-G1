<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    sql_connect();

    $ba_bec_numJoueur = (int) ($_POST['numJoueur'] ?? 0);
    $ba_bec_numAffectation = (int) ($_POST['numAffectation'] ?? 0);
    $ba_bec_prenomJoueur = ctrlSaisies($_POST['prenomJoueur'] ?? '');
    $ba_bec_nomJoueur = ctrlSaisies($_POST['nomJoueur'] ?? '');
    $ba_bec_posteJoueur = ctrlSaisies($_POST['posteJoueur'] ?? '');
    $ba_bec_photoActuelle = ctrlSaisies($_POST['photoActuelle'] ?? '');
    $ba_bec_numeroMaillot = ctrlSaisies($_POST['numeroMaillot'] ?? '');
    $ba_bec_numEquipe = (int) ($_POST['numEquipe'] ?? 0);
    $ba_bec_numSaison = (int) ($_POST['numSaison'] ?? 0);
    $ba_bec_dateDebut = ctrlSaisies($_POST['dateDebut'] ?? '');
    $ba_bec_dateNaissance = ctrlSaisies($_POST['dateNaissance'] ?? '');
    $ba_bec_errors = [];
    $ba_bec_clubsPrecedentsInput = $_POST['clubsPrecedents'] ?? '';
    $ba_bec_clubsList = [];
    if (is_array($ba_bec_clubsPrecedentsInput)) {
        $ba_bec_clubsList = array_values(array_filter(array_map('trim', $ba_bec_clubsPrecedentsInput), 'strlen'));
    } elseif ($ba_bec_clubsPrecedentsInput !== '') {
        $ba_bec_clubsList = [trim((string) $ba_bec_clubsPrecedentsInput)];
    }

    $ba_bec_nom_image = null;
    if (isset($_FILES['photoJoueur']) && $_FILES['photoJoueur']['error'] === 0) {
        $ba_bec_tmpName = $_FILES['photoJoueur']['tmp_name'];
        $ba_bec_name = $_FILES['photoJoueur']['name'];
        $ba_bec_size = $_FILES['photoJoueur']['size'];
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
                } elseif (!in_array($ba_bec_extension, ['svg', 'avif'], true)) {
                    $ba_bec_dimensions = getimagesize($ba_bec_tmpName);
                    if ($ba_bec_dimensions === false) {
                        $ba_bec_errors[] = "Le fichier n'est pas une image valide.";
                    }
                }
            }

            if (empty($ba_bec_errors)) {
                $ba_bec_nom_image = time() . '_' . basename($ba_bec_name);
                $ba_bec_uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/';
                $ba_bec_destination = $ba_bec_uploadDir . $ba_bec_nom_image;
                if (!move_uploaded_file($ba_bec_tmpName, $ba_bec_destination)) {
                    $ba_bec_errors[] = "Erreur lors de l'upload de l'image.";
                }
            }
        }
    }

    if ($ba_bec_numJoueur <= 0 || $ba_bec_prenomJoueur === '' || $ba_bec_nomJoueur === '') {
        $ba_bec_errors[] = 'Le prénom et le nom sont obligatoires.';
    }
    if ($ba_bec_numEquipe <= 0) {
        $ba_bec_errors[] = 'Veuillez sélectionner une équipe valide.';
    }
    if ($ba_bec_numSaison <= 0) {
        $ba_bec_errors[] = 'Veuillez sélectionner une saison valide.';
    }

    if (empty($ba_bec_errors)) {
        $ba_bec_photoFinale = $ba_bec_nom_image !== null ? $ba_bec_nom_image : $ba_bec_photoActuelle;
        $ba_bec_photoValue = $ba_bec_photoFinale !== '' ? $ba_bec_photoFinale : null;
        $ba_bec_dateValue = $ba_bec_dateNaissance !== '' ? $ba_bec_dateNaissance : null;

        $updateJoueur = $DB->prepare(
            'UPDATE JOUEUR
                SET prenomJoueur = :prenom,
                    nomJoueur = :nom,
                    urlPhotoJoueur = :photo,
                    dateNaissance = :dateNaissance
             WHERE numJoueur = :numJoueur'
        );
        $updateJoueur->execute([
            ':prenom' => $ba_bec_prenomJoueur,
            ':nom' => $ba_bec_nomJoueur,
            ':photo' => $ba_bec_photoValue,
            ':dateNaissance' => $ba_bec_dateValue,
            ':numJoueur' => $ba_bec_numJoueur,
        ]);

        $ba_bec_numPoste = null;
        if ($ba_bec_posteJoueur !== '') {
            $posteStmt = $DB->prepare('SELECT numPoste FROM POSTE WHERE libPoste = :libPoste LIMIT 1');
            $posteStmt->execute([':libPoste' => $ba_bec_posteJoueur]);
            $ba_bec_numPoste = $posteStmt->fetchColumn();
            if ($ba_bec_numPoste === false) {
                $insertPoste = $DB->prepare('INSERT INTO POSTE (libPoste) VALUES (:libPoste)');
                $insertPoste->execute([':libPoste' => $ba_bec_posteJoueur]);
                $ba_bec_numPoste = $DB->lastInsertId();
            }
        }

        $ba_bec_numeroValue = $ba_bec_numeroMaillot !== '' ? (int) $ba_bec_numeroMaillot : null;
        $ba_bec_dateDebutValue = $ba_bec_dateDebut !== '' ? $ba_bec_dateDebut : null;

        if ($ba_bec_numAffectation > 0) {
            $updateAffectation = $DB->prepare(
                'UPDATE JOUEUR_AFFECTATION
                    SET numEquipe = :numEquipe,
                        numSaison = :numSaison,
                        numPoste = :numPoste,
                        numMaillot = :numMaillot,
                        dateDebut = :dateDebut
                 WHERE numAffectation = :numAffectation'
            );
            $updateAffectation->execute([
                ':numEquipe' => $ba_bec_numEquipe,
                ':numSaison' => $ba_bec_numSaison,
                ':numPoste' => $ba_bec_numPoste,
                ':numMaillot' => $ba_bec_numeroValue,
                ':dateDebut' => $ba_bec_dateDebutValue,
                ':numAffectation' => $ba_bec_numAffectation,
            ]);
        } else {
            $insertAffectation = $DB->prepare(
                'INSERT INTO JOUEUR_AFFECTATION (numJoueur, numEquipe, numSaison, numPoste, numMaillot, dateDebut)
                 VALUES (:numJoueur, :numEquipe, :numSaison, :numPoste, :numMaillot, :dateDebut)'
            );
            $insertAffectation->execute([
                ':numJoueur' => $ba_bec_numJoueur,
                ':numEquipe' => $ba_bec_numEquipe,
                ':numSaison' => $ba_bec_numSaison,
                ':numPoste' => $ba_bec_numPoste,
                ':numMaillot' => $ba_bec_numeroValue,
                ':dateDebut' => $ba_bec_dateDebutValue,
            ]);
        }

        $deleteClubs = $DB->prepare('DELETE FROM JOUEUR_CLUB WHERE numJoueur = :numJoueur');
        $deleteClubs->execute([':numJoueur' => $ba_bec_numJoueur]);

        if (!empty($ba_bec_clubsList)) {
            $clubSelect = $DB->prepare('SELECT numClub FROM CLUB WHERE nomClub = :nomClub LIMIT 1');
            $clubInsert = $DB->prepare('INSERT INTO CLUB (nomClub) VALUES (:nomClub)');
            $clubLinkInsert = $DB->prepare(
                'INSERT INTO JOUEUR_CLUB (numJoueur, numClub, notes)
                 VALUES (:numJoueur, :numClub, :notes)'
            );

            foreach ($ba_bec_clubsList as $clubName) {
                $clubSelect->execute([':nomClub' => $clubName]);
                $clubId = $clubSelect->fetchColumn();
                if ($clubId === false) {
                    $clubInsert->execute([':nomClub' => $clubName]);
                    $clubId = $DB->lastInsertId();
                }

                $clubLinkInsert->execute([
                    ':numJoueur' => $ba_bec_numJoueur,
                    ':numClub' => $clubId,
                    ':notes' => null,
                ]);
            }
        }

        header('Location: ../../views/backend/joueurs/list.php');
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
            <a href="<?php echo ROOT_URL . '/views/backend/joueurs/list.php'; ?>" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</div>
