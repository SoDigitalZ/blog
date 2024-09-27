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
    public function requete(string $sql, array $attributs = null)
    {
        if ($attributs !== null) {
            $query = $this->db->prepare($sql);  // Appel à PDO::prepare()
            $query->execute($attributs);
            return $query;
        } else {
            return $this->db->query($sql);
        }
    }
}
