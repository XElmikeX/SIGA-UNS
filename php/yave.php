<?php
// Configuración para PostgreSQL en Railway
$host = getenv('PGHOST') ?: "postgres.railway.internal";
$port = getenv('PGPORT') ?: "5432";
$dbname = getenv('PGDATABASE') ?: "railway";
$user = getenv('PGUSER') ?: "postgres";
$password = getenv('PGPASSWORD');

// Añadir SSL para Railway
$ssl = "sslmode=require";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;$ssl";
    $conexion = new PDO($dsn, $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Opcional: probar conexión
    // $conexion->query("SELECT 1");
    
} catch (PDOException $e) {
    // Para Railway, solo log
    error_log("Error DB Connection: " . $e->getMessage());
    
    // Respuesta JSON para API calls
    if (php_sapi_name() !== 'cli') {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Database connection error'
        ]);
        exit();
    }
    die("Database connection error");
}
?>