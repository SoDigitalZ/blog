<?php

namespace App\Controllers;

abstract class Validator
{
    protected array $errors = [];
    protected array $data = [];

    public function __construct(array $formData)
    {
        $this->data = $formData;
        $this->normalize(); // Normalise les données à la création
    }

    /**
     * Méthode abstraite, chaque classe enfant doit implémenter sa propre logique de validation.
     */
    abstract public function validate(): void;

    /**
     * Normalise les données (trim des chaînes de caractères).
     */
    protected function normalize(): void
    {
        foreach ($this->data as $key => $value) {
            $this->data[$key] = is_string($value) ? trim($value) : $value;
        }
    }

    /**
     * Valide une chaîne de caractères selon des critères de longueur.
     */
    public function validateString(string $field, array $options = []): void
    {
        $value = $this->data[$field] ?? '';

        // Validation de la présence du champ si requis
        if (!empty($options['required']) && empty($value)) {
            $this->addError($field, $options['message'] ?? "Le champ $field est requis.");
            return;
        }

        // Validation de la longueur minimale
        if (!empty($options['minLength']) && strlen($value) < $options['minLength']) {
            $this->addError($field, $options['message'] ?? "Le champ $field doit comporter au moins {$options['minLength']} caractères.");
        }

        // Validation de la longueur maximale
        if (!empty($options['maxLength']) && strlen($value) > $options['maxLength']) {
            $this->addError($field, $options['message'] ?? "Le champ $field ne peut pas dépasser {$options['maxLength']} caractères.");
        }
    }

    /**
     * Valide une URL.
     */
    public function validateUrl(string $field, array $options = []): void
    {
        $value = $this->data[$field] ?? '';

        // Validation de la présence du champ si requis
        if (!empty($options['required']) && empty($value)) {
            $this->addError($field, $options['message'] ?? "L'URL est obligatoire.");
            return;
        }

        // Validation de la validité de l'URL
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
            $this->addError($field, $options['message'] ?? "L'URL fournie n'est pas valide.");
        }
    }

    /**
     * Valide une valeur numérique.
     */
    public function validateNumeric(string $field, array $options = []): void
    {
        $value = $this->data[$field] ?? '';

        // Validation de la présence du champ si requis
        if (!empty($options['required']) && empty($value)) {
            $this->addError($field, $options['message'] ?? "Le champ $field est requis.");
            return;
        }

        // Validation si la valeur est numérique
        if (!is_numeric($value)) {
            $this->addError($field, $options['message'] ?? "Le champ $field doit être un nombre.");
            return;
        }

        // Validation si la valeur doit être positive
        if (!empty($options['positive']) && $value <= 0) {
            $this->addError($field, $options['message'] ?? "Le champ $field doit être un nombre positif.");
        }
    }

    /**
     * Ajoute une erreur pour un champ.
     */
    public function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    /**
     * Retourne toutes les erreurs de validation.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Vérifie si le formulaire est valide.
     */
    public function isValid(): bool
    {
        return empty($this->errors);
    }
}
