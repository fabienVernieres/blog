<?php

/**
 * PostEntity File Doc Comment
 * php version 8.0.0
 * 
 * @category Entity
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */

namespace app\entity;

/**
 * PostEntity
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class PostEntity
{
    private int $_id;
    private int $_category;
    private int $_user;
    private string $_author;
    private string $_title;
    private string $_slug;
    private string $_creationDate;

    /**
     * Get the value of id
     * 
     * @return int
     */
    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * Get the value of category
     * 
     * @return int
     */
    public function getCategory(): int
    {
        return $this->_category;
    }

    /**
     * Set the value of category
     * 
     * @param int $category id de la catégorie
     *
     * @return self
     */
    public function setCategory($category)
    {
        $this->_category = $category;

        return $this;
    }

    /**
     * Get the value of user
     * 
     * @return int
     */
    public function getUser(): int
    {
        return $this->_user;
    }

    /**
     * Set the value of user
     * 
     * @param int $user id de l'utilisateur
     *
     * @return self
     */
    public function setUser($user)
    {
        $this->_user = $user;

        return $this;
    }

    /**
     * Get the value of author
     * 
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->_author;
    }

    /**
     * Set the value of author
     * 
     * @param string $author nom de l'auteur
     *
     * @return self
     */
    public function setAuthor($author)
    {
        $this->_author = $author;

        return $this;
    }

    /**
     * Get the value of title
     * 
     * @return string
     */
    public function getTitle(): string
    {
        return $this->_title;
    }

    /**
     * Set the value of title
     * 
     * @param string $title titre de l'article
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->_title = $title;

        return $this;
    }

    /**
     * Get the value of slug
     * 
     * @return string
     */
    public function getSlug(): string
    {
        return $this->_slug;
    }

    /**
     * Set the value of slug
     * 
     * @param string $slug slug du post
     *
     * @return self
     */
    public function setSlug($slug)
    {
        $this->_slug = $slug;

        return $this;
    }

    /**
     * Get the value of creationDate
     * 
     * @return string
     */
    public function getCreationDate(): string
    {
        return $this->_creationDate;
    }

    /**
     * Set the value of creationDate
     * 
     * @param string $creationDate date de création
     *
     * @return self
     */
    public function setCreationDate($creationDate)
    {
        $this->_creationDate = $creationDate;

        return $this;
    }

    /**
     * Retourne les propriétés d'un objet en tableau associatif
     *
     * @return array
     */
    public function getObjVars(): array
    {
        $array = get_object_vars($this);

        foreach ($array as $key => $value) {
            $newKey = substr($key, 1);
            $array[$newKey] = $value;
            unset($array[$key]);
        }

        return $array;
    }
}