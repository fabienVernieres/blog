<?php

/**
 * FormController File Doc Comment
 * 
 * Contrôleur permettant le traitement sécurisé des données envoyées
 * par les formulaires
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
use app\entity\LinkEntity;
use app\entity\PostEntity;
use app\service\AuthService;
use app\service\FormService;
use app\entity\ArticleEntity;
use app\service\RenderService;
use Behat\Transliterator\Transliterator;

/**
 * FormController
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class FormController extends AdminController
{
    /**
     * ID de l'utilisateur
     * 
     * @var int
     * */
    private $_userId;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        AuthService::startSession();
        $this->session = AuthService::getSession();
        $this->_userId = AuthService::isUser('admin');
    }

    /**
     * Affiche le formulaire d'ajout de post
     *
     * @param string $type catégorie du post
     * 
     * @return void
     */
    public function add(string $type): void
    {
        $pageTitle = 'Ajouter un ' . $type;

        RenderService::render(
            '/admin/form-' . $type,
            $pageTitle
        );
    }

    /**
     * Affiche le formulaire pour modifier un post
     *
     * @param string $slug slug du post à modifier
     * 
     * @return void
     */
    public function update($slug): void
    {
        // Les données du post
        $PostModel = new PostModel;
        $post      = $PostModel->getPost(
            $slug,
            'admin'
        );

        // L'image liée au post
        $ImagesModel = new PostModel;
        $images      = $ImagesModel->listPosts(
            'images',
            null,
            null,
            null,
            null,
            $post->id
        );

        // affiche le formulaire
        $pageTitle = 'Modifier votre ' . $post->category;

        RenderService::render(
            '/admin/form-' . $post->category,
            $pageTitle,
            $post,
            $images
        );
    }

    /**
     * Ajoute un article
     * 
     * @return void
     */
    public function addArticle(): void
    {
        $post    = new PostEntity;
        $article = new stdClass;

        // Contrôle les donnes reçues pour le post
        FormService::controlData($post, [
            '1#title#form/add/article',
            '1#author#form/add/article'
        ]);

        $post->setCategory(1);
        $post->setUser($this->_userId);
        $post->setSlug(Transliterator::urlize(
            $post->getTitle()
        ));

        // Contrôle les donnes reçues pour l'article
        FormService::controlData($article, [
            '1#description#form/add/article',
            '1#text#form/add/article'
        ]);

        // Ajoute l'article
        $newPost = new PostModel;

        $newPost->addPost(
            $post,
            $article,
            'article'
        );

        // Recherche l'id de l'article
        $lastPost = new PostModel;

        $lastPost = $lastPost->getPost($post->getSlug());

        // Ajoute l'image liée à l'article
        $file = $_FILES["fileToUpload"]["name"];
        if (!empty($file)) {
            $this->addImage(
                $lastPost->id,
                'image'
            );
        }

        // Message de confirmation et redirection
        AuthService::updateSession('message', 'Post ajouté');

        header('Location: ' . ROOT . 'admin');
        exit;
    }

    /**
     * Modifie un article
     * 
     * @return void
     */
    public function updateArticle(): void
    {
        $post     = new PostEntity;
        $article  = new ArticleEntity;
        $id       = $_POST['id'];
        $slug     = $_POST['slug'];
        $category = $_POST['category'];

        // Contrôle les donnes reçues pour le post
        FormService::controlData($post, [
            '1#title#form/update/' . $slug,
            '1#author#form/update/' . $slug
        ]);

        // Contrôle les donnes reçues pour l'article
        FormService::controlData($article, [
            '1#description#form/update/' . $slug,
            '1#text#form/update/' . $slug
        ]);

        // Modifie l'article
        $newPost = new PostModel;

        $newPost->updatePost(
            $id,
            $category,
            $post,
            $article
        );

        // Ajoute l'image liées à l'article
        if (!empty($_FILES["fileToUpload"]["name"])) {
            $this->addImage(
                $id,
                'image'
            );
        }

        // Message de confirmation et redirection
        AuthService::updateSession('message', 'Post modifié');

        header('Location: ' . ROOT . 'admin');
        exit;
    }

    /**
     * Ajoute un lien
     * 
     * @return void
     */
    public function addLink(): void
    {
        // Initie un objet pour le post et pour le lien
        $post = new PostEntity;
        $link = new stdClass;

        // Contrôle les donnes reçues pour le post
        FormService::controlData($post, [
            '1#title#form/add/link'
        ]);

        $post->setCategory(4);
        $post->setUser($this->_userId);
        $post->setSlug(
            Transliterator::urlize(
                $post->getTitle()
            )
        );

        // Contrôle les donnes reçues pour le link
        FormService::controlData($link, [
            '1#url#form/add/link'
        ]);

        // Ajoute le lien
        $newPost = new PostModel;

        $newPost->addPost(
            $post,
            $link,
            'link'
        );

        // Message de confirmation et redirection
        AuthService::updateSession('message', 'Lien ajouté');

        header('Location: ' . ROOT . 'account#links');
        exit;
    }

    /**
     * Modifie un lien
     * 
     * @return void
     */
    public function updateLink(): void
    {
        // Initie un objet pour le post et pour le lien
        $post = new PostEntity;
        $link = new LinkEntity;

        // Identifiants du lien
        $id       = $_POST['id'];
        $slug     = $_POST['slug'];
        $category = $_POST['category'];

        // Contrôle les donnes reçues
        // Contrôle les donnes reçues pour le post
        FormService::controlData($post, [
            '1#title#form/update/' . $slug
        ]);

        // Contrôle les donnes reçues pour le link
        FormService::controlData($link, [
            '1#url#form/update/' . $slug
        ]);

        // Modifie le lien
        $newPost = new PostModel;

        $newPost->updatePost(
            $id,
            $category,
            $post,
            $link
        );

        // Message de confirmation et redirection
        AuthService::updateSession('message', 'Lien modifié');

        header('Location: ' . ROOT . 'account#links');
        exit;
    }

    /**
     * Ajoute une image
     *
     * @param string $article   id de l'article
     * @param string $imageName nom de l'image
     * 
     * @return void
     */
    public function addImage(string $article = null, string $imageName = null): void
    {
        $fileToUpLoad = $_FILES["fileToUpload"];

        if (!empty($fileToUpLoad)) {
            // Initie $file, $post et $image
            $file           = pathinfo(basename($fileToUpLoad["name"]));
            $post           = new PostEntity;
            $image          = new stdClass;
            $post->setCategory(3);
            $post->setUser($this->_userId);
            $title
                = (!empty($imageName))
                ? $imageName : 'avatar';
            $post->setTitle($title);

            // Ajoute l'id de l'utilisateur au début du slug de l'image
            $slug = $this->_userId . '-'
                . Transliterator::urlize($file['filename']);

            // Si l'image est liée à un article, 
            // on ajoute le numéro de ce dernier à la fin du slug
            $slug
                = (!empty($article))
                ? $slug . '-' . $article : $slug;
            $post->setSlug($slug);

            $image->article
                = (!empty($article))
                ? $article : null;

            // Nom complet du fichier
            $image->url = $post->getSlug() . '.' . $file['extension'];

            // Dossier de destination
            $target_dir = 'upload/';

            $target_file = $target_dir . $image->url;

            $uploadOk = 1;

            // Type du fichier
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Vérifie si le fichier est une image
            if (isset($_POST["submit"])) {
                $check
                    = getimagesize($fileToUpLoad["tmp_name"]);

                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    AuthService::updateSession('erreur', 'Mauvais format de fichier.');

                    $uploadOk = 0;
                }
            }

            // Vérifie si le fichier existe déjà
            if (file_exists($target_file)) {
                AuthService::updateSession('erreur', 'Image déjà enregistrée.');

                $uploadOk = 0;
            }

            // Contrôle le poids de l'image
            if ($fileToUpLoad["size"] > IMAGE_MAX_WEIGHT) {
                AuthService::updateSession('erreur', 'Votre image est trop volumineuse.');

                $uploadOk = 0;
            }

            // Autorise certains formats de fichier
            if (
                $imageFileType != "jpg"
                && $imageFileType != "png"
                && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                AuthService::updateSession('erreur', 'Désolé, votre image doit 
                être de format JPG, JPEG, PNG ou GIF. Les autres formats 
                sont refusés.');

                $uploadOk = 0;
            }

            // Ajoute l'image si tout est ok
            if ($uploadOk == 1) {
                if (
                    move_uploaded_file(
                        $fileToUpLoad["tmp_name"],
                        $target_file
                    )
                ) {
                    AuthService::updateSession('message', 'Image ajoutée');

                    $newImage = new PostModel;

                    $newImage->addPost(
                        $post,
                        $image,
                        'image'
                    );
                } else {
                    AuthService::updateSession('erreur', 'Désolé, votre image n\'a 
                    pu être téléchargé.');
                }
            }

            if (empty($article)) {
                header('Location: ' . ROOT . 'account#avatar');
                exit;
            }
        } else {
            AuthService::updateSession('erreur', 'Aucun fichier choisi');

            header('Location: ' . ROOT . 'account');
            exit;
        }
    }
}