<?php
// yave.php - VERSIÓN SIMPLIFICADA PARA 8080
error_reporting(E_ALL);
ini_set('display_errors', 1);

function conectarDB() {
    $db_url = getenv('DATABASE_URL');
    
    if (empty($db_url)) {
        error_log("❌ DATABASE_URL no definida");
        return false;
    }
    
    // Parsear la URL
    $db_opts = parse_url($db_url);
    
    if (!$db_opts || !isset($db_opts['host'])) {
        error_log("❌ DATABASE_URL inválida: $db_url");
        return false;
    }
    
    $host = $db_opts['host'];
    $port = $db_opts['port'] ?? 5432; // Usará 8080 si está en la URL
    $db   = ltrim($db_opts['path'] ?? '/railway', '/');
    $user = $db_opts['user'] ?? 'postgres';
    $pass = $db_opts['pass'] ?? '';
    
    // ✅ Asegurar conexión SSL
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";
    
    try {
        $conexion = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        
        // Verificar conexión con una consulta simple
        $stmt = $conexion->query("SELECT 1");
        error_log("✅ PostgreSQL CONECTADO en host:$host, port:$port, db:$db");
        
        return $conexion;
    } catch (PDOException $e) {
        error_log("❌ Error PDO: " . $e->getMessage());
        error_log("❌ DSN intentado: $dsn");
        return false;
    }
}
?>