<?php
require_once 'vendor/autoload.php';

// Constantes

//Connexion à la base
\Modele\ConnectionFactory::getConnection();

//Dispatch
$frontControleur = new \Controleur\FrontControleur();
$frontControleur->dispatch();