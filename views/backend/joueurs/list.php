<?php
/*
 * Vue d'administration (liste) pour le module joueurs.
 * - Le gabarit est rendu côté serveur et s'appuie sur les inclusions globales (config/header) déjà chargées.
 * - Les filtres éventuels sont lus via la query string (GET) pour limiter l'affichage sans modifier l'URL de base.
 * - Les résultats sont présentés dans un tableau structuré, avec des actions de consultation/modification/suppression.
 * - Les liens d'action pointent vers les routes backend correspondantes afin d'enchaîner le workflow.
 * - Les classes utilitaires (Bootstrap) gèrent la mise en page et la hiérarchie visuelle des sections.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

sql_connect();

$ba_bec_is_missing_table = [
    'JOUEUR' => sql_is_missing_table('JOUEUR'),
    'EQUIPE' => sql_is_missing_table('EQUIPE'),
];

$ba_bec_missing_table_labels = [
    'JOUEUR' => 'JOUEUR',
    'EQUIPE' => 'EQUIPE',
];

$ba_bec_players = [];
$ba_bec_sort = isset($_GET['tri']) ? (string) $_GET['tri'] : 'nom';
$ba_bec_allowed_sorts = ['nom', 'equipe'];
if (!in_array($ba_bec_sort, $ba_bec_allowed_sorts, true)) {
    $ba_bec_sort = 'nom';
}
if (!in_array(true, $ba_bec_is_missing_table, true)) {
    $orderBy = $ba_bec_sort === 'equipe'
        ? 'e.nomEquipe IS NULL, e.nomEquipe ASC, j.nomJoueur ASC, j.prenomJoueur ASC'
        : 'j.nomJoueur ASC, j.prenomJoueur ASC';
    $playersQuery = "SELECT
            j.numJoueur,
            j.prenomJoueur,
            j.nomJoueur,
            j.urlPhotoJoueur,
            j.dateNaissance,
            j.numeroMaillot,
            j.posteJoueur,
            e.nomEquipe
        FROM JOUEUR j
        LEFT JOIN EQUIPE e ON j.codeEquipe = e.codeEquipe
        ORDER BY {$orderBy}";
    $ba_bec_players = $DB->query($playersQuery)->fetchAll(PDO::FETCH_ASSOC);
}

function format_poste(?int $poste): string
{
    $labels = [
        1 => 'Meneur',
        2 => 'Arrière',
        3 => 'Ailier',
        4 => 'Ailier fort',
        5 => 'Pivot',
    ];
    if (!$poste) {
        return 'Non renseigné';
    }
    return $labels[$poste] ?? ('Poste ' . $poste);
}

function format_age(?string $birthDate): string
{
    if (!$birthDate) {
        return 'Non renseigné';
    }
    $date = DateTime::createFromFormat('Y-m-d', $birthDate);
    if (!$date) {
        return 'Non renseigné';
    }
    return (string) $date->diff(new DateTime())->y;
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary">
                    Retour au panneau admin
                </a>
                <a href="<?php echo ROOT_URL . '/views/backend/joueurs/create.php'; ?>" class="btn btn-success">
                    Ajouter un joueur
                </a>
            </div>

            <?php foreach ($ba_bec_is_missing_table as $ba_bec_table => $ba_bec_missing): ?>
                <?php if ($ba_bec_missing): ?>
                    <div class="alert alert-warning">
                        <div>La table <?php echo htmlspecialchars($ba_bec_missing_table_labels[$ba_bec_table]); ?> est manquante. Veuillez téléchargé la derniere base de donné fournis.</div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

            <h1>Liste des joueurs</h1>
            <form method="get" class="row g-3 align-items-end mb-3">
                <div class="col-md-4">
                    <label for="tri" class="form-label">Trier par</label>
                    <select name="tri" id="tri" class="form-select">
                        <option value="nom" <?php echo $ba_bec_sort === 'nom' ? 'selected' : ''; ?>>Nom</option>
                        <option value="equipe" <?php echo $ba_bec_sort === 'equipe' ? 'selected' : ''; ?>>Équipe</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Appliquer</button>
                </div>
            </form>
            <?php if (empty($ba_bec_players)) : ?>
                <div class="alert alert-info">Aucun joueur trouvé.</div>
            <?php else : ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Âge</th>
                            <th>Équipe</th>
                            <th>Poste</th>
                            <th>Maillot</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $ba_bec_current_team = null; ?>
                        <?php foreach ($ba_bec_players as $ba_bec_player): ?>
                            <?php if ($ba_bec_sort === 'equipe') : ?>
                                <?php $ba_bec_team_label = $ba_bec_player['nomEquipe'] ?? 'Non affecté'; ?>
                                <?php if ($ba_bec_team_label !== $ba_bec_current_team) : ?>
                                    <tr class="table-secondary">
                                        <td colspan="7">
                                            <strong><?php echo htmlspecialchars($ba_bec_team_label); ?></strong>
                                        </td>
                                    </tr>
                                    <?php $ba_bec_current_team = $ba_bec_team_label; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            <tr>
                                <td><?php echo htmlspecialchars($ba_bec_player['numJoueur']); ?></td>
                                <td><?php echo htmlspecialchars($ba_bec_player['prenomJoueur'] . ' ' . $ba_bec_player['nomJoueur']); ?></td>
                                <td><?php echo htmlspecialchars(format_age($ba_bec_player['dateNaissance'] ?? null)); ?></td>
                                <td><?php echo htmlspecialchars($ba_bec_player['nomEquipe'] ?? 'Non affecté'); ?></td>
                                <td><?php echo htmlspecialchars(format_poste($ba_bec_player['posteJoueur'] ?? null)); ?></td>
                                <td><?php echo htmlspecialchars($ba_bec_player['numeroMaillot'] ?? ''); ?></td>
                                <td>
                                    <a href="edit.php?numJoueur=<?php echo $ba_bec_player['numJoueur']; ?>" class="btn btn-primary">Edit</a>
                                    <a href="delete.php?numJoueur=<?php echo $ba_bec_player['numJoueur']; ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
