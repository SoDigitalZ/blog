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

        $error = null;

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

        $this->render('login/index', ['error' => $error]);
    }

    /**
     * Fonction d'inscription
     */
    public function register()
    {
        $errors = [];
        $formData = [
            'first_name' => $_POST['first_name'] ?? '',
            'last_name' => $_POST['last_name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'confirmedPassword' => $_POST['confirmedPassword'] ?? ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérification du token CSRF
            if (!isset($_POST['form_token']) || $_POST['form_token'] !== ($_SESSION['form_token'] ?? '')) {
                $errors[] = "Soumission de formulaire non autorisée.";
            }
            unset($_SESSION['form_token']); // Supprime le token pour éviter sa réutilisation

            // Validation des données d'inscription
            $validator = new ValidatorRegister();
            $errors = array_merge($errors, $validator->validateRegistration($formData)); //validator ?? construct formdata

            if (empty($errors)) {
                $user = (new User())
                    ->setFirstName($formData['first_name'])
                    ->setLastName($formData['last_name'])
                    ->setEmail($formData['email'])
                    ->setPassword(password_hash($formData['password'], PASSWORD_BCRYPT))
                    ->setPhone($formData['phone']);

                //   $user=new User($formData); (à corriger, remplacer 81/86)

                $userManager = new UserManager();
                if ($userManager->registerUser($user)) {
                    $this->render('user/register', ['success' => "Utilisateur enregistré avec succès."]);
                    return;
                } else {
                    $errors[] = "Une erreur est survenue lors de l'enregistrement. Veuillez réessayer.";
                }
            }
        }

        // Génère un nouveau token CSRF uniquement en cas de première demande ou d'erreurs
        $form_token = bin2hex(random_bytes(32));
        $_SESSION['form_token'] = $form_token;

        // Affichage du formulaire avec les erreurs et les données pré-remplies
        $this->render('user/register', [
            'errors' => $errors,
            'formData' => $formData,
            'form_token' => $form_token
        ]);
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
