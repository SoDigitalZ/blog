<?php

namespace App\Controllers;

class ValidatorUser
{
    private const ERROR_MESSAGES = [
        'email_required' => "L'email est obligatoire.",
        'email_invalid' => "L'email n'est pas valide.",
        'password_required' => "Le mot de passe est obligatoire.",
        'password_invalid' => "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.",
        'phone_invalid' => "Le numéro de téléphone doit être au format international ou contenir entre 10 et 15 chiffres.",
        'user_not_found' => "Utilisateur introuvable.",
        'password_incorrect' => "Mot de passe incorrect.",
    ];

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
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/', $password) === 1;
    }

    /**
     * Vérifier si le mot de passe fourni correspond au mot de passe haché
     * @param string $inputPassword
     * @param string $hashedPassword
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
        return preg_match('/^\+?[0-9]{10,15}$/', $phone) === 1;
    }

    /**
     * Valider un formulaire de connexion
     * Vérifie que l'email est valide et que le mot de passe n'est pas vide
     * @param array $formData Données du formulaire (email, password)
     * @param bool $userExists Résultat de la vérification de l'utilisateur (true si trouvé)
     * @param bool|null $passwordValid Résultat de la vérification du mot de passe (null si utilisateur introuvable)
     * @return array array{errors: array<string, string>, data: array<string, string>}
     */
    public function validateLogin(array $formData, bool $userExists = true, ?bool $passwordValid = null): array
    {
        $errors = [];
        $validatedData = [];

        // Valider l'email
        if (empty($formData['email'])) {
            $errors['email'] = self::ERROR_MESSAGES['email_required'];
        } elseif (!$this->validateEmail($formData['email'])) {
            $errors['email'] = self::ERROR_MESSAGES['email_invalid'];
        } else {
            $validatedData['email'] = $this->sanitizeEmail($formData['email']);
        }

        // Valider le mot de passe
        if (empty($formData['password'])) {
            $errors['password'] = self::ERROR_MESSAGES['password_required'];
        } else {
            $validatedData['password'] = $formData['password'];
        }

        // Ajout des erreurs générales si aucune autre erreur détectée
        if (empty($errors)) {
            if (!$userExists) {
                $errors['email'] = self::ERROR_MESSAGES['user_not_found'];
            } elseif ($passwordValid === false) {
                $errors['password'] = self::ERROR_MESSAGES['password_incorrect'];
            }
        }

        return ['errors' => $errors, 'data' => $validatedData];
    }
}
