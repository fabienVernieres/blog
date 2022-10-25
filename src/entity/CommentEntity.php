<?php

/**
 * CommentEntity File Doc Comment
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
 * CommentEntity
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class CommentEntity
{
    private int $_id;
    private int $_article;
    private string $_text;
    private bool $_valid;

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
     * @param int $article id de l'article commenté
     *
     * @return self
     */
    public function setArticle(int $article): self
    {
        $this->_article = $article;

        return $this;
    }

    /**
     * Get the value of text
     * 
     * @return string
     */
    public function getText(): string
    {
        return $this->_text;
    }

    /**
     * Set the value of text
     * 
     * @param string $text texte du commentaire
     *
     * @return self
     */
    public function setText(string $text): self
    {
        $this->_text = $text;

        return $this;
    }

    /**
     * Get the value of valid
     * 
     * @return int
     */
    public function getValid(): int
    {
        return $this->_valid;
    }

    /**
     * Set the value of valid
     * 
     * @param int $valid prend la valeur de 0 ou 1 pour un commentaire validé
     *
     * @return self
     */
    public function setValid(int $valid): self
    {
        $this->_valid = $valid;

        return $this;
    }
}