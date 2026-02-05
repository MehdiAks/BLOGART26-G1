<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
$pageStyles = [ROOT_URL . '/src/css/dashboard.css'];
include '../../header.php';


?>

<div class="admin-loading" id="admin-loading" aria-hidden="true">
    <div class="admin-loading__fill"></div>
    <div class="admin-loading__logo">
        <video
            class="admin-loading__video"
            id="admin-loading-video"
            muted
            playsinline
            preload="auto"
            poster="<?php echo ROOT_URL . '/src/images/logo/logo-bec/logo.png'; ?>"
        >
            <source src="<?php echo ROOT_URL . '/src/images/logo/logo-bec/logo-anime-transparent.mov'; ?>" type="video/quicktime">
            <img src="<?php echo ROOT_URL . '/src/images/logo/logo-bec/logo.png'; ?>" alt="Logo BEC">
        </video>
    </div>
</div>

<!-- Bootstrap admin dashboard template -->
<div class="admin-dashboard"> 
    <hr class="my-3">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <p>Bienvenue sur le dashboard !</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-12 col-lg-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Matchs</h5>
                        <p class="card-text">Planifiez les rencontres, horaires et résultats.</p>
                        <div class="admin-actions d-flex flex-wrap gap-2">
                            <a href="/views/backend/matches/list.php" class="btn btn-primary">Liste</a>
                            <a href="/views/backend/matches/create.php" class="btn btn-success">Créer</a>
                            <a href="/views/backend/matches/edit.php" class="btn btn-warning disabled">Modifier</a>
                            <a href="/views/backend/matches/delete.php" class="btn btn-danger disabled">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Articles</h5>
                        <p class="card-text">Créez des articles avec images et mots-clés associés.</p>
                        <div class="admin-actions d-flex flex-wrap gap-2">
                            <a href="/views/backend/articles/list.php" class="btn btn-primary">Liste</a>
                            <a href="/views/backend/articles/create.php" class="btn btn-success">Créer</a>
                            <a href="/views/backend/articles/edit.php" class="btn btn-warning disabled">Modifier</a>
                            <a href="/views/backend/articles/delete.php" class="btn btn-danger disabled">Supprimer</a>
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
                            <a href="/views/backend/likes/list.php" class="btn btn-primary">Liste</a>
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
                            <a href="/views/backend/comments/list.php" class="btn btn-primary">Liste</a>
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
                            <a href="/views/backend/keywords/list.php" class="btn btn-primary">Liste</a>
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
                            <a href="/views/backend/thematiques/list.php" class="btn btn-primary">Liste</a>
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
                            <a href="/views/backend/statuts/list.php" class="btn btn-primary">Liste</a>
                            <a href="/views/backend/statuts/create.php" class="btn btn-success">Créer</a>
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
                            <a href="/views/backend/members/list.php" class="btn btn-primary">Liste</a>
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
                            <a href="/views/backend/joueurs/list.php" class="btn btn-primary">Liste</a>
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
                            <a href="/views/backend/benevoles/list.php" class="btn btn-primary">Liste</a>
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
                            <a href="/views/backend/equipes/list.php" class="btn btn-primary">Liste</a>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loading = document.getElementById('admin-loading');
        const video = document.getElementById('admin-loading-video');

        if (!loading) {
            return;
        }

        const fillDuration = 1600;
        const drainDuration = 900;

        const startDrain = function () {
            loading.classList.add('admin-loading--drain');
            window.setTimeout(function () {
                loading.remove();
            }, drainDuration + 200);
        };

        const startLogo = function () {
            loading.classList.add('admin-loading--logo');
            if (video) {
                video.currentTime = 0;
                const playPromise = video.play();
                if (playPromise && typeof playPromise.catch === 'function') {
                    playPromise.catch(function () {
                        window.setTimeout(startDrain, 1200);
                    });
                }
            } else {
                window.setTimeout(startDrain, 1200);
            }
        };

        if (video) {
            video.addEventListener('ended', startDrain, { once: true });
        }

        window.setTimeout(startLogo, fillDuration + 200);
    });
</script>
