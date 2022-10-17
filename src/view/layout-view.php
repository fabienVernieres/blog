<?php

use app\service\AuthService;

AuthService::isActiveSession();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (!empty($pageTitle)) ? $pageTitle : BLOG_TITLE ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="<?= ROOT ?>public/style.css">
</head>

<body class="bg-secondary">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark absolute-top">
            <div class="container">

                <button class="navbar-toggler order-2 order-md-1" type="button" data-toggle="collapse"
                    data-target=".navbar-collapse" aria-controls="navbar-left navbar-right" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3 order-md-2" id="navbar-left">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= ROOT ?>">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= ROOT ?>list">Actualités</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= ROOT ?>contact">Contact</a>
                        </li>
                    </ul>
                </div>

                <a class="navbar-brand mx-auto order-1 order-md-3" href="<?= ROOT ?>">Premier Blog</a>

                <div class="collapse navbar-collapse order-4 order-md-4" id="navbar-right">
                    <ul class="navbar-nav ms-auto">

                        <?php if (!isset($_SESSION['user']['id']) && !isset($_SESSION['user']['email'])) : ?>
                        <li class="nav-item">
                            <a href="<?= ROOT ?>register" class="nav-link px-2 text-muted">Inscription</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= ROOT ?>login" class="nav-link px-2 text-muted">Connexion</a>
                        </li>
                        <?php else : ?>
                        <li class="nav-item">
                            <a href="<?= ROOT ?>account" class="nav-link px-2 text-muted">Votre profil</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= ROOT ?>login/logout" class="nav-link px-2 text-muted">Déconnexion</a>
                        </li>
                        <?php endif; ?>



                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <?= $content ?>


    <footer class="py-3 my-4 container">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <?php if (AuthService::isAdmin()) : ?>
            <li class="nav-item">
                <a href="<?= ROOT ?>admin" class="nav-link px-2 text-light">Administration</a>
            </li>
            <?php endif; ?>
        </ul>
        <p class="text-center text-light">&copy; 2022 Fabien Vernières</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.21.1/dist/locale/bootstrap-table-fr-FR.js"></script>
</body>

</html>