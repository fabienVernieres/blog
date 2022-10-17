<?php

/**
 * UserEntity File Doc Comment
 * php version 8.0.0
 * 
 * @category Entity
 * @package  Blog
 * @author   Vernières fabien <fabienvernieres@gmail.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */

namespace app\entity;

/**
 * UserEntity
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <fabienvernieres@gmail.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class UserEntity
{
    public string $lastname;
    public string $firstname;
    public string $description;
    public string $email;
    public string $password;
}