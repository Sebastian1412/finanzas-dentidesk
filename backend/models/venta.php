<?php
namespace Models;

use Core\Database;
use PDO;
use PDOException;

class Venta
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function obtenerTodas(): array
    {
        try {
            $stmt = $this->db->query("SELECT * FROM ventas ORDER BY fecha DESC");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error al obtener ventas: ' . $e->getMessage());
            return [];
        }
    }

    public function crear(array $data): bool
    {
        try {
            $sql = "INSERT INTO ventas (cliente_id, total, fecha) VALUES (:cliente_id, :total, NOW())";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':cliente_id' => $data['cliente_id'] ?? null,
                ':total'      => $data['total'] ?? 0
            ]);
        } catch (PDOException $e) {
            error_log('Error al crear venta: ' . $e->getMessage());
            return false;
        }
    }
}
