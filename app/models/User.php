<?php

namespace App\Models;

class User
{
    protected $id;
    protected $first_name;
    protected $last_name;
    protected $email;
    protected $password;
    protected $confirmedPassword;
    protected $phone;
    protected $role = 0;        // Défini par défaut pour éviter null
    protected $is_valid = false; // Défini par défaut
    protected $banned = false;   // Défini par défaut

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

    // Getters

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

    public function getConfirmedPassword(): string
    {
        return $this->confirmedPassword;
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

    // Setters avec retour de $this pour permettre le chaînage

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;
        return $this;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
    }

    public function setConfirmedPassword(string $confirmedPassword)
    {
        $this->confirmedPassword = $confirmedPassword;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function setRole(int $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function setIsValid(bool $is_valid): self
    {
        $this->is_valid = $is_valid;
        return $this;
    }

    public function setBanned(bool $banned): self
    {
        $this->banned = $banned;
        return $this;
    }
}
