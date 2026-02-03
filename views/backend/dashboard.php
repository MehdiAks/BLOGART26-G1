<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
$pageStyles = [ROOT_URL . '/src/css/dashboard.css'];
include '../../header.php';


?>

<!-- Bootstrap admin dashboard template -->
<div class="admin-dashboard">
    <hr class="my-3">
    <div style="color: black; font-size: 30px; font-family: Montserrat; font-weight: 400; padding-left: 3rem ;word-wrap: break-word">Liens permettant d'administrer le Blog d'Articles</div>    
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
    </div>
</div>
