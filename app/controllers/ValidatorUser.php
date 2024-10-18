<?php

namespace App\Controllers;

use App\Models\UserManager;

class ValidatorUser extends Validator
{
    protected $userManager;

    public function __construct()
    {
        $this->userManager = new UserManager();
    }

    /**
     * Vérifier si un email est déjà pris par un utilisateur
     * @param string $email
     * @return bool
     */
    public function isEmailTaken(string $email): bool
    {
        return $this->userManager->emailExists($email);  // Appelle la méthode dans UserManager
    }

    /**
     * Valider les données d'inscription
     * @param array $data
     * @return array
     */
    public function validateRegistration(array $data): array
    {
        $errors = [];

        if (!$this->validateEmail($data['email'])) {
            $errors[] = "L'email n'est pas valide.";
        } elseif ($this->isEmailTaken($data['email'])) {
            $errors[] = "L'email est déjà utilisé.";
        }

        if (!$this->validateString($data['first_name'])) {
            $errors[] = "Le prénom n'est pas valide.";
        }

        if (!$this->validateString($data['last_name'])) {
            $errors[] = "Le nom n'est pas valide.";
        }

        if (!$this->validatePassword($data['password'])) {
            $errors[] = "Le mot de passe doit comporter au moins 8 caractères.";
        }

        return $errors;
    }
}
