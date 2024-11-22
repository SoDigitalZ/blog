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
    private ValidatorRegister $validator;
    private PostManager $postManager;

    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->validator = new ValidatorRegister();
        $this->postManager = new PostManager();
    }

    public function login(Request $request)
    {
        if (Session::has('user')) {
            header('Location: /admin');
            exit;
        }

        $fieldErrors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $request->post('email');
            $password = $request->post('password');

            $user = $this->userManager->findOneByEmail($email);

            $validationResult = $this->validator->validateLogin(
                ['email' => $email, 'password' => $password],
                userExists: $user !== null,
                passwordValid: $user ? $this->validator->verifyPassword($password, $user->getPassword()) : null
            );

            $fieldErrors = $validationResult['errors'];

            if (empty($fieldErrors)) {
                Session::set('user', [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'role' => $user->getRole(),
                ]);
                header('Location: /');
                exit;
            }
        }

        $this->render('login/index', ['fieldErrors' => $fieldErrors]);
    }

    public function register(Request $request)
    {
        $fieldErrors = [];
        $formData = $request->allPost();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formToken = $request->post('form_token');
            if (!$formToken || $formToken !== Session::get('form_token', '')) {
                $fieldErrors['form_token'] = "Soumission de formulaire non autorisée.";
            }
            Session::delete('form_token');

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

        $formToken = bin2hex(random_bytes(32));
        Session::set('form_token', $formToken);

        $this->render('user/register', [
            'fieldErrors' => $fieldErrors,
            'formData' => $formData,
            'form_token' => $formToken,
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
        $currentPage = $request->get('page', 1);
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
        return Session::has('user');
    }

    public function logout()
    {
        Session::delete('user');
        Session::destroy();
        header('Location: /');
        exit;
    }
}
