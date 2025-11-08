<?php
// models/Transaccion.php

class Transaccion {
    private $conn;
    private $table = 'transacciones';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear una transacción
    public function crear($usuario_id, $tipo, $descripcion, $monto) {
        $sql = "INSERT INTO {$this->table} (usuario_id, tipo, descripcion, monto)
                VALUES (:usuario_id, :tipo, :descripcion, :monto)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':monto', $monto);

        return $stmt->execute();
    }

    // Listar todas las transacciones de un usuario
    public function listarPorUsuario($usuario_id) {
        $sql = "SELECT id, tipo, descripcion, monto, fecha 
                FROM {$this->table}
                WHERE usuario_id = :usuario_id
                ORDER BY fecha DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener el total de ingresos y egresos de un usuario
    public function obtenerTotales($usuario_id) {
        $sql = "SELECT 
                    SUM(CASE WHEN tipo = 'ingreso' THEN monto ELSE 0 END) AS total_ingresos,
                    SUM(CASE WHEN tipo = 'egreso' THEN monto ELSE 0 END) AS total_egresos
                FROM {$this->table}
                WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Eliminar una transacción (solo del usuario autenticado)
    public function eliminar($id, $usuario_id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
