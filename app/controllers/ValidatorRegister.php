<?php

namespace App\Controllers;

use App\Models\UserManager;

class ValidatorRegister extends Validator
{
    private UserManager $userManager;

    public function __construct(array $formData)
    {
        parent::__construct($formData);
        $this->userManager = new UserManager();
    }

    /**
     * Valide le formulaire d'inscription.
     */
    public function validate(): void
    {
        // Valider les champs du formulaire d'inscription
        $this->validateString('first_name', 2, 50);
        $this->validateString('last_name', 2, 50);
        $this->validateEmail('email');
        $this->validatePassword('password');
        $this->validateConfirmPassword('password', 'confirmedPassword');
        $this->validatePhone('phone');

        // Vérifie si l'email est déjà utilisé
        if ($this->isValid() && $this->userManager->emailExists($this->data['email'])) {
            $this->addError('email', "L'email est déjà utilisé.");
        }
    }

    /**
     * Valide la correspondance entre le mot de passe et la confirmation du mot de passe
     * 
     * @param string $passwordField
     * @param string $confirmPasswordField
     */
    private function validateConfirmPassword(string $passwordField, string $confirmPasswordField): void
    {
        $password = $this->data[$passwordField] ?? '';
        $confirmPassword = $this->data[$confirmPasswordField] ?? '';

        if (empty($confirmPassword)) {
            $this->addError($confirmPasswordField, "La confirmation du mot de passe est obligatoire.");
        } elseif ($password !== $confirmPassword) {
            $this->addError($confirmPasswordField, "Les mots de passe ne correspondent pas.");
        }
    }
}
