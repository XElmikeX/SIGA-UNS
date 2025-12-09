<?php
// config/db.php - ConeXión PostgreSQL (NO CAMBIA)
function conectarDB() {
    $db_url = getenv('DATABASE_URL');
    
    if (empty($db_url)) {
        die("Error: DATABASE_URL no configurada");
    }
    
    $db_opts = parse_url($db_url);
    $host = $db_opts['host'];
    $port = $db_opts['port'] ?? 5432;
    $db   = ltrim($db_opts['path'] ?? '/railway', '/');
    $user = $db_opts['user'] ?? 'postgres';
    $pass = $db_opts['pass'] ?? '';
    
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";
    
    try {
        $conn = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        return $conn;
    } catch (PDOException $e) {
        die("Error DB: " . $e->getMessage());
    }
}
?>