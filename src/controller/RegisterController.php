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
        $user = new UserEntity;

        // Contrôle les données reçues pour le profil

        FormService::controlData($user, [
            '1#lastname#register',
            '1#firstname#register',
            '1#description#register',
            '1#email#register',
            '1#password#register'
        ]);

        // On hash le password
        $user->setPassword(FormService::hashPassword($user->getPassword()));

        // Ajoute l'utilisateur
        $newUser = new UserModel;

        $newUser->addUser($user);
    }
}