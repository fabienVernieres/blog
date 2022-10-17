<?php

/**
 * IndexController File Doc Comment
 * 
 * Contrôleur de la page d'accueil
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
 * IndexController
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <fabienvernieres@gmail.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class IndexController
{
    /**
     * Page d'accueil
     *
     * @return void
     */
    public function index(): void
    {
        // Profile de l'utilisateur 1
        $profile = new UserModel;
        $profile = $profile->getUser(1);

        // Son avatar
        $avatarModel = new AvatarModel;

        $profile->image
            = (!empty($avatarModel->get(1)))
            ? $avatarModel->get(1)->url : '';

        // Ses liens internet
        $links = new PostModel;

        $listLinks = $links->listPosts(
            'links',
            null,
            null,
            null,
            1,
            null
        );

        // Ses derniers posts
        $articles = new PostModel;

        $listArticles
            = $articles->listPosts(
                'articles',
                null,
                NUMBER_ITEMS_INDEX_PAGE,
                null,
                1,
                null
            );

        // Affiche la vue
        $pageTitle = 'Premier Blog';

        RenderService::render(
            'index',
            $pageTitle,
            $profile,
            $listLinks,
            $listArticles
        );
    }
}