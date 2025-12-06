<?php
// yave.php - Versión mejorada para Railway

$conexion = null;

function conectarDB() {
    global $conexion;
    
    if ($conexion === null) {
        // Opción 1: Usar DATABASE_URL (la que te da Railway)
        $database_url = $_ENV['DATABASE_URL'] ?? getenv('DATABASE_URL');
        
        if ($database_url) {
            // Parsear la URL de Railway
            $url = parse_url($database_url);
            $host = $url['host'];
            $port = $url['port'] ?? 5432;
            $dbname = substr($url['path'], 1); // Quita el / inicial
            $username = $url['user'];
            $password = $url['pass'];
        } else {
            // Opción 2: Usar variables individuales
            $host = $_ENV['PGHOST'] ?? getenv('PGHOST');
            $port = $_ENV['PGPORT'] ?? getenv('PGPORT');
            $dbname = $_ENV['PGDATABASE'] ?? getenv('PGDATABASE');
            $username = $_ENV['PGUSER'] ?? getenv('PGUSER');
            $password = $_ENV['PGPASSWORD'] ?? getenv('PGPASSWORD');
        }
        
        // Verificar que tenemos datos de conexión
        if (empty($host)) {
            error_log("❌ Variables PostgreSQL no configuradas en Railway");
            $conexion = false;
            return $conexion;
        }
        
        try {
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
            $conexion = new PDO($dsn, $username, $password);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            error_log("✅ Conexión PostgreSQL exitosa a: $host");
            return $conexion;
        } catch (PDOException $e) {
            error_log("❌ Error PostgreSQL: " . $e->getMessage());
            $conexion = false;
            return $conexion;
        }
    }
    
    return $conexion;
}
?>