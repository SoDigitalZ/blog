<?php

namespace App\Models;

use App\Core\Db;

class Manager
{
    protected $db;

    public function __construct()
    {
        try {
            // Récupérer l'instance de Db, qui est un objet PDO
            $this->db = Db::getInstance();
        } catch (\Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }

    // Méthode d'exécution des requêtes préparées
    protected function requete(string $sql, array $attributs = null)
    {
        try {
            if ($attributs !== null) {
                $query = $this->db->prepare($sql);
                $query->execute($attributs);
            } else {
                $query = $this->db->query($sql);
            }

            return $query;
        } catch (\PDOException $e) {
            error_log("Erreur SQL : " . $sql);
            error_log("Attributs : " . json_encode($attributs));
            error_log("Message PDO : " . $e->getMessage());
            throw $e;
        }
    }
}
