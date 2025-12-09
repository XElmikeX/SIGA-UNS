<?php
function conectarDB() {
    /*postgresql://user:pass@host:5432/mi_basedatos*/
    $db_url = getenv('DATABASE_URL');
    
    $db_opts = parse_url($db_url);

    $user = $db_opts['user'];
    $pass = $db_opts['pass'];
    $host = $db_opts['host'];
    $port = $db_opts['port'];
    $db   = ltrim($db_opts['path'],'/');
    
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";
    
    try {
        $conexion = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        return $conexion;
    } catch (PDOException $e) {
        die("Error DB: " . $e->getMessage());
    }
}
?>