<?php
// Log para debug
error_log("Healthcheck accessed: " . date('Y-m-d H:i:s'));

header("Content-Type: application/json");
http_response_code(200);
echo json_encode([
    "status" => "ok",
    "service" => "SIGA-UNS",
    "timestamp" => date('Y-m-d H:i:s'),
    "php_version" => phpversion(),
    "extensions" => get_loaded_extensions()
]);
?>