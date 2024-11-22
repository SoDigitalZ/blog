<?php

namespace App\Controllers;

use App\Models\UserManager;
use App\Models\User;
use App\Controllers\ValidatorRegister;


class UserController extends Controller
{
    private UserManager $userManager;
    private ValidatorRegister $validator;

    public function __construct()
    {
        // Initialisation des dépendances
        $this->userManager = new UserManager();
        $this->validator = new ValidatorRegister(); // Utilisé pour les validations (extend ValidatorUser)
    }

    /**
     * Gérer la connexion d'un utilisateur
     */
    public function login()
    {
        if ($this->isUserLoggedIn()) {
            header('Location: /admin');
            exit;
        }

        $fieldErrors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupère l'utilisateur
            $user = $this->userManager->findOneByEmail($_POST['email'] ?? null);

            // Valide le formulaire
            $validationResult = $this->validator->validateLogin(
                $_POST,
                userExists: $user !== null,
                passwordValid: $user ? $this->validator->verifyPassword($_POST['password'], $user->getPassword()) : null
            );

            $fieldErrors = $validationResult['errors'];

            if (empty($fieldErrors)) {
                $this->userManager->setSession($user);
                header('Location: /');
                exit;
            }
        }

        $this->render('login/index', ['fieldErrors' => $fieldErrors]);
    }

    public function register()
    {
        $fieldErrors = [];
        $formData = $_POST; // Conserve les données saisies par l'utilisateur

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérification du token CSRF
            if (!isset($formData['form_token']) || $formData['form_token'] !== ($_SESSION['form_token'] ?? '')) {
                $fieldErrors['form_token'] = "Soumission de formulaire non autorisée.";
            }
            unset($_SESSION['form_token']); // Supprime le token après usage

            // Crée un objet User
            $user = new User($formData);

            // Valide l'objet User
            $fieldErrors = $this->validator->validateRegistration($user);

            if (empty($fieldErrors)) {
                // Enregistre l'utilisateur via le UserManager
                if ($this->userManager->registerUser($user)) {
                    $this->render('user/register', ['success' => "Utilisateur enregistré avec succès."]);
                    return;
                }

                $fieldErrors['general'] = "Une erreur est survenue lors de l'enregistrement.";
            }
        }

        $form_token = bin2hex(random_bytes(32));
        $_SESSION['form_token'] = $form_token;

        // Transmet les données saisies et les erreurs à la vue
        $this->render('user/register', [
            'fieldErrors' => $fieldErrors,
            'formData' => $formData,
            'form_token' => $form_token
        ]);
    }

    public function profile()
    {
        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header('Location: /user/login');
            exit;
        }

        // Récupère les données de l'utilisateur depuis la session
        $user = $_SESSION['user'];

        // Affiche la vue du profil
        $this->render('user/profile', ['user' => $user]);
    }

    private function isUserLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    public function logout()
    {
        // Supprime les données de la session
        unset($_SESSION['user']);
        session_destroy();

        // Redirige vers la page d'accueil
        header('Location: /');
        exit;
    }
}
