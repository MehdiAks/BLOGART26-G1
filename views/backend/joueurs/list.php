<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_table'])) {
    $ba_bec_table = strtoupper(trim($_POST['create_table']));
    $ba_bec_allowed_tables = ['JOUEUR', 'EQUIPE', 'EQUIPE_JOUEUR'];
    if (in_array($ba_bec_table, $ba_bec_allowed_tables, true) && sql_create_table($ba_bec_table)) {
        header('Location: list.php?table_created=' . urlencode($ba_bec_table));
        exit;
    }
    $ba_bec_table_error = 'La création de la table a échoué. Vérifiez la connexion à la base de données.';
}

$ba_bec_postes = [
    'poste1' => 'Poste 1',
    'poste2' => 'Poste 2',
    'poste3' => 'Poste 3',
    'poste4' => 'Poste 4',
    'poste5' => 'Poste 5',
];

$ba_bec_equipes = sql_select('EQUIPE', '*', null, null, 'libEquipe ASC');
$ba_bec_sections_rows = sql_select('EQUIPE', 'DISTINCT sectionEquipe', "sectionEquipe IS NOT NULL AND sectionEquipe <> ''", null, 'sectionEquipe ASC');
$ba_bec_sections = array_values(array_filter(array_map(static function ($row) {
    return $row['sectionEquipe'] ?? null;
}, $ba_bec_sections_rows)));

$ba_bec_filters = [
    'poste' => $_GET['poste'] ?? '',
    'photo' => $_GET['photo'] ?? '',
    'section' => $_GET['section'] ?? '',
    'equipe' => $_GET['equipe'] ?? '',
    'age_min' => $_GET['age_min'] ?? '',
    'age_max' => $_GET['age_max'] ?? '',
    'tri' => $_GET['tri'] ?? '',
];

$ba_bec_where = [];

if (!empty($ba_bec_filters['poste']) && array_key_exists($ba_bec_filters['poste'], $ba_bec_postes)) {
    $ba_bec_poste_label = $ba_bec_postes[$ba_bec_filters['poste']];
    $ba_bec_where[] = "j.posteJoueur LIKE '%" . str_replace("'", "''", $ba_bec_poste_label) . "%'";
}

if ($ba_bec_filters['photo'] === 'with') {
    $ba_bec_where[] = "j.urlPhotoJoueur IS NOT NULL AND j.urlPhotoJoueur <> ''";
}
if ($ba_bec_filters['photo'] === 'without') {
    $ba_bec_where[] = "(j.urlPhotoJoueur IS NULL OR j.urlPhotoJoueur = '')";
}

if (!empty($ba_bec_filters['section']) && in_array($ba_bec_filters['section'], $ba_bec_sections, true)) {
    $ba_bec_section = str_replace("'", "''", $ba_bec_filters['section']);
    $ba_bec_where[] = "e.sectionEquipe = '{$ba_bec_section}'";
}

$ba_bec_equipe_ids = array_map(static function ($equipe) {
    return (int) ($equipe['numEquipe'] ?? 0);
}, $ba_bec_equipes);
if (!empty($ba_bec_filters['equipe']) && in_array((int) $ba_bec_filters['equipe'], $ba_bec_equipe_ids, true)) {
    $ba_bec_where[] = 'e.numEquipe = ' . (int) $ba_bec_filters['equipe'];
}

$ba_bec_age_min = filter_var($ba_bec_filters['age_min'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
if ($ba_bec_age_min !== false && $ba_bec_age_min !== null) {
    $ba_bec_where[] = 'TIMESTAMPDIFF(YEAR, j.dateNaissance, CURDATE()) >= ' . (int) $ba_bec_age_min;
}

$ba_bec_age_max = filter_var($ba_bec_filters['age_max'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
if ($ba_bec_age_max !== false && $ba_bec_age_max !== null) {
    $ba_bec_where[] = 'TIMESTAMPDIFF(YEAR, j.dateNaissance, CURDATE()) <= ' . (int) $ba_bec_age_max;
}

$ba_bec_sort_options = [
    'alpha_asc' => 'j.nomJoueur ASC, j.prenomJoueur ASC',
    'alpha_desc' => 'j.nomJoueur DESC, j.prenomJoueur DESC',
    'arrivee_asc' => 'j.anneeArrivee ASC, j.nomJoueur ASC',
    'arrivee_desc' => 'j.anneeArrivee DESC, j.nomJoueur ASC',
];
$ba_bec_order = $ba_bec_sort_options[$ba_bec_filters['tri']] ?? 'j.nomJoueur ASC, j.prenomJoueur ASC';

$ba_bec_where_clause = !empty($ba_bec_where) ? implode(' AND ', $ba_bec_where) : null;
$ba_bec_joueurs = sql_select(
    'JOUEUR j LEFT JOIN EQUIPE_JOUEUR ej ON j.numJoueur = ej.numJoueur LEFT JOIN EQUIPE e ON ej.numEquipe = e.numEquipe',
    'j.numJoueur, j.prenomJoueur, j.nomJoueur, j.numMaillot, j.posteJoueur, j.urlPhotoJoueur, j.anneeArrivee, j.dateNaissance, TIMESTAMPDIFF(YEAR, j.dateNaissance, CURDATE()) AS ageJoueur, GROUP_CONCAT(DISTINCT e.libEquipe ORDER BY e.libEquipe SEPARATOR ", ") AS equipes, GROUP_CONCAT(DISTINCT e.sectionEquipe ORDER BY e.sectionEquipe SEPARATOR ", ") AS sections',
    $ba_bec_where_clause,
    'j.numJoueur',
    $ba_bec_order
);
$ba_bec_missing_tables = [
    'JOUEUR' => sql_is_missing_table('JOUEUR'),
    'EQUIPE' => sql_is_missing_table('EQUIPE'),
    'EQUIPE_JOUEUR' => sql_is_missing_table('EQUIPE_JOUEUR'),
];
$ba_bec_missing_labels = [
    'JOUEUR' => 'JOUEUR',
    'EQUIPE' => 'EQUIPE',
    'EQUIPE_JOUEUR' => 'EQUIPE_JOUEUR',
];
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary">
                    Retour au panneau admin
                </a>
            </div>
            <h1>Joueurs</h1>
            <?php if (!empty($_GET['table_created'])): ?>
                <div class="alert alert-success">La table <?php echo htmlspecialchars($_GET['table_created']); ?> a été créée.</div>
            <?php endif; ?>
            <?php if (!empty($ba_bec_table_error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($ba_bec_table_error); ?></div>
            <?php endif; ?>
            <?php foreach ($ba_bec_missing_tables as $ba_bec_table => $ba_bec_is_missing): ?>
                <?php if ($ba_bec_is_missing): ?>
                    <div class="alert alert-warning d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <div>La table <?php echo htmlspecialchars($ba_bec_missing_labels[$ba_bec_table]); ?> est manquante. Vous pouvez la créer pour continuer.</div>
                        <form method="post" class="mb-0">
                            <button type="submit" name="create_table" value="<?php echo htmlspecialchars($ba_bec_table); ?>" class="btn btn-warning">Créer la table</button>
                        </form>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <form method="get" class="mb-4 border rounded p-3 bg-light">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="poste" class="form-label">Poste</label>
                        <select name="poste" id="poste" class="form-select">
                            <option value="">Tous les postes</option>
                            <?php foreach ($ba_bec_postes as $ba_bec_key => $ba_bec_label): ?>
                                <option value="<?php echo htmlspecialchars($ba_bec_key); ?>" <?php echo ($ba_bec_filters['poste'] === $ba_bec_key) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($ba_bec_label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="photo" class="form-label">Photo</label>
                        <select name="photo" id="photo" class="form-select">
                            <option value="">Toutes</option>
                            <option value="with" <?php echo ($ba_bec_filters['photo'] === 'with') ? 'selected' : ''; ?>>Avec photo</option>
                            <option value="without" <?php echo ($ba_bec_filters['photo'] === 'without') ? 'selected' : ''; ?>>Sans photo</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="section" class="form-label">Section</label>
                        <select name="section" id="section" class="form-select">
                            <option value="">Toutes les sections</option>
                            <?php foreach ($ba_bec_sections as $ba_bec_section): ?>
                                <option value="<?php echo htmlspecialchars($ba_bec_section); ?>" <?php echo ($ba_bec_filters['section'] === $ba_bec_section) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($ba_bec_section); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="equipe" class="form-label">Équipe</label>
                        <select name="equipe" id="equipe" class="form-select">
                            <option value="">Toutes les équipes</option>
                            <?php foreach ($ba_bec_equipes as $ba_bec_equipe): ?>
                                <option value="<?php echo htmlspecialchars($ba_bec_equipe['numEquipe']); ?>" <?php echo ((string) $ba_bec_filters['equipe'] === (string) $ba_bec_equipe['numEquipe']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($ba_bec_equipe['libEquipe']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="age_min" class="form-label">Âge min</label>
                        <input type="number" min="0" name="age_min" id="age_min" class="form-control" value="<?php echo htmlspecialchars($ba_bec_filters['age_min']); ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="age_max" class="form-label">Âge max</label>
                        <input type="number" min="0" name="age_max" id="age_max" class="form-control" value="<?php echo htmlspecialchars($ba_bec_filters['age_max']); ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="tri" class="form-label">Tri</label>
                        <select name="tri" id="tri" class="form-select">
                            <option value="alpha_asc" <?php echo ($ba_bec_filters['tri'] === 'alpha_asc') ? 'selected' : ''; ?>>Alphabétique (A → Z)</option>
                            <option value="alpha_desc" <?php echo ($ba_bec_filters['tri'] === 'alpha_desc') ? 'selected' : ''; ?>>Alphabétique (Z → A)</option>
                            <option value="arrivee_asc" <?php echo ($ba_bec_filters['tri'] === 'arrivee_asc') ? 'selected' : ''; ?>>Arrivée au club (ancien)</option>
                            <option value="arrivee_desc" <?php echo ($ba_bec_filters['tri'] === 'arrivee_desc') ? 'selected' : ''; ?>>Arrivée au club (récent)</option>
                        </select>
                    </div>
                    <div class="col-md-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Filtrer</button>
                        <a href="list.php" class="btn btn-outline-secondary">Réinitialiser</a>
                    </div>
                </div>
            </form>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Numéro</th>
                        <th>Poste</th>
                        <th>Âge</th>
                        <th>Arrivée</th>
                        <th>Équipe(s)</th>
                        <th>Section</th>
                        <th>Photo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ba_bec_joueurs)): ?>
                        <?php foreach ($ba_bec_joueurs as $ba_bec_joueur): ?>
                            <tr>
                                <td><?php echo $ba_bec_joueur['numJoueur']; ?></td>
                                <td><?php echo $ba_bec_joueur['prenomJoueur']; ?></td>
                                <td><?php echo $ba_bec_joueur['nomJoueur']; ?></td>
                                <td><?php echo $ba_bec_joueur['numMaillot'] ?? '-'; ?></td>
                                <td><?php echo $ba_bec_joueur['posteJoueur'] ?: '-'; ?></td>
                                <td><?php echo $ba_bec_joueur['ageJoueur'] ?? '-'; ?></td>
                                <td><?php echo $ba_bec_joueur['anneeArrivee'] ?? '-'; ?></td>
                                <td><?php echo $ba_bec_joueur['equipes'] ?: '-'; ?></td>
                                <td><?php echo $ba_bec_joueur['sections'] ?: '-'; ?></td>
                                <td>
                                    <?php if (!empty($ba_bec_joueur['urlPhotoJoueur'])): ?>
                                        <?php
                                        $ba_bec_photo = $ba_bec_joueur['urlPhotoJoueur'];
                                        $ba_bec_photoUrl = preg_match('/^(https?:\\/\\/|\\/)/', $ba_bec_photo)
                                            ? $ba_bec_photo
                                            : ROOT_URL . '/src/uploads/' . $ba_bec_photo;
                                        ?>
                                        <a href="<?php echo htmlspecialchars($ba_bec_photoUrl); ?>" target="_blank" rel="noopener">Voir</a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit.php?numJoueur=<?= htmlspecialchars($ba_bec_joueur['numJoueur']); ?>" class="btn btn-primary">Edit</a>
                                    <a href="delete.php?numJoueur=<?= htmlspecialchars($ba_bec_joueur['numJoueur']); ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11">Aucun joueur trouvé</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <a href="create.php" class="btn btn-success">Créer</a>
        </div>
    </div>
</div>
