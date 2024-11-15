<?php

namespace App\Controllers;

use App\Models\User;
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
        return $this->userManager->emailExists($email);
    }

    /**
     * Valider les données d'inscription
     * @param User $data
     * @return array
     */
    public function validateRegistration(User $data): array
    {
        $errors = [];

        // Valider l'email
        if (!$this->validateEmail($data->getEmail())) {
            $errors[] = "L'email n'est pas valide.";
        } elseif ($this->isEmailTaken($data->getEmail())) {
            $errors[] = "L'email est déjà utilisé.";
        }

        // Valider le prénom
        if (!$this->validateString($data->getFirstName())) {
            $errors[] = "Le prénom n'est pas valide.";
        }

        // Valider le nom
        if (!$this->validateString($data->getLastName())) {
            $errors[] = "Le nom n'est pas valide.";
        }

        // Valider le mot de passe
        if (!$this->validatePassword($data->getPassword())) {
            $errors[] = "Le mot de passe doit comporter au moins 8 caractères.";
        }

        // Vérifier la correspondance entre password et confirmedPassword
        if ($data->getPassword() !== $data->getConfirmedPassword()) {
            $errors[] = "Les mots de passe ne correspondent pas.";
        }

        // Valider le numéro de téléphone
        if (!$this->validatePhone($data->getPhone())) {
            $errors[] = "Le numéro de téléphone doit contenir uniquement des chiffres, avec 10 à 15 caractères.";
        }

        return $errors;
    }
}
