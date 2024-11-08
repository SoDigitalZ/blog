<?php

namespace App\Controllers;

use App\Models\UserManager;

class ValidatorRegister extends Validator
{
    protected $userManager;

    public function __construct()
    {
        $this->userManager = new UserManager();
    }

    /**
     * Valider le formulaire de connexion
     * Vérifie que les champs email et mot de passe ne sont pas vides.
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function validateLoginForm(string $email, string $password): bool
    {
        return !empty($email) && !empty($password);
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

        // Valider l'email
        if (!$this->validateEmail($data['email'])) {
            $errors[] = "L'email n'est pas valide.";
        } elseif ($this->isEmailTaken($data['email'])) {
            $errors[] = "L'email est déjà utilisé.";
        }

        // Valider le prénom
        if (!$this->validateString($data['first_name'])) {
            $errors[] = "Le prénom n'est pas valide.";
        }

        // Valider le nom
        if (!$this->validateString($data['last_name'])) {
            $errors[] = "Le nom n'est pas valide.";
        }

        // Valider le mot de passe
        if (!$this->validatePassword($data['password'])) {
            $errors[] = "Le mot de passe doit comporter au moins 8 caractères.";
        }

        // Vérifier la correspondance entre password et confirmedPassword
        if ($data['password'] !== $data['confirmedPassword']) {
            $errors[] = "Les mots de passe ne correspondent pas.";
        }

        // Valider le numéro de téléphone
        if (!$this->validatePhone($data['phone'])) {
            $errors[] = "Le numéro de téléphone doit contenir uniquement des chiffres et comporter entre 10 et 15 caractères.";
        }

        return $errors;
    }
}
