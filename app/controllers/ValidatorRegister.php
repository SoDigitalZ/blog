<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\UserManager;

class ValidatorRegister extends ValidatorUser
{
    private const ERROR_MESSAGES = [
        'first_name_required' => "Le prénom est obligatoire.",
        'first_name_invalid' => "Le prénom n'est pas valide.",
        'last_name_required' => "Le nom est obligatoire.",
        'last_name_invalid' => "Le nom n'est pas valide.",
        'email_required' => "L'email est obligatoire.",
        'email_invalid' => "L'email n'est pas valide.",
        'email_taken' => "L'email est déjà utilisé.",
        'password_required' => "Le mot de passe est obligatoire.",
        'password_invalid' => "Le mot de passe doit comporter au moins 8 caractères, une majuscule, une minuscule et un chiffre.",
        'password_confirmation_required' => "La confirmation du mot de passe est obligatoire.",
        'password_mismatch' => "Les mots de passe ne correspondent pas.",
        'phone_invalid' => "Le numéro de téléphone doit contenir uniquement des chiffres et comporter entre 10 et 15 caractères.",
    ];

    protected UserManager $userManager;

    public function __construct()
    {
        $this->userManager = new UserManager();
    }

    /**
     * Vérifier si un email est déjà pris par un utilisateur.
     * 
     * @param string $email
     * @return bool
     */
    public function isEmailTaken(string $email): bool
    {
        return $this->userManager->emailExists($email);
    }

    /**
     * Valider les données d'inscription.
     * 
     * @param User $user
     * @return array
     */
    public function validateRegistration(User $user): array
    {
        $errors = [];

        $errors = array_merge($errors, $this->validateFirstName($user->getFirstName()));
        $errors = array_merge($errors, $this->validateLastName($user->getLastName()));
        $errors = array_merge($errors, $this->validateEmailField($user->getEmail()));
        $errors = array_merge($errors, $this->validatePasswordField($user->getPassword(), $user->getConfirmedPassword()));
        $errors = array_merge($errors, $this->validatePhoneField($user->getPhone()));

        return $errors;
    }

    private function validateFirstName(?string $firstName): array
    {
        if (empty($firstName)) {
            return ['first_name' => self::ERROR_MESSAGES['first_name_required']];
        } elseif (!$this->validateString($firstName)) {
            return ['first_name' => self::ERROR_MESSAGES['first_name_invalid']];
        }
        return [];
    }

    private function validateLastName(?string $lastName): array
    {
        if (empty($lastName)) {
            return ['last_name' => self::ERROR_MESSAGES['last_name_required']];
        } elseif (!$this->validateString($lastName)) {
            return ['last_name' => self::ERROR_MESSAGES['last_name_invalid']];
        }
        return [];
    }

    private function validateEmailField(?string $email): array
    {
        if (empty($email)) {
            return ['email' => self::ERROR_MESSAGES['email_required']];
        } elseif (!$this->validateEmail($email)) {
            return ['email' => self::ERROR_MESSAGES['email_invalid']];
        } elseif ($this->isEmailTaken($email)) {
            return ['email' => self::ERROR_MESSAGES['email_taken']];
        }
        return [];
    }

    private function validatePasswordField(?string $password, ?string $confirmedPassword): array
    {
        $errors = [];

        if (empty($password)) {
            $errors['password'] = self::ERROR_MESSAGES['password_required'];
        } elseif (!$this->validatePassword($password)) {
            $errors['password'] = self::ERROR_MESSAGES['password_invalid'];
        }

        if (empty($confirmedPassword)) {
            $errors['confirmedPassword'] = self::ERROR_MESSAGES['password_confirmation_required'];
        } elseif ($password !== $confirmedPassword) {
            $errors['confirmedPassword'] = self::ERROR_MESSAGES['password_mismatch'];
        }

        return $errors;
    }

    private function validatePhoneField(?string $phone): array
    {
        if (!empty($phone) && !$this->validatePhone($phone)) {
            return ['phone' => self::ERROR_MESSAGES['phone_invalid']];
        }
        return [];
    }
}
