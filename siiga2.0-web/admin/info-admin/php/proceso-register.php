<?php
// RUTA CORRECTA (yave.php está en la raíz)
require_once __DIR__ . '/yave.php';

// Llamar a conectarDB() explícitamente
$conexionInfo = conectarDBinfo();

if (!$conexionInfo) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Base de datos no disponible. Intente más tarde.'
    ]);
    exit();
}

// Este archivo solo procesa peticiones POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    
    // Verificar que los campos existan
    if(empty($_POST["userName"]) || empty($_POST["userEmail"]) || empty($_POST["userPassword"])) {
        echo json_encode([
            'success' => false,
            'message' => 'Faltan campos obligatorios'
        ]);
        exit();
    }
    
    $userName = htmlspecialchars($_POST["userName"]);
    $userEmail = htmlspecialchars($_POST["userEmail"]);
    // Cifrar la contraseña
    $userPassword = password_hash($_POST["userPassword"], PASSWORD_DEFAULT);
    
    try {
        // 1. Verificar si el email ya existe
        $checkQuery = "SELECT * FROM usuarios WHERE email = :userEmail";
        $stmtCheck = $conexionInfo->prepare($checkQuery);
        $stmtCheck->execute([':userEmail' => $userEmail]);
        
        // Uso de fetchColumn para obtener el conteo (más eficiente que rowCount en algunos drivers)
        if ($stmtCheck->fetchColumn() > 0) {
            echo json_encode([
                'success' => false,
                'message' => 'GMAIL EXISTENTE'
            ]);
            exit();
        }

        // 2. Insertar el nuevo usuario
        $insertQuery = "INSERT INTO usuarios(usuario, email, password) 
                       VALUES(:userName, :userEmail, :userPassword)";
        $stmt = $conexionInfo->prepare($insertQuery);
        $result = $stmt->execute([
            ':userName' => $userName,
            ':userEmail' => $userEmail,
            ':userPassword' => $userPassword
        ]);

        if($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Usuario registrado exitosamente',
                'user' => [
                    'userName' => $userName,
                    'userEmail' => $userEmail,
                    'userPassword' => $_POST["userPassword"] // Devuelve la original para JS, no el hash
                ]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al insertar el usuario'
            ]);
        }
        
    } catch (PDOException $e) {
        error_log("Error en DB (Registro): " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => 'Error en la base de datos: ' . $e->getMessage()
        ]);
    }
    exit();
} else {
    // Si no es POST, devolver error
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Acceso denegado. Se requiere método POST.'
    ]);
}
?>