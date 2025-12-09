<?php

require_once __DIR__ . '/db.php';

session_start();

function loginDesdeTabla($tabla, $email, $password) {
    $conn = conectarDB();

    try {
        // Buscar usuario
        $sql = "SELECT * FROM $tabla WHERE email = :email LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
        if ($usuario && $usuario['password'] === $password) {
            // REGISTRAR EN LOG (para VERLO después)
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'IP Desconocida';
                
            // Mensaje para Railway Logs
            error_log("=== NUEVO LOGIN DETECTADO ===");
            error_log("Usuario: $email");
            error_log("Tipo: $tabla");
            error_log("IP: $ip");
            error_log("=============================");

            return true;
        }
        
    } catch (PDOException $e) {
        error_log("Error login $tabla: " . $e->getMessage());
    }
    
    return false;
}
?>