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
            if (password_verify($password, $usuario['password'])) {
                // ✅ Password hasheado correcto
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['user_name'] = $usuario['usuario'] ?? $usuario['email'];
                $_SESSION['user_email'] = $usuario['email'];
                $_SESSION['user_type'] = $tabla;
                return true;
            }
            // ⚠️ Temporal: Si password está en texto plano
            elseif ($usuario['password'] === $password) {
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['user_name'] = $usuario['usuario'] ?? $usuario['email'];
                $_SESSION['user_email'] = $usuario['email'];
                $_SESSION['user_type'] = $tabla;
                return true;
            }
        }
    } catch (PDOException $e) {
        error_log("Error login $tabla: " . $e->getMessage());
    }
    
    return false;
}
?>