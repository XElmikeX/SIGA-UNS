<?php
// verificar-conexion.php
echo "<h2>🔍 Verificando conexión a Postgres-CGIf</h2>";

// Mostrar variable actual
$db_url = getenv('DATABASE_URL');
echo "<p>DATABASE_URL: " . (empty($db_url) ? '❌ NO CONFIGURADA' : '✅ CONFIGURADA') . "</p>";

if ($db_url) {
    // Parsear URL para mostrar info (sin password)
    $url = parse_url($db_url);
    echo "<pre>";
    echo "Host: " . $url['host'] . "\n";
    echo "Puerto: " . ($url['port'] ?? '5432') . "\n";
    echo "Base de datos: " . substr($url['path'], 1) . "\n";
    echo "Usuario: " . $url['user'] . "\n";
    echo "</pre>";
    
    // Verificar a cuál BD se conecta
    if (strpos($url['host'], 'postgres-cgif') !== false) {
        echo "<p style='color:green;'>✅ CONECTANDO A: Postgres-CGIf (CORRECTO)</p>";
    } else {
        echo "<p style='color:red;'>❌ CONECTANDO A: " . $url['host'] . " (INCORRECTO)</p>";
        echo "<p>Debe cambiar la variable a: \${Postgres-CGIf.DATABASE_URL}</p>";
    }
}

// Incluir yave.php y probar conexión
require_once __DIR__ . '/yave.php';
$con = conectarDB();

if ($con) {
    echo "<p style='color:green;'>✅ Conexión PHP exitosa</p>";
    
    try {
        // Verificar tabla
        $stmt = $con->query("SELECT EXISTS (SELECT FROM information_schema.tables WHERE table_name = 'usuarios')");
        $existe = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($existe['exists'] == 't') {
            echo "<p style='color:green;'>✅ Tabla 'usuarios' EXISTE en Postgres-CGIf</p>";
            
            // Contar registros
            $stmt = $con->query("SELECT COUNT(*) as total FROM usuarios");
            $count = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<p>Total de usuarios registrados: <strong>" . $count['total'] . "</strong></p>";
            
            // Mostrar últimos registros
            $stmt = $con->query("SELECT id, nombre_usuario, email_usuario, fecha_registro FROM usuarios ORDER BY id DESC LIMIT 5");
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($usuarios)) {
                echo "<h3>Últimos usuarios registrados:</h3>";
                echo "<table border='1'>";
                echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Fecha</th></tr>";
                foreach ($usuarios as $user) {
                    echo "<tr>";
                    echo "<td>{$user['id']}</td>";
                    echo "<td>{$user['nombre_usuario']}</td>";
                    echo "<td>{$user['email_usuario']}</td>";
                    echo "<td>{$user['fecha_registro']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        } else {
            echo "<p style='color:red;'>❌ Tabla 'usuarios' NO EXISTE en Postgres-CGIf</p>";
            echo "<p>Crea la tabla con:</p>";
            echo "<pre>";
            echo "CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nombre_usuario VARCHAR(255) UNIQUE NOT NULL,
    email_usuario VARCHAR(255) UNIQUE NOT NULL,
    password_usuario TEXT NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";
            echo "</pre>";
        }
        
    } catch (PDOException $e) {
        echo "<p style='color:red;'>❌ Error en consulta: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color:red;'>❌ No se pudo conectar a la base de datos</p>";
    echo "<p>Verifica que la variable DATABASE_URL esté configurada correctamente.</p>";
}
?>