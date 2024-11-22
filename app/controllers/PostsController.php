<?php

namespace App\Controllers;

use App\Models\PostManager;
use App\Models\Post;

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


    public function show(int $id)
    {
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
            // Validation des champs requis
            if (empty($formData['title'])) {
                $errors['title'] = "Le titre est obligatoire.";
            }
            if (empty($formData['chapo'])) {
                $errors['chapo'] = "Le chapeau est obligatoire.";
            }
            if (empty($formData['content'])) {
                $errors['content'] = "Le contenu est obligatoire.";
            }

            if (empty($errors)) {
                $post = new Post($formData);

                $postManager = new PostManager();
                if ($postManager->create($post)) {
                    header('Location: /posts');
                    exit();
                } else {
                    $errors['general'] = "Une erreur est survenue lors de l'enregistrement de l'article.";
                }
            }
        }

        $this->render('posts/create', [
            'errors' => $errors,
            'formData' => $formData
        ]);
    }

    public function edit(int $id)
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
        $formData = $_POST;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($formData['title'])) {
                $errors['title'] = "Le titre est obligatoire.";
            }
            if (empty($formData['chapo'])) {
                $errors['chapo'] = "Le chapeau est obligatoire.";
            }
            if (empty($formData['content'])) {
                $errors['content'] = "Le contenu est obligatoire.";
            }

            if (empty($errors)) {
                $post->setTitle($formData['title'])
                    ->setChapo($formData['chapo'])
                    ->setContent($formData['content']);

                if ($postManager->update($post)) {
                    header('Location: /posts');
                    exit();
                } else {
                    $errors['general'] = "Une erreur est survenue lors de la mise à jour de l'article.";
                }
            }
        }

        $this->render('posts/edit', [
            'post' => $post,
            'errors' => $errors,
            'formData' => $formData
        ]);
    }

    public function delete(int $id)
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
