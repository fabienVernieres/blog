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
 * @author   Vernières fabien <fabienvernieres@gmail.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */

namespace app\controller;

use app\model\PostModel;
use app\entity\PostEntity;
use app\service\FormService;
use app\service\RenderService;
use Behat\Transliterator\Transliterator;
use stdClass;

/**
 * PostController
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <fabienvernieres@gmail.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class PostController
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
        $post = new PostEntity();
        $comment = new stdClass();

        session_start();

        // Contrôle le $_POST slug
        if (!empty($_POST['slug'])) {
            $slug = FormService::controlInputText(
                $_POST['slug'],
                MEDIUM_INPUT
            );
        } else {
            header('Location: ' . ROOT . '');
            exit;
        }

        // Contrôle les données $_POST
        if (
            !empty($_POST['title'])
            && !empty($_POST['text'])
            && !empty($_POST['lastname'])
            && !empty($_POST['firstname'])
        ) {
            $post->category = 2;

            if (!empty($_SESSION['user']['id'])) {
                $post->user = $_SESSION['user']['id'];
            }
            $post->author
                = FormService::controlInputText(
                    $_POST['firstname'],
                    SHORT_INPUT
                ) . ' ' . FormService::controlInputText(
                    $_POST['lastname'],
                    SHORT_INPUT
                );

            $post->title
                = FormService::controlInputText(
                    $_POST['title'],
                    SHORT_INPUT
                );

            $post->slug
                = Transliterator::urlize(
                    $post->title
                );

            $comment->article = $_POST['article'];

            $comment->text
                = FormService::controlInputText(
                    $_POST['text'],
                    LONG_INPUT
                );
        } else {
            $_SESSION['user']['erreur'] = "Merci de remplir tous les champs 
            du formulaire";

            header('Location: ' . ROOT . $slug);
            exit;
        }

        // Ajoute le commentaire
        $newPost = new PostModel();

        $newPost->addPost(
            $post,
            $comment,
            'comment'
        );

        // Message de confirmation et redirection
        $_SESSION['user']['message'] = "Merci pour votre commentaire, il 
        sera approuvé avant publication";

        header('Location: ' . ROOT . $slug);
        exit;
    }
}