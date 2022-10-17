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
 * @author   Vernières fabien <fabienvernieres@gmail.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */

namespace app\controller;

use app\service\FormService;
use app\service\RenderService;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * ContactController
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <fabienvernieres@gmail.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class ContactController
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
        // Contrôle les données $_POST
        if (
            !empty($_POST['lastname'])
            && !empty($_POST['firstname'])
            && !empty($_POST['message'])
        ) {
            $lastname = FormService::controlInputText(
                $_POST['lastname'],
                SHORT_INPUT
            );

            $firstname = FormService::controlInputText(
                $_POST['firstname'],
                SHORT_INPUT
            );

            $message = wordwrap(
                FormService::controlInputText(
                    $_POST['message'],
                    LONG_INPUT
                ),
                70,
                "\r\n"
            );
        } else {
            session_start();

            $_SESSION['user']['erreur'] = "Merci de remplir tous les champs du formulaire";

            header('Location: ' . ROOT . 'contact');
            exit;
        }

        // Contrôle l'adresse email
        if (
            !empty($_POST['email'])
            && FormService::isValidEmail($_POST['email'])
        ) {
            $email = $_POST['email'];
        } else {
            session_start();

            $_SESSION['user']['erreur'] = "Adresse e-mail incorrecte";

            header('Location: ' . ROOT . 'contact');
            exit;
        }

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
            session_start();

            $_SESSION['user']['message'] = "Merci pour votre message, 
                nous vous répondrons dans les plus brefs délais.";

            header('Location: ' . ROOT . 'contact');
            exit;
        } else {
            echo $mail->ErrorInfo;
        }
        $mail->smtpClose();
    }
}