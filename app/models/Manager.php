<?php

namespace App\Models;

use PDO;
use App\Core\Db;

class Manager
{
    // Instance de la connexion à la base de données
    protected $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    // Méthode pour exécuter des requêtes SQL
    protected function requete(string $sql, array $attributs = null)
    {
        // Prépare et exécute la requête
        if ($attributs !== null) {
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            return $this->db->query($sql);
        }
    }
}
