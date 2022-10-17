<div class="pt-4 bg-primary pb-3">
    <div class="container">
        <h1 class="text-light mb-3">Inscription</h1>
    </div>
</div>

<div class="pt-4 bg-light pb-5">

    <div class="container">

        <p class="text-body fs-4">
            Inscrivez-vous et participez à la vie du blog en commentant les articles publiés.
        </p>

        <?php
        session_start();

        if (isset($_SESSION['user']['erreur'])) {
            echo '<div class="alert alert-danger mt-3" role="alert">' . $_SESSION['user']['erreur'] . '</div>';
            unset($_SESSION['user']['erreur']);
        }
        ?>

        <?php if (isset($_SESSION['user']['message'])) {
            echo '<div class="alert alert-success mt-3" role="alert">' . $_SESSION['user']['message'] . '</div>';
            unset($_SESSION['user']['message']);
        }
        ?>

        <div class="container bg-light pt-3 ps-4 pb-5">
            <form action="<?= ROOT ?>register/controlDataUser" method="post">
                <div class="row">
                    <div class="mb-3 col-md-5">
                        <label for="lastname" class="form-label">Votre nom</label>
                        <input type="text" class="form-control" name="lastname" maxlength="<?= SHORT_INPUT ?>"
                            aria-describedby="lastnameHelp">
                        <div id="lastnameHelp" class="form-text"><?= SHORT_INPUT ?> caractères maximum</div>
                    </div>
                    <div class="mb-3 col-md-5">
                        <label for="firstname" class="form-label">Votre prénom</label>
                        <input type="text" class="form-control" name="firstname" maxlength="<?= SHORT_INPUT ?>"
                            aria-describedby="firstnameHelp">
                        <div id="firtsnameHelp" class="form-text"><?= SHORT_INPUT ?> caractères maximum</div>
                    </div>
                    <div class="mb-3 col-md-10">
                        <label for="description" class="form-label">Une phrase qui vous résume</label>
                        <input type="text" class="form-control" name="description" maxlength="<?= LONG_INPUT ?>"
                            aria-describedby="descriptionHelp">
                        <div id="descriptionHelp" class="form-text"><?= LONG_INPUT ?> caractères maximum - exemple :
                            Martin
                            Durand,
                            le développeur
                            qu’il vous faut !</div>
                    </div>
                    <div class="mb-3 col-md-5">
                        <label for="email" class="form-label">Votre adresse e-mail</label>
                        <input type="email" class="form-control" name="email" placeholder="nom@exemple.com">
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
                        <button type="submit" name="register" class="btn btn-primary">S'inscrire</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>