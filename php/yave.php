<?php
// yave.php - Versión corregida para Railway

// En Railway, las variables se cargan en $_ENV
$host = $_ENV['PGHOST'] ?? "postgres.railway.internal";
$port = $_ENV['PGPORT'] ?? "5432";
$dbname = $_ENV['PGDATABASE'] ?? "railway";
$user = $_ENV['PGUSER'] ?? "postgres";
$password = $_ENV['PGPASSWORD'] ?? "";

// Debug: Verificar variables (quitar en producción)
if (isset($_GET['debug'])) {
    echo "<pre>Debug PostgreSQL:<br>";
    echo "HOST: $host<br>";
    echo "PORT: $port<br>";
    echo "DB: $dbname<br>";
    echo "USER: $user<br>";
    echo "PASS: " . (empty($password) ? 'VACÍA' : 'DEFINIDA') . "<br>";
    echo "</pre>";
}

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $conexion = new PDO($dsn, $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Test de conexión rápida
    $conexion->query("SELECT 1");
    error_log("✅ Conexión PostgreSQL exitosa a: $host");
    
} catch (PDOException $e) {
    error_log("❌ Error conexión PostgreSQL: " . $e->getMessage());
    
    // NO usar die() - eso causa 502
    // En lugar de eso, mostrar error amigable si estamos en modo debug
    if (isset($_GET['debug'])) {
        echo "<div style='background: #ffcccc; padding: 10px; margin: 10px;'>";
        echo "<strong>Error PostgreSQL:</strong> " . $e->getMessage();
        echo "<br><strong>DSN usado:</strong> $dsn";
        echo "</div>";
    }
    
    // Marcar conexión como fallida pero continuar
    $conexion = false;
}
?>