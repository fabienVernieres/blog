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
 * @author   Vernières fabien <fabienvernieres@gmail.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */

namespace app\controller;

use stdClass;
use app\model\PostModel;
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
 * @author   Vernières fabien <fabienvernieres@gmail.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class FormController extends AdminController
{
    /**
     * Id de l'utilisateur
     * 
     * @var int
     */
    private $_userId = '';

    /**
     * Vérifie si l'utilisateur est un administrateur
     *
     * @return void
     */
    public function __construct()
    {
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
        $post    = new PostEntity();
        $article = new stdClass();

        // Contrôle les donnes reçues
        if (
            !empty($_POST['title'])
            && !empty($_POST['description'])
            && !empty($_POST['text'])
        ) {
            $post->category = 1;
            $post->user = $this->_userId;

            $post->author = FormService::controlInputText(
                $_POST['author'],
                SHORT_INPUT
            );

            $post->title = FormService::controlInputText(
                $_POST['title'],
                SHORT_INPUT
            );

            $post->slug = Transliterator::urlize(
                $post->title
            );

            $article->description = FormService::controlInputText(
                $_POST['description'],
                MEDIUM_INPUT
            );

            $article->text
                = FormService::controlInputText(
                    $_POST['text'],
                    LONG_INPUT
                );
        } else {
            $_SESSION['user']['erreur'] = "Merci de remplir tous les 
            champs du formulaire";

            header('Location: ' . ROOT . 'form/add/article');
            exit;
        }

        // Ajoute l'article
        $newPost = new PostModel();

        $newPost->addPost(
            $post,
            $article,
            'article'
        );

        // Recherche l'id de l'article
        $lastPost = new PostModel();

        $lastPost = $lastPost->getPost($post->slug);

        // Ajoute l'image liée à l'article
        if (!empty($_FILES["fileToUpload"]["name"])) {
            $this->addImage(
                $lastPost->id,
                'image'
            );
        }

        // Message de confirmation et redirection
        $_SESSION['user']['message'] = "Post ajouté";

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
        $post     = new PostEntity();
        $article  = new ArticleEntity();
        $id       = $_POST['id'];
        $slug     = $_POST['slug'];
        $category = $_POST['category'];

        // Contrôle les donnes reçues
        if (
            !empty($_POST['title'])
            && !empty($_POST['author'])
            && !empty($_POST['description'])
            && !empty($_POST['text'])
        ) {
            $post->title
                = FormService::controlInputText(
                    $_POST['title'],
                    SHORT_INPUT
                );

            $post->author
                = FormService::controlInputText(
                    $_POST['author'],
                    SHORT_INPUT
                );

            $article->description
                = FormService::controlInputText(
                    $_POST['description'],
                    MEDIUM_INPUT
                );

            $article->text
                = FormService::controlInputText(
                    $_POST['text'],
                    LONG_INPUT
                );
        } else {
            $_SESSION['user']['erreur'] = "Merci de remplir tous les champs 
            du formulaire";

            header('Location: ' . ROOT . 'form/update/' . $slug);
            exit;
        }

        // Modifie l'article
        $newPost = new PostModel();

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
        $_SESSION['user']['message'] = "Post modifié";

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

        // Contrôle les donnes reçues
        if (
            !empty($_POST['title'])
            && !empty($_POST['url'])
        ) {
            $post->category = 4;
            $post->user     = $this->_userId;

            $post->title
                = FormService::controlInputText(
                    $_POST['title'],
                    SHORT_INPUT
                );

            $post->slug
                = Transliterator::urlize(
                    $post->title
                );

            $link->url
                = FormService::controlInputText(
                    $_POST['url'],
                    MEDIUM_INPUT
                );
        } else {
            $_SESSION['user']['erreur']
                = "Merci de remplir tous les champs du formulaire";

            header('Location: ' . ROOT . 'form/add/link');
            exit;
        }

        // Ajoute le lien
        $newPost = new PostModel();

        $newPost->addPost(
            $post,
            $link,
            'link'
        );

        // Message de confirmation et redirection
        $_SESSION['user']['message'] = "Lien ajouté";

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
        $post = new PostEntity();
        $link = new ArticleEntity();

        // Identifiants du lien
        $id       = $_POST['id'];
        $slug     = $_POST['slug'];
        $category = $_POST['category'];

        // Contrôle les donnes reçues
        if (!empty($_POST['title']) && !empty($_POST['url'])) {
            $post->title
                = FormService::controlInputText(
                    $_POST['title'],
                    SHORT_INPUT
                );

            $post->slug
                = FormService::controlInputText(
                    $_POST['slug'],
                    SHORT_INPUT
                );

            $link->url
                = FormService::controlInputText(
                    $_POST['url'],
                    LONG_INPUT
                );
        } else {
            $_SESSION['user']['erreur'] = "Merci de remplir tous les champs 
            du formulaire";

            header('Location: ' . ROOT . 'form/update/' . $slug);
            exit;
        }

        // Modifie le lien
        $newPost = new PostModel();

        $newPost->updatePost(
            $id,
            $category,
            $post,
            $link
        );

        // Message de confirmation et redirection
        $_SESSION['user']['message'] = "Lien modifié";

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
        if (!empty($_FILES["fileToUpload"]["name"])) {
            // Initie $file, $post et $image
            $file           = pathinfo(basename($_FILES["fileToUpload"]["name"]));
            $post           = new PostEntity();
            $image          = new stdClass();
            $post->category = 3;
            $post->user     = $this->_userId;
            $post->title
                = (!empty($imageName))
                ? $imageName : 'avatar';

            // Ajoute l'id de l'utilisateur au début du slug de l'image
            $post->slug = $this->_userId . '-'
                . Transliterator::urlize($file['filename']);

            // Si l'image est liée à un article, 
            // on ajoute le numéro de ce dernier à la fin du slug
            $post->slug
                = (!empty($article))
                ? $post->slug . '-' . $article : $post->slug;

            $image->article
                = (!empty($article))
                ? $article : null;

            // Nom complet du fichier
            $image->url = $post->slug . '.' . $file['extension'];

            // Dossier de destination
            $target_dir = 'upload/';

            $target_file = $target_dir . $image->url;

            $uploadOk = 1;

            // Type du fichier
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Vérifie si le fichier est une image
            if (isset($_POST["submit"])) {
                $check
                    = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $_SESSION['user']['erreur'] = "Mauvais format de fichier.";

                    $uploadOk = 0;
                }
            }

            // Vérifie si le fichier existe déjà
            if (file_exists($target_file)) {
                $_SESSION['user']['erreur'] = "Image déjà enregistrée.";
                $uploadOk = 0;
            }

            // Contrôle le poids de l'image
            if ($_FILES["fileToUpload"]["size"] > IMAGE_MAX_WEIGHT) {
                $_SESSION['user']['erreur'] = "Votre image est trop volumineuse.";

                $uploadOk = 0;
            }

            // Autorise certains formats de fichier
            if (
                $imageFileType != "jpg"
                && $imageFileType != "png"
                && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                $_SESSION['user']['erreur'] = "Désolé, votre image doit 
                être de format JPG, JPEG, PNG ou GIF. Les autres formats 
                sont refusés.";

                $uploadOk = 0;
            }

            // Ajoute l'image si tout est ok
            if ($uploadOk == 1) {
                if (
                    move_uploaded_file(
                        $_FILES["fileToUpload"]["tmp_name"],
                        $target_file
                    )
                ) {
                    $_SESSION['user']['message'] = "Image ajoutée";

                    $newImage = new PostModel();

                    $newImage->addPost(
                        $post,
                        $image,
                        'image'
                    );
                } else {
                    $_SESSION['user']['erreur'] = "Désolé, votre image n'a 
                    pu être téléchargé.";
                }
            }

            if (empty($article)) {
                header('Location: ' . ROOT . 'account#avatar');
                exit;
            }
        } else {
            $_SESSION['user']['erreur'] = "Aucun fichier choisi";

            header('Location: ' . ROOT . 'account');
            exit;
        }
    }
}