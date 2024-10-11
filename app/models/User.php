<?php

namespace App\Models;

class User
{
    protected $id;
    protected $first_name;
    protected $last_name;
    protected $email;
    protected $password;
    protected $phone;
    protected $role;
    protected $is_valid;
    protected $banned;

    /**
     * Hydratation de l'objet utilisateur à partir d'un tableau de données
     * @param array $data
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters (méthodes pour récupérer les valeurs des propriétés)

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getRole(): int
    {
        return $this->role;
    }

    public function getIsValid(): bool
    {
        return $this->is_valid;
    }

    public function getBanned(): bool
    {
        return $this->banned;
    }

    // Setters (méthodes pour définir les valeurs des propriétés)

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setFirstName(string $first_name)
    {
        $this->first_name = $first_name;
    }

    public function setLastName(string $last_name)
    {
        $this->last_name = $last_name;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }

    public function setRole(int $role)
    {
        $this->role = $role;
    }

    public function setIsValid(bool $is_valid)
    {
        $this->is_valid = $is_valid;
    }

    public function setBanned(bool $banned)
    {
        $this->banned = $banned;
    }
}
