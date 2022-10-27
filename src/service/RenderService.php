<?php

/**
 * RenderService File Doc Comment
 * php version 8.0.0
 * 
 * @category Service
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */

namespace app\service;

/**
 * RenderService
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class RenderService
{
    /**
     * Utilise la vue, le contenu et le layout pour afficher le rendu
     *
     * @param string $path      nom de la vue
     * @param string $pageTitle titre de la page
     * @param object $object1   paramètre 1
     * @param object $object2   paramètre 2
     * @param object $object3   paramètre 3
     * 
     * @return void
     */
    public static function render(string $path, string $pageTitle = null, $object1 = null, $object2 = null, $object3 = null)
    {
        AuthService::startSession();
        $session = AuthService::getSession();
        $isAdmin = AuthService::isAdmin();

        $file = '../src/view/' .  $path . '-view.php';

        if (file_exists($file)) {
            ob_start();

            include $file;

            $content = ob_get_clean();

            include '../src/view/' . 'layout-view.php';
        } else {
            header('Location: ' . ROOT . '');
            exit;
        }
        unset($_SESSION['user']['message']);
        unset($_SESSION['user']['erreur']);
    }
}