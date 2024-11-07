<?php

namespace App\Controllers;

use App\Models\UserManager;
use App\Models\User;
use App\Controllers\ValidatorRegister;

class UserController extends Controller
{
    /**
     * Fonction de connexion
     */
    public function index()
    {
        if ($this->isUserLoggedIn()) {
            header('Location: /admin');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new ValidatorRegister();
            $email = $validator->sanitizeEmail($_POST['email']);
            $password = $_POST['password'];

            if ($validator->validateLoginForm($email, $password)) {
                $userManager = new UserManager();
                $userFind = $userManager->findOneByEmail($email);

                if ($userFind) {
                    $user = new User();
                    $user->hydrate($userFind);

                    if ($validator->verifyPassword($password, $user->getPassword())) {
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

        $this->render('login/index', ['error' => $error ?? null]);
    }

    /**
     * Fonction d'inscription
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            // Vérification du token CSRF
            if (!isset($_POST['form_token']) || $_POST['form_token'] !== $_SESSION['form_token']) {
                $errors[] = "Soumission de formulaire non autorisée.";
            }

            // Supprimer le token après vérification pour empêcher une réutilisation
            unset($_SESSION['form_token']);

            // Récupérer les données du formulaire et les stocker dans un tableau
            $formData = [
                'first_name' => $_POST['first_name'] ?? '',
                'last_name' => $_POST['last_name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'confirmedPassword' => $_POST['confirmedPassword'] ?? ''
            ];

            // Créer et valider les données utilisateur
            $user = new User();
            $user->setFirstName($formData['first_name']);
            $user->setLastName($formData['last_name']);
            $user->setEmail($formData['email']);
            $user->setPassword($formData['password']);
            $user->setPhone($formData['phone']);

            // Validation avec ValidatorRegister
            $validator = new ValidatorRegister();
            $errors = array_merge($errors, $validator->validateRegistration($formData));

            // Enregistrer l'utilisateur si pas d'erreurs
            if (empty($errors)) {
                $userManager = new UserManager();
                if ($userManager->registerUser($user)) {
                    $success = "Utilisateur enregistré avec succès.";
                    $this->render('user/register', ['success' => $success]);
                    return;
                } else {
                    $errors[] = "Une erreur est survenue lors de l'enregistrement. Veuillez réessayer.";
                }
            }

            // Générer un nouveau token pour la prochaine soumission
            $form_token = bin2hex(random_bytes(32));
            $_SESSION['form_token'] = $form_token;

            // En cas d'erreur, retourner les données du formulaire et les erreurs
            $this->render('user/register', [
                'errors' => $errors,
                'formData' => $formData,
                'form_token' => $form_token
            ]);
        } else {
            // Première demande (GET) pour afficher le formulaire avec le token
            $form_token = bin2hex(random_bytes(32));
            $_SESSION['form_token'] = $form_token;
            $this->render('user/register', ['form_token' => $form_token]);
        }
    }


    /**
     * Fonction de déconnexion
     */
    public function logout()
    {
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
     * Détruit la session utilisateur
     */
    private function destroyUserSession()
    {
        unset($_SESSION['user']);
        session_destroy();
    }
}
