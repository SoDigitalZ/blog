<?php

namespace App\Models;

use App\Core\Db;  // Utilisation de la classe Db pour gérer la connexion à la base de données
use PDO;

class UserManager
{
    protected $db;

    public function __construct()
    {
        // Utilisation de la connexion unique à la base de données via la classe Db
        $this->db = Db::getInstance();
    }

    /**
     * Trouver un utilisateur par son email
     *
     * @param string $email
     * @return array|false Retourne un tableau associatif contenant les informations de l'utilisateur ou false si non trouvé
     */
    public function findOneByEmail(string $email)
    {
        $query = $this->db->prepare("SELECT * FROM user WHERE email = :email");
        $query->execute(['email' => $email]);
        return $query->fetch(PDO::FETCH_ASSOC);  // Retourne les données de l'utilisateur sous forme de tableau associatif
    }

    /**
     * Créer une session utilisateur
     *
     * @param User $user
     */
    public function setSession(User $user)
    {
        // Stocker les informations de l'utilisateur dans la session PHP
        $_SESSION['user'] = [
            'id' => $user->getId(),  // Récupère l'ID de l'utilisateur avec getId()
            'email' => $user->getEmail(),  // Récupère l'email avec getEmail()
            'first_name' => $user->getFirstName(),  // Récupère le prénom avec getFirstName()
            'last_name' => $user->getLastName(),  // Récupère le nom avec getLastName()
            'role' => $user->getRole()  // Récupère le rôle de l'utilisateur avec getRole()
        ];
    }

    /**
     * Enregistrer un nouvel utilisateur dans la base de données
     *
     * @param User $user
     * @return bool
     */
    public function registerUser(User $user): bool
    {
        // Hachage du mot de passe
        $passwordHash = password_hash($user->getPassword(), PASSWORD_BCRYPT);

        // Préparer la requête d'insertion
        $query = $this->db->prepare("
        INSERT INTO user (first_name, last_name, email, password, phone, role, is_valid, banned)
        VALUES (:first_name, :last_name, :email, :password, :phone, :role, :is_valid, :banned)
    ");

        // Exécuter la requête en passant les paramètres
        return $query->execute([
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'email' => $user->getEmail(),
            'password' => $passwordHash,
            'phone' => $user->getPhone(),
            'role' => $user->getRole(),
            'is_valid' => (int) $user->getIsValid(), // Convertit en entier
            'banned' => (int) $user->getBanned()     // Convertit en entier
        ]);
    }


    /**
     * Vérifier si un utilisateur existe déjà par email
     *
     * @param string $email
     * @return bool
     */
    public function emailExists(string $email): bool
    {
        $query = $this->db->prepare("SELECT COUNT(*) FROM user WHERE email = :email");
        $query->execute(['email' => $email]);
        return $query->fetchColumn() > 0;  // Retourne true si l'email existe déjà, sinon false
    }

    /**
     * Mettre à jour les informations d'un utilisateur
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateUser(int $id, array $data): bool
    {
        $query = $this->db->prepare("
            UPDATE user 
            SET first_name = :first_name, last_name = :last_name, email = :email, phone = :phone, role = :role, is_valid = :is_valid, banned = :banned 
            WHERE id = :id
        ");

        return $query->execute([
            'id' => $id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role' => $data['role'],
            'is_valid' => $data['is_valid'],
            'banned' => $data['banned']
        ]);
    }

    /**
     * Supprimer un utilisateur de la base de données
     *
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool
    {
        $query = $this->db->prepare("DELETE FROM user WHERE id = :id");
        return $query->execute(['id' => $id]);
    }

    /**
     * Trouver un utilisateur par son ID
     *
     * @param int $id
     * @return array|false Retourne un tableau associatif contenant les informations de l'utilisateur ou false si non trouvé
     */
    public function findOneById(int $id)
    {
        $query = $this->db->prepare("SELECT * FROM user WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);  // Retourne les données de l'utilisateur sous forme de tableau associatif
    }

    /**
     * Récupérer tous les utilisateurs
     *
     * @return array|false Retourne un tableau associatif avec tous les utilisateurs ou false si erreur
     */
    public function findAll()
    {
        $query = $this->db->query("SELECT * FROM user");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
