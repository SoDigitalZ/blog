<?php

namespace App\Controllers;

class MainController extends Controller
{
    public function index()
    {
        // Par défaut, la méthode index affiche la page d'accueil.
        $this->render('main/index');
    }
}
