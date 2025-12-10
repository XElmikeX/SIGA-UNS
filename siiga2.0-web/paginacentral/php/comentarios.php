<?php
    require_once __DIR__ . 'yave.php';

    $conexion = conexionDB();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        header('Content-Type: application/json');

        if (empty($_POST['gmail'] || empty($_POST['comentario']))){
            echo json_encode([
                'success'=>false,
                'message'=>'Rellenar todos los espacios',
                
            ]);
            exit();
        }

        $userEmail = htmlspecialchars($_POST['gmail']);
        $userComent = htmlspecialchars($_POST['comentario']);

    try{
        $insertQuery = "INSERT INTO comentarios(email,comentario) VALUES(':userEmail','userComent')";
        $stmtQuery = $conexion -> prepare($insertQuery);
        $resultado = $stmtQuery -> execute([
            ':userEmail' => $userEmail,
            ':userComent' => $userComent,
        ]);

        if($resultado){
            echo json_encode([
                'success' => true,
                'message' => 'Comentario Enviado'
            ]);
        }else{
            echo json_encode([
                'success' => false,
                'message' => 'No Enviar',
            ]);
            exit();
        }
    }catch (PDOException $e){
        error_log('Error en la DB:' . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' =>'Error en la DB:' . $e->getMessage(),
        ]);
        exit();
    }
           
    }else{
        header('Content-Type: application/json');
        error_log('Tiene q ser por metodo POST');
        echo json_encode([
            'success' => false,
            'message' =>'Escribe en comentarios q lo cambien a post',
        ]);
        exit();
    }
?>