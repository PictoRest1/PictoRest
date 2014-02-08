<?php
require_once 'vendor/autoload.php';

//Connexion à la base
\php\Modele\ConnectionFactory::getConnection();

//Dispatch
$frontControleur = new \php\Controleur\FrontControleur();
$frontControleur->dispatch();


