<?php
require_once '../config/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']) ?? '';
    $password = htmlspecialchars($_POST['password']) ?? '';
    
    $usuario = autenticarUsuario($email, $password, 'usuarios');
    
    if ($usuario) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_tipo'] = 'usuarios';
        
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>