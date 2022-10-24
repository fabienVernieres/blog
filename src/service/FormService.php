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

use app\service\AuthService;
use App\Service\FormService as ServiceFormService;

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
                if (!isset($_POST[$data[1]]) || empty($_POST[$data[1]])) {
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
                self::$_data = mb_strtoupper(
                    self::controlInputText(
                        $_POST['lastname'],
                        SHORT_INPUT
                    )
                );
                break;

            case 'firstname':
                self::$_data = ucfirst(
                    mb_strtolower(
                        FormService::controlInputText(
                            $_POST['firstname'],
                            SHORT_INPUT
                        )
                    )
                );
                break;

            case 'description':
                self::$_data = FormService::controlInputText(
                    $_POST['description'],
                    MEDIUM_INPUT
                );
                break;

            case 'email':
                self::$_data = $_POST['email'];
                if (!self::isValidEmail($_POST['email'])) {
                    self::$_errorMessage = 'Adresse e-mail incorrecte';
                }
                break;

            case 'password':
                self::$_data = $_POST['password'];
                if (strlen($_POST['password']) < 8) {
                    self::$_errorMessage = 'Mot de passe trop court';
                }
                break;

            case 'title':
                self::$_data = self::controlInputText(
                    $_POST['title'],
                    SHORT_INPUT
                );
                break;

            case 'author':
                self::$_data = self::controlInputText(
                    $_POST['author'],
                    SHORT_INPUT
                );
                break;

            case 'text':
                self::$_data = self::controlInputText(
                    $_POST['text'],
                    LONG_INPUT
                );
                break;

            case 'url':
                self::$_data = self::controlInputText(
                    $_POST['url'],
                    MEDIUM_INPUT
                );
                break;
        }
    }
}