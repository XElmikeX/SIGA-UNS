<?php
// health.php - VERSIÓN SIMPLE
header("Content-Type: application/json");

// Solo responder OK
echo json_encode([
    "status" => "ok",
    "service" => "SIGA-UNS",
    "timestamp" => date('Y-m-d H:i:s'),
    "php_version" => phpversion()
]);

http_response_code(200);
?>