<?php

namespace App\Controllers;

class ValidatorPost extends Validator
{
    /**
     * Valide les données d'un article.
     */
    public function validate(): void
    {
        // Valide le titre : obligatoire, chaîne de caractères, longueur minimale/maximale
        $this->validateString('title', [
            'required' => true,
            'minLength' => 3,
            'maxLength' => 255,
            'message' => "Le titre doit comporter entre 3 et 255 caractères.",
        ]);

        // Valide le chapeau : obligatoire, chaîne de caractères, longueur maximale
        $this->validateString('chapo', [
            'required' => true,
            'maxLength' => 255,
            'message' => "Le chapeau ne peut pas dépasser 255 caractères.",
        ]);

        // Valide le contenu : obligatoire, chaîne de caractères, longueur minimale
        $this->validateString('content', [
            'required' => true,
            'minLength' => 10,
            'message' => "Le contenu doit comporter au moins 10 caractères.",
        ]);

        // Valide l'URL de l'image
        $this->validateUrl('image', [
            'required' => false, // L'image est optionnelle
            'message' => "L'URL de l'image n'est pas valide.",
        ]);

        // Valide la catégorie : obligatoire, numérique et positive
        $this->validateNumeric('category_id', [
            'required' => true,
            'positive' => true,
            'message' => "La catégorie est invalide.",
        ]);
    }
}
