<?php

namespace App\Controllers;

class Validator
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
     * Valider une chaîne de caractères (nom, prénom, etc.)
     * @param string $string
     * @param int $minLength
     * @param int $maxLength
     * @return bool
     */
    public function validateString(string $string, int $minLength = 2, int $maxLength = 255): bool
    {
        $length = strlen($string);
        return $length >= $minLength && $length <= $maxLength;
    }

    /**
     * Valider un mot de passe (exemple simple)
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        return strlen($password) >= 8;  // Le mot de passe doit comporter au moins 8 caractères
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
     * Vérifier si le mot de passe fourni correspond au mot de passe haché
     * @param string $inputPassword Le mot de passe saisi par l'utilisateur
     * @param string $hashedPassword Le mot de passe haché stocké en base de données
     * @return bool
     */
    public function verifyPassword(string $inputPassword, string $hashedPassword): bool
    {
        return password_verify($inputPassword, $hashedPassword);
    }
}
