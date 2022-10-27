<?php

/**
 * PostController File Doc Comment
 * 
 * Contrôleur permettant de lire ou lister des posts et 
 * également de commenter un article 
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

use stdClass;
use app\model\PostModel;
use app\entity\PostEntity;
use app\service\AuthService;
use app\service\FormService;
use app\service\RenderService;
use Behat\Transliterator\Transliterator;

/**
 * PostController
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class PostController extends MainController
{
    /**
     * Liste d'articles
     *
     * @param string $start début de la liste
     * 
     * @return void
     */
    public function list(string $start): void
    {
        // La liste
        $PostModel = new PostModel;

        $listArticles = $PostModel->listPosts(
            'articles',
            $start,
            NUMBER_ITEMS_LIST_PAGE,
            null,
            null,
            null
        );

        // Nombre total pour la pagination
        $number = new PostModel;
        $number = $number->countPosts(1);

        // Affichage de la page actualités
        $pageTitle = "Actualités : liste des articles";

        RenderService::render(
            '/article/articles',
            $pageTitle,
            $listArticles,
            $number
        );
    }

    /**
     * Lire un article
     *
     * @param string $slug slug de l'article
     * 
     * @return void
     */
    public function read(string $slug): void
    {
        // L'article
        $PostModel = new PostModel;
        $post = $PostModel->getPost($slug);

        // Les commentaires liés
        $CommentsModel = new PostModel;

        $comments = $CommentsModel->listPosts(
            'comments',
            null,
            null,
            null,
            null,
            $post->id
        );

        // Les images liées
        $ImagesModel = new PostModel;

        $images = $ImagesModel->listPosts(
            'images',
            null,
            null,
            null,
            null,
            $post->id
        );

        // Affichage de l'article
        RenderService::render(
            '/article/article',
            $post->title,
            $post,
            $comments,
            $images
        );
    }

    /**
     * Ajoute un commentaire
     *
     * @return void
     */
    public function comment(): void
    {
        // Initie PostEntity et stdClass
        $post = new PostEntity;
        $comment = new stdClass;

        $slug = $_POST['slug'];

        // Contrôle les données reçues pour le post
        FormService::controlData($post, [
            '1#author# ' . $slug,
            '1#title#' . $slug
        ]);

        $post->setCategory(2);
        $post->setUser($_SESSION['user']['id']);
        $post->setSlug(Transliterator::urlize(
            $post->getTitle()
        ));

        // Contrôle les données reçues pour le commentaire
        FormService::controlData($comment, [
            '1#text# ' . $slug
        ]);

        $comment->article = $_POST['article'];

        // Ajoute le commentaire
        $newPost = new PostModel();

        $newPost->addPost(
            $post,
            $comment,
            'comment'
        );

        // Message de confirmation et redirection
        AuthService::updateSession('message', 'Merci pour votre commentaire, il 
        sera approuvé avant publication');

        header('Location: ' . ROOT . $slug);
        exit;
    }
}