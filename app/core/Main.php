<?php

namespace App\Core;

use App\Core\Request;

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
        $params = array_slice($segments, 2); // Les paramètres supplémentaires

        // Namespace complet du contrôleur
        $controllerClass = '\\App\\Controllers\\' . $controllerName;

        // Instancie la classe Request
        $request = new Request();

        // Vérifie si le contrôleur existe
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();

            // Vérifie si l'action existe dans le contrôleur
            if (method_exists($controller, $actionName)) {
                // Utilisation de Reflection pour gérer les paramètres
                $reflectionMethod = new \ReflectionMethod($controller, $actionName);
                $methodParameters = $reflectionMethod->getParameters();

                // Prépare les arguments à passer à la méthode
                $arguments = [];

                foreach ($methodParameters as $parameter) {
                    $parameterType = $parameter->getType()?->getName();

                    // Si le paramètre est de type Request, on passe l'objet Request
                    if ($parameterType === Request::class) {
                        $arguments[] = $request;
                    } else {
                        // Sinon, on prend le prochain paramètre de l'URL
                        $arguments[] = array_shift($params);
                    }
                }

                // Appelle l'action avec les arguments préparés
                $reflectionMethod->invokeArgs($controller, $arguments);
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
    private function notFound(string $message)
    {
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        echo "<p>$message</p>";
        exit();
    }
}
