<?php // Démarre l'exécution du script en mode PHP.
/*
 * Vue d'administration (édition) pour le module benevoles.
 * - Le formulaire réutilise la structure de création mais avec des valeurs pré-remplies côté serveur.
 * - Les identifiants nécessaires (ID) sont passés via la query string ou des champs cachés.
 * - L'action du formulaire cible la route de mise à jour correspondante.
 * - Les sections HTML isolent les groupes d'attributs pour une édition guidée.
 * - Les actions secondaires permettent de revenir à la liste sans enregistrer.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge le fichier de configuration via la racine serveur.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Importe les utilitaires de redirection.
include '../../../header.php'; // Injecte l'en-tête HTML commun.

if (!isset($_GET['numPersonnel'])) { // Vérifie que l'identifiant du personnel est présent dans l'URL.
    header('Location: ' . ROOT_URL . '/views/backend/benevoles/list.php'); // Redirige vers la liste si l'identifiant manque.
    exit(); // Stoppe l'exécution du script après la redirection.
}

$ba_bec_numPersonnel = $_GET['numPersonnel']; // Stocke l'identifiant du personnel depuis la query string.
$ba_bec_benevole = sql_select('PERSONNEL', '*', "numPersonnel = '$ba_bec_numPersonnel'"); // Charge les informations du bénévole depuis la base.
$ba_bec_benevole = $ba_bec_benevole[0] ?? null; // Extrait le premier résultat ou met null si absent.
$ba_bec_teams = sql_select('EQUIPE', 'codeEquipe, nomEquipe', null, null, 'nomEquipe ASC'); // Récupère la liste des équipes pour la sélection.

if (!$ba_bec_benevole) { // Vérifie que le bénévole existe réellement.
    header('Location: ' . ROOT_URL . '/views/backend/benevoles/list.php'); // Redirige vers la liste si aucun bénévole trouvé.
    exit(); // Stoppe l'exécution après la redirection.
}
?>

<!-- Ouvre le conteneur principal Bootstrap. -->
<div class="container">
    <!-- Ouvre une ligne Bootstrap pour la grille. -->
    <div class="row">
        <!-- Ouvre une colonne pleine largeur pour l'entête. -->
        <div class="col-md-12">
            <!-- Ouvre un bloc avec marge basse pour le lien de retour. -->
            <div class="mb-3">
                <!-- Ouvre un lien qui retourne à la liste. -->
                <a href="<?php echo ROOT_URL . '/views/backend/benevoles/list.php'; ?>" class="btn btn-secondary">
                    <!-- Affiche le texte du lien de retour. -->
                    Retour à la liste
                <!-- Ferme le lien de retour. -->
                </a>
            <!-- Ferme le bloc de marge basse. -->
            </div>
            <!-- Affiche le titre principal de la page d'édition. -->
            <h1>Modifier un bénévole</h1>
        <!-- Ferme la colonne d'entête. -->
        </div>
        <!-- Ouvre une colonne pleine largeur pour le formulaire. -->
        <div class="col-md-12">
            <!-- Ouvre le formulaire qui enverra les données à la route de mise à jour. -->
            <form action="<?php echo ROOT_URL . '/api/benevoles/update.php'; ?>" method="post" enctype="multipart/form-data">
                <!-- Champ caché qui transporte l'identifiant du bénévole. -->
                <input type="hidden" name="numPersonnel" value="<?php echo htmlspecialchars($ba_bec_benevole['numPersonnel']); ?>" />
                <!-- Ouvre un groupe de formulaire pour le prénom. -->
                <div class="form-group">
                    <!-- Libellé du champ prénom. -->
                    <label for="prenomPersonnel">Prénom</label>
                    <!-- Champ texte pré-rempli avec le prénom existant. -->
                    <input id="prenomPersonnel" name="prenomPersonnel" class="form-control" type="text"
                        value="<?php echo htmlspecialchars($ba_bec_benevole['prenomPersonnel']); ?>"
                        placeholder="Prénom (ex: Léa)" required />
                <!-- Ferme le groupe du prénom. -->
                </div>
                <!-- Ouvre un groupe de formulaire avec marge haute pour le nom. -->
                <div class="form-group mt-2">
                    <!-- Libellé du champ nom. -->
                    <label for="nomPersonnel">Nom</label>
                    <!-- Champ texte pré-rempli avec le nom existant. -->
                    <input id="nomPersonnel" name="nomPersonnel" class="form-control" type="text"
                        value="<?php echo htmlspecialchars($ba_bec_benevole['nomPersonnel']); ?>"
                        placeholder="Nom (ex: Martin)" required />
                <!-- Ferme le groupe du nom. -->
                </div>
                <!-- Ouvre un groupe de formulaire avec marge haute pour la photo. -->
                <div class="form-group mt-2">
                    <!-- Libellé du champ photo. -->
                    <label for="photoPersonnel">Photo</label>
                    <!-- Champ fichier pour téléverser une image. -->
                    <input id="photoPersonnel" name="photoPersonnel" class="form-control" type="file" accept="image/*" />
                <!-- Ferme le groupe de la photo. -->
                </div>
                <!-- Ouvre un groupe de formulaire avec marge haute pour les rôles. -->
                <div class="form-group mt-3">
                    <!-- Affiche le libellé de section des rôles. -->
                    <label class="form-label d-block">Rôles</label>
                    <!-- Ouvre un bloc pour la case staff équipe. -->
                    <div class="form-check">
                        <!-- Case à cocher pré-cochée si le bénévole est staff équipe. -->
                        <input class="form-check-input" type="checkbox" id="estStaffEquipe" name="estStaffEquipe" value="1" <?php echo !empty($ba_bec_benevole['estStaffEquipe']) ? 'checked' : ''; ?> />
                        <!-- Libellé de la case staff équipe. -->
                        <label class="form-check-label" for="estStaffEquipe">Staff équipe</label>
                    <!-- Ferme le bloc staff équipe. -->
                    </div>
                    <!-- Ouvre un bloc avec marge haute pour la sélection d'équipe. -->
                    <div class="mt-2">
                        <!-- Libellé de la liste des équipes. -->
                        <label for="numEquipeStaff" class="form-label">Équipe rattachée</label>
                        <!-- Ouvre la liste déroulante des équipes. -->
                        <select id="numEquipeStaff" name="numEquipeStaff" class="form-select">
                            <!-- Option vide invitant à choisir une équipe. -->
                            <option value="">Sélectionner une équipe</option>
                            <!-- Démarre la boucle PHP qui affiche chaque équipe. -->
                            <?php foreach ($ba_bec_teams as $ba_bec_team): ?>
                                <!-- Option avec sélection conditionnelle si l'équipe correspond. -->
                                <option value="<?php echo htmlspecialchars($ba_bec_team['codeEquipe']); ?>" <?php echo ((string) ($ba_bec_benevole['numEquipeStaff'] ?? '') === (string) $ba_bec_team['codeEquipe']) ? 'selected' : ''; ?>>
                                    <!-- Affiche le nom de l'équipe de manière échappée. -->
                                    <?php echo htmlspecialchars($ba_bec_team['nomEquipe']); ?>
                                <!-- Ferme l'option d'équipe. -->
                                </option>
                            <!-- Termine la boucle PHP des équipes. -->
                            <?php endforeach; ?>
                        <!-- Ferme la liste déroulante. -->
                        </select>
                    <!-- Ferme le bloc de sélection d'équipe. -->
                    </div>
                    <!-- Ouvre un bloc avec marge haute pour le rôle staff équipe. -->
                    <div class="mt-2">
                        <!-- Libellé du champ rôle staff équipe. -->
                        <label for="roleStaffEquipe" class="form-label">Rôle staff équipe</label>
                        <!-- Champ texte pré-rempli avec le rôle staff équipe existant. -->
                        <input id="roleStaffEquipe" name="roleStaffEquipe" class="form-control" type="text"
                            value="<?php echo htmlspecialchars($ba_bec_benevole['roleStaffEquipe'] ?? ''); ?>"
                            placeholder="Ex: Coach, assistant coach, analyste vidéo" />
                    <!-- Ferme le bloc du rôle staff équipe. -->
                    </div>
                    <!-- Ouvre un bloc pour la case direction. -->
                    <div class="form-check mt-2">
                        <!-- Case à cocher pré-cochée si le bénévole est en direction. -->
                        <input class="form-check-input" type="checkbox" id="estDirection" name="estDirection" value="1" <?php echo !empty($ba_bec_benevole['estDirection']) ? 'checked' : ''; ?> />
                        <!-- Libellé de la case direction. -->
                        <label class="form-check-label" for="estDirection">Direction</label>
                    <!-- Ferme le bloc de la case direction. -->
                    </div>
                    <!-- Ouvre un bloc avec marge haute pour le poste en direction. -->
                    <div class="mt-2">
                        <!-- Libellé du champ poste en direction. -->
                        <label for="posteDirection" class="form-label">Poste en direction</label>
                        <!-- Champ texte pré-rempli avec le poste en direction existant. -->
                        <input id="posteDirection" name="posteDirection" class="form-control" type="text"
                            value="<?php echo htmlspecialchars($ba_bec_benevole['posteDirection'] ?? ''); ?>"
                            placeholder="Ex: Président, Trésorier" />
                    <!-- Ferme le bloc du poste en direction. -->
                    </div>
                    <!-- Ouvre un bloc pour la case commission technique. -->
                    <div class="form-check mt-2">
                        <!-- Case à cocher pré-cochée si le bénévole est en commission technique. -->
                        <input class="form-check-input" type="checkbox" id="estCommissionTechnique" name="estCommissionTechnique" value="1" <?php echo !empty($ba_bec_benevole['estCommissionTechnique']) ? 'checked' : ''; ?> />
                        <!-- Libellé de la case commission technique. -->
                        <label class="form-check-label" for="estCommissionTechnique">Commission technique</label>
                    <!-- Ferme le bloc de la case commission technique. -->
                    </div>
                    <!-- Ouvre un bloc avec marge haute pour le poste commission technique. -->
                    <div class="mt-2">
                        <!-- Libellé du champ poste commission technique. -->
                        <label for="posteCommissionTechnique" class="form-label">Poste commission technique</label>
                        <!-- Champ texte pré-rempli avec le poste commission technique existant. -->
                        <input id="posteCommissionTechnique" name="posteCommissionTechnique" class="form-control" type="text"
                            value="<?php echo htmlspecialchars($ba_bec_benevole['posteCommissionTechnique'] ?? ''); ?>"
                            placeholder="Ex: Responsable technique" />
                    <!-- Ferme le bloc du poste commission technique. -->
                    </div>
                    <!-- Ouvre un bloc pour la case commission animation. -->
                    <div class="form-check mt-2">
                        <!-- Case à cocher pré-cochée si le bénévole est en commission animation. -->
                        <input class="form-check-input" type="checkbox" id="estCommissionAnimation" name="estCommissionAnimation" value="1" <?php echo !empty($ba_bec_benevole['estCommissionAnimation']) ? 'checked' : ''; ?> />
                        <!-- Libellé de la case commission animation. -->
                        <label class="form-check-label" for="estCommissionAnimation">Commission animation</label>
                    <!-- Ferme le bloc de la case commission animation. -->
                    </div>
                    <!-- Ouvre un bloc avec marge haute pour le poste commission animation. -->
                    <div class="mt-2">
                        <!-- Libellé du champ poste commission animation. -->
                        <label for="posteCommissionAnimation" class="form-label">Poste commission animation</label>
                        <!-- Champ texte pré-rempli avec le poste commission animation existant. -->
                        <input id="posteCommissionAnimation" name="posteCommissionAnimation" class="form-control" type="text"
                            value="<?php echo htmlspecialchars($ba_bec_benevole['posteCommissionAnimation'] ?? ''); ?>"
                            placeholder="Ex: Responsable animations" />
                    <!-- Ferme le bloc du poste commission animation. -->
                    </div>
                    <!-- Ouvre un bloc pour la case commission communication. -->
                    <div class="form-check mt-2">
                        <!-- Case à cocher pré-cochée si le bénévole est en commission communication. -->
                        <input class="form-check-input" type="checkbox" id="estCommissionCommunication" name="estCommissionCommunication" value="1" <?php echo !empty($ba_bec_benevole['estCommissionCommunication']) ? 'checked' : ''; ?> />
                        <!-- Libellé de la case commission communication. -->
                        <label class="form-check-label" for="estCommissionCommunication">Commission communication</label>
                    <!-- Ferme le bloc de la case commission communication. -->
                    </div>
                    <!-- Ouvre un bloc avec marge haute pour le poste commission communication. -->
                    <div class="mt-2">
                        <!-- Libellé du champ poste commission communication. -->
                        <label for="posteCommissionCommunication" class="form-label">Poste commission communication</label>
                        <!-- Champ texte pré-rempli avec le poste commission communication existant. -->
                        <input id="posteCommissionCommunication" name="posteCommissionCommunication" class="form-control" type="text"
                            value="<?php echo htmlspecialchars($ba_bec_benevole['posteCommissionCommunication'] ?? ''); ?>"
                            placeholder="Ex: Responsable communication" />
                    <!-- Ferme le bloc du poste commission communication. -->
                    </div>
                <!-- Ferme le groupe de formulaire des rôles. -->
                </div>
                <!-- Ouvre un groupe de formulaire avec marge haute pour le bouton de soumission. -->
                <div class="form-group mt-3">
                    <!-- Bouton qui envoie le formulaire mis à jour. -->
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                <!-- Ferme le groupe du bouton. -->
                </div>
            <!-- Ferme le formulaire. -->
            </form>
        <!-- Ferme la colonne du formulaire. -->
        </div>
    <!-- Ferme la ligne Bootstrap. -->
    </div>
<!-- Ferme le conteneur principal. -->
</div>
