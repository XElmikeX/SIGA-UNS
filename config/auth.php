<?php
// config/auth.php - VERSIÓN CORREGIDA
require_once __DIR__ . '/db.php';

session_start();

function loginDesdeTabla($tabla, $email, $password) {
    $conn = conectarDB();
    if (!$conn) return false;
    
    try {
        // ✅ CORREGIDO: Prepared statement con placeholder
        $sql = "SELECT * FROM $tabla WHERE email = :email LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario && password_verify($password, $usuario['password'])) {
            // Guardar en sesión
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_name'] = $usuario['usuario'] ?? $usuario['email'];
            $_SESSION['user_email'] = $usuario['email'];
            $_SESSION['user_type'] = $tabla;
            
            return true;
        }
    } catch (PDOException $e) {
        error_log("Error en login: " . $e->getMessage());
        return false;
    }
    
    return false;
}

// Función para debug
function debugSession() {
    echo "<pre>Sesión actual:\n";
    print_r($_SESSION);
    echo "</pre>";
}
?>