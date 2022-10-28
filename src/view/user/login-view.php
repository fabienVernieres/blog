<div class="pt-4 bg-primary pb-3">
    <div class="container">
        <h1 class="text-light mb-3">Connectez-vous</h1>
    </div>
</div>

<div class="pt-4 bg-light pb-5">

    <div class="container">

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

        <div class="container bg-light pt-3 ps-4 pb-5">
            <form action="<?= ROOT ?>login/logIn" method="post">
                <div class="row">
                    <div class="mb-3 col-md-5">
                        <label for="email" class="form-label">Votre adresse e-mail</label>
                        <input type="email" class="form-control" name="email" placeholder="nom@exemple.com">
                    </div>
                    <div class="mb-3 col-md-5">
                        <label for="password" class="form-label">Mot de Passe</label>
                        <input type="password" class="form-control" name="password" maxlength="<?= SHORT_INPUT ?>">
                    </div>
                    <div class="mb-3 col-md-5">
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>