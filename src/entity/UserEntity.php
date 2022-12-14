<?php

/**
 * UserEntity File Doc Comment
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
 * UserEntity
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class UserEntity
{
    private int $_id;
    private string $_lastname;
    private string $_firstname;
    private string $_description;
    private string $_email;
    private string $_password;
    private string $_role;
    private int $_valid;

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
     * Get the value of lastname
     * 
     * @return string
     */
    public function getLastname(): string
    {
        return $this->_lastname;
    }

    /**
     * Set the value of lastname
     * 
     * @param string $lastname le nom de famille de l'utilisateur
     *
     * @return self
     */
    public function setLastname(string $lastname): self
    {
        $this->_lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of firstname
     * 
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->_firstname;
    }

    /**
     * Set the value of firstname
     * 
     * @param string $firstname le prénom de l'utilisateur
     *
     * @return self
     */
    public function setFirstname(string $firstname): self
    {
        $this->_firstname = $firstname;

        return $this;
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
     * @param string $description description de l'utilisateur
     *
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->_description = $description;

        return $this;
    }

    /**
     * Get the value of email
     * 
     * @return string
     */
    public function getEmail(): string
    {
        return $this->_email;
    }

    /**
     * Set the value of email
     * 
     * @param string $email adresse mail de l'utilisateur
     *
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->_email = $email;

        return $this;
    }

    /**
     * Get the value of password
     * 
     * @return string
     */
    public function getPassword(): string
    {
        return $this->_password;
    }

    /**
     * Set the value of password
     * 
     * @param string $password le mot de passe de l'utilisateur
     *
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->_password = $password;

        return $this;
    }

    /**
     * Get the value of _role
     * 
     * @return string
     */
    public function get_role(): string
    {
        return $this->_role;
    }

    /**
     * Set the value of _role
     *
     * @return  self
     */
    public function set_role($_role): self
    {
        $this->_role = $_role;

        return $this;
    }

    /**
     * Get the value of _valid
     * 
     * @return int
     */
    public function get_valid(): int
    {
        return $this->_valid;
    }

    /**
     * Set the value of _valid
     *
     * @return  self
     */
    public function set_valid($_valid): self
    {
        $this->_valid = $_valid;

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