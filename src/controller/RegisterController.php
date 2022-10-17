<?php

/**
 * RegisterController File Doc Comment
 * 
 * Contrôleur pour permettre à l'utilisateur de s'inscrire
 * 
 * php version 8.0.0
 * 
 * @category Controller
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */

namespace app\controller;

use app\model\UserModel;
use app\entity\UserEntity;
use app\service\FormService;
use app\service\RenderService;

/**
 * RegisterController
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class RegisterController
{
    /**
     * Affiche le formulaire d'inscription
     *
     * @return void
     */
    public function index(): void
    {
        if (isset($_POST['register'])) {
            $this->controlDataUser();
        } else {
            RenderService::render(
                'user/register'
            );
        }
    }

    /**
     * Contrôle les données reçues
     *
     * @return void
     */
    public function controlDataUser(): void
    {
        // Initie un objet UserEntity
        $user = new UserEntity();

        session_start();

        // Contrôle les données $_POST
        if (
            !empty($_POST['lastname'])
            && !empty($_POST['firstname'])
            && !empty($_POST['description'])
            && !empty($_POST['password'])
        ) {
            $user->lastname = mb_strtoupper(
                FormService::controlInputText(
                    $_POST['lastname'],
                    SHORT_INPUT
                )
            );

            $user->firstname = ucfirst(
                mb_strtolower(
                    FormService::controlInputText(
                        $_POST['firstname'],
                        SHORT_INPUT
                    )
                )
            );

            $user->description = FormService::controlInputText(
                $_POST['description'],
                LONG_INPUT
            );

            if (strlen($_POST['password']) < 8) {
                $_SESSION['user']['erreur'] = "Mot de passe trop court";

                header('Location: ' . ROOT . 'register');
                exit;
            }

            $user->password = FormService::hashPassword(
                $_POST['password']
            );
        } else {
            $_SESSION['user']['erreur'] = "Merci de remplir tous les champs 
            du formulaire";

            header('Location: ' . ROOT . 'register');
            exit;
        }

        if (
            !empty($_POST['email'])
            && FormService::isValidEmail($_POST['email'])
        ) {
            $user->email = $_POST['email'];
        } else {
            $_SESSION['user']['erreur'] = "Adresse e-mail incorrecte";

            header('Location: ' . ROOT . 'register');
            exit;
        }

        // Ajoute l'utilisateur
        $newUser = new UserModel();

        $newUser->addUser($user);
    }
}