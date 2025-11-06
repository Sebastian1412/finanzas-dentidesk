<?php
// middlewares/auth.php

function auth_middleware($conn) {
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Falta header Authorization']);
        exit;
    }

    if (!preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
        http_response_code(401);
        echo json_encode(['error' => 'Token inválido']);
        exit;
    }

    $token = $matches[1];
    $stmt = $conn->prepare("SELECT usuario_id, expires_at FROM tokens_api WHERE token = :t");
    $stmt->execute([':t' => $token]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        http_response_code(401);
        echo json_encode(['error' => 'Token no encontrado']);
        exit;
    }

    if ($row['expires_at'] && new DateTime() > new DateTime($row['expires_at'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Token expirado']);
        exit;
    }

    return (int)$row['usuario_id'];
}
