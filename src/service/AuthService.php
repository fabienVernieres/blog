<?php

/**
 * AuthService File Doc Comment
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
 * AuthService
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class AuthService
{
    /**
     * Vérifie si l'utilisateur est un utilisateur enregistré 
     * et contrôle son rôle
     *
     * @param string $role rôle de l'utilisateur
     * 
     * @return int
     */
    public static function isUser(string $role): ?int
    {
        self::isActiveSession();

        if (isset($_SESSION['user']['id'])) {
            $roles = explode(',', $_SESSION['user']['role']);
            if (!in_array($role, $roles)) {
                header('Location: ' . ROOT . '');
                exit;
            }
        } else {
            header('Location: ' . ROOT . '');
            exit;
        }
        return $_SESSION['user']['id'];
    }

    /**
     * Vérifie si l'utilisateur est un administrateur
     *
     * @return bool
     */
    public static function isAdmin(): bool
    {
        if (
            isset($_SESSION['user']['id'])
            && isset($_SESSION['user']['email'])
        ) {
            $roles
                = explode(',', $_SESSION['user']['role']);
            if (in_array('admin', $roles)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Démarre une session si aucune active
     *
     * @return void
     */
    public static function isActiveSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}