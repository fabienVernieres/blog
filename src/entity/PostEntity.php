<?php

/**
 * PostEntity File Doc Comment
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
 * PostEntity
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <fabienvernieres@gmail.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class PostEntity
{
    public int $id;
    public string $category;
    public string $user;
    public string $title;
    public string $slug;
    public string $creationDate;
}