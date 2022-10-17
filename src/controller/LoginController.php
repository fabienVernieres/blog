<?php

/**
 * LoginController File Doc Comment
 * 
 * Contrôleur permettant à l'utilisateur de s'authentifier
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
use app\service\FormService;
use app\service\RenderService;

/**
 * LoginController
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class LoginController
{
    /**
     * Affiche le formulaire de connexion
     *
     * @return void
     */
    public function index()
    {
        RenderService::render(
            'user/login'
        );
    }

    /**
     * Connecte l'utilisateir
     *
     * @return void
     */
    public function logIn(): void
    {
        // Contrôle les données reçues
        if (
            $_POST['email']
            && FormService::isValidEmail($_POST['email'])
            && $_POST['password']
        ) {
            $email = $_POST['email'];

            $password = FormService::controlInputText(
                $_POST['password'],
                SHORT_INPUT
            );
        } else {
            session_start();

            $_SESSION['user']['erreur'] = "Merci de remplir tous les champs 
            du formulaire";

            header('Location: ' . ROOT . 'login');
            exit;
        }

        // Envoie les données au model
        $user = new UserModel;

        $user->logUser(
            $email,
            $password
        );
    }

    /**
     * Déconnecte l'utilisateur
     *
     * @return void
     */
    public function logOut(): void
    {
        // Destruction des variables de la session
        session_start();

        session_unset();

        // Redirection vers la page d'accueil
        header('Location: ' . ROOT . '');
        exit;
    }
}