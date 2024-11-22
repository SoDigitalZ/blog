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
     * Méthode générique pour rechercher un utilisateur par champ.
     *
     * @param string $field
     * @param mixed $value
     * @return User|null
     */
    private function findOneByField(string $field, $value): ?User
    {
        // Limite les champs autorisés pour éviter les injections SQL
        $allowedFields = ['id', 'email'];
        if (!in_array($field, $allowedFields, true)) {
            throw new \InvalidArgumentException("Le champ '$field' n'est pas autorisé.");
        }

        $query = $this->db->prepare("SELECT * FROM user WHERE $field = :value");
        $query->execute(['value' => $value]);
        $user = $query->fetchObject(User::class);

        return $user ?: null;
    }

    /**
     * Trouver un utilisateur par son email.
     *
     * @param string $email
     * @return User|null
     */
    public function findOneByEmail(string $email): ?User
    {
        return $this->findOneByField('email', $email);
    }

    /**
     * Trouver un utilisateur par son ID.
     *
     * @param int $id
     * @return User|null
     */
    public function findOneById(int $id): ?User
    {
        return $this->findOneByField('id', $id);
    }

    /**
     * Stocker les informations d'un utilisateur dans la session.
     *
     * @param User $user
     * @return void
     */
    public function setSession(User $user): void
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
     *
     * @param User $user
     * @return bool
     */
    public function registerUser(User $user): bool
    {
        try {
            // Hashage du mot de passe
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT));

            $query = $this->db->prepare("
                INSERT INTO user (first_name, last_name, email, password, phone, role, is_valid, banned)
                VALUES (:first_name, :last_name, :email, :password, :phone, :role, :is_valid, :banned)
            ");

            return $query->execute([
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(), // Mot de passe hashé
                'phone' => $user->getPhone(),
                'role' => (int) $user->getRole(),
                'is_valid' => (int) $user->getIsValid(),
                'banned' => (int) $user->getBanned()
            ]);
        } catch (\PDOException $e) {
            error_log("Erreur lors de l'enregistrement de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Vérifier si un utilisateur existe déjà par email.
     *
     * @param string $email
     * @return bool
     */
    public function emailExists(string $email): bool
    {
        $query = $this->db->prepare("SELECT COUNT(*) FROM user WHERE email = :email");
        $query->execute(['email' => $email]);
        return $query->fetchColumn() > 0;
    }

    /**
     * Mettre à jour les informations d'un utilisateur.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateUser(int $id, array $data): bool
    {
        try {
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
                'role' => (int) $data['role'],
                'is_valid' => (int) $data['is_valid'],
                'banned' => (int) $data['banned']
            ]);
        } catch (\PDOException $e) {
            error_log("Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Supprimer un utilisateur de la base de données.
     *
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool
    {
        try {
            $query = $this->db->prepare("DELETE FROM user WHERE id = :id");
            return $query->execute(['id' => $id]);
        } catch (\PDOException $e) {
            error_log("Erreur lors de la suppression de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Récupérer tous les utilisateurs.
     *
     * @return array
     */
    public function findAll(): array
    {
        $query = $this->db->query("SELECT * FROM user");
        return $query->fetchAll(PDO::FETCH_CLASS, User::class) ?: [];
    }
}
