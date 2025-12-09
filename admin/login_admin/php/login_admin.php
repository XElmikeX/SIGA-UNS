<?php
// admin/login_admin/php/login_admin.php
require_once __DIR__ . '/../../../config/auth.php';

$tabla = 'admins';
$error = '';

// 1. Si YA está logueado como admin, redirigir DIRECTAMENTE
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admins') {
    // ✅ RUTA CORRECTA: sube 1 nivel (a login_admin/) y entra a info-admin/
    header('Location: ../info-admin/index.php');
    exit();
}

// 2. Procesar login si viene POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['userEmail'] ?? '');
    $password = $_POST['userPassword'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = "Por favor complete todos los campos";
    } else {
        // Intentar login
        if (loginDesdeTabla($tabla, $email, $password)) {
            // ✅ REDIRECCIÓN CORRECTA después de login
            header('Location: ../info-admin/index.php');
            exit();
        } else {
            $error = "Email o contraseña incorrectos";
        }
    }
}
?>

<!-- HTML mínimo para el formulario -->
<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
</head>
<body>
    <h2>Login Administrador</h2>
    
    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <input type="email" name="userEmail" placeholder="Email" required>
        <input type="password" name="userPassword" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
    
    <p><a href="../../../index.php">Volver al inicio</a></p>
</body>
</html>