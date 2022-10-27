<div class="pt-4 bg-primary pb-3">
    <div class="container">
        <h1 class="text-light mb-3"><?= $pageTitle ?></h1>
    </div>
</div>

<div class="bg-light">

    <div class="row">
        <div class="col-xl-2 col-md-3 bg-dark pt-3">

            <ul class="nav flex-column ps-2 pb-3">
                <li class="list-group-item list-group-item-secondary pt-2 pb-2 ps-3 mb-3">
                    Tableau de bord
                </li>

                <li class="nav-item ps-3 mb-3">
                    <a class="text-light text-decoration-none" href="<?= ROOT ?>admin">Articles</a>
                </li>

                <li class="nav-item ps-3 mb-3">
                    <a class="text-light text-decoration-none" href="<?= ROOT ?>admin/comment">Commentaires</a>
                </li>

                <li class="nav-item ps-3 mb-3">
                    <a class="text-light text-decoration-none" href="<?= ROOT ?>admin/image">Images</a>
                </li>

                <li class="nav-item ps-3 mb-3">
                    <a class="text-light text-decoration-none" href="<?= ROOT ?>admin/users">Utilisateurs</a>
                </li>

                <li class="nav-item ps-3 mb-3">
                    <a class="text-light text-decoration-none" href="<?= ROOT ?>account">Votre compte</a>
                </li>
            </ul>
        </div>

        <div class="col-xl-10 col-md-9 pt-3 ps-4 pb-5">
            <?php if (isset($session['user']['erreur'])) {
                echo '<div class="alert alert-danger mt-3" role="alert">' . $session['user']['erreur'] . '</div>';
                unset($session['user']['erreur']);
            }
            ?>

            <?php if (isset($session['user']['message'])) {
                echo '<div class="alert alert-success mt-3" role="alert">' . $session['user']['message'] . '</div>';
                unset($session['user']['message']);
            }
            ?>