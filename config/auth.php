<?php
require_once 'db.php';

session_start();

function loginDesdeTabla($tabla, $email, $password) {
    $conn = conectarDB();
    
    $sql = "SELECT * FROM $tabla WHERE email = $email LIMIT 1";
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