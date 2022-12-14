<?php

/**
 * UserModel File Doc Comment
 * 
 * Model pour la gestion des utilisateurs
 * 
 * php version 8.0.0
 * 
 * @category Model
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */

namespace app\model;

use app\entity\UserEntity;
use app\service\AuthService;

/**
 * UserModel
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class UserModel extends MainModel
{
    /**
     * Ajoute un utilisateur
     *
     * @param UserEntity $user objet utilisateur
     * 
     * @return void
     */
    public function addUser(UserEntity $user): void
    {
        // Retourne les propriétés de l'objet sous forme de tableau associatif
        $user = $user->getObjVars();

        // Vérifie si l'email n'est pas déjà utilisée
        $sql = "SELECT id,valid FROM user  WHERE email = ?";

        $statement = $this->pdo->prepare($sql);

        $statement->execute(
            [$user['email']]
        );

        $response = $statement->fetch();

        // Prépare la requête SQL
        $sql = self::insertArray(
            'user',
            $user
        );

        $statement = $this->pdo->prepare($sql);

        // Ajoute un nouvel utilisateur
        if (empty($response)) {
            $statement->execute($user);

            AuthService::updateSession('message', 'Merci pour votre inscription, elle est en attente 
            de validation par l\'administrateur du site');

            header('Location: ' . ROOT . 'login');
            exit;
        }

        // Message d'erreur: compte existant
        if ($response->valid == 1) {
            AuthService::updateSession('erreur', 'Utilisateur déjà enregistré, 
            connectez-vous en utilisant le formulaire ci-dessous.');

            header('Location: ' . ROOT . 'login');
            exit;
        }

        // Message d'erreur: compte en attente de validation
        if ($response->valid == 0) {
            AuthService::updateSession('erreur', 'Votre compte est en attente de 
            validation par l\'administrateur du site.');

            header('Location: ' . ROOT . 'login');
            exit;
        }
    }

    /**
     * Authentifie un utilisateur
     *
     * @param UserEntity $user objet utilisateur
     * 
     * @return void
     */
    public function logUser(UserEntity $user): void
    {
        // Recherche l'utilisateur par son email
        $sql = "SELECT * FROM user WHERE email = ?";

        $statement = $this->pdo->prepare($sql);

        $statement->execute(
            [$user->getEmail()]
        );

        $response = $statement->fetch();

        // Connecte l'utilisateur ou affiche un message d'erreur
        if (
            isset($response)
            && !empty($response)
            && password_verify($user->getPassword(), $response->password)
            && $response->valid == 1
        ) {
            $this->session['user']['id']        = $response->id;
            $this->session['user']['email']     = $response->email;
            $this->session['user']['firstname'] = $response->firstname;
            $this->session['user']['lastname']  = $response->lastname;
            $this->session['user']['role']      = $response->role;
            $this->session['user']['message']   = "Bienvenue $response->firstname";

            AuthService::setSession($this->session);

            header('Location: ' . ROOT . 'admin');
            exit;
        }

        if (!empty($response->id) && $response->valid == 0) {
            AuthService::updateSession('erreur', 'Votre compte est en attente de 
            validation par l\'administrateur du site.');

            header('Location: ' . ROOT . 'login');
            exit;
        }

        if (empty($response->id) || !password_verify($user->getPassword(), $response->password)) {
            AuthService::updateSession('erreur', 'E-mail ou mot de passe invalide.');

            header('Location: ' . ROOT . 'login');
            exit;
        }
    }

    /**
     * Recherche un utilisateur
     *
     * @param int $id id de l'utilisateur
     * 
     * @return object
     */
    public function getUser(int $id): object
    {
        $sql = "SELECT * FROM user WHERE id = :id and valid = 1";

        $statement = $this->pdo->prepare($sql);

        $statement->execute(
            ['id' => $id]
        );

        $user = $statement->fetch();

        if (empty($user)) {
            header('Location: ' . ROOT . '');
        }

        return $user;
    }

    /**
     * Recherche tous les utilisateurs non admin
     *
     * @return array
     */
    public function getUsers(): array
    {
        $sql = "SELECT * FROM user WHERE role != 'user,admin' ORDER BY valid";

        $statement = $this->pdo->prepare($sql);

        $statement->execute();

        $users = $statement->fetchAll();

        return $users;
    }

    /**
     * Valide un utilisateur
     *
     * @param int $id id de l'utilisateur
     * 
     * @return void
     */
    public function validUser(int $id): void
    {
        $sql = "UPDATE user SET valid = 1 WHERE id = :id";

        $statement = $this->pdo->prepare($sql);

        $statement->execute(
            ['id' => $id]
        );
    }

    /**
     * Supprime un utilisateur
     *
     * @param int $id id de l'utilisateur
     * 
     * @return void
     */
    public function deleteUser(int $id): void
    {
        $sql = "DELETE FROM user WHERE id = :id and id != 1";

        $statement = $this->pdo->prepare($sql);

        $statement->execute(
            ['id' => $id]
        );
    }

    /**
     * Met à jour les données de l'utilisateur
     *
     * @param int        $id      id de l'utilisateur
     * @param UserEntity $profile objet utilisateur
     * 
     * @return void
     */
    public function updateUser(int $id, UserEntity $profile): void
    {
        // Vérifie si l'email n'est pas utilisé par un autre utilisateur
        $sql = "SELECT * FROM user WHERE id != :id AND email = :email";

        $statement = $this->pdo->prepare($sql);

        $statement->execute(
            [
                'id' => $id,
                'email' => $profile->getEmail()
            ]
        );

        $response = $statement->fetch();

        if ($response === false) {

            $profile = $profile->getObjVars();

            $sql = self::updateArray(
                'user',
                $profile
            );

            $profile['id'] = $id;

            $statement = $this->pdo->prepare($sql);

            $statement->execute($profile);

            AuthService::updateSession('message', 'Profile modifié avec succés');

            header('Location: ' . ROOT . 'account');
            exit;
        }

        AuthService::updateSession('erreur', 'Adresse e-mail déjà utilisée');

        header('Location: ' . ROOT . 'account');
        exit;
    }
}