<?php if ($isAdmin === true) : ?>

<?php require '../src/view/admin/header.php'; ?>

<?php else : ?>

<div class="pt-4 bg-primary pb-3">
    <div class="container">
        <h1 class="text-light mb-3"><?= $pageTitle ?></h1>
    </div>
</div>

<div class="pt-4 bg-light pb-5">

    <div class="container">

        <?php endif; ?>

        <h2>Vos informations</h2>

        <?php if (isset($session['user']['erreur'])) : ?>
        <div class="alert alert-danger mt-3" role="alert">
            <?= $session['user']['erreur'] ?>
        </div>
        <?php endif; ?>

        <?php if (isset($session['user']['message'])) : ?>
        <div class="alert alert-success mt-3" role="alert">
            <?= $session['user']['message'] ?>
        </div>
        <?php endif; ?>

        <form action="<?= ROOT ?>account/update" method="post">
            <div class="row">
                <div class="mb-3 col-md-5">
                    <label for="lastname" class="form-label">Votre nom</label>
                    <input type="text" class="form-control" name="lastname" maxlength="<?= SHORT_INPUT ?>"
                        aria-describedby="lastnameHelp" value="<?= $object1->lastname ?>">
                    <div id="lastnameHelp" class="form-text"><?= SHORT_INPUT ?> caractères maximum</div>
                </div>
                <div class="mb-3 col-md-5">
                    <label for="firstname" class="form-label">Votre prénom</label>
                    <input type="text" class="form-control" name="firstname" maxlength="<?= SHORT_INPUT ?>"
                        aria-describedby="firstnameHelp" value="<?= $object1->firstname ?>">
                    <div id="firtsnameHelp" class="form-text"><?= SHORT_INPUT ?> caractères maximum</div>
                </div>
                <div class="mb-3 col-md-10">
                    <label for="description" class="form-label">Une phrase qui vous résume</label>
                    <input type="text" class="form-control" name="description" maxlength="<?= MEDIUM_INPUT ?>"
                        aria-describedby="descriptionHelp" value="<?= $object1->description ?>">
                    <div id="descriptionHelp" class="form-text"><?= MEDIUM_INPUT ?> caractères maximum - exemple
                        :
                        Martin
                        Durand,
                        le développeur
                        qu’il vous faut !</div>
                </div>
                <div class="mb-3 col-md-5">
                    <label for="email" class="form-label">Votre adresse e-mail</label>
                    <input type="email" class="form-control" name="email" value="<?= $object1->email ?>">
                </div>
                <div class="mb-3 col-md-5">
                    <label for="password" class="form-label">Mot de Passe</label>
                    <input type="password" class="form-control" name="password" maxlength="<?= SHORT_INPUT ?>"
                        aria-describedby="paswwordHelp">
                    <div id="passowrdHelp" class="form-text"><?= MIN_INPUT ?> caractères minimum -
                        <?= SHORT_INPUT ?>
                        caractères
                        maximum</div>
                </div>
                <div class="mb-3 col-md-5">
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </div>
        </form>

        <?php if ($isAdmin === true) : ?>

        <?php require 'avatar.php'; ?>

        <?php require 'links.php'; ?>

        <?php require '../src/view/admin/footer.php'; ?>

        <?php else : ?>

    </div>
</div>

<?php endif; ?>