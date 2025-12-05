<?php
echo "<h1>Debug Railway</h1>";
echo "PHP Version: " . phpversion() . "<br>";
echo "PORT env: " . ($_SERVER['PORT'] ?? 'No definido') . "<br>";
echo "SERVER_PORT: " . ($_SERVER['SERVER_PORT'] ?? 'No definido') . "<br>";
echo "Working dir: " . getcwd() . "<br>";

// Listar archivos
echo "<h3>Archivos en raíz:</h3>";
foreach (scandir('.') as $file) {
    if (!in_array($file, ['.', '..'])) {
        echo "- $file<br>";
    }
}

// Verificar si Dockerfile existe
echo "<h3>¿Dockerfile existe?: " . (file_exists('Dockerfile') ? '✅ Sí' : '❌ No') . "</h3>";
?>