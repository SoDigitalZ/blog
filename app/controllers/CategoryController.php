<?php

namespace App\Controllers;

use App\Models\Category;
use App\Core\Session;
use App\Core\Request;

class CategoriesController
{
    public function index()
    {
        $categories = Category::getAll();

        $this->render('categories/index', [
            'categories' => $categories,
        ]);
    }

    public function create(Request $request)
    {
        $errors = [];
        $formData = $request->allPost();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($formData['name'])) {
                $errors['name'] = "Le nom de la catégorie est obligatoire.";
            }

            if (empty($errors)) {
                $category = new Category();
                $category->setName($formData['name']);
                $category->save();

                Session::set('success', 'Catégorie ajoutée avec succès.');
                header('Location: /categories');
                exit();
            }
        }

        $this->render('categories/create', [
            'errors' => $errors,
            'formData' => $formData,
        ]);
    }

    public function edit(Request $request, int $id)
    {
        $category = Category::find($id);

        if (!$category) {
            http_response_code(404);
            echo "<h1>404 Not Found</h1>";
            echo "<p>Catégorie introuvable.</p>";
            exit();
        }

        $errors = [];
        $formData = $request->allPost();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($formData['name'])) {
                $errors['name'] = "Le nom de la catégorie est obligatoire.";
            }

            if (empty($errors)) {
                $category->setName($formData['name']);
                $category->save();

                Session::set('success', 'Catégorie modifiée avec succès.');
                header('Location: /categories');
                exit();
            }
        }

        $this->render('categories/edit', [
            'category' => $category,
            'errors' => $errors,
        ]);
    }

    public function delete(int $id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->delete();
            Session::set('success', 'Catégorie supprimée avec succès.');
        }

        header('Location: /categories');
        exit();
    }

    private function render(string $view, array $data = [])
    {
        extract($data);
        require ROOT . "/views/{$view}.php";
    }
}
