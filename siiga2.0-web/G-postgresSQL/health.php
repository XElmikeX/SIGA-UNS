<?php
// health.php - con verificación de puerto
header('Content-Type: application/json');

$status = [
    'status' => 'ok',
    'timestamp' => date('Y-m-d H:i:s'),
    'php_version' => PHP_VERSION,
    'server_port' => $_SERVER['SERVER_PORT'] ?? 'unknown',
    'database_connected' => false
];

try {
    require_once __DIR__ . '/php/info-admin.php';
    $conn = conectarDB();
    if ($conn) {
        $status['database_connected'] = true;
        $status['database_port'] = '8080';
    }
} catch (Exception $e) {
    $status['database_error'] = $e->getMessage();
}

echo json_encode($status);
?>