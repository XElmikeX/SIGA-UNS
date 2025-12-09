<?php
    include "yave.php";
    $userEmail = mysqli_real_escape_string($conexion,$_POST["gmail"]);
    $userComent = mysqli_real_escape_string($conexion,$_POST["comentario"]);

    $query = "INSERT INTO comentarios(email,comentario) VALUES('$userEmail','$userComent')";

    $run = mysqli_query($conexion,$query);

    if ($run){
        header("Location:http://localhost/PAGINA/paginacentral/");
    };
?>