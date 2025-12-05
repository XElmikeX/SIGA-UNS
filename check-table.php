<?php
echo "<h1>Verificando estructura de tabla 'usuarios'</h1>";

try {
    $host = $_ENV['PGHOST'] ?? "postgres.railway.internal";
    $port = $_ENV['PGPORT'] ?? "5432";
    $dbname = $_ENV['PGDATABASE'] ?? "railway";
    $user = $_ENV['PGUSER'] ?? "postgres";
    $password = $_ENV['PGPASSWORD'] ?? "";
    
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Conectado a PostgreSQL<br>";
    
    // Obtener estructura de la tabla
    $sql = "SELECT 
        column_name, 
        data_type, 
        is_nullable,
        character_maximum_length
    FROM information_schema.columns 
    WHERE table_name = 'usuarios' 
    ORDER BY ordinal_position";
    
    $stmt = $pdo->query($sql);
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($columns)) {
        echo "❌ La tabla 'usuarios' no tiene columnas o no existe<br>";
    } else {
        echo "<h3>Estructura actual de 'usuarios':</h3>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Columna</th><th>Tipo</th><th>Longitud</th><th>¿Nulo?</th></tr>";
        
        foreach ($columns as $col) {
            echo "<tr>";
            echo "<td>{$col['column_name']}</td>";
            echo "<td>{$col['data_type']}</td>";
            echo "<td>" . ($col['character_maximum_length'] ?: '-') . "</td>";
            echo "<td>{$col['is_nullable']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Verificar si coincide con lo que espera tu código
        $expected = ['id', 'nombre_usuario', 'email_usuario', 'password_usuario', 'fecha_registro'];
        $actual = array_column($columns, 'column_name');
        
        $missing = array_diff($expected, $actual);
        $extra = array_diff($actual, $expected);
        
        if (!empty($missing)) {
            echo "<p style='color: red;'>❌ Faltan columnas: " . implode(', ', $missing) . "</p>";
        }
        if (!empty($extra)) {
            echo "<p style='color: orange;'>⚠️ Columnas extra: " . implode(', ', $extra) . "</p>";
        }
        if (empty($missing) && empty($extra)) {
            echo "<p style='color: green;'>✅ Estructura correcta</p>";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}
?>