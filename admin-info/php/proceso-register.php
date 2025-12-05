<?php
include __DIR__ . "/yave.php";  // Usa __DIR__ para ruta absoluta;

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
    
    // Usar htmlspecialchars para seguridad (PDO ya maneja la seguridad con prepared statements)
    $userName = htmlspecialchars($_POST["userName"]);
    $userEmail = htmlspecialchars($_POST["userEmail"]);
    $userPassword = password_hash($_POST["userPassword"], PASSWORD_DEFAULT);

    try {
        // VERIFICACION DE REGISTRO - Usar prepared statements
        $checkQuery = "SELECT * FROM usuarios WHERE nombre_usuario = :userName OR email_usuario = :userEmail";
        $stmt = $conexion->prepare($checkQuery);
        $stmt->execute([
            ':userName' => $userName,
            ':userEmail' => $userEmail
        ]);
        
        $existingUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $nameExists = false;
        $emailExists = false;
        
        foreach ($existingUsers as $user) {
            if ($user['nombre_usuario'] === $userName) {
                $nameExists = true;
            }
            if ($user['email_usuario'] === $userEmail) {
                $emailExists = true;
            }
        }

        if ($nameExists && $emailExists) {
            echo json_encode([
                'success' => false,
                'message' => 'NOMBRE Y GMAIL EXISTENTES'
            ]);
            exit();
        }

        if ($nameExists) {
            echo json_encode([
                'success' => false,
                'message' => 'NOMBRE EXISTENTE'
            ]);
            exit();
        }

        if ($emailExists) {
            echo json_encode([
                'success' => false,
                'message' => 'GMAIL EXISTENTE'
            ]);
            exit();
        }

        // ENVIO EXITOSO - Usar prepared statements
        $insertQuery = "INSERT INTO usuarios(nombre_usuario, email_usuario, password_usuario) 
                       VALUES(:userName, :userEmail, :userPassword)";
        $stmt = $conexion->prepare($insertQuery);
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
                    'userPassword' => $userPassword
                ]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al insertar el usuario'
            ]);
        }
        
    } catch (PDOException $e) {
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
        'message' => 'Método no permitido'
    ]);
    exit();
}
?>