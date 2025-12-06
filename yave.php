<?php
// yave.php - VERSIÓN ROBUSTA FINAL
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

    // ⭐ PARSEO DE URL CRÍTICO
    $db_opts = parse_url($db_url);
    
    // Si parse_url falla o faltan componentes
    if ($db_opts === false || !isset($db_opts['host'], $db_opts['port'], $db_opts['path'], $db_opts['user'], $db_opts['pass'])) {
        error_log("🚨 Error: Fallo al parsear DATABASE_URL.");
        return false;
    }
    
    $host = $db_opts['host'];
    $port = $db_opts['port'];
    $db   = ltrim($db_opts['path'], '/'); 
    $user = $db_opts['user'];
    $pass = $db_opts['pass'];

    // Construir DSN estándar para PDO
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";

    try {
        $conexion = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        error_log("✅ Conexión a PostgreSQL establecida.");
        return $conexion;
    } catch (PDOException $e) {
        error_log("❌ Error de Conexión: " . $e->getMessage());
        return false;
    }
}
?>