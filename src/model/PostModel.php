<?php

/**
 * PostModel File Doc Comment
 * 
 * Model pour la gestion des posts (obtenir, ajout, modification, ...)
 * 
 * php version 8.0.0
 * 
 * @category Model
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */

namespace app\model;

use stdClass;
use app\entity\PostEntity;
use app\service\AuthService;

/**
 * PostModel
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class PostModel extends MainModel
{
    /**
     * Liste de posts
     * 
     * @var array
     */
    private $_list = [];

    /**
     * Objet post 
     * 
     * @var stdClass
     */
    private $_post;

    /**
     * Nombre de posts
     * 
     * @var float
     */
    private $_numberPosts;

    /**
     * Ajoute un post
     *
     * @param PostEntity $post     le post
     * @param stdClass   $typePost (article, commentaire, image ou lien)
     * @param string     $category la catégorie du post
     * 
     * @return void
     */
    public function addPost(PostEntity $post, stdClass $typePost, string $category)
    {
        // Rend le slug unique
        $sql = "SELECT * FROM post WHERE slug like :slug ORDER BY id desc";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(
            ['slug' => $post->slug . '%']
        );

        $response = $stmt->fetch();

        $count = $stmt->rowCount();

        if ($count > 0) {
            $responseArray = explode(
                '-',
                $response->slug
            );

            $responseId = end($responseArray);

            $post->slug
                .= (is_numeric($responseId))
                ? '-' . ($responseId + 1) :  '-2';
        }

        // Insère le post
        $post = get_object_vars($post);

        $sql = self::insertArray(
            'post',
            $post
        );

        $statement = $this->pdo->prepare($sql);
        $statement->execute($post);

        // Insère le typePost (article, comment, image, link)
        $typePost->id = $this->pdo->lastInsertId();
        $typePost = get_object_vars($typePost);

        $sql = self::insertArray(
            $category,
            $typePost
        );

        $statement = $this->pdo->prepare($sql);
        $statement->execute($typePost);
    }

    /**
     * Retourne une liste de posts
     *
     * @param string $category  catégorie
     * @param string $start     début
     * @param int    $number    nombre de posts
     * @param string $zone      zone
     * @param int    $userId    id de l'utilisateur
     * @param int    $articleId numéro de l'article
     * 
     * @return array
     */
    public function listPosts(string $category, ?string $start, ?int $number, ?string $zone, ?int $userId, ?int $articleId): array
    {
        switch ($category) {
            case 'articles':
                if ($zone == 'admin' || !empty($userId)) {
                    $zone = "WHERE post.user = $userId";
                }
                // Début et limite de recherche pour la pagination
                if ($number !== null) {
                    $start
                        = ($start > 0)
                        ? (($start - 1) * $number) : '0';

                    $limit = "LIMIT $start , $number";
                } else {
                    $limit = '';
                }

                $sql = "SELECT post.id AS id, 
                    post.category AS category, 
                    post.user AS user, 
                    post.title AS title, 
                    post.slug AS slug, 
                    DATE_FORMAT(post.creationDate, '%d/%m/%Y à %Hh%m') AS creationDate, 
                    article.description AS description, 
                    article.text AS text, 
                    DATE_FORMAT(article.updateDate, '%d/%m/%Y à %Hh%m') AS updateDate, 
                    image.url AS image 
                    FROM post 
                    JOIN article ON article.id = post.id 
                    LEFT JOIN image ON image.article = post.id 
                    $zone 
                    ORDER BY id DESC 
                    $limit";
                break;
            case 'comments':
                if ($zone == 'admin') {
                    $zone = "WHERE article.user = $userId AND valid = 0";
                }
                if ($articleId) {
                    $zone = "WHERE comment.article = :id and valid = 1";
                }
                $sql = "SELECT post.id AS id, 
                    post.author AS author, 
                    post.title AS title, 
                    post.slug, 
                    DATE_FORMAT(post.creationDate, '%d/%m/%Y à %Hh%m') 
                    AS creationDate, 
                    comment.text AS text, 
                    article.id AS articleId, 
                    article.title AS articleTitle, 
                    article.slug AS articleSlug  
                    FROM post 
                    JOIN comment ON comment.id = post.id 
                    JOIN post AS article ON article.id = comment.article 
                    $zone 
                    ORDER BY id DESC";
                break;
            case 'links':
                $sql = "SELECT post.id AS id, 
                    post.user AS user, 
                    post.title AS title, 
                    post.slug AS slug, 
                    DATE_FORMAT(post.creationDate, '%d %m %Y') 
                    AS creationDate, 
                    link.url AS url 
                    FROM post 
                    JOIN link ON link.id = post.id 
                    WHERE post.user = $userId
                    ORDER BY id DESC";
                break;
            case 'images':
                if ($zone === 'admin') {
                    $zone = "WHERE post.user = $userId";
                }
                if ($articleId) {
                    $zone = "WHERE image.article = :id";
                }
                $sql = "SELECT post.id AS id, 
                    post.user AS user, 
                    post.title AS title, 
                    post.slug AS slug, 
                    DATE_FORMAT(post.creationDate, '%d/%m/%Y à %Hh%m') 
                    AS creationDate, 
                    image.url AS url 
                    FROM post 
                    JOIN image ON image.id = post.id  
                    $zone 
                    ORDER BY id DESC";
                break;
            default:
                header('Location: ' . ROOT . '');
        }

        $statement = $this->pdo->prepare(($sql));
        if ($articleId) {
            $statement->execute(
                ['id' => $articleId]
            );
        } else {
            $statement->execute();
        }
        return $this->_list = $statement->fetchAll();
    }

    /**
     * Retourne un post
     *
     * @param string $slug slug dy post
     * @param string $zone zone
     * 
     * @return object
     */
    public function getPost(string $slug, string $zone = null): object
    {
        // Vérifie si le post existe
        $sql = "SELECT category, user 
               FROM post 
               WHERE slug = :slug";

        $statement = $this->pdo->prepare($sql);

        $statement->execute(
            ['slug' => $slug]
        );

        $response = $statement->fetch();

        if ($response == false) {
            header('Location: ' . ROOT . '');
            exit;
        }

        // Requête SQL en fonction du type de post (article, comment, image ou link)
        switch ($response->category) {
            case 1:
                $sql = "SELECT post.id AS id, 
                    post.user AS user, 
                    post.author AS author, 
                    post.title AS title, 
                    post.slug AS slug, 
                    DATE_FORMAT(post.creationDate, '%d/%m/%Y à %Hh%m') 
                    AS creationDate, 
                    article.description AS description, 
                    article.text AS text, 
                    DATE_FORMAT(article.updateDate, '%d/%m/%Y à %Hh%m') 
                    AS updateDate, 
                    category.slug AS category 
                    FROM post
                    LEFT JOIN article ON article.id = post.id 
                    LEFT JOIN category ON category.id = post.category 
                    WHERE post.slug = :slug";
                break;
            case 2:
                $sql = "SELECT post.id AS id, 
                    post.author AS author, 
                    post.title AS title, 
                    post.slug AS slug, 
                    comment.text AS text, 
                    category.slug AS category, 
                    article.user AS user 
                    FROM post
                    JOIN comment ON comment.id = post.id 
                    JOIN category ON category.id = post.category 
                    JOIN post AS article ON article.id = comment.article 
                    WHERE post.slug = :slug";
                break;
            case 3:
                $sql = "SELECT post.id AS id, 
                    post.user AS user, 
                    post.title AS title, 
                    post.slug AS slug, 
                    DATE_FORMAT(post.creationDate, '%d/%m/%Y à %Hh%m') 
                    AS creationDate, 
                    image.url AS url, 
                    category.slug AS category 
                    FROM post 
                    JOIN image ON image.id = post.id 
                    JOIN category ON category.id = post.category 
                    WHERE post.slug = :slug";
                break;
            case 4:
                $sql = "SELECT post.id AS id, 
                    post.user AS user, 
                    post.title AS title, 
                    post.slug AS slug, 
                    DATE_FORMAT(post.creationDate, '%d/%m/%Y à %Hh%m') 
                    AS creationDate, 
                    link.url AS url, 
                    category.slug AS category 
                    FROM post 
                    JOIN link ON link.id = post.id 
                    JOIN category ON category.id = post.category 
                    WHERE post.slug = :slug";
                break;
        }

        // Prépare et exécute la requête SQL
        $statement = $this->pdo->prepare($sql);

        $statement->execute(
            ['slug' => $slug]
        );

        $response = $statement->fetch();

        AuthService::isActiveSession();

        if (
            $zone === 'admin'
            && $response->user !== $_SESSION['user']['id']
        ) {
            header('Location: ' . ROOT . '');
            exit;
        } else {
            $this->_post = $response;
        }

        // Retourne le post
        return $this->_post;
    }

    /**
     * Met à jour un post
     *
     * @param int        $id       id du post
     * @param string     $category catégorie du post
     * @param PostEntity $post     objet post
     * @param mixed      $article  objet article
     * 
     * @return void
     */
    public function updatePost(int $id, string $category, PostEntity $post, $article): void
    {
        $post = get_object_vars($post);

        $sql = self::updateArray(
            'post',
            $post
        );

        $post['id'] = $id;

        $statement = $this->pdo->prepare($sql);

        $statement->execute($post);

        $article = get_object_vars($article);

        $sql = self::updateArray(
            $category,
            $article
        );

        $article['id'] = $id;

        $statement = $this->pdo->prepare($sql);

        $statement->execute($article);
    }

    /**
     * Supprime un post
     *
     * @param int $id id du post
     * 
     * @return void
     */
    public function deletePost(int $id): void
    {
        $sql = "DELETE FROM post WHERE id = :id";

        $statement = $this->pdo->prepare($sql);

        $statement->execute(
            ['id' => $id]
        );
    }

    /**
     * Valide un commentaire
     *
     * @param int $id id du commentaire
     * 
     * @return void
     */
    public function validComment(int $id): void
    {
        $sql = "UPDATE comment SET valid = 1 WHERE id = :id";

        $statement = $this->pdo->prepare($sql);

        $statement->execute(
            ['id' => $id]
        );
    }


    /**
     * Compte le nombre de post d'une catégorie
     *
     * @param int $category catégorie
     * 
     * @return void
     */
    public function countPosts(int $category): float
    {
        $sql = "SELECT * FROM post WHERE category = :category";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(
            ['category' => $category]
        );

        $this->numberPosts = floatval($stmt->rowCount());

        return floor($this->numberPosts / NUMBER_ITEMS_LIST_PAGE);
    }
}