<?php
// test-conexion.php
require_once __DIR__ . '/yave.php';

echo "<h2>🧪 Probando conexión a PostgreSQL...</h2>";

$con = conectarDB();

if ($con) {
    echo "<p style='color: green;'>✅ Conexión exitosa a PostgreSQL</p>";
    
    // Probar consulta
    try {
        $stmt = $con->query("SELECT COUNT(*) as total FROM usuarios");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<p>Total de usuarios en tabla: " . $result['total'] . "</p>";
        
        // Mostrar estructura
        $stmt = $con->query("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = 'usuarios'");
        echo "<h3>Estructura de la tabla 'usuarios':</h3>";
        echo "<table border='1'><tr><th>Columna</th><th>Tipo</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>{$row['column_name']}</td><td>{$row['data_type']}</td></tr>";
        }
        echo "</table>";
        
        // Probar inserción
        $test_pass = password_hash("test123", PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nombre_usuario, email_usuario, password_usuario) 
                VALUES ('test_user', 'test@example.com', ?)
                ON CONFLICT (nombre_usuario) DO NOTHING
                RETURNING id";
        
        $stmt = $con->prepare($sql);
        $stmt->execute([$test_pass]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            echo "<p style='color: green;'>✅ Inserción de prueba exitosa. ID: {$result['id']}</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ Usuario test ya existe</p>";
        }
        
    } catch (PDOException $e) {
        echo "<p style='color: red;'>❌ Error en consulta: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ No se pudo conectar a PostgreSQL</p>";
    echo "<p>Variables disponibles:</p>";
    echo "<pre>";
    echo "DATABASE_URL: " . (getenv('DATABASE_URL') ? 'SÍ' : 'NO') . "\n";
    echo "PGHOST: " . (getenv('PGHOST') ? getenv('PGHOST') : 'NO') . "\n";
    echo "PGUSER: " . (getenv('PGUSER') ? 'SÍ' : 'NO') . "\n";
    echo "</pre>";
}
?>