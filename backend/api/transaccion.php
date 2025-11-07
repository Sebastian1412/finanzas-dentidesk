<?php
// backend/api/transaccion.php

header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization"); 
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS"); 

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

include_once '../models/transaccion.php';
include_once '../core/database.php';
include_once '../middlewares/auth.php';

use Core\Database;

header('Content-Type: application/json');

$conn = Database::getConnection();

$method = $_SERVER['REQUEST_METHOD'];
$usuario_id = auth_middleware($conn); // retorna ID del usuario autenticado

$transaccion = new Transaccion($conn);

switch ($method) {
    case 'GET':
        if (isset($_GET['totales'])) {
            $data = $transaccion->obtenerTotales($usuario_id);
            echo json_encode($data);
        } else {
            $data = $transaccion->listarPorUsuario($usuario_id);
            echo json_encode($data);
        }
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['tipo'], $input['monto'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Campos requeridos: tipo, monto']);
            exit;
        }
        $descripcion = $input['descripcion'] ?? '';
        $ok = $transaccion->crear($usuario_id, $input['tipo'], $descripcion, $input['monto']);
        echo json_encode(['success' => $ok]);
        break;

    case 'DELETE':
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'ID requerido']);
            exit;
        }
        $ok = $transaccion->eliminar($_GET['id'], $usuario_id);
        echo json_encode(['success' => $ok]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
}