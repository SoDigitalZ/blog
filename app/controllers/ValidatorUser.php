<?php

namespace App\Controllers;

class ValidatorUser
{
    /**
     * Valider un email
     * @param string $email
     * @return bool
     */
    public function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Nettoyer un email
     * @param string $email
     * @return string
     */
    public function sanitizeEmail(string $email): string
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Valider une chaîne de caractères (nom, prénom, etc.)
     * @param string $string
     * @param int $minLength
     * @param int $maxLength
     * @return bool
     */
    public function validateString(string $string, int $minLength = 2, int $maxLength = 255): bool
    {
        $length = strlen(trim($string));
        return $length >= $minLength && $length <= $maxLength;
    }

    /**
     * Valider un mot de passe
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        // Vérifie si le mot de passe contient au moins :
        // - 8 caractères
        // - Une lettre majuscule
        // - Une lettre minuscule
        // - Un chiffre
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/', $password) === 1;
    }

    /**
     * Vérifier si le mot de passe fourni correspond au mot de passe haché
     * @param string $inputPassword Le mot de passe saisi par l'utilisateur
     * @param string $hashedPassword Le mot de passe haché stocké en base de données
     * @return bool
     */
    public function verifyPassword(string $inputPassword, string $hashedPassword): bool
    {
        return password_verify($inputPassword, $hashedPassword);
    }

    /**
     * Valider un numéro de téléphone
     * @param string $phone
     * @return bool
     */
    public function validatePhone(string $phone): bool
    {
        // Format international : + suivi de 10 à 15 chiffres, ou local avec 10 à 15 chiffres
        return preg_match('/^\+?[0-9]{10,15}$/', $phone) === 1;
    }

    /**
     * Valider un formulaire de connexion
     * Vérifie que l'email est valide et que le mot de passe n'est pas vide
     * @param array $formData Données du formulaire (email, password)
     * @return array
     */
    public function validateLogin(array $formData): array
    {
        $errors = [];
        $validatedData = [];

        // Valider l'email
        if (empty($formData['email'])) {
            $errors['email'] = "L'email est obligatoire.";
        } elseif (!$this->validateEmail($formData['email'])) {
            $errors['email'] = "L'email n'est pas valide.";
        } else {
            $validatedData['email'] = $this->sanitizeEmail($formData['email']);
        }

        // Valider le mot de passe
        if (empty($formData['password'])) {
            $errors['password'] = "Le mot de passe est obligatoire.";
        } else {
            $validatedData['password'] = $formData['password'];
        }

        return ['errors' => $errors, 'data' => $validatedData];
    }
}
