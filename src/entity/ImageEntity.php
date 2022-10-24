<?php

/**
 * ImageEntity File Doc Comment
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
 * ImageEntity
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class ImageEntity
{
    private int $_id;
    private int $_article;
    private string $_url;

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
     * Get the value of article
     * 
     * @return int
     */
    public function getArticle(): int
    {
        return $this->_article;
    }

    /**
     * Set the value of article
     * 
     * @param int $article id de l'article lié
     *
     * @return self
     */
    public function setArticle($article)
    {
        $this->_article = $article;

        return $this;
    }

    /**
     * Get the value of url
     * 
     * @return string
     */
    public function getUrl(): string
    {
        return $this->_url;
    }

    /**
     * Set the value of url
     * 
     * @param string $url url de l'image
     *
     * @return self
     */
    public function setUrl($url)
    {
        $this->_url = $url;

        return $this;
    }
}