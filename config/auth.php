<?php
// config/auth.php - Sistema de autenticación centralizado
require_once 'database.php';

session_start(); // Iniciar sesión para todos

function autenticarUsuario($email, $password, $tipo) {
    $conexion = conectarDB();
    if (!$conexion) return false;
    
    $tabla = obtenerTablaPorTipo($tipo);
    
    $sql = "SELECT * FROM $tabla WHERE email = :email LIMIT 1";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':email' => $email]);
    $usuario = $stmt->fetch();
    
    if ($usuario && password_verify($password, $usuario['password_hash'])) {
        return $usuario;
    }
    
    return false;
}

function registrarUsuario($datos, $tipo) {
    $conexion = conectarDB();
    if (!$conexion) return false;
    
    $tabla = obtenerTablaPorTipo($tipo);
    
    // Verificar si email ya existe
    $checkSql = "SELECT COUNT(*) FROM $tabla WHERE email = :email";
    $checkStmt = $conexion->prepare($checkSql);
    $checkStmt->execute([':email' => $datos['email']]);
    
    if ($checkStmt->fetchColumn() > 0) {
        return ['success' => false, 'message' => 'Email ya registrado'];
    }
    
    // Hash de contraseña
    $datos['password_hash'] = password_hash($datos['password'], PASSWORD_DEFAULT);
    
    // Construir consulta dinámica
    $campos = array_keys($datos);
    $placeholders = ':' . implode(', :', $campos);
    
    $sql = "INSERT INTO $tabla (" . implode(', ', $campos) . ") 
            VALUES ($placeholders)";
    
    try {
        $stmt = $conexion->prepare($sql);
        $result = $stmt->execute($datos);
        
        return [
            'success' => $result,
            'message' => $result ? 'Registro exitoso' : 'Error en registro',
            'user_id' => $conexion->lastInsertId()
        ];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Error DB: ' . $e->getMessage()
        ];
    }
}

function verificarSesion($tipo_requerido) {
    if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== $tipo_requerido) {
        header('Location: ../index.php');
        exit();
    }
}

function cerrarSesion() {
    session_destroy();
    header('Location: ../index.php');
    exit();
}
?>