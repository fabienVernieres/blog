<?php

/**
 * AvatarModel File Doc Comment
 * 
 * Recherche l'avatar de l'utilisateur
 * 
 * php version 8.0.0
 * 
 * @category Model
 * @package  Blog
 * @author   Vernières fabien <fabienvernieres@gmail.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */

namespace app\model;

use stdClass;

/**
 * AvatarModel
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <fabienvernieres@gmail.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class AvatarModel extends MainModel
{
    /**
     * Objet avatar
     * 
     * @var stdClass 
     */
    private $_avatar;

    /**
     * Cherche l'avatar de l'utilisateur
     *
     * @param int $userId id de l'utilisateur
     * 
     * @return stdClass
     */
    public function get(int $userId): ?stdClass
    {
        $sql = "SELECT 
                post.id AS id, 
                post.user AS user, 
                post.title AS title, 
                post.slug AS slug, 
                DATE_FORMAT(post.creationDate, '%d/%m/%Y à %Hh%m') AS creationDate, 
                image.url AS url, 
                category.slug AS category 
                FROM post 
                JOIN image ON image.id = post.id 
                JOIN category ON category.id = post.category 
                WHERE post.user = :id AND post.title = 'avatar'";

        $statement = $this->pdo->prepare(($sql));

        $statement->execute(
            ['id' => $userId]
        );

        $response = $statement->fetch();

        if ($response !== false) {
            $this->_avatar = $response;
        }
        return $this->_avatar;
    }
}