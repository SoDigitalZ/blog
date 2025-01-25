<?php

namespace App\Controllers;

use App\Models\PostManager;
use App\Models\Post;
use App\Core\Request;
use App\Core\Session;

class PostsController extends Controller
{
    public function index()
    {
        $postManager = new PostManager();

        // Paramètres de pagination
        $postsPerPage = 16; // Nombre d'articles par page
        $currentPage = $_GET['page'] ?? 1; // Page actuelle (par défaut 1)
        $offset = ($currentPage - 1) * $postsPerPage; // Calcul de l'offset

        // Récupérer les articles paginés et le nombre total d'articles
        $posts = $postManager->findPaginated($postsPerPage, $offset);
        $totalPosts = $postManager->countAll();
        $totalPages = ceil($totalPosts / $postsPerPage);

        $this->render('posts/index', [
            'posts' => $posts,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }

    public function show(Request $request)
    {
        // Extraction de l'ID depuis l'URI
        $id = (int) basename($request->getPath()); // Extrait la dernière partie de l'URL (ex : /posts/show/3 -> 3)

        $postManager = new PostManager();
        $post = $postManager->find($id);

        if (!$post) {
            http_response_code(404);
            echo "<h1>404 Not Found</h1>";
            echo "<p>L'article demandé n'existe pas.</p>";
            exit();
        }

        $this->render('posts/show', compact('post'));
    }


    public function create()
    {
        $errors = [];
        $formData = $_POST;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérification de l'utilisateur connecté
            if (!Session::has('user')) {
                header('Location: /user/login');
                exit();
            }

            // Récupération de l'utilisateur connecté
            $userId = Session::get('user')['id'];

            // Validation des champs requis
            if (empty($formData['title'])) {
                $errors['title'] = "Le titre est obligatoire.";
            }
            if (empty($formData['content'])) {
                $errors['content'] = "Le contenu est obligatoire.";
            }

            // Gestion de l'upload d'image
            if ($_FILES['image']['error'] === 0)
                if (!empty($_FILES['image']['name'])) {
                    $uploadDir = __DIR__ . '/../../public/picture/post_image/';
                    $uploadFile = $uploadDir . basename($_FILES['image']['name']);

                    // Vérifier si le fichier est une image valide MIME + bonne extension + générer nom de fichier unique (en partant de uniq id)
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                        $errors['image'] = "Seuls les fichiers JPEG, PNG et GIF sont autorisés.";
                    } elseif (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                        $errors['image'] = "Une erreur est survenue lors du téléchargement de l'image.";
                    } else {
                        $formData['image'] = '/picture/post_image/' . basename($_FILES['image']['name']);
                    }
                }

            if (empty($errors)) {
                $formData['user_id'] = $userId;

                // Création de l'article
                $post = new Post($formData);
                $postManager = new PostManager();
                if ($postManager->create($post)) {
                    header('Location: /user/profile');
                    exit();
                } else {
                    $errors['general'] = "Une erreur est survenue lors de l'enregistrement de l'article.";
                }
            }
        }

        // Transmettre les erreurs et données à la vue
        $this->render('posts/create', [
            'errors' => $errors,
            'formData' => $formData,
        ]);
    }


    public function edit(Request $request, int $id)
    {
        $postManager = new PostManager();
        $post = $postManager->find($id);

        if (!$post) {
            http_response_code(404);
            echo "<h1>404 Not Found</h1>";
            echo "<p>L'article demandé n'existe pas.</p>";
            exit();
        }

        $errors = [];
        $formData = array_map(function ($value) {
            return is_array($value) ? '' : trim($value);
        }, $request->allPost());
        // Récupère les données POST

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gestion de l'upload d'une nouvelle image
            if (!empty($_FILES['image']['name'])) {
                $uploadDir = __DIR__ . '/../../public/picture/post_image/';
                $uploadFile = $uploadDir . basename($_FILES['image']['name']);

                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                    $errors['image'] = "Seuls les fichiers JPEG, PNG et GIF sont autorisés.";
                } elseif (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $errors['image'] = "Une erreur est survenue lors du téléchargement de l'image.";
                } else {
                    $formData['image'] = '/picture/post_image/' . basename($_FILES['image']['name']);
                }
            } else {
                // Si aucune nouvelle image n'est uploadée, conserver l'image actuelle
                $formData['image'] = $post->getImage();
            }

            // Validation avec ValidatorPost (facultatif)
            $validator = new ValidatorPost($formData);
            $validator->validate();

            if ($validator->isValid()) {
                $post->setTitle($formData['title'])
                    ->setChapo($formData['chapo'])
                    ->setContent($formData['content'])
                    ->setImage($formData['image'])
                    ->setCategoryId($formData['category_id']);

                if ($postManager->update($post)) {
                    header('Location: /user/profile');
                    exit();
                } else {
                    $errors['general'] = "Une erreur est survenue lors de la mise à jour de l'article.";
                }
            } else {
                $errors = $validator->getErrors();
            }
        }

        $this->render('posts/edit', [
            'post' => $post,
            'errors' => $errors,
            'formData' => $formData,
        ]);
    }

    public function delete(Request $request, int $id)
    {
        $postManager = new PostManager();
        $post = $postManager->find($id);

        if (!$post) {
            http_response_code(404);
            echo "<h1>404 Not Found</h1>";
            echo "<p>L'article demandé n'existe pas.</p>";
            exit();
        }

        if ($postManager->delete($id)) {
            header('Location: /posts');
            exit();
        } else {
            echo "<h1>Erreur</h1>";
            echo "<p>Impossible de supprimer l'article.</p>";
        }
    }
}
