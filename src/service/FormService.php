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

namespace app\service;

use app\service\AuthService;

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
     * Variable contrôlée
     * 
     * @var string
     */
    private static $_data;

    /**
     * Message d'erreur personnalisé
     * 
     * @var string
     */
    private static $_errorMessage;

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
        return
            strip_tags(
                trim(
                    substr(
                        $text,
                        0,
                        $length
                    )
                )
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
        return (filter_var($email, FILTER_SANITIZE_EMAIL));
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
            $password,
            PASSWORD_DEFAULT
        );
    }

    /**
     * Contrôle les données reçues via un formulaire
     *
     * @param mixed $object    objet recevant les données
     * @param array $dataTypes tableau de types de données
     * 
     * @return void
     */
    public static function controlData($object, array $dataTypes): void
    {
        foreach ($dataTypes as $data) {
            // On explose la donnée $data tel que :
            // [0] = champs obligatoire (1) ou non (0)
            // [1] = type de la donnée (title, description, email, ...)
            // [2] = page de retour en cas d'erreur
            $data = explode('#', $data);

            // On traite la donnée
            self::dataFilter($data[1]);

            // On assigne la donnée à la propriété de l'objet
            $objectSetter = 'set' . ucfirst($data[1]);
            if (method_exists($object, $objectSetter)) {
                $object->$objectSetter(self::$_data);
            } else {
                $objectProperty = $data[1];
                $object->$objectProperty = self::$_data;
            }

            // Si la donnée est obligatoire mais manquante
            if ($data[0] == 1) {
                $dataNeeded = $_POST[$data[1]];
                if (!isset($dataNeeded) || empty($dataNeeded)) {
                    AuthService::isActiveSession();
                    $_SESSION['user']['erreur'] = 'Merci de remplir tous les 
                    champs du formulaire';
                    header('Location: ' . ROOT . $data[2]);
                    exit;
                }
            }

            // Si la donnée renvoie un message d'erreur lors du traitement
            if (isset(self::$_errorMessage)) {
                AuthService::isActiveSession();
                $_SESSION['user']['erreur'] = self::$_errorMessage;
                header('Location: ' . ROOT . $data[2]);
                exit;
            }
        }
    }

    /**
     * Traite une donnée dans un format valide et sécurisé
     *
     * @param string $data donnée à traiter en fonction de son type
     * 
     * @return void
     */
    public static function dataFilter(string $data): void
    {
        switch ($data) {
            case 'lastname':
                $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
                self::$_data = mb_strtoupper(
                    self::controlInputText(
                        $lastname,
                        SHORT_INPUT
                    )
                );
                break;

            case 'firstname':
                $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
                self::$_data = ucfirst(
                    mb_strtolower(
                        FormService::controlInputText(
                            $firstname,
                            SHORT_INPUT
                        )
                    )
                );
                break;

            case 'description':
                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
                self::$_data = FormService::controlInputText(
                    $description,
                    MEDIUM_INPUT
                );
                break;

            case 'email':
                self::$_data = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                if (!self::isValidEmail(self::$_data)) {
                    self::$_errorMessage = 'Adresse e-mail incorrecte';
                }
                break;

            case 'password':
                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
                self::$_data = $password;
                if (strlen(self::$_data) < 8) {
                    self::$_errorMessage = 'Mot de passe trop court';
                }
                break;

            case 'title':
                $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
                self::$_data = self::controlInputText(
                    $title,
                    SHORT_INPUT
                );
                break;

            case 'author':
                $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_SPECIAL_CHARS);
                self::$_data = self::controlInputText(
                    $author,
                    SHORT_INPUT
                );
                break;

            case 'text':
                $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_SPECIAL_CHARS);
                self::$_data = self::controlInputText(
                    $text,
                    LONG_INPUT
                );
                break;

            case 'url':
                $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_SPECIAL_CHARS);
                self::$_data = self::controlInputText(
                    $url,
                    MEDIUM_INPUT
                );
                break;
        }
    }
}