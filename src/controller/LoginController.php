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
use app\entity\UserEntity;
use app\service\AuthService;
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
class LoginController extends MainController
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
        $user = new UserEntity;

        // Contrôle les données $_POST
        FormService::controlData($user, [
            '1#email#login',
            '1#password#login'
        ]);

        // Envoie les données au model
        $userModel = new UserModel;

        $userModel->logUser($user);
    }

    /**
     * Déconnecte l'utilisateur
     *
     * @return void
     */
    public function logOut(): void
    {
        // Destruction des variables de la session
        AuthService::startSession();

        session_unset();

        // Redirection vers la page d'accueil
        header('Location: ' . ROOT . '');
        exit;
    }
}