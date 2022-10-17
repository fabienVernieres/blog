<?php

/**
 * UserController File Doc Comment
 * 
 * Contrôleur pour afficher le profil de l'utilisateur
 * 
 * php version 8.0.0
 * 
 * @category Controller
 * @package  Blog
 * @author   Vernières fabien <fabienvernieres@gmail.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */

namespace app\controller;

use app\model\PostModel;
use app\model\UserModel;
use app\model\AvatarModel;
use app\service\RenderService;

/**
 * UserController
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <fabienvernieres@gmail.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class UserController
{
    /**
     * Redirection si aucune méthode
     *
     * @return void
     */
    public function index(): void
    {
        header('Location: ' . ROOT);
        exit;
    }

    /**
     * Affiche le profil de l'utilisateur
     *
     * @param string $profileId id de l'utilisateur
     * 
     * @return void
     */
    public function profile(string $profileId): void
    {
        if (empty($profileId) || !is_numeric($profileId)) {
            header('Location: ' . ROOT . '');
            exit;
        }

        // Le profil
        $profile = new UserModel;

        $profile = $profile->getUser(
            $profileId
        );

        // L'avatar
        $avatarModel = new AvatarModel;

        $profile->image
            = (!empty($avatarModel->get(1)))
            ? $avatarModel->get(1)->url : '';

        // Les liens
        $links = new PostModel;

        $listLinks
            = $links->listPosts(
                'links',
                null,
                null,
                '',
                $profileId,
                null
            );

        // Affichage du profil
        $pageTitle = $profile->firstname . ' ' . $profile->lastname;

        RenderService::render(
            'user/profile',
            $pageTitle,
            $profile,
            $listLinks
        );
    }
}