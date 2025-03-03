<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Router;

// Charge les variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Instancie et lance le routeur
$router = new Router();
$router->handleRequest();
