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

    // 1. ⭐ PASO CRÍTICO: Parsear la URL (URI) de Railway
    $db_opts = parse_url($db_url);
    
    // Fallo de parsing básico
    if ($db_opts === false || !isset($db_opts['host'], $db_opts['port'], $db_opts['path'], $db_opts['user'], $db_opts['pass'])) {
        error_log("🚨 Error: Fallo al parsear DATABASE_URL.");
        return false;
    }
    
    $host = $db_opts['host'];
    $port = $db_opts['port'];
    // Quitar el '/' inicial de la ruta del DB
    $db   = ltrim($db_opts['path'], '/'); 
    $user = $db_opts['user'];
    $pass = $db_opts['pass'];

    // 2. Construir DSN estándar para PDO (pgsql:host=...;dbname=...)
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";

    // 3. Opciones de conexión (Incluyendo SSL)
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // CRÍTICO: Requerir SSL para PostgreSQL en Railway
        PDO::ATTR_SSL_MODE => PDO::SSL_REQUIRED 
    ];

    try {
        // Si esta línea falla, es la causa del 502
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