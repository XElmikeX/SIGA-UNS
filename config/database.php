<?php
// config/database.php
function conectarDB() {
    $db_url = getenv('DATABASE_URL');
    
    if (empty($db_url)) {
        error_log("DATABASE_URL no definida");
        return false;
    }
    
    $db_opts = parse_url($db_url);
    
    if (!$db_opts || !isset($db_opts['host'])) {
        error_log("DATABASE_URL inválida: $db_url");
        return false;
    }
    
    $host = $db_opts['host'];
    $port = $db_opts['port'] ?? 5432;
    $db   = ltrim($db_opts['path'] ?? '/railway', '/');
    $user = $db_opts['user'] ?? 'postgres';
    $pass = $db_opts['pass'] ?? '';
    
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";
    
    try {
        $conexion = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        
        return $conexion;
    } catch (PDOException $e) {
        error_log("Error PDO: " . $e->getMessage());
        return false;
    }
}

// ✅ AÑADE ESTA FUNCIÓN AQUÍ para que auth.php la use
function obtenerTablaPorTipo($tipo) {
    switch($tipo) {
        case 'admin': return 'admins';
        case 'docente': return 'docentes';
        case 'usuarios': return 'usuarios';
        default: return 'usuarios';
    }
}
?>