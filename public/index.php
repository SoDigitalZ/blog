<?php

session_set_cookie_params([
    'secure' => true, // En HTTPS uniquement
    'httponly' => true, // Accessible uniquement via PHP
    'samesite' => 'Strict' // Protège contre les attaques CSRF
]);
// Démarrage de la session pour permettre l'utilisation de $_SESSION partout
session_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

// Inclure l'autoloader de Composer avant d'utiliser Whoops
require __DIR__ . '/../vendor/autoload.php';

// Utilisation de Whoops pour gérer les erreurs
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// On définit une constante contenant le dossier racine
define('ROOT', dirname(__DIR__));

// On importe les namespaces nécessaires
use App\Autoloader;
use App\Core\Main;

// On instancie la router Main
$app = new Main();

// On démarre l'application depuis le router Main
$app->start();
