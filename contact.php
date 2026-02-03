<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once 'header.php';
?>

<main class="container py-5">
    <div class="row align-items-start g-5">
        <div class="col-lg-6">
            <h1 class="mb-3">Contact</h1>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque laoreet feugiat lorem, sed
                pharetra mi pulvinar nec. Sed accumsan dolor ut orci dignissim, non faucibus neque egestas.
            </p>
            <div class="article-content mt-4">
                <h2 class="h5">Nous écrire</h2>
                <p>
                    <strong>Email :</strong> contact@bec-bordeaux.fr<br>
                    <strong>Téléphone :</strong> 06 71 94 23 80
                </p>
            </div>
        </div>

        <div class="col-lg-6">
            <form>
        <div class="form-group">
            <label for="exampleInputEmail1">Adresse Mail</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Numéro de téléphone</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Votre message</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
            <small>Ces informations ne seront pas communiquées à des tiers .</small>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
    </div>
</main>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
?>
