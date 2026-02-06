<?php // Démarre l'exécution du script en mode PHP.
/*
 * Vue d'administration (création) pour le module benevoles.
 * - Cette page expose un formulaire HTML complet permettant de saisir les données métier.
 * - L'action du formulaire pointe vers la route de création côté backend (controller/action).
 * - Les champs sont regroupés par sections pour guider l'utilisateur et faciliter la validation.
 * - Les boutons principaux déclenchent l'envoi et les liens secondaires ramènent au tableau de bord ou à la liste.
 * - Les classes Bootstrap structurent la mise en forme sans logique métier dans la vue.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge le fichier de configuration via le chemin racine du serveur.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Importe les fonctions de redirection nécessaires à la page.
include '../../../header.php'; // Insère l'en-tête HTML commun à toutes les pages.

$ba_bec_teams = sql_select('EQUIPE', 'codeEquipe, nomEquipe', null, null, 'nomEquipe ASC'); // Récupère la liste des équipes triée par nom pour alimenter la liste déroulante.
?>

<!-- Ouvre le conteneur principal Bootstrap pour la mise en page. -->
<div class="container">
    <!-- Ouvre une ligne Bootstrap pour organiser la grille. -->
    <div class="row">
        <!-- Ouvre une colonne pleine largeur pour le bloc d'entête. -->
        <div class="col-md-12">
            <!-- Ouvre un bloc avec marge basse pour le bouton de retour. -->
            <div class="mb-3">
                <!-- Ouvre un lien vers la liste des bénévoles. -->
                <a href="<?php echo ROOT_URL . '/views/backend/benevoles/list.php'; ?>" class="btn btn-secondary">
                    <!-- Affiche le texte du lien de retour. -->
                    Retour à la liste
                <!-- Ferme le lien de retour. -->
                </a>
            <!-- Ferme le bloc de marge basse. -->
            </div>
            <!-- Affiche le titre principal de la page. -->
            <h1>Ajouter un bénévole</h1>
        <!-- Ferme la colonne d'entête. -->
        </div>
        <!-- Ouvre une colonne pleine largeur pour le formulaire. -->
        <div class="col-md-12">
            <!-- Ouvre le formulaire qui enverra les données au backend. -->
            <form action="<?php echo ROOT_URL . '/api/benevoles/create.php'; ?>" method="post" enctype="multipart/form-data">
                <!-- Ouvre un groupe de formulaire pour le prénom. -->
                <div class="form-group">
                    <!-- Associe le libellé au champ prénom. -->
                    <label for="prenomPersonnel">Prénom</label>
                    <!-- Champ texte pour saisir le prénom. -->
                    <input id="prenomPersonnel" name="prenomPersonnel" class="form-control" type="text"
                        placeholder="Prénom (ex: Léa)" required />
                <!-- Ferme le groupe de formulaire du prénom. -->
                </div>
                <!-- Ouvre un groupe de formulaire avec marge haute pour le nom. -->
                <div class="form-group mt-2">
                    <!-- Associe le libellé au champ nom. -->
                    <label for="nomPersonnel">Nom</label>
                    <!-- Champ texte pour saisir le nom. -->
                    <input id="nomPersonnel" name="nomPersonnel" class="form-control" type="text"
                        placeholder="Nom (ex: Martin)" required />
                <!-- Ferme le groupe de formulaire du nom. -->
                </div>
                <!-- Ouvre un groupe de formulaire avec marge haute pour la photo. -->
                <div class="form-group mt-2">
                    <!-- Associe le libellé au champ de fichier photo. -->
                    <label for="photoPersonnel">Photo</label>
                    <!-- Champ fichier pour téléverser une image. -->
                    <input id="photoPersonnel" name="photoPersonnel" class="form-control" type="file" accept="image/*" />
                <!-- Ferme le groupe de formulaire de la photo. -->
                </div>
                <!-- Ouvre un groupe de formulaire avec marge haute pour les rôles. -->
                <div class="form-group mt-3">
                    <!-- Affiche un libellé de section pour les rôles. -->
                    <label class="form-label d-block">Rôles</label>
                    <!-- Ouvre un bloc pour la case à cocher staff équipe. -->
                    <div class="form-check">
                        <!-- Case à cocher indiquant l'appartenance au staff équipe. -->
                        <input class="form-check-input" type="checkbox" id="estStaffEquipe" name="estStaffEquipe" value="1" />
                        <!-- Libellé associé à la case staff équipe. -->
                        <label class="form-check-label" for="estStaffEquipe">Staff équipe</label>
                    <!-- Ferme le bloc de case à cocher staff équipe. -->
                    </div>
                    <!-- Ouvre un bloc avec marge haute pour sélectionner l'équipe. -->
                    <div class="mt-2">
                        <!-- Libellé pour la liste des équipes rattachées. -->
                        <label for="numEquipeStaff" class="form-label">Équipe rattachée</label>
                        <!-- Ouvre la liste déroulante des équipes. -->
                        <select id="numEquipeStaff" name="numEquipeStaff" class="form-select">
                            <!-- Option vide invitant à choisir une équipe. -->
                            <option value="">Sélectionner une équipe</option>
                            <!-- Démarre la boucle PHP pour afficher chaque équipe. -->
                            <?php foreach ($ba_bec_teams as $ba_bec_team): ?>
                                <!-- Définit une option avec le code d'équipe comme valeur. -->
                                <option value="<?php echo htmlspecialchars($ba_bec_team['codeEquipe']); ?>">
                                    <!-- Affiche le nom de l'équipe de manière échappée. -->
                                    <?php echo htmlspecialchars($ba_bec_team['nomEquipe']); ?>
                                <!-- Ferme l'option d'équipe. -->
                                </option>
                            <!-- Termine la boucle PHP des équipes. -->
                            <?php endforeach; ?>
                        <!-- Ferme la liste déroulante des équipes. -->
                        </select>
                    <!-- Ferme le bloc de sélection d'équipe. -->
                    </div>
                    <!-- Ouvre un bloc avec marge haute pour le rôle staff équipe. -->
                    <div class="mt-2">
                        <!-- Libellé pour le champ du rôle staff équipe. -->
                        <label for="roleStaffEquipe" class="form-label">Rôle staff équipe</label>
                        <!-- Champ texte pour saisir le rôle staff équipe. -->
                        <input id="roleStaffEquipe" name="roleStaffEquipe" class="form-control" type="text"
                            placeholder="Ex: Coach, assistant coach, analyste vidéo" />
                    <!-- Ferme le bloc du rôle staff équipe. -->
                    </div>
                    <!-- Ouvre un bloc pour la case à cocher direction. -->
                    <div class="form-check mt-2">
                        <!-- Case à cocher indiquant l'appartenance à la direction. -->
                        <input class="form-check-input" type="checkbox" id="estDirection" name="estDirection" value="1" />
                        <!-- Libellé associé à la case direction. -->
                        <label class="form-check-label" for="estDirection">Direction</label>
                    <!-- Ferme le bloc de la case direction. -->
                    </div>
                    <!-- Ouvre un bloc avec marge haute pour le poste en direction. -->
                    <div class="mt-2">
                        <!-- Libellé du champ poste en direction. -->
                        <label for="posteDirection" class="form-label">Poste en direction</label>
                        <!-- Champ texte pour saisir le poste en direction. -->
                        <input id="posteDirection" name="posteDirection" class="form-control" type="text"
                            placeholder="Ex: Président, Trésorier" />
                    <!-- Ferme le bloc du poste en direction. -->
                    </div>
                    <!-- Ouvre un bloc pour la case à cocher commission technique. -->
                    <div class="form-check mt-2">
                        <!-- Case à cocher indiquant l'appartenance à la commission technique. -->
                        <input class="form-check-input" type="checkbox" id="estCommissionTechnique" name="estCommissionTechnique" value="1" />
                        <!-- Libellé associé à la case commission technique. -->
                        <label class="form-check-label" for="estCommissionTechnique">Commission technique</label>
                    <!-- Ferme le bloc de la case commission technique. -->
                    </div>
                    <!-- Ouvre un bloc avec marge haute pour le poste en commission technique. -->
                    <div class="mt-2">
                        <!-- Libellé du champ poste commission technique. -->
                        <label for="posteCommissionTechnique" class="form-label">Poste commission technique</label>
                        <!-- Champ texte pour saisir le poste en commission technique. -->
                        <input id="posteCommissionTechnique" name="posteCommissionTechnique" class="form-control" type="text"
                            placeholder="Ex: Responsable technique" />
                    <!-- Ferme le bloc du poste commission technique. -->
                    </div>
                    <!-- Ouvre un bloc pour la case à cocher commission animation. -->
                    <div class="form-check mt-2">
                        <!-- Case à cocher indiquant l'appartenance à la commission animation. -->
                        <input class="form-check-input" type="checkbox" id="estCommissionAnimation" name="estCommissionAnimation" value="1" />
                        <!-- Libellé associé à la case commission animation. -->
                        <label class="form-check-label" for="estCommissionAnimation">Commission animation</label>
                    <!-- Ferme le bloc de la case commission animation. -->
                    </div>
                    <!-- Ouvre un bloc avec marge haute pour le poste en commission animation. -->
                    <div class="mt-2">
                        <!-- Libellé du champ poste commission animation. -->
                        <label for="posteCommissionAnimation" class="form-label">Poste commission animation</label>
                        <!-- Champ texte pour saisir le poste en commission animation. -->
                        <input id="posteCommissionAnimation" name="posteCommissionAnimation" class="form-control" type="text"
                            placeholder="Ex: Responsable animations" />
                    <!-- Ferme le bloc du poste commission animation. -->
                    </div>
                    <!-- Ouvre un bloc pour la case à cocher commission communication. -->
                    <div class="form-check mt-2">
                        <!-- Case à cocher indiquant l'appartenance à la commission communication. -->
                        <input class="form-check-input" type="checkbox" id="estCommissionCommunication" name="estCommissionCommunication" value="1" />
                        <!-- Libellé associé à la case commission communication. -->
                        <label class="form-check-label" for="estCommissionCommunication">Commission communication</label>
                    <!-- Ferme le bloc de la case commission communication. -->
                    </div>
                    <!-- Ouvre un bloc avec marge haute pour le poste en commission communication. -->
                    <div class="mt-2">
                        <!-- Libellé du champ poste commission communication. -->
                        <label for="posteCommissionCommunication" class="form-label">Poste commission communication</label>
                        <!-- Champ texte pour saisir le poste en commission communication. -->
                        <input id="posteCommissionCommunication" name="posteCommissionCommunication" class="form-control" type="text"
                            placeholder="Ex: Responsable communication" />
                    <!-- Ferme le bloc du poste commission communication. -->
                    </div>
                <!-- Ferme le groupe de formulaire des rôles. -->
                </div>
                <!-- Ouvre un groupe de formulaire avec marge haute pour le bouton de soumission. -->
                <div class="form-group mt-3">
                    <!-- Bouton qui envoie le formulaire. -->
                    <button type="submit" class="btn btn-primary">Créer</button>
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
