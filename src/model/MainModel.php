<?php

/**
 * MainModel File Doc Comment
 * 
 * Model pour se connecter à la base de données
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

/**
 * MainModel
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
abstract class MainModel
{
    private static $_instance = null;
    protected \PDO $pdo;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->pdo = self::getconnection();
    }

    /**
     * Connexion à la base de données
     *
     * @return PDO
     */
    public static function getConnection(): \PDO
    {
        if (self::$_instance === null) {

            try {
                self::$_instance = new \PDO(
                    'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
                    DB_USER,
                    DB_PASSWORD
                );

                self::$_instance->setAttribute(
                    \PDO::ATTR_DEFAULT_FETCH_MODE,
                    \PDO::FETCH_OBJ
                );

                self::$_instance->setAttribute(
                    \PDO::ATTR_ERRMODE,
                    \PDO::ERRMODE_EXCEPTION
                );
            } catch (\PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br/>";
                die();
            }
        }

        return self::$_instance;
    }

    /**
     * Retourne la requête SQL pour insèrer un tableau
     *
     * @param string $table la table de la base de données
     * @param array  $array le tableau à insérer
     * 
     * @return string
     */
    public static function insertArray(string $table, array $array): string
    {
        $sql = "INSERT INTO $table (
            " . implode(',', array_keys($array)) . "
            ) 
        VALUES (
            :" . implode(',:', array_keys($array)) . "
            )";

        return $sql;
    }

    /**
     * Retourne la requête SQL pour mettre à jour depuis un tableau
     *
     * @param string $table la table de la base de données
     * @param array  $array le tableau à mettre à jour
     * 
     * @return string
     */
    public static function updateArray(string $table, array $array): string
    {
        $sql = '';
        $i   = 0;
        $len = count($array);

        foreach ($array as $key => $value) {
            $i++;
            $sql .= $key . "= :" . $key;
            if ($i < $len) {
                $sql .= ", ";
            }
        }

        if ($table == 'article') {
            $date = date("Y-m-d H:i:s");
            $sql .= ", updateDate=\"$date\" ";
        }

        $sql .= " WHERE id = :id";
        $sql = "UPDATE $table SET $sql";

        return $sql;
    }
}