<?php

require_once __DIR__ . '/../vendor/autoload.php';  // Cargar el autoloader de Composer
use Dotenv\Dotenv;

// Cargar las variables de entorno desde el archivo .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/..'); // Ruta a la carpeta raíz del proyecto
$dotenv->load();