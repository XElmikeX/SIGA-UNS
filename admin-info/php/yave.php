<?php
// Configuración para PostgreSQL en Railway
$host = getenv('PGHOST') ?: "postgres.railway.internal";
$port = getenv('PGPORT') ?: "5432";
$dbname = getenv('PGDATABASE') ?: "railway";
$user = getenv('PGUSER') ?: "postgres";
$password = getenv('PGPASSWORD');

// Añadir SSL para Railway (IMPORTANTE)
$ssl = "sslmode=require";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;$ssl";
    $conexion = new PDO($dsn, $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Log para producción
    error_log("Error DB: " . $e->getMessage());
    die("Error de conexión con la base de datos");
}
?>