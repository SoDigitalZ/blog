<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Session;
use App\Models\UserManager;
use App\Models\User;
use App\Controllers\ValidatorRegister;
use App\Models\PostManager;

class UserController extends Controller
{
    private UserManager $userManager;
    private PostManager $postManager;

    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->postManager = new PostManager();
    }

    /**
     * Gestion de la connexion de l'utilisateur
     */
    public function login(Request $request)
    {
        // Redirection si l'utilisateur est déjà connecté
        if (Session::has('user')) {
            header('Location: /');
            exit;
        }

        // Récupération des données du formulaire
        $formData = $request->allPost();
        // -> voir register - $user = new User($formData);

        // Validation avec ValidatorUser
        $validator = new ValidatorUser($formData);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator->validate(); // Exécute la validation
        }

        $fieldErrors = $validator->getErrors();

        // Si la validation est correcte et qu'aucune erreur n'est présente
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $validator->isValid()) {
            $user = $validator->getUser();
            if ($user) {
                // Création de la session utilisateur
                Session::set('user', [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'role' => $user->getRole(),
                ]);
                header('Location: /');
                exit;
            }
        }

        // On affiche la vue de connexion avec la ternaire pour les erreurs
        $this->render('login/index', [
            'fieldErrors' => $fieldErrors ?? [],
            'formData' => $formData
        ]);
    }

    /**
     * Gestion de l'inscription de l'utilisateur
     */
    public function register(Request $request)
    {
        if (Session::has('user')) {
            header('Location: /');
            exit;
        }

        $formData = $request->allPost();
        $fieldErrors = [];
        $user = new User($formData); // On conserve l'objet User dès le début

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérification du token CSRF
            $formToken = $request->post('form_token');
            if (!$formToken || $formToken !== Session::get('form_token', '')) {
                $fieldErrors['form_token'] = 'Soumission de formulaire non autorisée.';
            }
            Session::delete('form_token');

            // Instancier et valider le formulaire
            $validator = new ValidatorRegister($formData); // passer l'user object
            $validator->validate();
            $fieldErrors = $validator->getErrors();

            if ($validator->isValid()) {
                try {
                    if ($this->userManager->registerUser($user)) {
                        $this->render('user/register', ['success' => 'Utilisateur enregistré avec succès.']);
                        return;
                    }
                    $fieldErrors['general'] = 'Une erreur est survenue lors de l\'enregistrement.';
                } catch (\Exception $e) {
                    error_log($e->getMessage());
                    $fieldErrors['general'] = 'Erreur inattendue. Veuillez réessayer plus tard.';
                }
            }
        }

        $formToken = bin2hex(random_bytes(32));
        Session::set('form_token', $formToken);

        $this->render('user/register', [
            'fieldErrors' => $fieldErrors ?? [],
            'formData' => $formData,
            'form_token' => $formToken,
            'user' => $user, // On renvoie aussi l'objet User à la vue
        ]);
    }

    public function profile(Request $request)
    {
        if (!Session::has('user')) {
            header('Location: /user/login');
            exit;
        }

        $user = Session::get('user');
        $postsPerPage = 5;
        $currentPage = (int) $request->get('page', 1);
        $offset = ($currentPage - 1) * $postsPerPage;

        $posts = $this->postManager->findPaginatedByUser($user['id'], $postsPerPage, $offset);
        $totalPosts = $this->postManager->countByUser($user['id']);
        $totalPages = (int) ceil($totalPosts / $postsPerPage);

        if ($currentPage > $totalPages && $totalPages > 0) {
            header("Location: /user/profile?page=$totalPages");
            exit();
        }

        $this->render('user/profile', [
            'user' => $user,
            'posts' => $posts,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }

    private function isUserLoggedIn(): bool
    {
        return Session::has('user');
    }

    public function logout()
    {
        if (!Session::has('user')) {
            header('Location: /user/login');
            exit;
        }

        Session::delete('user');
        Session::destroy();
        header('Location: /');
        exit;
    }
}
