<?php

/**
 * LinkEntity File Doc Comment
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
 * LinkEntity
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class LinkEntity
{
    private int $_id;
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
     * @param string $url url du lien
     *
     * @return self
     */
    public function setUrl(string $url): self
    {
        $this->_url = $url;

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