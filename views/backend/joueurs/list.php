<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

sql_connect();

$ba_bec_allowed_tables = ['JOUEUR', 'EQUIPE', 'JOUEUR_AFFECTATION', 'JOUEUR_AFFECTATION_POSTE'];
if (isset($_POST['create_table'])) {
    $ba_bec_table = strtoupper(trim((string) ($_POST['create_table'] ?? '')));
    if (in_array($ba_bec_table, $ba_bec_allowed_tables, true) && sql_create_table($ba_bec_table)) {
        header('Location: list.php?table_created=' . urlencode($ba_bec_table));
        exit;
    }
}

$ba_bec_is_missing_table = [
    'JOUEUR' => sql_is_missing_table('JOUEUR'),
    'EQUIPE' => sql_is_missing_table('EQUIPE'),
    'JOUEUR_AFFECTATION' => sql_is_missing_table('JOUEUR_AFFECTATION'),
    'JOUEUR_AFFECTATION_POSTE' => sql_is_missing_table('JOUEUR_AFFECTATION_POSTE'),
];

$ba_bec_missing_table_labels = [
    'JOUEUR' => 'JOUEUR',
    'EQUIPE' => 'EQUIPE',
    'JOUEUR_AFFECTATION' => 'JOUEUR_AFFECTATION',
    'JOUEUR_AFFECTATION_POSTE' => 'JOUEUR_AFFECTATION_POSTE',
];

$ba_bec_players = [];
if (!in_array(true, $ba_bec_is_missing_table, true)) {
    $playersQuery = "SELECT
            j.numJoueur,
            j.prenomJoueur,
            j.nomJoueur,
            j.urlPhotoJoueur,
            j.dateNaissance,
            a.numMaillot,
            GROUP_CONCAT(DISTINCT p.libPoste ORDER BY p.libPoste SEPARATOR ', ') AS libPostes,
            s.libSaison,
            e.libEquipe
        FROM JOUEUR j
        LEFT JOIN (
            SELECT numJoueur, MAX(numAffectation) AS latestAffectation
            FROM JOUEUR_AFFECTATION
            GROUP BY numJoueur
        ) latest ON j.numJoueur = latest.numJoueur
        LEFT JOIN JOUEUR_AFFECTATION a ON a.numAffectation = latest.latestAffectation
        LEFT JOIN JOUEUR_AFFECTATION_POSTE ap ON ap.numAffectation = a.numAffectation
        LEFT JOIN POSTE p ON ap.numPoste = p.numPoste
        LEFT JOIN SAISON s ON a.numSaison = s.numSaison
        LEFT JOIN EQUIPE e ON a.numEquipe = e.numEquipe
        GROUP BY
            j.numJoueur,
            j.prenomJoueur,
            j.nomJoueur,
            j.urlPhotoJoueur,
            j.dateNaissance,
            a.numMaillot,
            s.libSaison,
            e.libEquipe
        ORDER BY j.nomJoueur ASC";
    $ba_bec_players = $DB->query($playersQuery)->fetchAll(PDO::FETCH_ASSOC);
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
                    <div class="alert alert-warning d-flex justify-content-between align-items-center">
                        <div>La table <?php echo htmlspecialchars($ba_bec_missing_table_labels[$ba_bec_table]); ?> est manquante. Vous pouvez la créer pour continuer.</div>
                        <form method="post">
                            <button type="submit" name="create_table" value="<?php echo htmlspecialchars($ba_bec_table); ?>" class="btn btn-warning">Créer la table</button>
                        </form>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

            <h1>Liste des joueurs</h1>
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
                            <th>Saison</th>
                            <th>Poste</th>
                            <th>Maillot</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ba_bec_players as $ba_bec_player): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($ba_bec_player['numJoueur']); ?></td>
                                <td><?php echo htmlspecialchars($ba_bec_player['prenomJoueur'] . ' ' . $ba_bec_player['nomJoueur']); ?></td>
                                <td><?php echo htmlspecialchars(format_age($ba_bec_player['dateNaissance'] ?? null)); ?></td>
                                <td><?php echo htmlspecialchars($ba_bec_player['libEquipe'] ?? 'Non affecté'); ?></td>
                                <td><?php echo htmlspecialchars($ba_bec_player['libSaison'] ?? 'Non renseignée'); ?></td>
                                <td><?php echo htmlspecialchars($ba_bec_player['libPostes'] ?? 'Non renseigné'); ?></td>
                                <td><?php echo htmlspecialchars($ba_bec_player['numMaillot'] ?? ''); ?></td>
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
