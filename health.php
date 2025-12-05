<?php
// health.php - Versión SIMPLE sin PostgreSQL

// Solo verificar que PHP funciona
header("Content-Type: application/json");
http_response_code(200);

echo json_encode([
    "status" => "ok",
    "service" => "SIGA-UNS",
    "timestamp" => date('Y-m-d H:i:s'),
    "php_version" => phpversion()
]);

// NO incluir yave.php aquí
// NO intentar conectar a PostgreSQL
?>