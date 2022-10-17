<?php

use app\service\AuthService;
?>

<div class="pt-4 bg-primary pb-3">
    <div class="container">
        <h1 class="blog-post-title mb-3 text-light"><?= $object1->title ?></h1>
    </div>
</div>

<div class="pt-4 bg-light pb-5">

    <div class="container">
        <div>

            <?php if (isset($_SESSION['user']['erreur'])) {
                echo '<div class="alert alert-danger mt-3" role="alert">' . $_SESSION['user']['erreur'] . '</div>';
                unset($_SESSION['user']['erreur']);
            }
            ?>

            <?php if (isset($_SESSION['user']['message'])) {
                echo '<div class="alert alert-success mt-3" role="alert">' . $_SESSION['user']['message'] . '</div>';
                unset($_SESSION['user']['message']);
            }
            ?>

            <p class="fw-semibold fs-5 text-secondary"><?= $object1->description ?></p>
            <p class="blog-post-meta text-secondary"><small>Posté le <?= $object1->creationDate ?>
                    par <a href="<?= ROOT ?>user/profile/<?= $object1->user ?>"><?= $object1->author ?></a></small>
            </p>

            <?php foreach ($object3 as $image) : ?>
            <figure class="px-3">
                <img src="<?= ROOT ?>public/upload/<?= $image->url ?>" class="img-fluid"
                    alt="Image <?= $object1->title ?>">
            </figure>
            <?php endforeach; ?>

            <p><?= nl2br($object1->text) ?></p>

            <p class="text-secondary"><small>Dernière mise à jour : <?= $object1->updateDate ?></small></p>
        </div>

        <div class="list-group mt-5 mb-5 col-md-8">
            <h5 class="ps-3 mb-3">Vos commentaires</h5>

            <?php if (!empty($object2)) : ?>
            <?php foreach ($object2 as $comment) : ?>
            <div class="ms-2 list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">
                        <?= $comment->title ?></a>
                    </h5>
                </div>
                <p class="mb-1"><?= $comment->text ?>
                </p>
                <small>Posté le <?= $comment->creationDate ?> par <?= $comment->author ?></small>
            </div>
            <?php endforeach; ?>
            <?php else : ?>
            <p class="text-muted text-left">
                Aucun commentaire actuellement
            </p>
            <?php endif; ?>
        </div>

        <?php if ((isset($_SESSION['user']['id'])) && !empty(($_SESSION['user']['id']))) : ?>
        <div class=" bg-light px-3 col-md-8">
            <h5 class="pt-2">Laisser un commentaire</h5>
            <form action="<?= ROOT ?>post/comment" method="post">
                <input type="hidden" name="article" value="<?= $object1->id ?>">
                <input type="hidden" name="slug" value="<?= $object1->slug ?>">

                <?php
                    AuthService::isActiveSession();
                    ?>

                <input type="hidden" name="lastname" value="<?= ($_SESSION['user']['lastname']) ?? '' ?>">
                <input type="hidden" name="firstname" value="<?= ($_SESSION['user']['firstname']) ?? '' ?>">

                <div class="row">
                    <div class="mb-3 col-5">
                        <label for="title" class="form-label">Titre de votre commentaire</label>
                        <input type="text" class="form-control" name="title" maxlength="<?= SHORT_INPUT ?>"
                            aria-describedby="titleHelp">
                        <div id="titleHelp" class="form-text"><?= SHORT_INPUT ?> caractères maximum</div>
                    </div>

                    <div class="mb-3 col-10">
                        <label for="text" class="form-label">Votre commentaire</label>
                        <textarea class="form-control" name="text" placeholder="Ecrivez votre texte ici"
                            rows="3"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 col-5">
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </div>
                </div>
            </form>
            <?php else : ?>
            <p class="text-muted text-left">
                Pour laisser un commentaire
                <a href="<?= ROOT ?>register">Inscrivez-vous</a> ou
                <a href="<?= ROOT ?>login">connectez-vous</a>
            </p>
            <?php endif ?>
        </div>
    </div>
</div>