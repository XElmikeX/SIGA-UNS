<?php
// verificar-conexion.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Verificar Conexión</title></head><body>";
echo "<h1>🔍 Verificación de Conexión</h1>";

if (file_exists(__DIR__ . '/yave.php')) {
    require_once __DIR__ . '/yave.php';
    echo "<p>✅ yave.php encontrado</p>";
    
    try {
        $conn = conectarDB();
        if ($conn) {
            echo "<p style='color:green; font-weight:bold;'>✅ CONEXIÓN EXITOSA A POSTGRESQL</p>";
        } else {
            echo "<p style='color:red; font-weight:bold;'>❌ FALLO EN CONEXIÓN</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red;'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p style='color:red;'>❌ yave.php NO encontrado</p>";
}

echo "<hr><p><a href='index.php'>← Volver al inicio</a></p>";
echo "</body></html>";