<?php
// test.php - DIAGNÓSTICO ABSOLUTO MINIMO (Para resolver 502)
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>✅ TEST DE ARRANQUE PHP</h1>";
echo "<p>PHP Versión: " . phpversion() . "</p>";

// 1. Verificar si el archivo yave.php existe
if (file_exists(__DIR__ . '/yave.php')) {
    echo "<p style='color:green'>✅ yave.php encontrado.</p>";
    
    // 2. Intentar incluir yave.php de forma segura
    try {
        // Al incluir este archivo, si hay un error fatal, se generará aquí.
        require_once __DIR__ . '/yave.php';
        echo "<p style='color:green'>✅ yave.php incluido sin error fatal de sintaxis.</p>";
        
        // 3. Intentar la conexión
        if (function_exists('conectarDB')) {
            $conn = conectarDB();
            
            if ($conn) {
                echo "<p style='color:green; font-weight: bold;'>🎉 POSTGRESQL CONECTADO CON ÉXITO</p>";
                // Si la tabla ya existe, esto debe funcionar
                try {
                    $stmt = $conn->query("SELECT 1 FROM usuarios LIMIT 1");
                    echo "<p style='color:green'>✅ Consulta a tabla 'usuarios' OK.</p>";
                } catch (Exception $e) {
                    echo "<p style='color:orange'>⚠️ Error de Consulta: " . $e->getMessage() . "</p>";
                }
            } else {
                echo "<p style='color:red; font-weight: bold;'>❌ FALLO EN CONEXIÓN</p>";
                echo "<p>Revisa la variable DATABASE_URL y los Logs de la aplicación para el error de PDO.</p>";
            }
        } else {
            echo "<p style='color:red'>❌ La función conectarDB no se encontró en yave.php</p>";
        }
        
    } catch (Throwable $e) {
        // Esto atrapará cualquier error fatal/excepción grave
        echo "<p style='color:red'>❌ EXCEPCIÓN AL CARGAR yave.php: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color:red'>❌ yave.php NO encontrado en la ruta esperada.</p>";
}
?>