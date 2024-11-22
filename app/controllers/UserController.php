<?php

namespace App\Controllers;

use App\Models\UserManager;
use App\Models\User;
use App\Controllers\ValidatorRegister;
use App\Models\PostManager;

class UserController extends Controller
{
    private UserManager $userManager;
    private ValidatorRegister $validator;
    private PostManager $postManager;

    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->validator = new ValidatorRegister();
        $this->postManager = new PostManager();
    }

    public function login()
    {
        if ($this->isUserLoggedIn()) {
            header('Location: /admin');
            exit;
        }

        $fieldErrors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->userManager->findOneByEmail($_POST['email'] ?? null);

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
        $formData = $_POST;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($formData['form_token']) || $formData['form_token'] !== ($_SESSION['form_token'] ?? '')) {
                $fieldErrors['form_token'] = "Soumission de formulaire non autorisée.";
            }
            unset($_SESSION['form_token']);

            $user = new User($formData);
            $fieldErrors = $this->validator->validateRegistration($user);

            if (empty($fieldErrors)) {
                try {
                    if ($this->userManager->registerUser($user)) {
                        $this->render('user/register', ['success' => "Utilisateur enregistré avec succès."]);
                        return;
                    }
                    $fieldErrors['general'] = "Une erreur est survenue lors de l'enregistrement.";
                } catch (\Exception $e) {
                    error_log($e->getMessage());
                    $fieldErrors['general'] = "Erreur inattendue. Veuillez réessayer plus tard.";
                }
            }
        }

        $form_token = bin2hex(random_bytes(32));
        $_SESSION['form_token'] = $form_token;

        $this->render('user/register', [
            'fieldErrors' => $fieldErrors,
            'formData' => $formData,
            'form_token' => $form_token
        ]);
    }

    public function profile()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /user/login');
            exit;
        }

        $user = $_SESSION['user'];
        $postsPerPage = 5;
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0
            ? (int)$_GET['page']
            : 1;
        $offset = ($currentPage - 1) * $postsPerPage;

        $posts = $this->postManager->findPaginatedByUser($user['id'], $postsPerPage, $offset);
        $totalPosts = $this->postManager->countByUser($user['id']);
        $totalPages = ceil($totalPosts / $postsPerPage);

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
        return isset($_SESSION['user']);
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        header('Location: /');
        exit;
    }
}
