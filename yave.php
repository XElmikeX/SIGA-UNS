<?php
// yave.php - VERSIÓN PARA POSTGRES ÚNICO
$conexion = null;

function conectarDB() {
    global $conexion;
    
    if ($conexion !== null) {
        return $conexion;
    }
    
    // Railway te da esta variable automáticamente
    $database_url = getenv('DATABASE_URL');
    
    // Debug (visible solo si hay error)
    if (empty($database_url)) {
        error_log("🚨 yave.php: DATABASE_URL VACÍA");
        error_log("   Verifica en Railway: DATABASE_URL=\${Postgres.DATABASE_URL}");
        $conexion = false;
        return $conexion;
    }
    
    // Mostrar info de debug (ocultando contraseña)
    $url_info = parse_url($database_url);
    $host_debug = $url_info['host'] ?? 'desconocido';
    error_log("🔗 yave.php: Conectando a: $host_debug");
    
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
        
        // Info para debug (sin contraseña)
        $safe_url = preg_replace('/:[^:@]*@/', ':****@', $database_url);
        error_log("   URL usada: $safe_url");
        
        $conexion = false;
        return $conexion;
    }
}

// Función helper para debug
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