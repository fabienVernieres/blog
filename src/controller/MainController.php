<?php

/**
 * MainController File Doc Comment
 * 
 * Contrôleur principal
 * 
 * php version 8.0.0
 * 
 * @category Controller
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */

namespace app\controller;

use app\service\AuthService;

/**
 * MainController
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class MainController
{
    protected array $session;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        AuthService::startSession();
        $this->session = AuthService::getSession();
    }
}