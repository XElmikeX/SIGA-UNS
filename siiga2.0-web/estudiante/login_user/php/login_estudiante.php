<?php
session_start();
require_once __DIR__ . '/../../../L-config/auth.php';

$tabla = 'usuarios'; // o 'estudiantes' si tu tabla se llama así

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['userEmail'] ?? '';
    $password = $_POST['userPassword'] ?? '';
    
    if (loginDesdeTabla($tabla, $email, $password)) {
        header('Location: ../../info-user/index.html');
        exit();
    } else {
        $_SESSION['error'] = "Credenciales incorrectas";
        header('Location: index.php');
        exit();
    }
}
?>