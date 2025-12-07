<?php
echo "✅ Apache está funcionando<br>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Server: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'No info') . "<br>";
echo "Port: " . ($_SERVER['SERVER_PORT'] ?? 'No info') . "<br>";

// Probar PostgreSQL
if (file_exists(__DIR__ . '/yave.php')) {
    require_once __DIR__ . '/yave.php';
    $conn = conectarDB();
    if ($conn) {
        echo "✅ PostgreSQL: CONECTADO<br>";
    } else {
        echo "❌ PostgreSQL: NO CONECTADO<br>";
    }
}
?>