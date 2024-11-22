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
            // Suppression du mode FETCH_OBJ par défaut
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Récupère l'instance unique de la connexion à la base de données.
     *
     * @return PDO
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            new self();
        }

        return self::$instance;
    }

    /**
     * Prépare une requête SQL et associe une classe pour les résultats.
     *
     * @param string $query La requête SQL.
     * @param string $className Le nom de la classe à associer (par défaut stdClass).
     * @param array $params Les paramètres pour la requête préparée.
     * @return array|false Retourne un tableau d'objets de la classe spécifiée ou false en cas d'échec.
     */
    public static function fetchClass(string $query, string $className = 'stdClass', array $params = [])
    {
        $stmt = self::getInstance()->prepare($query);

        if ($stmt->execute($params)) {
            return $stmt->fetchAll(PDO::FETCH_CLASS, $className);
        }

        return false;
    }
}
