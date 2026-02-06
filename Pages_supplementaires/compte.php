<!-- Cette ligne contient: <?php -->
<?php
// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Ligne vide pour aération.

// Cette ligne contient: $ba_bec_numMemb = $_SESSION['user_id'] ?? null;
$ba_bec_numMemb = $_SESSION['user_id'] ?? null;
// Cette ligne contient: $ba_bec_numStat = $_SESSION['numStat'] ?? null;
$ba_bec_numStat = $_SESSION['numStat'] ?? null;
// Cette ligne contient: if (!$ba_bec_numMemb) {
if (!$ba_bec_numMemb) {
// Cette ligne contient: header("Location: " . ROOT_URL . "/views/backend/security/login.php");
    header("Location: " . ROOT_URL . "/views/backend/security/login.php");
// Cette ligne contient: exit();
    exit();
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: $memberData = sql_select(
$memberData = sql_select(
// Cette ligne contient: "MEMBRE INNER JOIN STATUT ON MEMBRE.numStat = STATUT.numStat",
    "MEMBRE INNER JOIN STATUT ON MEMBRE.numStat = STATUT.numStat",
// Cette ligne contient: "MEMBRE.numMemb, MEMBRE.pseudoMemb, MEMBRE.prenomMemb, MEMBRE.nomMemb, MEMBRE.eMailMemb, STATUT.libStat",
    "MEMBRE.numMemb, MEMBRE.pseudoMemb, MEMBRE.prenomMemb, MEMBRE.nomMemb, MEMBRE.eMailMemb, STATUT.libStat",
// Cette ligne contient: "MEMBRE.numMemb = $ba_bec_numMemb"
    "MEMBRE.numMemb = $ba_bec_numMemb"
// Cette ligne contient: )[0] ?? [];
)[0] ?? [];
// Ligne vide pour aération.

// Cette ligne contient: $ba_bec_recaptchaSiteKey = getenv('RECAPTCHA_SITE_KEY');
$ba_bec_recaptchaSiteKey = getenv('RECAPTCHA_SITE_KEY');
// Cette ligne contient: $ba_bec_recaptchaSiteKeyEscaped = htmlspecialchars($ba_bec_recaptchaSiteKey ?? '', ENT_QUOTES, 'UTF-8');
$ba_bec_recaptchaSiteKeyEscaped = htmlspecialchars($ba_bec_recaptchaSiteKey ?? '', ENT_QUOTES, 'UTF-8');
// Ligne vide pour aération.

// Cette ligne contient: $ba_bec_success = $_SESSION['success'] ?? null;
$ba_bec_success = $_SESSION['success'] ?? null;
// Cette ligne contient: $ba_bec_error = $_SESSION['error'] ?? null;
$ba_bec_error = $_SESSION['error'] ?? null;
// Cette ligne contient: unset($_SESSION['success'], $_SESSION['error']);
unset($_SESSION['success'], $_SESSION['error']);
// Ligne vide pour aération.

// Cette ligne contient: $totalComments = sql_select("comment", "COUNT(*) as total", "numMemb = $ba_bec_numMemb")[0]['total'] ?? 0;
$totalComments = sql_select("comment", "COUNT(*) as total", "numMemb = $ba_bec_numMemb")[0]['total'] ?? 0;
// Cette ligne contient: $pendingComments = sql_select(
$pendingComments = sql_select(
// Cette ligne contient: "comment",
    "comment",
// Cette ligne contient: "COUNT(*) as total",
    "COUNT(*) as total",
// Cette ligne contient: "numMemb = $ba_bec_numMemb AND attModOK = 0 AND delLogiq = 0"
    "numMemb = $ba_bec_numMemb AND attModOK = 0 AND delLogiq = 0"
// Cette ligne contient: )[0]['total'] ?? 0;
)[0]['total'] ?? 0;
// Cette ligne contient: $publishedComments = sql_select(
$publishedComments = sql_select(
// Cette ligne contient: "comment",
    "comment",
// Cette ligne contient: "COUNT(*) as total",
    "COUNT(*) as total",
// Cette ligne contient: "numMemb = $ba_bec_numMemb AND attModOK = 1 AND delLogiq = 0"
    "numMemb = $ba_bec_numMemb AND attModOK = 1 AND delLogiq = 0"
// Cette ligne contient: )[0]['total'] ?? 0;
)[0]['total'] ?? 0;
// Ligne vide pour aération.

// Cette ligne contient: $recentComments = sql_select(
$recentComments = sql_select(
// Cette ligne contient: "comment c INNER JOIN article a ON c.numArt = a.numArt",
    "comment c INNER JOIN article a ON c.numArt = a.numArt",
// Cette ligne contient: "c.numCom, c.libCom, c.dtCreaCom, c.attModOK, c.delLogiq, a.libTitrArt",
    "c.numCom, c.libCom, c.dtCreaCom, c.attModOK, c.delLogiq, a.libTitrArt",
// Cette ligne contient: "c.numMemb = $ba_bec_numMemb",
    "c.numMemb = $ba_bec_numMemb",
// Cette ligne contient: null,
    null,
// Cette ligne contient: "c.dtCreaCom DESC",
    "c.dtCreaCom DESC",
// Cette ligne contient: 5
    5
// Cette ligne contient: );
);
// Ligne vide pour aération.

// Cette ligne contient: $recentLikes = sql_select(
$recentLikes = sql_select(
// Cette ligne contient: "likeart l INNER JOIN article a ON l.numArt = a.numArt",
    "likeart l INNER JOIN article a ON l.numArt = a.numArt",
// Cette ligne contient: "l.numArt, l.likeA, a.libTitrArt",
    "l.numArt, l.likeA, a.libTitrArt",
// Cette ligne contient: "l.numMemb = $ba_bec_numMemb",
    "l.numMemb = $ba_bec_numMemb",
// Cette ligne contient: null,
    null,
// Cette ligne contient: "a.libTitrArt ASC",
    "a.libTitrArt ASC",
// Cette ligne contient: 5
    5
// Cette ligne contient: );
);
// Ligne vide pour aération.

// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php';
// Cette ligne contient: ?>
?>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <main class="container my-5"> -->
<main class="container my-5">
<!-- Cette ligne contient: <h1 class="mb-4">Mon compte</h1> -->
    <h1 class="mb-4">Mon compte</h1>
<!-- Cette ligne contient: <?php if ($ba_bec_success): ?> -->
    <?php if ($ba_bec_success): ?>
<!-- Cette ligne contient: <div class="alert alert-success"><?php echo htmlspecialchars($ba_bec_success); ?></div> -->
        <div class="alert alert-success"><?php echo htmlspecialchars($ba_bec_success); ?></div>
<!-- Cette ligne contient: <?php endif; ?> -->
    <?php endif; ?>
<!-- Cette ligne contient: <?php if ($ba_bec_error): ?> -->
    <?php if ($ba_bec_error): ?>
<!-- Cette ligne contient: <div class="alert alert-danger"><?php echo htmlspecialchars($ba_bec_error); ?></div> -->
        <div class="alert alert-danger"><?php echo htmlspecialchars($ba_bec_error); ?></div>
<!-- Cette ligne contient: <?php endif; ?> -->
    <?php endif; ?>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <div class="row g-4"> -->
    <div class="row g-4">
<!-- Cette ligne contient: <div class="col-lg-4"> -->
        <div class="col-lg-4">
<!-- Cette ligne contient: <div class="card h-100"> -->
            <div class="card h-100">
<!-- Cette ligne contient: <div class="card-body"> -->
                <div class="card-body">
<!-- Cette ligne contient: <h2 class="h5 mb-3">Accès rapide</h2> -->
                    <h2 class="h5 mb-3">Accès rapide</h2>
<!-- Cette ligne contient: <div class="d-grid gap-2"> -->
                    <div class="d-grid gap-2">
<!-- Cette ligne contient: <a class="btn btn-outline-primary" href="<?php echo ROOT_URL . '/Pages_supplementaires/compte.php'; ?>">Mon compte</a> -->
                        <a class="btn btn-outline-primary" href="<?php echo ROOT_URL . '/Pages_supplementaires/compte.php'; ?>">Mon compte</a>
<!-- Cette ligne contient: <?php if ($ba_bec_numStat === 1 || $ba_bec_numStat === 2): ?> -->
                        <?php if ($ba_bec_numStat === 1 || $ba_bec_numStat === 2): ?>
<!-- Cette ligne contient: <a class="btn btn-outline-secondary" href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>">Panneau admin</a> -->
                            <a class="btn btn-outline-secondary" href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>">Panneau admin</a>
<!-- Cette ligne contient: <?php endif; ?> -->
                        <?php endif; ?>
<!-- Cette ligne contient: <a class="btn btn-outline-danger" href="<?php echo ROOT_URL . '/api/security/disconnect.php'; ?>">Déconnexion</a> -->
                        <a class="btn btn-outline-danger" href="<?php echo ROOT_URL . '/api/security/disconnect.php'; ?>">Déconnexion</a>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: </div> -->
            </div>
<!-- Cette ligne contient: </div> -->
        </div>
<!-- Cette ligne contient: <div class="col-lg-4"> -->
        <div class="col-lg-4">
<!-- Cette ligne contient: <div class="card h-100"> -->
            <div class="card h-100">
<!-- Cette ligne contient: <div class="card-body"> -->
                <div class="card-body">
<!-- Cette ligne contient: <h2 class="h5 mb-3">Statut</h2> -->
                    <h2 class="h5 mb-3">Statut</h2>
<!-- Cette ligne contient: <p class="mb-1"><strong>Nom d'utilisateur :</strong> <?php echo htmlspecialchars($memberData['pseudoMemb'] ?? ''); ?></p> -->
                    <p class="mb-1"><strong>Nom d'utilisateur :</strong> <?php echo htmlspecialchars($memberData['pseudoMemb'] ?? ''); ?></p>
<!-- Cette ligne contient: <p class="mb-1"><strong>Statut :</strong> <?php echo htmlspecialchars($memberData['libStat'] ?? ''); ?></p> -->
                    <p class="mb-1"><strong>Statut :</strong> <?php echo htmlspecialchars($memberData['libStat'] ?? ''); ?></p>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: </div> -->
            </div>
<!-- Cette ligne contient: </div> -->
        </div>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <div class="col-lg-4"> -->
        <div class="col-lg-4">
<!-- Cette ligne contient: <div class="card h-100"> -->
            <div class="card h-100">
<!-- Cette ligne contient: <div class="card-body"> -->
                <div class="card-body">
<!-- Cette ligne contient: <h2 class="h5 mb-3">Coordonnées</h2> -->
                    <h2 class="h5 mb-3">Coordonnées</h2>
<!-- Cette ligne contient: <p class="mb-1"><strong>Prénom :</strong> <?php echo htmlspecialchars($memberData['prenomMemb'] ?? ''); ?></p> -->
                    <p class="mb-1"><strong>Prénom :</strong> <?php echo htmlspecialchars($memberData['prenomMemb'] ?? ''); ?></p>
<!-- Cette ligne contient: <p class="mb-1"><strong>Nom :</strong> <?php echo htmlspecialchars($memberData['nomMemb'] ?? ''); ?></p> -->
                    <p class="mb-1"><strong>Nom :</strong> <?php echo htmlspecialchars($memberData['nomMemb'] ?? ''); ?></p>
<!-- Cette ligne contient: <p class="mb-1"><strong>Email :</strong> <?php echo htmlspecialchars($memberData['eMailMemb'] ?? ''); ?></p> -->
                    <p class="mb-1"><strong>Email :</strong> <?php echo htmlspecialchars($memberData['eMailMemb'] ?? ''); ?></p>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: </div> -->
            </div>
<!-- Cette ligne contient: </div> -->
        </div>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <div class="col-lg-4"> -->
        <div class="col-lg-4">
<!-- Cette ligne contient: <div class="card h-100"> -->
            <div class="card h-100">
<!-- Cette ligne contient: <div class="card-body"> -->
                <div class="card-body">
<!-- Cette ligne contient: <h2 class="h5 mb-3">Commentaires</h2> -->
                    <h2 class="h5 mb-3">Commentaires</h2>
<!-- Cette ligne contient: <p class="mb-1"><strong>Total :</strong> <?php echo htmlspecialchars((string) $totalComments); ?></p> -->
                    <p class="mb-1"><strong>Total :</strong> <?php echo htmlspecialchars((string) $totalComments); ?></p>
<!-- Cette ligne contient: <p class="mb-1"><strong>En attente :</strong> <?php echo htmlspecialchars((string) $pendingComments); ?></p> -->
                    <p class="mb-1"><strong>En attente :</strong> <?php echo htmlspecialchars((string) $pendingComments); ?></p>
<!-- Cette ligne contient: <p class="mb-1"><strong>Publiés :</strong> <?php echo htmlspecialchars((string) $publishedComments); ?></p> -->
                    <p class="mb-1"><strong>Publiés :</strong> <?php echo htmlspecialchars((string) $publishedComments); ?></p>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: </div> -->
            </div>
<!-- Cette ligne contient: </div> -->
        </div>
<!-- Cette ligne contient: </div> -->
    </div>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <div class="card mt-4"> -->
    <div class="card mt-4">
<!-- Cette ligne contient: <div class="card-body"> -->
        <div class="card-body">
<!-- Cette ligne contient: <h2 class="h5 mb-3">Derniers commentaires</h2> -->
            <h2 class="h5 mb-3">Derniers commentaires</h2>
<!-- Cette ligne contient: <?php if (!empty($recentComments)): ?> -->
            <?php if (!empty($recentComments)): ?>
<!-- Cette ligne contient: <div class="table-responsive"> -->
                <div class="table-responsive">
<!-- Cette ligne contient: <table class="table table-striped align-middle"> -->
                    <table class="table table-striped align-middle">
<!-- Cette ligne contient: <thead> -->
                        <thead>
<!-- Cette ligne contient: <tr> -->
                            <tr>
<!-- Cette ligne contient: <th>Article</th> -->
                                <th>Article</th>
<!-- Cette ligne contient: <th>Commentaire</th> -->
                                <th>Commentaire</th>
<!-- Cette ligne contient: <th>Date</th> -->
                                <th>Date</th>
<!-- Cette ligne contient: <th>Statut</th> -->
                                <th>Statut</th>
<!-- Cette ligne contient: <th>Action</th> -->
                                <th>Action</th>
<!-- Cette ligne contient: </tr> -->
                            </tr>
<!-- Cette ligne contient: </thead> -->
                        </thead>
<!-- Cette ligne contient: <tbody> -->
                        <tbody>
<!-- Cette ligne contient: <?php foreach ($recentComments as $ba_bec_comment): ?> -->
                            <?php foreach ($recentComments as $ba_bec_comment): ?>
<!-- Cette ligne contient: <?php -->
                                <?php
// Cette ligne contient: $statusLabel = 'En attente';
                                $statusLabel = 'En attente';
// Cette ligne contient: if ((int) $ba_bec_comment['delLogiq'] === 1) {
                                if ((int) $ba_bec_comment['delLogiq'] === 1) {
// Cette ligne contient: $statusLabel = 'Supprimé';
                                    $statusLabel = 'Supprimé';
// Cette ligne contient: } elseif ((int) $ba_bec_comment['attModOK'] === 1) {
                                } elseif ((int) $ba_bec_comment['attModOK'] === 1) {
// Cette ligne contient: $statusLabel = 'Publié';
                                    $statusLabel = 'Publié';
// Cette ligne contient: }
                                }
// Cette ligne contient: ?>
                                ?>
<!-- Cette ligne contient: <tr> -->
                                <tr>
<!-- Cette ligne contient: <td><?php echo htmlspecialchars($ba_bec_comment['libTitrArt']); ?></td> -->
                                    <td><?php echo htmlspecialchars($ba_bec_comment['libTitrArt']); ?></td>
<!-- Cette ligne contient: <td><?php echo htmlspecialchars($ba_bec_comment['libCom']); ?></td> -->
                                    <td><?php echo htmlspecialchars($ba_bec_comment['libCom']); ?></td>
<!-- Cette ligne contient: <td><?php echo htmlspecialchars($ba_bec_comment['dtCreaCom']); ?></td> -->
                                    <td><?php echo htmlspecialchars($ba_bec_comment['dtCreaCom']); ?></td>
<!-- Cette ligne contient: <td><?php echo htmlspecialchars($statusLabel); ?></td> -->
                                    <td><?php echo htmlspecialchars($statusLabel); ?></td>
<!-- Cette ligne contient: <td> -->
                                    <td>
<!-- Cette ligne contient: <form action="<?php echo ROOT_URL . '/api/account/delete-comment.php'; ?>" method="post" onsubmit="return confirm('Supprimer ce commentaire ?');"> -->
                                        <form action="<?php echo ROOT_URL . '/api/account/delete-comment.php'; ?>" method="post" onsubmit="return confirm('Supprimer ce commentaire ?');">
<!-- Cette ligne contient: <input type="hidden" name="numCom" value="<?php echo (int) $ba_bec_comment['numCom']; ?>"> -->
                                            <input type="hidden" name="numCom" value="<?php echo (int) $ba_bec_comment['numCom']; ?>">
<!-- Cette ligne contient: <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button> -->
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
<!-- Cette ligne contient: </form> -->
                                        </form>
<!-- Cette ligne contient: </td> -->
                                    </td>
<!-- Cette ligne contient: </tr> -->
                                </tr>
<!-- Cette ligne contient: <?php endforeach; ?> -->
                            <?php endforeach; ?>
<!-- Cette ligne contient: </tbody> -->
                        </tbody>
<!-- Cette ligne contient: </table> -->
                    </table>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: <?php else: ?> -->
            <?php else: ?>
<!-- Cette ligne contient: <p class="mb-0">Vous n'avez pas encore publié de commentaire.</p> -->
                <p class="mb-0">Vous n'avez pas encore publié de commentaire.</p>
<!-- Cette ligne contient: <?php endif; ?> -->
            <?php endif; ?>
<!-- Cette ligne contient: </div> -->
        </div>
<!-- Cette ligne contient: </div> -->
    </div>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <div class="card mt-4"> -->
    <div class="card mt-4">
<!-- Cette ligne contient: <div class="card-body"> -->
        <div class="card-body">
<!-- Cette ligne contient: <h2 class="h5 mb-3">Mes derniers likes</h2> -->
            <h2 class="h5 mb-3">Mes derniers likes</h2>
<!-- Cette ligne contient: <?php if (!empty($recentLikes)): ?> -->
            <?php if (!empty($recentLikes)): ?>
<!-- Cette ligne contient: <div class="table-responsive"> -->
                <div class="table-responsive">
<!-- Cette ligne contient: <table class="table table-striped align-middle"> -->
                    <table class="table table-striped align-middle">
<!-- Cette ligne contient: <thead> -->
                        <thead>
<!-- Cette ligne contient: <tr> -->
                            <tr>
<!-- Cette ligne contient: <th>Article</th> -->
                                <th>Article</th>
<!-- Cette ligne contient: <th>Type</th> -->
                                <th>Type</th>
<!-- Cette ligne contient: <th>Action</th> -->
                                <th>Action</th>
<!-- Cette ligne contient: </tr> -->
                            </tr>
<!-- Cette ligne contient: </thead> -->
                        </thead>
<!-- Cette ligne contient: <tbody> -->
                        <tbody>
<!-- Cette ligne contient: <?php foreach ($recentLikes as $ba_bec_like): ?> -->
                            <?php foreach ($recentLikes as $ba_bec_like): ?>
<!-- Cette ligne contient: <tr> -->
                                <tr>
<!-- Cette ligne contient: <td><?php echo htmlspecialchars($ba_bec_like['libTitrArt']); ?></td> -->
                                    <td><?php echo htmlspecialchars($ba_bec_like['libTitrArt']); ?></td>
<!-- Cette ligne contient: <td><?php echo ((int) $ba_bec_like['likeA'] === 1) ? 'Like' : 'Dislike'; ?></td> -->
                                    <td><?php echo ((int) $ba_bec_like['likeA'] === 1) ? 'Like' : 'Dislike'; ?></td>
<!-- Cette ligne contient: <td> -->
                                    <td>
<!-- Cette ligne contient: <form action="<?php echo ROOT_URL . '/api/account/delete-like.php'; ?>" method="post" onsubmit="return confirm('Supprimer ce like ?');"> -->
                                        <form action="<?php echo ROOT_URL . '/api/account/delete-like.php'; ?>" method="post" onsubmit="return confirm('Supprimer ce like ?');">
<!-- Cette ligne contient: <input type="hidden" name="numArt" value="<?php echo (int) $ba_bec_like['numArt']; ?>"> -->
                                            <input type="hidden" name="numArt" value="<?php echo (int) $ba_bec_like['numArt']; ?>">
<!-- Cette ligne contient: <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button> -->
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
<!-- Cette ligne contient: </form> -->
                                        </form>
<!-- Cette ligne contient: </td> -->
                                    </td>
<!-- Cette ligne contient: </tr> -->
                                </tr>
<!-- Cette ligne contient: <?php endforeach; ?> -->
                            <?php endforeach; ?>
<!-- Cette ligne contient: </tbody> -->
                        </tbody>
<!-- Cette ligne contient: </table> -->
                    </table>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: <?php else: ?> -->
            <?php else: ?>
<!-- Cette ligne contient: <p class="mb-0">Vous n'avez pas encore liké d'article.</p> -->
                <p class="mb-0">Vous n'avez pas encore liké d'article.</p>
<!-- Cette ligne contient: <?php endif; ?> -->
            <?php endif; ?>
<!-- Cette ligne contient: </div> -->
        </div>
<!-- Cette ligne contient: </div> -->
    </div>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <div class="card mt-4 border-danger"> -->
    <div class="card mt-4 border-danger">
<!-- Cette ligne contient: <div class="card-body"> -->
        <div class="card-body">
<!-- Cette ligne contient: <h2 class="h5 mb-3 text-danger">Supprimer mon compte</h2> -->
            <h2 class="h5 mb-3 text-danger">Supprimer mon compte</h2>
<!-- Cette ligne contient: <p class="mb-3">La suppression est définitive et effacera vos likes et commentaires.</p> -->
            <p class="mb-3">La suppression est définitive et effacera vos likes et commentaires.</p>
<!-- Cette ligne contient: <form action="<?php echo ROOT_URL . '/api/account/delete.php'; ?>" method="post" id="delete-account-form" onsubmit="return confirm('Confirmer la suppression définitive de votre compte ?');"> -->
            <form action="<?php echo ROOT_URL . '/api/account/delete.php'; ?>" method="post" id="delete-account-form" onsubmit="return confirm('Confirmer la suppression définitive de votre compte ?');">
<!-- Cette ligne contient: <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-delete-account"> -->
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-delete-account">
<!-- Cette ligne contient: <div class="form-check mb-3"> -->
                <div class="form-check mb-3">
<!-- Cette ligne contient: <input class="form-check-input" type="checkbox" id="confirmDeleteAccount" name="confirmDeleteAccount" value="1" required> -->
                    <input class="form-check-input" type="checkbox" id="confirmDeleteAccount" name="confirmDeleteAccount" value="1" required>
<!-- Cette ligne contient: <label class="form-check-label" for="confirmDeleteAccount">Je confirme vouloir supprimer mon compte.</label> -->
                    <label class="form-check-label" for="confirmDeleteAccount">Je confirme vouloir supprimer mon compte.</label>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: <button type="submit" class="btn btn-danger">Supprimer mon compte</button> -->
                <button type="submit" class="btn btn-danger">Supprimer mon compte</button>
<!-- Cette ligne contient: </form> -->
            </form>
<!-- Cette ligne contient: </div> -->
        </div>
<!-- Cette ligne contient: </div> -->
    </div>
<!-- Cette ligne contient: </main> -->
</main>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <?php if (!empty($ba_bec_recaptchaSiteKey)): ?> -->
<?php if (!empty($ba_bec_recaptchaSiteKey)): ?>
<!-- Cette ligne contient: <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $ba_bec_recaptchaSiteKeyEscaped; ?>"></script> -->
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $ba_bec_recaptchaSiteKeyEscaped; ?>"></script>
<!-- Cette ligne contient: <script> -->
<script>
<!-- Cette ligne contient: (function () { -->
    (function () {
<!-- Cette ligne contient: var form = document.getElementById('delete-account-form'); -->
        var form = document.getElementById('delete-account-form');
<!-- Cette ligne contient: var tokenInput = document.getElementById('g-recaptcha-response-delete-account'); -->
        var tokenInput = document.getElementById('g-recaptcha-response-delete-account');
<!-- Cette ligne contient: var siteKey = '<?php echo $ba_bec_recaptchaSiteKeyEscaped; ?>'; -->
        var siteKey = '<?php echo $ba_bec_recaptchaSiteKeyEscaped; ?>';
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: if (!form || !tokenInput || !siteKey || typeof grecaptcha === 'undefined') { -->
        if (!form || !tokenInput || !siteKey || typeof grecaptcha === 'undefined') {
<!-- Cette ligne contient: return; -->
            return;
<!-- Cette ligne contient: } -->
        }
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: form.addEventListener('submit', function (event) { -->
        form.addEventListener('submit', function (event) {
<!-- Cette ligne contient: if (tokenInput.value) { -->
            if (tokenInput.value) {
<!-- Cette ligne contient: return; -->
                return;
<!-- Cette ligne contient: } -->
            }
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: event.preventDefault(); -->
            event.preventDefault();
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: grecaptcha.ready(function () { -->
            grecaptcha.ready(function () {
<!-- Cette ligne contient: grecaptcha.execute(siteKey, {action: 'delete-account'}) -->
                grecaptcha.execute(siteKey, {action: 'delete-account'})
<!-- Cette ligne contient: .then(function (token) { -->
                    .then(function (token) {
<!-- Cette ligne contient: tokenInput.value = token; -->
                        tokenInput.value = token;
<!-- Cette ligne contient: form.submit(); -->
                        form.submit();
<!-- Cette ligne contient: }) -->
                    })
<!-- Cette ligne contient: .catch(function () { -->
                    .catch(function () {
<!-- Cette ligne contient: form.submit(); -->
                        form.submit();
<!-- Cette ligne contient: }); -->
                    });
<!-- Cette ligne contient: }); -->
            });
<!-- Cette ligne contient: }); -->
        });
<!-- Cette ligne contient: })(); -->
    })();
<!-- Cette ligne contient: </script> -->
</script>
<!-- Cette ligne contient: <?php endif; ?> -->
<?php endif; ?>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?> -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?>
