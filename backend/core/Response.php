<?php
namespace Core;

class Response
{
    public static function success(array $data = [], string $message = 'Operación exitosa', int $status = 200): void
    {
        http_response_code($status);
        echo json_encode([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function error(string $message = 'Ocurrió un error', int $status = 400): void
    {
        http_response_code($status);
        echo json_encode([
            'status' => 'error',
            'message' => $message
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
