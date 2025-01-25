<?php

namespace App\Controllers;

use App\Models\UserManager;

class ValidatorUser extends Validator
{
    private UserManager $userManager;
    private $user;

    public function __construct(array $formData)
    {
        parent::__construct($formData);
        $this->userManager = new UserManager();
    }

    /**
     * Valide le formulaire de connexion.
     */
    public function validate(): void
    {
        $this->validateEmail('email');

        // Pas de vérification stricte sur le format du mot de passe lors de la connexion
        $this->validatePassword('password', strict: false);

        // Si l'email et le mot de passe sont valides (pas d'erreurs jusque là)
        if ($this->isValid()) {
            // Récupérer l'utilisateur depuis la base de données
            $this->user = $this->userManager->findOneByEmail($this->data['email']);

            if (!$this->user) {
                // Si l'utilisateur n'existe pas, on affiche l'erreur sur l'email
                $this->addError('email', "Identifiant et/ou mot de passe incorrect.");
            } elseif (!password_verify($this->data['password'], $this->user->getPassword())) {
                // Si le mot de passe est incorrect, on affiche l'erreur sur l'email
                $this->addError('email', "Identifiant et/ou mot de passe incorrect.");
            }
        }
    }

    /**
     * Récupère l'utilisateur validé
     * 
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }
}
