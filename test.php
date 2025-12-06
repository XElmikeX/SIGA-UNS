<?php
// test.php - Diagnóstico rápido
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>✅ Test PHP Funcionando</h1>";
echo "<p>PHP: " . phpversion() . "</p>";
echo "<p>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";

// Probar PostgreSQL
if (file_exists(__DIR__ . '/yave.php')) {
    require_once __DIR__ . '/yave.php';
    
    // Llama a la conexión
    $conn = conectarDB();
    
    if ($conn) {
        echo "<p style='color:green'>✅ PostgreSQL CONECTADO</p>";
        
        try {
            // Verifica que la tabla "usuarios" exista
            $stmt = $conn->query("SELECT 1 FROM usuarios LIMIT 1");
            echo "<p style='color:green'>✅ Tabla 'usuarios' existe.</p>";
        } catch (Exception $e) {
            echo "<p style='color:orange'>⚠️ Error de Consulta/Tabla: " . $e->getMessage() . "</p>";
            echo "<p>❌ **SOLUCIÓN:** La tabla 'usuarios' probablemente no existe. Debes crearla en Railway.</p>";
        }
    } else {
        echo "<p style='color:red'>❌ PostgreSQL NO CONECTADO</p>";
        echo "<p>DATABASE_URL: " . (getenv('DATABASE_URL') ? 'Configurada' : 'No configurada') . "</p>";
    }
} else {
    echo "<p style='color:red'>❌ yave.php no encontrado</p>";
}

echo "<hr>";
echo "<a href='/'>Volver al inicio</a>";
?>