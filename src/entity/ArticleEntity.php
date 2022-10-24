<?php

/**
 * ArticleEntity File Doc Comment
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
 * ArticleEntity
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class ArticleEntity
{
    private int $_id;
    private string $_description;
    private string $_text;
    private string $_updateDate;

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
     * Get the value of description
     * 
     * @return string
     */
    public function getDescription(): string
    {
        return $this->_description;
    }

    /**
     * Set the value of description
     * 
     * @param string $description description de l'article
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->_description = $description;

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
     * @param string $text texte de l'article
     *
     * @return self
     */
    public function setText($text)
    {
        $this->_text = $text;

        return $this;
    }

    /**
     * Get the value of updateDate
     * 
     * @return string
     */
    public function getUpdateDate(): string
    {
        return $this->_updateDate;
    }

    /**
     * Set the value of updateDate
     * 
     * @param string $updateDate date de modification
     *
     * @return self
     */
    public function setUpdateDate($updateDate)
    {
        $this->_updateDate = $updateDate;

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