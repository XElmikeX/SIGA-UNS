<?php
// yave.php - SOLUCIÓN FINAL CON SSL
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

    // 1. Parsear la URL
    $db_opts = parse_url($db_url);
    if ($db_opts === false || !isset($db_opts['host'], $db_opts['port'], $db_opts['path'], $db_opts['user'], $db_opts['pass'])) {
        error_log("🚨 Error: Fallo al parsear DATABASE_URL.");
        return false;
    }
    
    $host = $db_opts['host'];
    $port = $db_opts['port'];
    $db   = ltrim($db_opts['path'], '/'); 
    $user = $db_opts['user'];
    $pass = $db_opts['pass'];

    // 2. Construir DSN estándar para PDO
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";

    // 3. Opciones de conexión (Incluyendo SSL)
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // ⭐ ESTO ES CRÍTICO PARA RAILWAY/POSTGRESQL ⭐
        PDO::ATTR_SSL_MODE => PDO::SSL_REQUIRED
    ];

    try {
        $conexion = new PDO($dsn, $user, $pass, $options);
        error_log("✅ Conexión a PostgreSQL establecida.");
        return $conexion;
    } catch (PDOException $e) {
        error_log("❌ Error de Conexión: " . $e->getMessage());
        return false;
    }
}
?>