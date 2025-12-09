<?php
require_once 'db.php';

session_start();

function registrarEnTabla($tabla, $datos) {
    $conn = conectarDB();
    
    // Verificar si email ya existe en ESA tabla
    $sql_check = "SELECT COUNT(*) FROM $tabla WHERE email = ?";
    $stmt = $conn->prepare($sql_check);
    $stmt->execute([$datos['email']]);
    
    if ($stmt->fetchColumn() > 0) {
        return ['success' => false, 'message' => 'Email ya registrado'];
    }
    
    // Hashear contraseña
    $hash = password_hash($datos['password'], PASSWORD_DEFAULT);
    
    // Insertar (versátil para cualquier tabla con misma estructura)
    $sql = "INSERT INTO $tabla (usuario, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$datos['usuario'], $datos['email'], $hash])) {
        return ['success' => true, 'message' => 'Registro exitoso'];
    }
    
    return ['success' => false, 'message' => 'Error en registro'];
}

function loginDesdeTabla($tabla, $email, $password) {
    $conn = conectarDB();
    
    $sql = "SELECT * FROM $tabla WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($usuario && password_verify($password, $usuario['password'])) {
        // Guardar en sesión con prefijo de tabla
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_name'] = $usuario['usuario'];
        $_SESSION['user_email'] = $usuario['email'];
        $_SESSION['user_type'] = $tabla; // 'admins', 'docentes', 'estudiantes'
        
        return true;
    }
    
    return false;
}
?>