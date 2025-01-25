<?php

namespace App\Core;

use App\Controllers\PostsController;
use App\Controllers\UserController;

class Main
{
    public function start(): void
    {
        // Instancie les classes nécessaires
        $request = new Request();
        $router = new Router();

        // Définit les routes
        $router->get('/', [\App\Controllers\MainController::class, 'index']);
        $router->get('/user/profile', [UserController::class, 'profile']);
        $router->get('/posts', [PostsController::class, 'index']);
        $router->get('/posts/show/{id}', [PostsController::class, 'show']);
        $router->get('/posts/create', [\App\Controllers\PostsController::class, 'create']);
        $router->post('/posts/create', [\App\Controllers\PostsController::class, 'create']);
        $router->get('/posts/edit/{id}', [PostsController::class, 'edit']);
        $router->post('/posts/edit/{id}', [PostsController::class, 'edit']);
        $router->post('/posts/delete/{id}', [PostsController::class, 'delete']);
        $router->get('/posts/show/{id}', [\App\Controllers\PostsController::class, 'show']);
        $router->get('/categories', [\App\Controllers\CategoriesController::class, 'index']);
        $router->get('/categories/create', [\App\Controllers\CategoriesController::class, 'create']);
        $router->post('/categories/create', [\App\Controllers\CategoriesController::class, 'create']);
        $router->get('/categories/edit/{id}', [\App\Controllers\CategoriesController::class, 'edit']);
        $router->post('/categories/edit/{id}', [\App\Controllers\CategoriesController::class, 'edit']);
        $router->get('/categories/delete/{id}', [\App\Controllers\CategoriesController::class, 'delete']);

        // Lance le routeur
        $router->dispatch($request);
    }
}
