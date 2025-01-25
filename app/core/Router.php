<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $uri, callable|array $action): void
    {
        $this->addRoute('GET', $uri, $action);
    }

    public function post(string $uri, callable|array $action): void
    {
        $this->addRoute('POST', $uri, $action);
    }

    private function addRoute(string $method, string $uri, callable|array $action): void
    {
        $this->routes[$method][$uri] = $action;
    }

    public function dispatch(Request $request): void
    {
        $method = $request->getMethod();
        $uri = $request->getPath();

        foreach ($this->routes[$method] ?? [] as $route => $action) {
            // Convertit les paramètres dynamiques {id} en regex
            $pattern = preg_replace('#\{([a-zA-Z0-9_]+)\}#', '([a-zA-Z0-9_-]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Retire le match complet

                if (is_callable($action)) {
                    call_user_func($action, $request, ...$matches);
                } elseif (is_array($action) && count($action) === 2) {
                    [$controllerClass, $method] = $action;

                    if (class_exists($controllerClass) && method_exists($controllerClass, $method)) {
                        $controller = new $controllerClass();
                        call_user_func_array([$controller, $method], array_merge([$request], $matches));
                        return;
                    }
                }
                $this->notFound("Méthode ou contrôleur non trouvé.");
                return;
            }
        }

        $this->notFound("Route non définie.");
    }



    private function notFound(string $message): void
    {
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        echo "<p>$message</p>";
        exit();
    }
}
