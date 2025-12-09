<?php
session_start();
require_once __DIR__ . '/../../../L-config/auth.php';

$tabla = 'docentes';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['userEmail'] ?? '';
    $password = $_POST['userPassword'] ?? '';
    
    if (loginDesdeTabla($tabla, $email, $password)) {
        // Verifica que exista la ruta docente/info-docen/
        header('Location: ../../info-docen/index.php');
        exit();
    } else {
        $_SESSION['error'] = "Credenciales incorrectas";
        header('Location: index.php');
        exit();
    }
}
?>