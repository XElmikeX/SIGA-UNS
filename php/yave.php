<?php
// yave.php - Versión mejorada

// NO intentar conectar automáticamente
$conexion = null;

function conectarDB() {
    global $conexion;
    
    if ($conexion === null) {
        $host = $_ENV['PGHOST'] ?? getenv('PGHOST');
        $port = $_ENV['PGPORT'] ?? getenv('PGPORT');
        $dbname = $_ENV['PGDATABASE'] ?? getenv('PGDATABASE');
        $user = $_ENV['PGUSER'] ?? getenv('PGUSER');
        $password = $_ENV['PGPASSWORD'] ?? getenv('PGPASSWORD');
        
        // Verificar que todas las variables existen
        if (empty($host) || empty($port) || empty($dbname) || empty($user) || empty($password)) {
            error_log("❌ Variables PostgreSQL no configuradas");
            $conexion = false;
            return $conexion;
        }
        
        try {
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
            $conexion = new PDO($dsn, $user, $password);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            error_log("✅ Conexión PostgreSQL exitosa");
        } catch (PDOException $e) {
            error_log("❌ Error PostgreSQL: " . $e->getMessage());
            $conexion = false;
        }
    }
    
    return $conexion;
}
?>