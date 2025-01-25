<?php

namespace App\Core;

class Request
{
    private array $get;
    private array $post;
    private string $method;
    private string $uri;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    /**
     * Récupère une valeur dans $_GET.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->get[$key] ?? $default;
    }

    /**
     * Récupère une valeur dans $_POST.
     */
    public function post(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $default;
    }

    /**
     * Vérifie si une clé existe dans $_GET.
     */
    public function hasGet(string $key): bool
    {
        return isset($this->get[$key]);
    }

    /**
     * Vérifie si une clé existe dans $_POST.
     */
    public function hasPost(string $key): bool
    {
        return isset($this->post[$key]);
    }

    /**
     * Récupère toutes les données de $_GET.
     */
    public function allGet(): array
    {
        return $this->get;
    }

    /**
     * Récupère toutes les données de $_POST.
     */
    public function allPost(): array
    {
        return $this->post;
    }

    /**
     * Récupère la méthode HTTP de la requête.
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Récupère le chemin de l'URI sans les paramètres.
     */
    public function getPath(): string
    {
        return $this->uri;
    }
}
