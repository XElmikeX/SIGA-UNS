<?php
// verificar-estructura.php
echo "<h2>📁 Verificando estructura del proyecto</h2>";

$files = [
    'Dockerfile' => 'Raíz',
    'index.php' => 'Raíz',
    'health.php' => 'Raíz',
    'yave.php' => 'Raíz',
    'php/proceso-register.php' => 'Carpeta php',
    'Js_table_regis.js' => 'Raíz o js/',
    'tabla.css' => 'Raíz'
];

echo "<table border='1'>";
echo "<tr><th>Archivo</th><th>Ubicación esperada</th><th>¿Existe?</th></tr>";

foreach ($files as $file => $location) {
    $exists = file_exists(__DIR__ . '/' . $file);
    $color = $exists ? 'green' : 'red';
    echo "<tr>";
    echo "<td>$file</td>";
    echo "<td>$location</td>";
    echo "<td style='color:$color'>" . ($exists ? '✅ SÍ' : '❌ NO') . "</td>";
    echo "</tr>";
}
echo "</table>";

// Verificar permisos
echo "<h3>🔐 Permisos:</h3>";
echo "<pre>";
system("ls -la");
echo "</pre>";
?>