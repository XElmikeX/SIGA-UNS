<?php
function conectarDB() {
    $db_url = getenv('DATABASE_URL');

    // Parsear la URL:host, puerto, usuario, contraseña, nom del BD
    $db_opts = parse_url($db_url);
    
    $host = $db_opts['host'];
    $port = $db_opts['port']; // Usará 8080 si está en la URL
    $db   = ltrim($db_opts['path'], '/');
    $user = $db_opts['user'];
    $pass = $db_opts['pass'];
    
    // Asegurar conexión SSL o TLS(importante para Railway)
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";
    
    try {
        $conexion = new PDO($dsn, $user, $pass, [
            //mejorar manejo de errores"lo envia abajo")
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        
        return $conexion;
    } catch (PDOException $e) {
        error_log("Error PDO: " . $e->getMessage());
        error_log("DSN intentado: $dsn");
        return false;
    }
}
?>