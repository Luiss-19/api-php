<?php
// routes/router.php

require_once "models/Cliente.php";
require_once "../models/Publicacion.php"; 

// Manejo de las solicitudes según el método HTTP
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $datos = json_decode(file_get_contents('php://input'), true);

        if (!$datos || !isset($datos['correo'], $datos['password'], $datos['titulo'], $datos['descripcion'])) {
            echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios']);
            exit;
        }

        $resultado = Publicacion::crearPublicacion($datos['correo'], $datos['password'], $datos['titulo'], $datos['descripcion']);
        echo json_encode($resultado);
        break;

    case 'PUT':
        $datos = json_decode(file_get_contents('php://input'), true);

        if (!$datos || !isset($datos['correo'], $datos['password'], $datos['titulo'], $datos['descripcion'])) {
            echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios']);
            exit;
        }

        $resultado = Publicacion::actualizarPublicacion($datos['correo'], $datos['password'], $datos['titulo'], $datos['descripcion']);
        echo json_encode($resultado);
        break;

    default:
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        break;
}
