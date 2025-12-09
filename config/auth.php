<?php

require_once __DIR__ . '/db.php';

session_start();

function loginDesdeTabla($tabla, $email, $password) {
    $conn = conectarDB();
    if (!$conn) return false;
    
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

function registrarEnTabla($tabla, $datos) {
    $conn = conectarDB();
    if (!$conn) return ['success' => false, 'message' => 'Error DB'];
    
    try {
        // Verificar si email ya existe
        $sql_check = "SELECT COUNT(*) FROM $tabla WHERE email = :email";
        $stmt = $conn->prepare($sql_check);
        $stmt->execute([':email' => $datos['email']]);
        
        if ($stmt->fetchColumn() > 0) {
            return ['success' => false, 'message' => 'Email ya registrado'];
        }
        
        // Hashear password
        $hash = password_hash($datos['password'], PASSWORD_DEFAULT);
        
        // Insertar
        $sql = "INSERT INTO $tabla (usuario, email, password) VALUES (:usuario, :email, :password)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt->execute([
            ':usuario' => $datos['usuario'],
            ':email' => $datos['email'],
            ':password' => $hash
        ])) {
            return ['success' => true, 'message' => 'Registro exitoso'];
        }
    } catch (PDOException $e) {
        error_log("Error registro $tabla: " . $e->getMessage());
    }
    
    return ['success' => false, 'message' => 'Error en registro'];
}


function verificarSesion($tipo_requerido) {
    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== $tipo_requerido) {
        header('Location: /index.php');
        exit();
    }
}
?>