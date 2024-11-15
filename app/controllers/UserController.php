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
            // Vérification du token CSRF
            if (!isset($_POST['form_token']) || !isset($_SESSION['form_token']) || $_POST['form_token'] !== $_SESSION['form_token']) {
                $errors[] = "Soumission de formulaire non autorisée.";
                // Regénérer le token pour permettre une nouvelle soumission
                //$form_token = bin2hex(random_bytes(32));
                //          $_SESSION['form_token'] = $form_token;
                //        $this->render('user/register', ['errors' => $errors, 'form_token' => $form_token]);
                //        return;
            } else {

                // Supprimer le token après vérification pour empêcher une réutilisation
                //unset($_SESSION['form_token']);

                // Création de l'objet User et hydratation
                $user = new User();
                $user->setFirstName($_POST['first_name']);
                $user->setLastName($_POST['last_name']);
                $user->setEmail($_POST['email']);
                $user->setPassword($_POST['password']);
                $user->setConfirmedPassword($_POST['confirmedPassword']);
                $user->setPhone($_POST['phone']);
                $confirmedPassword = $_POST['confirmedPassword'];

                // Préparer les données pour la validation
                //  $userData = [
                //      'first_name' => $user->getFirstName(),
                //     'last_name' => $user->getLastName(),
                //      'email' => $user->getEmail(),
                //      'password' => $user->getPassword(),
                //      'phone' => $user->getPhone(),
                //      'confirmedPassword' => $confirmedPassword
                //   ];

                // Valider les données avec ValidatorRegister
                $validator = new ValidatorRegister();
                $errors = $validator->validateRegistration($user);

                if (empty($errors)) {
                    $userManager = new UserManager();
                    if ($userManager->registerUser($user)) {
                        $success = "Utilisateur enregistré avec succès.";
                        //$this->render('user/register', ['success' => $success]);
                    } else {
                        $errors[] = "Une erreur est survenue lors de l'enregistrement. Veuillez réessayer.";
                        // Regénérer un nouveau token pour permettre une nouvelle soumission en cas d'erreur d'enregistrement
                        //          $form_token = bin2hex(random_bytes(32));
                        //         $_SESSION['form_token'] = $form_token;
                        //$this->render('user/register', ['errors' => $errors, 'form_token' => $form_token]);
                    }
                } else {
                    // Afficher les erreurs de validation et regénérer le token pour permettre une nouvelle tentative
                    //         $form_token = bin2hex(random_bytes(32));
                    //          $_SESSION['form_token'] = $form_token;
                    //$this->render('user/register', ['errors' => $errors, 'form_token' => $form_token]);
                }
            }
        } //else {
        // Générer et stocker le token CSRF dans la session pour la première affichage du formulaire
        $form_token = bin2hex(random_bytes(32));
        $_SESSION['form_token'] = $form_token;

        // Afficher le formulaire d'inscription avec le token
        $this->render('user/register', [
            'form_token' => $form_token,
            'errors' => $errors ?? '',
            'success' => $success ?? ''
        ]);
        //   }
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
