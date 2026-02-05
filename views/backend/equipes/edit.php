<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

if (!isset($_GET['numEquipe'])) {
    header('Location: ' . ROOT_URL . '/views/backend/equipes/list.php');
    exit;
}

sql_connect();

$ba_bec_numEquipe = (int) $_GET['numEquipe'];
$ba_bec_equipe = null;
if ($ba_bec_numEquipe) {
    $stmt = $DB->prepare(
        'SELECT e.*, c.nomClub, ce.libCategorie, se.libSection, ne.libNiveau
         FROM EQUIPE e
         INNER JOIN CLUB c ON e.numClub = c.numClub
         INNER JOIN CATEGORIE_EQUIPE ce ON e.numCategorie = ce.numCategorie
         INNER JOIN SECTION_EQUIPE se ON e.numSection = se.numSection
         INNER JOIN NIVEAU_EQUIPE ne ON e.numNiveau = ne.numNiveau
         WHERE e.numEquipe = :numEquipe'
    );
    $stmt->execute([':numEquipe' => $ba_bec_numEquipe]);
    $ba_bec_equipe = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

if (!$ba_bec_equipe) {
    header('Location: ' . ROOT_URL . '/views/backend/equipes/list.php');
    exit;
}

$ba_bec_photoEquipe = $ba_bec_equipe['urlPhotoEquipe'] ?? '';
$ba_bec_photoStaff = $ba_bec_equipe['urlPhotoStaff'] ?? '';

function ba_bec_equipe_photo_url(?string $path): string
{
    if (!$path) {
        return '';
    }

    if (preg_match('/^(https?:\/\/|\/)/', $path)) {
        return $path;
    }

    return ROOT_URL . '/src/uploads/photos-equipes/' . ltrim($path, '/');
}

$ba_bec_photoEquipeUrl = ba_bec_equipe_photo_url($ba_bec_photoEquipe);
$ba_bec_photoStaffUrl = ba_bec_equipe_photo_url($ba_bec_photoStaff);

$ba_bec_clubs = sql_select('CLUB', 'nomClub', null, null, 'nomClub ASC');
$ba_bec_categories = sql_select('CATEGORIE_EQUIPE', 'libCategorie', null, null, 'libCategorie ASC');
$ba_bec_sections = sql_select('SECTION_EQUIPE', 'libSection', null, null, 'libSection ASC');
$ba_bec_niveaux = sql_select('NIVEAU_EQUIPE', 'libNiveau', null, null, 'libNiveau ASC');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/equipes/list.php'; ?>" class="btn btn-secondary">
                    Retour à la liste
                </a>
            </div>
            <h1>Modifier une équipe</h1>
        </div>
        <div class="col-md-12">
            <form action="<?php echo ROOT_URL . '/api/equipes/update.php'; ?>" method="post">
                <input type="hidden" name="numEquipe" value="<?php echo htmlspecialchars($ba_bec_equipe['numEquipe']); ?>" />
                <div class="form-group">
                    <label for="codeEquipe">Code équipe</label>
                    <input id="codeEquipe" name="codeEquipe" class="form-control" type="text"
                        value="<?php echo htmlspecialchars($ba_bec_equipe['codeEquipe']); ?>"
                        placeholder="Code équipe (ex: U18F)" required />
                </div>
                <div class="form-group mt-2">
                    <label for="libEquipe">Nom court</label>
                    <input id="libEquipe" name="libEquipe" class="form-control" type="text"
                        value="<?php echo htmlspecialchars($ba_bec_equipe['libEquipe']); ?>" placeholder="Nom court..."
                        required />
                </div>
                <div class="form-group mt-2">
                    <label for="libEquipeComplet">Nom complet</label>
                    <input id="libEquipeComplet" name="libEquipeComplet" class="form-control" type="text"
                        value="<?php echo htmlspecialchars($ba_bec_equipe['libEquipeComplet'] ?? ''); ?>"
                        placeholder="Nom complet de l'équipe..." />
                </div>
                <div class="form-group mt-2">
                    <label for="nomClub">Club</label>
                    <input id="nomClub" name="nomClub" class="form-control" type="text" list="clubList"
                        value="<?php echo htmlspecialchars($ba_bec_equipe['nomClub'] ?? ''); ?>"
                        placeholder="Club (ex: BEC Basket)" required />
                    <datalist id="clubList">
                        <?php foreach ($ba_bec_clubs as $ba_bec_club): ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_club['nomClub']); ?>"></option>
                        <?php endforeach; ?>
                    </datalist>
                </div>
                <div class="form-group mt-2">
                    <label for="categorieEquipe">Catégorie</label>
                    <input id="categorieEquipe" name="categorieEquipe" class="form-control" type="text" list="categorieList"
                        value="<?php echo htmlspecialchars($ba_bec_equipe['libCategorie'] ?? ''); ?>"
                        placeholder="Catégorie (ex: Seniors)" />
                    <datalist id="categorieList">
                        <?php foreach ($ba_bec_categories as $ba_bec_categorie): ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_categorie['libCategorie']); ?>"></option>
                        <?php endforeach; ?>
                    </datalist>
                </div>
                <div class="form-group mt-2">
                    <label for="sectionEquipe">Section</label>
                    <input id="sectionEquipe" name="sectionEquipe" class="form-control" type="text" list="sectionList"
                        value="<?php echo htmlspecialchars($ba_bec_equipe['libSection'] ?? ''); ?>"
                        placeholder="Section (ex: Féminine)" />
                    <datalist id="sectionList">
                        <?php foreach ($ba_bec_sections as $ba_bec_section): ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_section['libSection']); ?>"></option>
                        <?php endforeach; ?>
                    </datalist>
                </div>
                <div class="form-group mt-2">
                    <label for="niveauEquipe">Niveau</label>
                    <input id="niveauEquipe" name="niveauEquipe" class="form-control" type="text" list="niveauList"
                        value="<?php echo htmlspecialchars($ba_bec_equipe['libNiveau'] ?? ''); ?>"
                        placeholder="Niveau (ex: Régional)" />
                    <datalist id="niveauList">
                        <?php foreach ($ba_bec_niveaux as $ba_bec_niveau): ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_niveau['libNiveau']); ?>"></option>
                        <?php endforeach; ?>
                    </datalist>
                </div>
                <div class="form-group mt-2">
                    <label for="descriptionEquipe">Description</label>
                    <textarea id="descriptionEquipe" name="descriptionEquipe" class="form-control" rows="4"
                        placeholder="Description de l'équipe..."><?php echo htmlspecialchars($ba_bec_equipe['descriptionEquipe'] ?? ''); ?></textarea>
                </div>
                <div class="form-group mt-2">
                    <label for="urlPhotoEquipe">Photo de l'équipe (fichier)</label>
                    <input id="urlPhotoEquipe" name="urlPhotoEquipe" class="form-control" type="text"
                        value="<?php echo htmlspecialchars($ba_bec_photoEquipe); ?>"
                        placeholder="ex: equipe-seniors.jpg (stocké dans /src/uploads/photos-equipes/)" />
                    <?php if ($ba_bec_photoEquipeUrl): ?>
                        <div class="mt-2">
                            <img src="<?php echo htmlspecialchars($ba_bec_photoEquipeUrl); ?>" alt="Photo équipe"
                                style="max-width: 200px; height: auto;">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group mt-2">
                    <label for="urlPhotoStaff">Photo du staff (fichier)</label>
                    <input id="urlPhotoStaff" name="urlPhotoStaff" class="form-control" type="text"
                        value="<?php echo htmlspecialchars($ba_bec_photoStaff); ?>"
                        placeholder="ex: staff-seniors.jpg (stocké dans /src/uploads/photos-equipes/)" />
                    <?php if ($ba_bec_photoStaffUrl): ?>
                        <div class="mt-2">
                            <img src="<?php echo htmlspecialchars($ba_bec_photoStaffUrl); ?>" alt="Photo staff"
                                style="max-width: 200px; height: auto;">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
