<?php
// admin/login_admin/index.php - FORMULARIO + PROCESAMIENTO
require_once __DIR__ . '/../../../config/auth.php'; // ⚠️ Ajusta esta ruta

$tabla = 'admins';
$error = '';

// 1. Si YA está logueado como admin, redirigir DIRECTAMENTE al dashboard
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admins') {
    header('Location: ../../info-admin/index.php'); // ⬅️ ESTA es la ruta que quieres
    exit();
}

// 2. Procesar login si viene POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['userEmail'] ?? '');
    $password = $_POST['userPassword'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = "Complete todos los campos";
    } elseif (loginDesdeTabla($tabla, $email, $password)) {
        // ✅ LOGIN EXITOSO - Redirigir a info-admin/index.php
        header('Location: ../../info-admin/index.php');
        exit(); // ⚠️ IMPORTANTE: detener ejecución
    } else {
        $error = "Email o contraseña incorrectos";
    }
}