<?php
// admin/login_admin/index.php - LOGIN PARA ADMINS
require_once __DIR__ . '/../../../config/auth.php';

$tabla = 'admins'; // TABLA FIJA para admins

// Procesar login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['userEmail'] ?? '';
    $password = $_POST['userPassword'] ?? '';
    
    if (loginDesdeTabla($tabla, $email, $password)) {
        header('Location: ../../info-admin/index.php');
        exit();
    }
}
?>