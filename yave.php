<?php
// yave.php - VERSIÓN PARA PRODUCCIÓN SIN ECHO
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conexion = null;

function conectarDB() {
    global $conexion;
    
    if ($conexion !== null) {
        return $conexion;
    }
    
    $database_url = getenv('DATABASE_URL');
    
    if (empty($database_url)) {
        error_log("🚨 yave.php: DATABASE_URL VACÍA");
        $conexion = false;
        return $conexion;
    }
    
    try {
        // Railway requiere SSL
        $dsn = $database_url;
        if (strpos($dsn, '?') === false) {
            $dsn .= '?sslmode=require';
        } else {
            $dsn .= '&sslmode=require';
        }
        
        $conexion = new PDO($dsn);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        error_log("✅ yave.php: Conexión exitosa a PostgreSQL");
        return $conexion;
        
    } catch (PDOException $e) {
        error_log("❌ yave.php: Error PDO: " . $e->getMessage());
        
        $safe_url = preg_replace('/:[^:@]*@/', ':****@', $database_url);
        error_log("   URL usada: $safe_url");
        
        $conexion = false;
        return $conexion;
    }
}

function getDBInfo() {
    $conn = conectarDB();
    if (!$conn) {
        return ["error" => "Sin conexión"];
    }
    
    try {
        $stmt = $conn->query("SELECT version() as pg_version, current_database() as db_name");
        return $stmt->fetch();
    } catch (Exception $e) {
        return ["error" => $e->getMessage()];
    }
}
?>