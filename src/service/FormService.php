<?php

/**
 * FormService File Doc Comment
 * php version 8.0.0
 * 
 * @category Service
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */

namespace App\Service;

/**
 * FormService
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class FormService
{
    /**
     * Corrige la chaîne de caractère : caractères spéciaux et longueur
     *
     * @param string $text   texte à contrôler
     * @param int    $length longueur maximum
     * 
     * @return string
     */
    public static function controlInputText(string $text, int $length): string
    {
        return htmlspecialchars(
            strip_tags(
                trim(
                    substr(
                        $text,
                        0,
                        $length
                    )
                )
            ),
            ENT_QUOTES
        );
    }

    /**
     * Vérifie la validité d'une adresse email
     *
     * @param string $email l'adresse email à vérifier
     * 
     * @return bool
     */
    public static function isValidEmail(string $email): bool
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        return (filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    /**
     * Crée une clé de hachage pour un mot de passe
     *
     * @param string $password le mot de passe à traiter
     * 
     * @return string
     */
    public static function hashPassword(string $password): string
    {
        return $password = password_hash(
            FormService::controlInputText(
                $password,
                SHORT_INPUT
            ),
            PASSWORD_DEFAULT
        );
    }
}