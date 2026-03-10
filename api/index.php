<?php
require 'flight/Flight.php';

// Configuración de la base de datos usando variables de entorno
Flight::register('db', 'PDO', [
    'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_NAME') . ';charset=utf8mb4',
    getenv('DB_USER'),
    getenv('DB_PASSWORD')
]);

// --- El resto de tus rutas (get, post, put, delete) van aquí ---
// Ejemplo:
Flight::route('GET /alumnos', function () {
    $sentencia = Flight::db()->prepare("SELECT * FROM alumnos");
    $sentencia->execute();
    $datos = $sentencia->fetchAll();
    Flight::json($datos);
});

// ... (Aquí van todas las demás rutas del tutorial) ...

Flight::start();
