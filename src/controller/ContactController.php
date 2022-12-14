<?php

/**
 * ContactController File Doc Comment
 * 
 * Contrôleur du formulaire de contact
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
use app\service\FormService;
use app\service\RenderService;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * ContactController
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class ContactController extends MainController
{
    /**
     * Affiche le formulaire de contact
     *
     * @return void
     */
    public function index(): void
    {
        $pageTitle = 'Contactez-nous';

        RenderService::render(
            'contact',
            $pageTitle
        );
    }

    /**
     * Envoie un message
     *
     * @return void
     */
    public function send(): void
    {
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

        // Contrôle les données $_POST
        if (
            empty($lastname)
            || empty($firstname)
            || empty($message)
        ) {
            AuthService::updateSession('erreur', 'Merci de remplir tous les champs du formulaire');

            header('Location: ' . ROOT . 'contact');
        }

        $lastname = FormService::controlInputText(
            $lastname,
            SHORT_INPUT
        );

        $firstname = FormService::controlInputText(
            $firstname,
            SHORT_INPUT
        );

        $message = wordwrap(
            FormService::controlInputText(
                $message,
                LONG_INPUT
            ),
            70,
            "\r\n"
        );

        // Contrôle l'adresse email
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        if (!FormService::isValidEmail($email)) {
            AuthService::updateSession('erreur', 'Adresse e-mail incorrecte');

            header('Location: ' . ROOT . 'contact');
        }

        // Envoie du mail
        if (
            !empty($lastname)
            && !empty($firstname)
            && !empty($message)
            && FormService::isValidEmail($email)
        ) {
            // Initie PHPMailer
            $mail = new PHPMailer(true);

            // Paramètre du serveur
            $mail->isSMTP();
            $mail->Host =       'smtp.gmail.com';
            $mail->SMTPAuth =   'true';
            $mail->SMTPSecure = 'tls';
            $mail->Port =       '587';
            $mail->Username =   EMAIL_ADMIN;
            $mail->Password =   PASSMAIL_ADMIN;

            // Destinataire
            $mail->setFrom(EMAIL_ADMIN);

            $mail->addAddress(EMAIL_ADMIN);

            // Contenu du message
            $mail->CharSet = PHPMailer::CHARSET_UTF8;

            $mail->Subject = 'Nouveau message';

            $mail->Body = <<<EOT
            Email: $email
            Name: $lastname $firstname
            Message: $message
            EOT;

            // Envoie du message
            if ($mail->send()) {
                AuthService::updateSession('message', 'Merci pour votre message, 
                nous vous répondrons dans les plus brefs délais.');

                header('Location: ' . ROOT . 'contact');
            } else {
                echo $mail->ErrorInfo;
            }
            $mail->smtpClose();
        }
    }
}