<?php

return [
    // --- Valores leídos de docker-compose.yml ---
    'host'     => getenv('DB_HOST') ?: '127.0.0.1',       // Docker: 'db', Local: '127.0.0.1'
    'database' => getenv('DB_NAME') ?: 'finanzas_db', // Docker: 'finanzas_db', Local: 'finanzas_db'
    'username' => getenv('DB_USER') ?: 'root',          // Docker: 'root', Local: 'root'
    'password' => getenv('DB_PASS') ?: '',              // Docker: 'root_password_seguro', Local: ''

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