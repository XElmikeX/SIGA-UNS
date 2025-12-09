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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador</title>
    <style>
        * { box-sizing: border-box; }
        body { 
            font-family: Arial, sans-serif; 
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 { 
            text-align: center; 
            color: #333;
            margin-bottom: 24px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        input:focus {
            outline: none;
            border-color: #007bff;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #0056b3;
        }
        .error {
            background: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #666;
            text-decoration: none;
        }
        .back-link:hover {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>🔐 Administrador</h2>
        
        <?php if ($error): ?>
            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="userEmail">Email:</label>
                <input type="email" id="userEmail" name="userEmail" 
                       value="<?php echo htmlspecialchars($_POST['userEmail'] ?? ''); ?>"
                       required autofocus>
            </div>
            
            <div class="form-group">
                <label for="userPassword">Contraseña:</label>
                <input type="password" id="userPassword" name="userPassword" required>
            </div>
            
            <button type="submit">Iniciar Sesión</button>
        </form>
        
        <a href="../../../index.php" class="back-link">← Volver al inicio</a>
        
        <!-- Debug info (remover en producción) -->
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['debug'])): ?>
            <hr style="margin: 20px 0;">
            <div style="font-size: 12px; color: #666;">
                <strong>Debug:</strong><br>
                POST recibido: <?php echo json_encode($_POST); ?><br>
                Ruta actual: <?php echo __DIR__; ?><br>
                Sesión: <?php echo json_encode($_SESSION); ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
