<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

$ba_bec_article = null;
$ba_bec_numArtBoutique = (int) ($_GET['numArtBoutique'] ?? 0);
if ($ba_bec_numArtBoutique > 0) {
    $ba_bec_rows = sql_select('boutique', '*', "numArtBoutique = '$ba_bec_numArtBoutique'");
    $ba_bec_article = $ba_bec_rows[0] ?? null;
}

$ba_bec_parse_json_list = static function ($value): string {
    if ($value === null || $value === '') {
        return '';
    }
    if (is_array($value)) {
        return implode(', ', $value);
    }
    if (!is_string($value)) {
        return '';
    }
    $decoded = json_decode($value, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        return implode(', ', $decoded);
    }
    return $value;
};

$ba_bec_parse_first_image = static function ($value): string {
    if ($value === null || $value === '') {
        return '';
    }
    if (is_array($value)) {
        return (string) ($value[0] ?? '');
    }
    if (is_string($value)) {
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return (string) ($decoded[0] ?? '');
        }
        return $value;
    }
    return '';
};
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Modifier un article boutique</h1>

            <?php if (!$ba_bec_article): ?>
                <div class="alert alert-danger">Article introuvable.</div>
                <a href="<?php echo ROOT_URL . '/views/backend/boutique/list.php'; ?>" class="btn btn-secondary">Retour</a>
            <?php else: ?>
                <form action="<?php echo ROOT_URL . '/api/boutique/update.php'; ?>" method="post">
                    <input type="hidden" name="numArtBoutique" value="<?php echo (int) $ba_bec_article['numArtBoutique']; ?>">

                    <div class="form-group mt-2">
                        <label for="libArtBoutique">Nom *</label>
                        <input id="libArtBoutique" name="libArtBoutique" class="form-control" type="text" required maxlength="255" value="<?php echo htmlspecialchars($ba_bec_article['libArtBoutique'] ?? ''); ?>">
                    </div>
                    <div class="form-group mt-2">
                        <label for="categorieArtBoutique">Catégorie *</label>
                        <input id="categorieArtBoutique" name="categorieArtBoutique" class="form-control" type="text" required maxlength="100" value="<?php echo htmlspecialchars($ba_bec_article['categorieArtBoutique'] ?? ''); ?>">
                    </div>
                    <div class="form-group mt-2">
                        <label for="descArtBoutique">Description</label>
                        <textarea id="descArtBoutique" name="descArtBoutique" class="form-control" rows="4"><?php echo htmlspecialchars($ba_bec_article['descArtBoutique'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-group mt-2">
                        <label for="couleursArtBoutique">Couleurs (séparées par des virgules)</label>
                        <input id="couleursArtBoutique" name="couleursArtBoutique" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_parse_json_list($ba_bec_article['couleursArtBoutique'] ?? '')); ?>">
                    </div>
                    <div class="form-group mt-2">
                        <label for="taillesArtBoutique">Tailles (séparées par des virgules)</label>
                        <input id="taillesArtBoutique" name="taillesArtBoutique" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_parse_json_list($ba_bec_article['taillesArtBoutique'] ?? '')); ?>">
                    </div>
                    <div class="form-group mt-2">
                        <label for="prixAdulteArtBoutique">Prix adulte (€) *</label>
                        <input id="prixAdulteArtBoutique" name="prixAdulteArtBoutique" class="form-control" type="number" step="0.01" min="0" required value="<?php echo htmlspecialchars((string) ($ba_bec_article['prixAdulteArtBoutique'] ?? '')); ?>">
                    </div>
                    <div class="form-group mt-2">
                        <label for="prixEnfantArtBoutique">Prix enfant (€)</label>
                        <input id="prixEnfantArtBoutique" name="prixEnfantArtBoutique" class="form-control" type="number" step="0.01" min="0" value="<?php echo htmlspecialchars((string) ($ba_bec_article['prixEnfantArtBoutique'] ?? '')); ?>">
                    </div>
                    <div class="form-group mt-2">
                        <label for="urlPhotoArtBoutique">Nom du fichier image</label>
                        <input id="urlPhotoArtBoutique" name="urlPhotoArtBoutique" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_parse_first_image($ba_bec_article['urlPhotoArtBoutique'] ?? '')); ?>">
                    </div>

                    <div class="form-group mt-3 d-flex gap-2">
                        <a href="<?php echo ROOT_URL . '/views/backend/boutique/list.php'; ?>" class="btn btn-secondary">Retour</a>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
