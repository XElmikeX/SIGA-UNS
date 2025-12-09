<?php
// admin/login.php
require_once '../../../config/auth.php';

$tabla = 'admins'; // ✅ TABLA FIJA para admins

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['userEmail'];
    $password = $_POST['userPassword'];
    
    if (loginDesdeTabla($tabla, $email, $password)) {
        header('Location: ../../info-admin/index.php');
        exit();
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>
