<?php
function conectarDB() {
    $db_url = getenv('DATABASE_URL');
    
    if (!$db_url) {
        die("Error: DATABASE_URL no está configurada");
    }
    
    $db_opts = parse_url($db_url);
    
    if (!$db_opts) {
        die("Error: DATABASE_URL no tiene formato válido");
    }

    $user = $db_opts['user'] ?? '';
    $pass = $db_opts['pass'] ?? '';
    $host = $db_opts['host'] ?? 'localhost';
    $port = $db_opts['port'] ?? '5432';
    $db   = ltrim($db_opts['path'] ?? '', '/');
    
    if (empty($user) || empty($db)) {
        die("Error: Faltan datos de conexión en DATABASE_URL");
    }
    
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";
    
    try {
        $conexion = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $conexion;
    } catch (PDOException $e) {
        error_log("Error de conexión DB: " . $e->getMessage());
        die("Error de conexión a la base de datos");
    }
}
?>