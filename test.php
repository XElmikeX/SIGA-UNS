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
    $conn = conectarDB();
    
    if ($conn) {
        echo "<p style='color:green'>✅ PostgreSQL CONECTADO</p>";
        try {
            $stmt = $conn->query("SELECT version()");
            echo "<p>Versión: " . $stmt->fetchColumn() . "</p>";
        } catch (Exception $e) {
            echo "<p style='color:red'>❌ Error consulta: " . $e->getMessage() . "</p>";
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