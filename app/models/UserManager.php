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
     * @param array $data
     * @return bool
     */
    public function registerUser(array $data): bool
    {
        // Hachage du mot de passe avant insertion dans la base de données
        $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT);
        $query = $this->db->prepare("
            INSERT INTO user (first_name, last_name, email, password, phone, role, is_valid, banned)
            VALUES (:first_name, :last_name, :email, :password, :phone, :role, :is_valid, :banned)
        ");
        return $query->execute([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $passwordHash,
            'phone' => $data['phone'],
            'role' => $data['role'],
            'is_valid' => $data['is_valid'],
            'banned' => $data['banned']
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
}
