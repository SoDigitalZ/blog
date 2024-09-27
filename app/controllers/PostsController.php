<?php

namespace App\Controllers;

use App\Models\PostManager;

class PostsController extends Controller
{
    /**
     * Affiche la liste des articles.
     */
    public function index()
    {
        // Instancie le PostManager pour accéder aux articles
        $postManager = new PostManager();

        // Récupère tous les articles
        $posts = $postManager->findAll();

        // Rend la vue avec les données des articles
        $this->render('posts/index', compact('posts'));
    }

    /**
     * Affiche un article spécifique par son ID.
     * @param int $id L'ID de l'article
     */
    public function show($id)
    {
        // Instancie le PostManager pour accéder aux articles
        $postManager = new PostManager();

        // Récupère l'article avec l'ID spécifié
        $post = $postManager->find($id, 'id');

        // Si l'article n'existe pas, affiche une page 404
        if (!$post) {
            http_response_code(404);
            echo "L'article n'existe pas.";
            exit();
        }

        // Rend la vue avec les données de l'article
        $this->render('posts/show', compact('post'));
    }
}
