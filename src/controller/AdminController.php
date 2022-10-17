<?php

/**
 * AdminController File Doc Comment
 * 
 * Contrôleur de la zone d'administration
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
use app\service\AuthService;
use app\service\RenderService;

/**
 * AdminController
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <fabienvernieres@gmail.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class AdminController
{
    /**
     * ID de l'utilisateur
     * 
     * @var int
     * */
    private $_userId = '';

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->_userId = AuthService::isUser('admin');
    }

    /**
     * Liste les posts de l'utilisateur
     *
     * @return void
     */
    public function index(): void
    {
        // Liste des articles
        $PostModel = new PostModel;

        $listArticles = $PostModel->listPosts(
            'articles',
            null,
            null,
            'admin',
            $this->_userId,
            null
        );

        // Affichage
        $pageTitle = 'Zone d\'administration';

        RenderService::render(
            'admin/admin',
            $pageTitle,
            $listArticles
        );
    }

    /**
     * Liste les commentaires en attente de modération
     *
     * @return void
     */
    public function comment(): void
    {
        // Liste des commentaires
        $PostModel = new PostModel;

        $listComments = $PostModel->listPosts(
            'comments',
            null,
            null,
            'admin',
            $this->_userId,
            null
        );

        // Affichage page de gestion des commentaires
        $pageTitle = 'Gestion des commentaires';

        RenderService::render(
            'admin/comment',
            $pageTitle,
            $listComments
        );
    }

    /**
     * Liste les images de l'utilisateur (avatar et images d'articles)
     *
     * @return void
     */
    public function image(): void
    {
        // Liste des images
        $image = new PostModel;

        $image = $image->listPosts(
            'images',
            null,
            null,
            'admin',
            $this->_userId,
            null
        );

        // Affichage de la galerie
        $pageTitle = 'Vos images';

        RenderService::render(
            'admin/image',
            $pageTitle,
            $image
        );
    }

    /**
     * Supprime un poste
     *
     * @param string $slug slug du post
     * 
     * @return void
     */
    public function delete(string $slug): void
    {
        // Recherche le post à supprimer
        $PostModel = new PostModel;

        $post = $PostModel->getPost(
            $slug,
            'admin'
        );

        // Recherche les images liées à ce post
        $fileToDelete = new PostModel;

        $files = $fileToDelete->listPosts(
            'images',
            null,
            null,
            null,
            null,
            $post->id
        );

        foreach ($files as $file) {
            unlink('upload/' . $file->url);
        }

        // Supprime le post
        $PostModel->deletePost($post->id);

        // Supprime les images liées
        if ($post->category == 'image') {
            unlink('upload/' . $post->url);
        }

        // Sélectionne l'url de destination
        $category = 'admin/' . $post->category;

        $category
            = ($post->category == 'image' && $post->title == 'avatar')
            ? 'account#avatar' : $category;

        $category
            = ($post->category == 'link')
            ? 'account#links' : $category;

        // Message de confirmation et redirection sur l'url de destination
        $_SESSION['user']['message'] = "Suppression confirmée";

        header('Location: ' . ROOT . $category);
        exit;
    }

    /**
     * Valide un commentaire
     *
     * @param string $slug slug du post
     * 
     * @return void
     */
    public function valid(string $slug): void
    {
        // Recherche le commentaire en question
        $PostModel = new PostModel;

        $post = $PostModel->getPost($slug, 'admin');

        // Valide le commentaire
        $PostModel->validComment(
            $post->id,
            $post->category
        );

        // Sélectionne l'url de destination
        $category = ($post->category == 'article')
            ? '' : '/' . $post->category;

        // Message de confirmation et redirection sur l'url de destination
        $_SESSION['user']['message'] = "Publication confirmée";

        header('Location: ' . ROOT . 'admin' . $category);
        exit;
    }

    /**
     * Liste des utilisateurs
     *
     * @return void
     */
    public function users()
    {
        // Liste des utilisateurs
        $users = new UserModel;

        $users = $users->getUsers();

        // Affichage page de gestion des utilisateurs
        $pageTitle = 'Gestion des utilisateurs';

        RenderService::render(
            'admin/users',
            $pageTitle,
            $users
        );
    }

    /**
     * Valide un utilisateur
     *
     * @param int $id id de l'utilisateur
     * 
     * @return void
     */
    public function validUser(int $id)
    {
        // Validation
        $user = new UserModel;

        $user->validUser($id);

        // Message de confirmation et redirection
        $_SESSION['user']['message'] = "Validation confirmée";

        header('Location: ' . ROOT . 'admin/users');
        exit;
    }

    /**
     * Supprimer un utilisateur
     *
     * @param int $id id de l'utilisateur
     * 
     * @return void
     */
    public function deleteUser(int $id)
    {
        // Suppression
        $user = new UserModel;

        $user->deleteUser($id);

        // Message de confirmation et redirection
        $_SESSION['user']['message'] = "Suppression confirmée";

        header('Location: ' . ROOT . 'admin/users');
        exit;
    }
}