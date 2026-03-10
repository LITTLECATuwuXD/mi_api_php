<?php
// Cargar el framework Flight
require 'flight/Flight.php';

// Configuración de la base de datos (usando variables de entorno)
Flight::register('db', 'PDO', array(
    'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_NAME') . ';charset=utf8mb4',
    getenv('DB_USER'),
    getenv('DB_PASSWORD')
));

// RUTA GET para listar alumnos
Flight::route('GET /alumnos', function () {
    $consulta = Flight::db()->prepare("SELECT * FROM alumnos");
    $consulta->execute();
    $resultados = $consulta->fetchAll();
    Flight::json($resultados);
});

// RUTA GET para un alumno específico
Flight::route('GET /alumnos/@id', function ($id) {
    $consulta = Flight::db()->prepare("SELECT * FROM alumnos WHERE id = ?");
    $consulta->execute([$id]);
    $resultado = $consulta->fetch();
    Flight::json($resultado);
});

// RUTA POST para crear alumno
Flight::route('POST /alumnos', function () {
    $datos = Flight::request()->data;
    $consulta = Flight::db()->prepare("INSERT INTO alumnos (nombres, apellidos) VALUES (?, ?)");
    $consulta->execute([$datos->nombres, $datos->apellidos]);
    Flight::json(['mensaje' => 'Alumno agregado correctamente']);
});

// RUTA PUT para actualizar
Flight::route('PUT /alumnos', function () {
    $datos = Flight::request()->data;
    $consulta = Flight::db()->prepare("UPDATE alumnos SET nombres = ?, apellidos = ? WHERE id = ?");
    $consulta->execute([$datos->nombres, $datos->apellidos, $datos->id]);
    Flight::json(['mensaje' => 'Alumno actualizado']);
});

// RUTA DELETE para eliminar
Flight::route('DELETE /alumnos', function () {
    $datos = Flight::request()->data;
    $consulta = Flight::db()->prepare("DELETE FROM alumnos WHERE id = ?");
    $consulta->execute([$datos->id]);
    Flight::json(['mensaje' => 'Alumno eliminado']);
});

// Ruta de prueba para verificar que la API funciona
Flight::route('GET /', function () {
    Flight::json(['mensaje' => 'API de alumnos funcionando correctamente']);
});

Flight::start();
