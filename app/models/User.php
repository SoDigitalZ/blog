<?php

namespace App\Models;

class User
{
    protected ?int $id = null;
    protected string $first_name = '';
    protected string $last_name = '';
    protected string $email = '';
    protected string $password = '';
    protected ?string $confirmedPassword = null; // Facultatif
    protected ?string $phone = null;
    protected int $role = 0;
    protected bool $is_valid = false;
    protected bool $banned = false;

    /**
     * Constructeur avec données facultatives.
     */
    public function __construct(array $formData = [])
    {
        if (!empty($formData)) {
            $this->setFirstName($formData['first_name'] ?? '')
                ->setLastName($formData['last_name'] ?? '')
                ->setEmail($formData['email'] ?? '')
                ->setPassword($formData['password'] ?? '')
                ->setConfirmedPassword($formData['confirmedPassword'] ?? null)
                ->setPhone($formData['phone'] ?? null);
        }
    }

    /**
     * Méthode pour hydrater l'objet depuis un tableau de données.
     */
    public function hydrate(array $data): self
    {
        foreach ($data as $key => $value) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    // Getters
    public function getId(): ?int
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
    public function getConfirmedPassword(): ?string
    {
        return $this->confirmedPassword;
    }
    public function getPhone(): ?string
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

    // Setters
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }
    public function setFirstName(string $first_name): self
    {
        $this->first_name = trim($first_name);
        return $this;
    }
    public function setLastName(string $last_name): self
    {
        $this->last_name = trim($last_name);
        return $this;
    }
    public function setEmail(string $email): self
    {
        $this->email = strtolower(trim($email));
        return $this;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
    public function setConfirmedPassword(?string $confirmedPassword): self
    {
        $this->confirmedPassword = $confirmedPassword;
        return $this;
    }
    public function setPhone(?string $phone): self
    {
        $this->phone = trim($phone);
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
