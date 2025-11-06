<?php
namespace Controllers;

use Models\Venta;
use Core\Response;

class VentasController
{
    private Venta $ventaModel;

    public function __construct()
    {
        $this->ventaModel = new Venta();
    }

    // Obtener todas las ventas
    public function listar(): void
    {
        $ventas = $this->ventaModel->obtenerTodas();

        if (empty($ventas)) {
            Response::success([], 'No hay ventas registradas');
        } else {
            Response::success($ventas, 'Ventas obtenidas correctamente');
        }
    }

    // Crear una nueva venta
    public function crear(): void
    {
        // Verificamos que la solicitud sea POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::error('Método no permitido', 405);
        }

        // Obtenemos el cuerpo JSON del request
        $input = json_decode(file_get_contents('php://input'), true);

        // Validaciones simples
        if (empty($input['cliente_id']) || empty($input['total'])) {
            Response::error('Datos incompletos: se requiere cliente_id y total');
        }

        $resultado = $this->ventaModel->crear($input);

        if ($resultado) {
            Response::success([], 'Venta registrada exitosamente', 201);
        } else {
            Response::error('No se pudo registrar la venta');
        }
    }
}
