<?php
// health.php - VERSIÓN CORREGIDA
header("Content-Type: application/json");

// IMPORTANTE: Forzar estado 200 para Railway
if (!headers_sent()) {
    http_response_code(200);
    header("Cache-Control: no-cache, must-revalidate");
    header("X-Railway-Health: OK");
}

echo json_encode([
    "status" => "ok",
    "service" => "SIGA-UNS",
    "timestamp" => date('Y-m-d H:i:s'),
    "php_version" => phpversion(),
    "environment" => getenv('RAILWAY_ENVIRONMENT') ?: 'production'
]);

exit(0); // Asegurar salida limpia
?>