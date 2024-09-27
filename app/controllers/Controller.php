<?php

namespace App\Controllers;

abstract class Controller
{
    /**
     * Méthode de rendu des vues.
     *
     * @param string $fichier Le nom du fichier de vue à inclure
     * @param array  $data    Les données à passer à la vue
     */
    public function render(string $fichier, array $data = [])
    {
        // Récupère les données et les extrait sous forme de variables
        extract($data);

        // Démarre la mise en tampon de sortie
        ob_start();

        // Inclut le fichier de vue
        require_once(ROOT . '/app/views/' . $fichier . '.php');

        // Récupère le contenu de la vue
        $content = ob_get_clean();

        // Inclut le template
        require_once(ROOT . '/app/views/layouts/default.php');
    }
}
