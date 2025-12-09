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
        
        if ($usuario) {
            // Verificar password (hasheado o texto plano temporal)
            if ($usuario['password'] === $password) {
                return true;
            }
        }
    } catch (PDOException $e) {
        error_log("Error login $tabla: " . $e->getMessage());
    }
    
    return false;
}
?>