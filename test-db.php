<?php
echo "<h1>Test Conexión PostgreSQL en Railway</h1>";

// Método 1: $_ENV
echo "<h2>Usando \$_ENV:</h2>";
echo "PGHOST: " . ($_ENV['PGHOST'] ?? 'NO DEFINIDO') . "<br>";
echo "PGUSER: " . ($_ENV['PGUSER'] ?? 'NO DEFINIDO') . "<br>";
echo "PGPASSWORD: " . (!empty($_ENV['PGPASSWORD']) ? 'DEFINIDA (' . strlen($_ENV['PGPASSWORD']) . ' chars)' : 'VACÍA') . "<br>";

// Método 2: getenv()
echo "<h2>Usando getenv():</h2>";
echo "PGHOST: " . (getenv('PGHOST') ?: 'NO DEFINIDO') . "<br>";
echo "PGUSER: " . (getenv('PGUSER') ?: 'NO DEFINIDO') . "<br>";
echo "PGPASSWORD: " . (getenv('PGPASSWORD') ? 'DEFINIDA (' . strlen(getenv('PGPASSWORD')) . ' chars)' : 'VACÍA') . "<br>";

// Método 3: $_SERVER
echo "<h2>Usando \$_SERVER:</h2>";
foreach ($_SERVER as $key => $value) {
    if (strpos($key, 'PG') === 0) {
        if ($key === 'PGPASSWORD') {
            echo "$key: **********<br>";
        } else {
            echo "$key: $value<br>";
        }
    }
}

// Intentar conexión
echo "<h2>Probando conexión real:</h2>";
try {
    $host = $_ENV['PGHOST'] ?? getenv('PGHOST');
    $port = $_ENV['PGPORT'] ?? getenv('PGPORT');
    $dbname = $_ENV['PGDATABASE'] ?? getenv('PGDATABASE');
    $user = $_ENV['PGUSER'] ?? getenv('PGUSER');
    $password = $_ENV['PGPASSWORD'] ?? getenv('PGPASSWORD');
    
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    echo "Intentando conectar con DSN: pgsql:host=HOST;port=$port;dbname=$dbname<br>";
    
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ <strong>Conexión EXITOSA!</strong><br>";
    
    // Verificar tablas
    $stmt = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Tablas en la base de datos:<br>";
    if (empty($tables)) {
        echo "❌ No hay tablas. Necesitas crear la tabla 'usuarios'<br>";
    } else {
        foreach ($tables as $table) {
            echo "- $table<br>";
        }
    }
    
} catch (Exception $e) {
    echo "❌ <strong>Error de conexión:</strong> " . $e->getMessage() . "<br>";
    echo "<pre>Detalles: " . print_r($e, true) . "</pre>";
}
?>