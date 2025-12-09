<?php
// admin/login.php
require_once '../config/auth.php';

$tabla = 'admins'; // ✅ TABLA FIJA para admins

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (loginDesdeTabla($tabla, $email, $password)) {
        header('Location: ' . $base_url . '/info_admin/index.php');
        exit();
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>
