<?php

return [
    // --- Valores leídos de docker-compose.yml ---
    'host'     => getenv('DB_HOST') ?: '127.0.0.1',       // Docker usará 'db', tu PC usará '127.0.0.1'
    'database' => getenv('DB_NAME') ?: 'finanzas_db', // 'finanzas_db' para ambos
    'username' => getenv('DB_USER') ?: 'root',          // 'root' para ambos
    'password' => getenv('DB_PASS') ?: '',              // Docker usará 'root_password_seguro', tu PC usará '' (vacío)

    // --- Configuración estándar ---
    'port'     => '3306',
    'charset'  => 'utf8mb4',
    'options'  => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_PERSISTENT         => false,
    ]
];
