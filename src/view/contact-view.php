<?php

use app\service\AuthService;
?>

<div class="pt-4 bg-light pb-5">

    <div class="container">
        <?php
        AuthService::isActiveSession();

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

        <form action="<?= ROOT ?>contact/send" method="post">
            <div class="card col-md-8">
                <div class="card-body">
                    <h5 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                            class="bi bi-envelope" viewBox="0 0 16 16">
                            <path
                                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                        </svg>
                        Envoyez un message
                    </h5>
                    <div class="row">
                        <div class="col-md-5">
                            <label for="lastname" class="form-label">Votre nom</label>
                            <input type="text" name="lastname" class="form-control" placeholder="Nom"
                                aria-label="lastname" />
                        </div>
                        <div class="col-md-5">
                            <label for="firstname" class="form-label">Votre prénom</label>
                            <input type="text" name="firstname" class="form-control" placeholder="Prénom"
                                aria-label="firstname" />
                        </div>
                    </div>

                    <div class="mt-3 mb-3 col-md-10">
                        <label for="email" class="form-label">Votre adresse e-mail</label>
                        <input type="email" name="email" class="form-control" placeholder="nom@exemple.com" />
                    </div>
                    <div class="mb-3 col-md-10">
                        <label for="message" class="form-label">Votre message</label>
                        <textarea class="form-control" name="message" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </div>
        </form>
    </div>
</div>