<?php
require_once 'vendor/autoload.php';
session_start();

// Constantes

//Connexion à la base
\php\Modele\ConnectionFactory::getConnection();

//Dispatch
$frontControleur = new \php\Controleur\FrontControleur();
$frontControleur->dispatch();


