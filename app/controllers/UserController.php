<?php

namespace App\Controllers;

use App\Models\UserManager;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Fonction de connexion
     */
    public function index()
    {
        // Si l'utilisateur est déjà connecté, redirection vers la page admin
        if ($this->isUserLoggedIn()) {
            header('Location: /admin');
            exit;
        }

        // Si le formulaire de connexion a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Nettoyage des données du formulaire
            $email = $this->sanitizeEmail($_POST['email']);
            $password = $_POST['password'];

            // Validation du formulaire
            if ($this->validateLoginForm($email, $password)) {
                // Création d'une instance de UserManager qui utilise la connexion unique via Db
                $userManager = new UserManager();

                // Recherche de l'utilisateur par email
                $userFind = $userManager->findOneByEmail($email);

                if ($userFind) {
                    // Hydratation de l'objet User avec les données trouvées
                    $user = new User();
                    $user->hydrate($userFind);

                    // Vérification du mot de passe
                    if ($this->verifyPassword($password, $user->getPassword())) {
                        // Création de la session utilisateur
                        $userManager->setSession($user);
                        header('Location: /admin');
                        exit;
                    } else {
                        $error = "Mot de passe incorrect.";
                    }
                } else {
                    $error = "Utilisateur introuvable.";
                }
            } else {
                $error = "Veuillez remplir tous les champs.";
            }
        }

        // Affichage de la vue de connexion avec un éventuel message d'erreur
        $this->render('login/index', ['error' => $error ?? null]);
    }

    /**
     * Fonction de déconnexion
     */
    public function logout()
    {
        // Suppression de la session utilisateur
        $this->destroyUserSession();
        header('Location: /');
        exit;
    }

    /**
     * Vérifie si un utilisateur est connecté
     */
    private function isUserLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * Crée une session utilisateur
     */
    private function createUserSession(User $user)
    {
        $_SESSION['user'] = [
            'id' => $user->getId(),
            'email' => $user->getEmail()
        ];
    }

    /**
     * Détruit la session utilisateur
     */
    private function destroyUserSession()
    {
        unset($_SESSION['user']);
        session_destroy();
    }

    /**
     * Nettoie l'email
     */
    private function sanitizeEmail(string $email): string
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Valide le formulaire de connexion
     */
    private function validateLoginForm(string $email, string $password): bool
    {
        return !empty($email) && !empty($password);
    }

    /**
     * Vérifie si le mot de passe est correct
     */
    private function verifyPassword(string $inputPassword, string $hashedPassword): bool
    {
        return password_verify($inputPassword, $hashedPassword);
    }
}
