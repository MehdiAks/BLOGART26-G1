<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

if (!isset($_GET['numJoueur'])) {
    header('Location: ' . ROOT_URL . '/views/backend/joueurs/list.php');
    exit();
}

$ba_bec_numJoueur = $_GET['numJoueur'];
$ba_bec_joueur = sql_select('JOUEUR', '*', "numJoueur = '$ba_bec_numJoueur'");
$ba_bec_joueur = $ba_bec_joueur[0] ?? null;
$ba_bec_equipes = sql_select('EQUIPE', 'numEquipe, libEquipe, sectionEquipe', null, null, 'libEquipe ASC');
$ba_bec_equipeJoueur = sql_select('EQUIPE_JOUEUR', 'numEquipe', "numJoueur = '$ba_bec_numJoueur'");
$ba_bec_numEquipe = $ba_bec_equipeJoueur[0]['numEquipe'] ?? '';
$ba_bec_sectionEquipe = '';
foreach ($ba_bec_equipes as $ba_bec_equipe) {
    if ($ba_bec_equipe['numEquipe'] == $ba_bec_numEquipe) {
        $ba_bec_sectionEquipe = $ba_bec_equipe['sectionEquipe'] ?? '';
        break;
    }
}

if (!$ba_bec_joueur) {
    header('Location: ' . ROOT_URL . '/views/backend/joueurs/list.php');
    exit();
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/joueurs/list.php'; ?>" class="btn btn-secondary">
                    Retour à la liste
                </a>
            </div>
            <h1>Modifier un joueur</h1>
        </div>
        <div class="col-md-12">
            <form action="<?php echo ROOT_URL . '/api/joueurs/update.php'; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="numJoueur" value="<?php echo htmlspecialchars($ba_bec_joueur['numJoueur']); ?>" />
                <input type="hidden" name="photoActuelle" value="<?php echo htmlspecialchars($ba_bec_joueur['urlPhotoJoueur'] ?? ''); ?>" />
                <div class="form-group">
                    <label for="prenomJoueur">Prénom</label>
                    <input id="prenomJoueur" name="prenomJoueur" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_joueur['prenomJoueur']); ?>" required />
                </div>
                <div class="form-group mt-2">
                    <label for="nomJoueur">Nom</label>
                    <input id="nomJoueur" name="nomJoueur" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_joueur['nomJoueur']); ?>" required />
                </div>
                <div class="form-group mt-2">
                    <label for="posteJoueur">Poste</label>
                    <input id="posteJoueur" name="posteJoueur" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_joueur['posteJoueur'] ?? ''); ?>" />
                </div>
                <div class="form-group mt-2">
                    <label for="photoJoueur">Photo (upload)</label>
                    <input id="photoJoueur" name="photoJoueur" class="form-control" type="file" accept="image/*" />
                    <?php if (!empty($ba_bec_joueur['urlPhotoJoueur'])): ?>
                        <?php
                        $ba_bec_photo = $ba_bec_joueur['urlPhotoJoueur'];
                        $ba_bec_photoUrl = preg_match('/^(https?:\\/\\/|\\/)/', $ba_bec_photo)
                            ? $ba_bec_photo
                            : ROOT_URL . '/src/uploads/' . $ba_bec_photo;
                        ?>
                        <small class="form-text text-muted">Photo actuelle : <a href="<?php echo htmlspecialchars($ba_bec_photoUrl); ?>" target="_blank" rel="noopener">Voir</a></small>
                    <?php endif; ?>
                </div>
                <div class="form-group mt-2">
                    <label for="numeroMaillot">Numéro de maillot</label>
                    <input id="numeroMaillot" name="numeroMaillot" class="form-control" type="number" min="0" max="99" value="<?php echo htmlspecialchars($ba_bec_joueur['numMaillot'] ?? ''); ?>" />
                </div>
                <div class="form-group mt-2">
                    <label for="sectionEquipe">Section</label>
                    <select id="sectionEquipe" name="sectionEquipe" class="form-control" required>
                        <option value="">Sélectionnez une section</option>
                        <option value="Homme" <?php echo $ba_bec_sectionEquipe === 'Homme' ? 'selected' : ''; ?>>Homme</option>
                        <option value="Femme" <?php echo $ba_bec_sectionEquipe === 'Femme' ? 'selected' : ''; ?>>Femme</option>
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="numEquipe">Équipe</label>
                    <select id="numEquipe" name="numEquipe" class="form-control" required>
                        <option value="">Sélectionnez une équipe</option>
                        <?php foreach ($ba_bec_equipes as $ba_bec_equipe): ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_equipe['numEquipe']); ?>"
                                data-section="<?php echo htmlspecialchars($ba_bec_equipe['sectionEquipe'] ?? ''); ?>"
                                <?php echo $ba_bec_numEquipe == $ba_bec_equipe['numEquipe'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($ba_bec_equipe['libEquipe']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="anneeArrivee">Année d'arrivée</label>
                    <input id="anneeArrivee" name="anneeArrivee" class="form-control" type="number" min="1900" max="2100" value="<?php echo htmlspecialchars($ba_bec_joueur['anneeArrivee'] ?? ''); ?>" />
                </div>
                <div class="form-group mt-2">
                    <label for="dateNaissance">Date de naissance</label>
                    <input id="dateNaissance" name="dateNaissance" class="form-control" type="date" value="<?php echo htmlspecialchars($ba_bec_joueur['dateNaissance'] ?? ''); ?>" />
                </div>
                <div class="form-group mt-2">
                    <label for="clubsPrecedents">Clubs précédents</label>
                    <?php
                    $ba_bec_clubsRaw = $ba_bec_joueur['clubsPrecedents'] ?? '';
                    $ba_bec_clubsList = preg_split('/\\r\\n|\\r|\\n|\\s*\\|\\s*/', $ba_bec_clubsRaw);
                    $ba_bec_clubsList = array_values(array_filter(array_map('trim', $ba_bec_clubsList), 'strlen'));
                    if (empty($ba_bec_clubsList)) {
                        $ba_bec_clubsList = [''];
                    }
                    ?>
                    <div id="clubsPrecedentsList" class="d-grid gap-2">
                        <?php foreach ($ba_bec_clubsList as $ba_bec_club): ?>
                            <input name="clubsPrecedents[]" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_club); ?>" />
                        <?php endforeach; ?>
                    </div>
                    <button type="button" id="addClubButton" class="btn btn-outline-secondary btn-sm mt-2">
                        Ajouter un club
                    </button>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function () {
        const sectionSelect = document.getElementById('sectionEquipe');
        const teamSelect = document.getElementById('numEquipe');
        const clubList = document.getElementById('clubsPrecedentsList');
        const addClubButton = document.getElementById('addClubButton');

        const filterTeams = () => {
            const section = sectionSelect.value;
            const options = Array.from(teamSelect.options);
            options.forEach((option) => {
                if (!option.value) {
                    option.hidden = false;
                    return;
                }
                const optionSection = option.dataset.section || '';
                option.hidden = section && optionSection !== section;
            });

            if (teamSelect.selectedOptions.length && teamSelect.selectedOptions[0].hidden) {
                teamSelect.value = '';
            }
        };

        const addClubField = () => {
            const wrapper = document.createElement('div');
            wrapper.className = 'd-flex gap-2';

            const input = document.createElement('input');
            input.name = 'clubsPrecedents[]';
            input.className = 'form-control';
            input.type = 'text';
            input.placeholder = 'Nom du club';

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-outline-danger';
            removeButton.textContent = 'Retirer';
            removeButton.addEventListener('click', () => wrapper.remove());

            wrapper.appendChild(input);
            wrapper.appendChild(removeButton);
            clubList.appendChild(wrapper);
        };

        sectionSelect.addEventListener('change', filterTeams);
        addClubButton.addEventListener('click', addClubField);
        filterTeams();
    })();
</script>
