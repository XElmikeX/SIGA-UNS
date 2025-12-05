<?php
// index-debug.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>DEBUG - Página principal simplificada</h1>";

// Test 1: PHP básico
echo "✅ PHP funciona<br>";

// Test 2: CSS
echo "<h3>Test CSS:</h3>";
echo '<link rel="stylesheet" href="tabla.css">';
echo '<div style="color: blue;">Texto azul si CSS carga</div>';

// Test 3: Verificar yave.php
echo "<h3>Test yave.php:</h3>";
$yavePath = __DIR__ . '/php/yave.php';
if (file_exists($yavePath)) {
    echo "✅ yave.php existe<br>";
    
    // Leer contenido para ver si hay error de sintaxis
    $content = file_get_contents($yavePath);
    if (strpos($content, '<?php') !== false) {
        echo "✅ yave.php tiene etiquetas PHP válidas<br>";
    }
    
    // Intentar incluir SIN detener si falla
    try {
        include $yavePath;
        echo "✅ yave.php incluido<br>";
        
        if (isset($conexion)) {
            echo "✅ \$conexion definido<br>";
            
            // Test conexión rápida
            try {
                $conexion->query("SELECT 1");
                echo "✅ Conexión PostgreSQL funciona<br>";
            } catch (Exception $e) {
                echo "⚠️ Conexión PostgreSQL falló: " . $e->getMessage() . "<br>";
                echo "<strong>PERO LA PÁGINA CONTINÚA</strong><br>";
            }
        } else {
            echo "❌ \$conexion NO definido<br>";
        }
    } catch (Exception $e) {
        echo "❌ ERROR FATAL en yave.php: " . $e->getMessage() . "<br>";
        echo "<strong>Esto causaría 502</strong><br>";
    }
} else {
    echo "❌ yave.php NO existe<br>";
}

// Continuar con HTML básico
echo "<h3>HTML básico:</h3>";
?>
<!DOCTYPE html>
<html>
<head>
    <title>DEBUG UNS</title>
</head>
<body>
    <h2>Tabla de horarios (simplificada)</h2>
    <table border="1">
        <tr><td>7 am</td><td>Clase</td></tr>
        <tr><td>8 am</td><td>Clase</td></tr>
    </table>
    
    <script>
        console.log("JavaScript funciona");
        document.write("<p>✅ JavaScript ejecutado</p>");
    </script>
</body>
</html>