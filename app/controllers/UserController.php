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
        // Si l'utilisateur est déjà connecté, redirection vers la page admin
        if ($this->isUserLoggedIn()) {
            header('Location: /admin');
            exit;
        }

        // Si le formulaire de connexion a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Création d'une instance du validateur
            $validator = new ValidatorUser();

            // Nettoyage des données du formulaire
            $email = $validator->sanitizeEmail($_POST['email']);
            $password = $_POST['password'];

            // Validation du formulaire
            if ($validator->validateLoginForm($email, $password)) {
                // Création d'une instance de UserManager pour interagir avec la base de données
                $userManager = new UserManager();

                // Recherche de l'utilisateur par email
                $userFind = $userManager->findOneByEmail($email);

                if ($userFind) {
                    // Hydratation de l'objet User avec les données trouvées
                    $user = new User();
                    $user->hydrate($userFind);

                    // Vérification du mot de passe
                    if ($validator->verifyPassword($password, $user->getPassword())) {
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
     * Fonction d'inscription
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données soumises via le formulaire
            // Rajouter $_Post invisible sur la page pour checker si bon form et pas autre
            // créer objet user et utilliser setter pour enregistrer les info dans l'objet
            $data = [
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'phone' => $_POST['phone']
            ];

            // Instancier le validateur utilisateur -- rajouter objet
            $validator = new ValidatorUser($objet);

            // Valider les données d'inscription -- virer $data car $objet créé sur $validator
            $validateForm = $validator->validateRegistration();

            if (empty($validateForm)) {
                // Si tout est valide, enregistrer l'utilisateur via UserManager ne pas oublier $objet
                $userManager = new UserManager($objet);
                $userManager->registerUser($objet);

                // Redirection ou message de succès
                echo "Utilisateur enregistré avec succès.";
            } else {
                // Affichage des erreurs
                foreach ($errors as $error) {
                    echo "<p style='color:red;'>$error</p>";
                }
            }
        } else {
            // Afficher le formulaire d'inscription
            $this->render('user/register');
        }
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
     * Détruit la session utilisateur
     */
    private function destroyUserSession()
    {
        unset($_SESSION['user']);
        session_destroy();
    }
}
