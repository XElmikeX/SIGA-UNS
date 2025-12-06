<?php
// yave.php - SOLUCIÓN FINAL CON PARSING Y SSL PARA 
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conexion = null;

function conectarDB() {
    global $conexion;
    if ($conexion !== null) return $conexion;

    $db_url = getenv('DATABASE_URL');
    if (empty($db_url)) {
        error_log("🚨 Error: DATABASE_URL no definida");
        return false;
    }

    $db_opts = parse_url($db_url);
    
    if ($db_opts === false || !isset($db_opts['host'], $db_opts['path'], $db_opts['user'], $db_opts['pass'])) {
        error_log("🚨 Error: Fallo al parsear DATABASE_URL.");
        return false;
    }
    
    $host = $db_opts['host'];
    $port = $db_opts['port'] ?? 5432; // Puerto por defecto
    $db   = ltrim($db_opts['path'], '/'); 
    $user = $db_opts['user'];
    $pass = $db_opts['pass'];

    // 1. DSN con requerimiento SSL integrado, evitando la constante PDO::SSL_REQUIRED
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require"; 

    // 2. Opciones de conexión estándar
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try {
        $conexion = new PDO($dsn, $user, $pass, $options);
        error_log("✅ Conexión a PostgreSQL establecida.");
        return $conexion;
    } catch (PDOException $e) {
        // Esto atrapará el error de conexión y evitará el 502
        error_log("❌ Error de Conexión PDO: " . $e->getMessage());
        return false;
    } catch (Exception $e) {
        error_log("❌ Error fatal en conectarDB: " . $e->getMessage());
        return false;
    }
}
?>