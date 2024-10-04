<?php

namespace App\Core;

use PDO;
use PDOException;

class Db
{
    private static $instance = null;

    private const DBHOST = 'localhost';
    private const DBUSER = 'root';
    private const DBPASS = '';
    private const DBNAME = 'blog';

    private function __construct()
    {
        // Connexion à la base de données
        try {
            $dsn = 'mysql:host=' . self::DBHOST . ';dbname=' . self::DBNAME;
            self::$instance = new PDO($dsn, self::DBUSER, self::DBPASS);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            new self();
        }

        return self::$instance;
    }
}
