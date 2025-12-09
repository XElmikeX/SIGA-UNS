<?php
// admin/login_admin/php/login_admin.php - VERSIÓN CORREGIDA
require_once __DIR__ . '/../../../config/auth.php';

$tabla = 'admins';
$error = '';

// Verificar si ya está logueado
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admins') {
    header('Location: ../../info-admin/index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ✅ Validar y obtener datos
    $email = trim($_POST['userEmail'] ?? '');
    $password = $_POST['userPassword'] ?? '';
    
    // Validar campos
    if (empty($email) || empty($password)) {
        $error = "Por favor complete todos los campos";
    } else {
        // Intentar login
        if (loginDesdeTabla($tabla, $email, $password)) {
            // ✅ Redirección ABSOLUTA desde raíz
            $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") 
                        . "://" . $_SERVER['HTTP_HOST'];
            
            // Verificar estructura según tu image.png
            header('Location: ' . $base_url . '/admin/info-admin/index.php');
            exit();
        } else {
            $error = "Email o contraseña incorrectos";
        }
    }
}
?>