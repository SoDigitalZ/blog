<?php

namespace App\Core;

class Main
{
    public function start()
    {
        // Récupère l'URL et supprime les paramètres éventuels
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Supprime les '/' initiaux et finaux
        $uri = trim($uri, '/');

        // Découpe l'URI en segments
        $segments = explode('/', $uri);

        // Définit le contrôleur, l'action, et les paramètres
        $controllerName = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'MainController';
        $actionName = isset($segments[1]) ? $segments[1] : 'index';
        $params = array_slice($segments, 2);

        // Namespace complet du contrôleur
        $controllerClass = '\\App\\Controllers\\' . $controllerName;

        // Vérifie si le contrôleur existe
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();

            // Vérifie si l'action existe dans le contrôleur
            if (method_exists($controller, $actionName)) {
                // Appelle l'action et passe les paramètres
                call_user_func_array([$controller, $actionName], $params);
            } else {
                // Gère l'erreur d'action non trouvée
                $this->notFound("Action '$actionName' non trouvée dans le contrôleur '$controllerName'.");
            }
        } else {
            // Gère l'erreur de contrôleur non trouvé
            $this->notFound("Contrôleur '$controllerName' non trouvé.");
        }
    }

    /**
     * Affiche une page d'erreur 404
     *
     * @param string $message
     */
    private function notFound($message)
    {
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        echo "<p>$message</p>";
        exit();
    }
}
