<?php

namespace App\Models;

use App\Core\Db;
use PDO;

class UserManager
{
    protected $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    /**
     * Trouver un utilisateur par son email.
     */
    public function findOneByEmail(string $email)
    {
        $query = $this->db->prepare("SELECT * FROM user WHERE email = :email");
        $query->execute(['email' => $email]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Créer une session utilisateur.
     */
    public function setSession(User $user)
    {
        $_SESSION['user'] = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'role' => $user->getRole()
        ];
    }

    /**
     * Enregistrer un nouvel utilisateur dans la base de données.
     */
    public function registerUser(User $user): bool
    {
        $passwordHash = password_hash($user->getPassword(), PASSWORD_BCRYPT);

        $query = $this->db->prepare("
            INSERT INTO user (first_name, last_name, email, password, phone, role, is_valid, banned)
            VALUES (:first_name, :last_name, :email, :password, :phone, :role, :is_valid, :banned)
        ");

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
     * Vérifier si un utilisateur existe déjà par email.
     */
    public function emailExists(string $email): bool
    {
        $query = $this->db->prepare("SELECT COUNT(*) FROM user WHERE email = :email");
        $query->execute(['email' => $email]);
        return $query->fetchColumn() > 0;
    }

    /**
     * Mettre à jour les informations d'un utilisateur.
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
     * Supprimer un utilisateur de la base de données.
     */
    public function deleteUser(int $id): bool
    {
        $query = $this->db->prepare("DELETE FROM user WHERE id = :id");
        return $query->execute(['id' => $id]);
    }

    /**
     * Trouver un utilisateur par son ID.
     */
    public function findOneById(int $id)
    {
        $query = $this->db->prepare("SELECT * FROM user WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer tous les utilisateurs.
     */
    public function findAll()
    {
        $query = $this->db->query("SELECT * FROM user");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
