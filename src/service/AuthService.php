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
    private static array $_session;


    /**
     * Démarre une session si aucune active
     *
     * @return void
     */
    public static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        self::$_session = filter_var_array($_SESSION);
    }

    /**
     * Get the value of _session
     * 
     * @return array
     */
    public static function getSession(): array
    {
        return self::$_session;
    }

    /**
     * Set the value of _session
     * 
     * @param array $session 
     * 
     * @return void
     */
    public static function setSession(array $session): void
    {
        $_SESSION = $session;
    }

    /**
     * Update Session
     *
     * @param string $type    Message de confirmation ou d'erreur
     * @param string $message Le message
     * 
     * @return void
     */
    public static function updateSession(string $type, string $message): void
    {
        $_SESSION['user'][$type] = $message;
    }

    /**
     * Vérifie si l'utilisateur est un utilisateur enregistré 
     * et contrôle son rôle
     *
     * @param string $role rôle de l'utilisateur
     * 
     * @return void
     */
    public static function isUser(string $role): void
    {
        if (isset(self::$_session['user'])) {
            $roles = explode(',', self::$_session['user']['role']);
            if (!in_array($role, $roles)) {
                header('Location: ' . ROOT . '');
                exit;
            }
        }

        if (!isset(self::$_session['user'])) {
            header('Location: ' . ROOT . '');
            exit;
        }
    }

    /**
     * Vérifie si l'utilisateur est un administrateur
     *
     * @return bool
     */
    public static function isAdmin(): bool
    {
        // tableau des rôles de l'utilisateur
        $roles = [];

        if (!empty(self::$_session['user']['role'])) {
            $roles = explode(',', self::$_session['user']['role']);
        }
        return in_array('admin', $roles);
    }
}