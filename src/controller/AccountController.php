<?php

/**
 * AccountController File Doc Comment
 * 
 * Contrôleur de la page "Votre compte" permettant à l'utilisateur 
 * de voir et modifier ses informations
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

use app\model\PostModel;
use app\model\UserModel;
use app\entity\UserEntity;
use app\model\AvatarModel;
use app\service\AuthService;
use app\service\FormService;
use app\service\RenderService;


/**
 * AccountController
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class AccountController
{
    /** 
     * ID de l'utilisateur
     * 
     * @var int 
     */
    private $_userId;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->_userId = AuthService::isUser('user');
    }

    /**
     * Affiche le compte de l'utilisateur
     *
     * @return void
     */
    public function index(): void
    {
        // Le profil
        $user = new UserModel;

        $user = $user->getUser($this->_userId);

        //Son avatar
        $avatarModel = new AvatarModel;

        $avatar
            = (!empty($avatarModel->get($this->_userId)))
            ? $avatarModel->get($this->_userId) : '';

        // Ses liens internet
        $links = new PostModel;

        $listLinks = $links->listPosts(
            'links',
            null,
            null,
            'admin',
            $this->_userId,
            null
        );

        $pageTitle = "Votre compte";

        RenderService::render(
            'user/account',
            $pageTitle,
            $user,
            $avatar,
            $listLinks
        );
    }

    /**
     * Contrôle des données reçues pour mettre à jour le profil de l'utilisateur
     *
     * @return void
     */
    public function update(): void
    {
        // Initie un objet UserEntity
        $profile = new UserEntity();

        // Contrôle les données $_POST
        if (
            !empty($_POST['lastname'])
            && !empty($_POST['firstname'])
            && !empty($_POST['description'])
            && !empty($_POST['password'])
        ) {
            $profile->lastname = mb_strtoupper(
                FormService::controlInputText(
                    $_POST['lastname'],
                    SHORT_INPUT
                )
            );

            $profile->firstname = ucfirst(
                mb_strtolower(
                    FormService::controlInputText(
                        $_POST['firstname'],
                        SHORT_INPUT
                    )
                )
            );

            $profile->description = FormService::controlInputText(
                $_POST['description'],
                MEDIUM_INPUT
            );

            if (strlen($_POST['password']) < 8) {
                $_SESSION['user']['erreur'] = "Mot de passe trop court";

                header('Location: ' . ROOT . 'account');
                exit;
            }

            $profile->password = FormService::hashPassword(
                $_POST['password']
            );
        } else {
            $_SESSION['user']['erreur'] = "Merci de remplir tous les 
            champs du formulaire";

            header('Location: ' . ROOT . 'account');
            exit;
        }

        // vérifie l'email
        if (
            !empty($_POST['email'])
            && FormService::isValidEmail($_POST['email'])
        ) {
            $profile->email = $_POST['email'];
        } else {
            $_SESSION['user']['erreur'] = "Adresse e-mail incorrecte";

            header('Location: ' . ROOT . 'account');
            exit;
        }

        // Tout est ok, met à jour le profil
        $user = new UserModel;
        $user = $user->updateUser($this->_userId, $profile);
    }
}