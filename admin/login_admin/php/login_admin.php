<?php
// admin/login_admin/index.php - LOGIN PARA ADMINS
require_once __DIR__ . '/../../../config/auth.php';

$tabla = 'admins'; // ✅ TABLA FIJA para admins
$error = '';

// Si YA está logueado como admin, ir al dashboard
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admins') {
    header('Location: ../../info-admin/index.php');
    exit();
}

// Procesar login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['userEmail'] ?? '');
    $password = $_POST['userPassword'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = "Complete todos los campos";
    } elseif (loginDesdeTabla($tabla, $email, $password)) {
        // ✅ LOGIN EXITOSO - Redirigir al dashboard
        header('Location: ../../info-admin/index.php');
        exit();
    } else {
        $error = "Email o contraseña incorrectos";
    }
}
?>