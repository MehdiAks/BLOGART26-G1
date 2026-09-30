<?php
/*
 * Vue d'administration (dashboard).
 * - Cette page rassemble les principaux modules accessibles via des cartes et boutons d'action.
 * - Les liens mènent vers les listes ou formulaires de création des entités gérées.
 * - L'affichage utilise la grille Bootstrap pour organiser les blocs fonctionnels.
 * - Le code PHP en amont prépare uniquement les ressources et indicateurs d'affichage.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
$pageStyles = [ROOT_URL . '/src/css/dashboard.css'];
$pageTitle = 'Tableau de bord · Administration';
$ba_bec_referrer = $_SERVER['HTTP_REFERER'] ?? '';
$ba_bec_referrerPath = parse_url($ba_bec_referrer, PHP_URL_PATH);
$ba_bec_adminReferrer = safe_redirect_target(is_string($ba_bec_referrerPath) ? $ba_bec_referrerPath : null, '');
$ba_bec_isBackendReferrer = strpos($ba_bec_adminReferrer, '/views/backend/') !== false;
$showAdminLoading = false;
include '../../header.php';
$ba_bec_modules = [
    ['Matchs', 'Planifiez les rencontres, horaires et résultats.', '/views/backend/matches/list.php', '/views/backend/matches/create.php'],
    ['Articles', 'Créez les articles, images et mots-clés associés.', '/public/index.php?controller=article&action=list', '/public/index.php?controller=article&action=create'],
    ['Boutique', 'Gérez les produits, prix et visuels de la boutique.', '/views/backend/boutique/list.php', '/views/backend/boutique/create.php'],
    ['Likes', 'Suivez les appréciations des articles.', '/views/backend/likes/list.php', '/views/backend/likes/create.php'],
    ['Commentaires', 'Modérez et organisez les retours des lecteurs.', '/views/backend/comments/list.php', '/views/backend/comments/create.php'],
    ['Mots-clés', 'Classez les articles par mots-clés.', '/views/backend/keywords/list.php', '/views/backend/keywords/create.php'],
    ['Thématiques', 'Structurez les catégories du blog.', '/views/backend/thematiques/list.php', '/views/backend/thematiques/create.php'],
    ['Statuts', 'Gérez les rôles et permissions.', '/public/index.php?controller=statut&action=list', '/public/index.php?controller=statut&action=create'],
    ['Membres', 'Administrez les comptes et leurs accès.', '/views/backend/members/list.php', '/views/backend/members/create.php'],
    ['Joueurs', 'Ajoutez et mettez à jour les joueurs.', '/views/backend/joueurs/list.php', '/views/backend/joueurs/create.php'],
    ['Bénévoles', 'Gérez les bénévoles et leurs profils.', '/views/backend/benevoles/list.php', '/views/backend/benevoles/create.php'],
    ['Équipes', 'Structurez et mettez à jour les équipes.', '/views/backend/equipes/list.php', '/views/backend/equipes/create.php'],
];
?>

<main class="admin-dashboard admin-dashboard--modules">
    <div class="container">
        <header class="admin-dashboard__header"><p class="eyebrow">Administration</p><h1>Tableau de bord</h1></header>
        <div class="admin-module-grid">
            <?php foreach ($ba_bec_modules as $ba_bec_module): ?>
                <section class="admin-module-row">
                    <div class="admin-module-row__copy"><h2><?php echo e($ba_bec_module[0]); ?></h2><p><?php echo e($ba_bec_module[1]); ?></p></div>
                    <div class="admin-module-row__actions"><a class="btn btn-outline-primary" href="<?php echo e(ROOT_URL . $ba_bec_module[2]); ?>">Voir la liste</a><a class="btn btn-primary" href="<?php echo e(ROOT_URL . $ba_bec_module[3]); ?>">Ajouter</a></div>
                </section>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<!-- Bootstrap admin dashboard template -->
<div class="admin-dashboard admin-dashboard--legacy" aria-hidden="true">
    <hr class="my-3">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <p>Bienvenue sur le dashboard !</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-12 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Matchs</h5>
                        <p class="card-text">Planifiez les rencontres, horaires et résultats.</p>
                        <div class="admin-actions d-flex flex-wrap gap-2">
                            <a href="/views/backend/matches/list.php" class="btn btn-primary">Voir la liste</a>
                            <a href="/views/backend/matches/create.php" class="btn btn-success">Créer</a>
                            <a href="/views/backend/matches/edit.php" class="btn btn-warning disabled">Modifier</a>
                            <a href="/views/backend/matches/delete.php" class="btn btn-danger disabled">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Articles</h5>
                        <p class="card-text">Créez des articles avec images et mots-clés associés.</p>
                        <div class="admin-actions d-flex flex-wrap gap-2">
                            <a href="/public/index.php?controller=article&action=list" class="btn btn-primary">Voir la liste</a>
                            <a href="/public/index.php?controller=article&action=create" class="btn btn-success">Créer</a>
                            <a href="/views/backend/articles/edit.php" class="btn btn-warning disabled">Modifier</a>
                            <a href="/views/backend/articles/delete.php" class="btn btn-danger disabled">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Boutique</h5>
                        <p class="card-text">Gérez les produits, prix, tailles, couleurs et visuels de la boutique.</p>
                        <div class="admin-actions d-flex flex-wrap gap-2">
                            <a href="/views/backend/boutique/list.php" class="btn btn-primary">Voir la liste</a>
                            <a href="/views/backend/boutique/create.php" class="btn btn-success">Créer</a>
                            <a href="/views/backend/boutique/edit.php" class="btn btn-warning disabled">Modifier</a>
                            <a href="/views/backend/boutique/delete.php" class="btn btn-danger disabled">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 mt-1">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Likes</h5>
                        <p class="card-text">Suivez les appréciations des articles.</p>
                        <div class="admin-actions d-flex flex-wrap gap-2">
                            <a href="/views/backend/likes/list.php" class="btn btn-primary">Voir la liste</a>
                            <a href="/views/backend/likes/create.php" class="btn btn-success">Créer</a>
                            <a href="/views/backend/likes/edit.php" class="btn btn-warning disabled">Modifier</a>
                            <a href="/views/backend/likes/delete.php" class="btn btn-danger disabled">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Commentaires</h5>
                        <p class="card-text">Modérez et organisez les retours des lecteurs.</p>
                        <div class="admin-actions d-flex flex-wrap gap-2">
                            <a href="/views/backend/comments/list.php" class="btn btn-primary">Voir la liste</a>
                            <a href="/views/backend/comments/create.php" class="btn btn-success">Créer</a>
                            <a href="/views/backend/comments/edit.php" class="btn btn-warning disabled">Modifier</a>
                            <a href="/views/backend/comments/delete.php" class="btn btn-danger disabled">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Mots-clés</h5>
                        <p class="card-text">Classez les articles par mots-clés.</p>
                        <div class="admin-actions d-flex flex-wrap gap-2">
                            <a href="/views/backend/keywords/list.php" class="btn btn-primary">Voir la liste</a>
                            <a href="/views/backend/keywords/create.php" class="btn btn-success">Créer</a>
                            <a href="/views/backend/keywords/edit.php" class="btn btn-warning disabled">Modifier</a>
                            <a href="/views/backend/keywords/delete.php" class="btn btn-danger disabled">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Thématiques</h5>
                        <p class="card-text">Structurez les catégories du blog.</p>
                        <div class="admin-actions d-flex flex-wrap gap-2">
                            <a href="/views/backend/thematiques/list.php" class="btn btn-primary">Voir la liste</a>
                            <a href="/views/backend/thematiques/create.php" class="btn btn-success">Créer</a>
                            <a href="/views/backend/thematiques/edit.php" class="btn btn-warning disabled">Modifier</a>
                            <a href="/views/backend/thematiques/delete.php" class="btn btn-danger disabled">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 mt-1">
            <div class="col-12 col-lg-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Statuts</h5>
                        <p class="card-text">Gérez les rôles et permissions.</p>
                        <div class="admin-actions d-flex flex-wrap gap-2">
                            <a href="/public/index.php?controller=statut&action=list" class="btn btn-primary">Voir la liste</a>
                            <a href="/public/index.php?controller=statut&action=create" class="btn btn-success">Créer</a>
                            <a href="/views/backend/statuts/edit.php" class="btn btn-warning disabled">Modifier</a>
                            <a href="/views/backend/statuts/delete.php" class="btn btn-danger disabled">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Membres</h5>
                        <p class="card-text">Inscription, accès et sécurité des comptes.</p>
                        <div class="admin-actions d-flex flex-wrap gap-2">
                            <a href="/views/backend/members/list.php" class="btn btn-primary">Voir la liste</a>
                            <a href="/views/backend/members/create.php" class="btn btn-success">Créer</a>
                            <a href="/views/backend/members/edit.php" class="btn btn-warning disabled">Modifier</a>
                            <a href="/views/backend/members/delete.php" class="btn btn-danger disabled">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 mt-1">
            <div class="col-12 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Joueurs</h5>
                        <p class="card-text">Ajoutez, modifiez ou retirez des joueurs.</p>
                        <div class="admin-actions d-flex flex-wrap gap-2">
                            <a href="/views/backend/joueurs/list.php" class="btn btn-primary">Voir la liste</a>
                            <a href="/views/backend/joueurs/create.php" class="btn btn-success">Créer</a>
                            <a href="/views/backend/joueurs/edit.php" class="btn btn-warning disabled">Modifier</a>
                            <a href="/views/backend/joueurs/delete.php" class="btn btn-danger disabled">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Bénévoles</h5>
                        <p class="card-text">Gérez l’équipe de bénévoles et leurs profils.</p>
                        <div class="admin-actions d-flex flex-wrap gap-2">
                            <a href="/views/backend/benevoles/list.php" class="btn btn-primary">Voir la liste</a>
                            <a href="/views/backend/benevoles/create.php" class="btn btn-success">Créer</a>
                            <a href="/views/backend/benevoles/edit.php" class="btn btn-warning disabled">Modifier</a>
                            <a href="/views/backend/benevoles/delete.php" class="btn btn-danger disabled">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Équipes</h5>
                        <p class="card-text">Structurez et mettez à jour les équipes.</p>
                        <div class="admin-actions d-flex flex-wrap gap-2">
                            <a href="/views/backend/equipes/list.php" class="btn btn-primary">Voir la liste</a>
                            <a href="/views/backend/equipes/create.php" class="btn btn-success">Créer</a>
                            <a href="/views/backend/equipes/edit.php" class="btn btn-warning disabled">Modifier</a>
                            <a href="/views/backend/equipes/delete.php" class="btn btn-danger disabled">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
