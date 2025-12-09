<?php
session_start();
require_once __DIR__ . '/../../../L-config/auth.php';

$tabla = 'admins';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['userEmail'] ?? '';
    $password = $_POST['userPassword'] ?? '';
    
    if (loginDesdeTabla($tabla, $email, $password)) {
        // Redirige correctamente desde admin/login_admin/ a admin/info-admin/
        header('Location: ../../info-admin/index.php');
        exit();
    } else {
        $_SESSION['error'] = "Credenciales incorrectas";
        header('Location: index.php');
        exit();
    }
}
?>