<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGA</title>

    <link rel="icon" href="G-assets/imagenes/logo.png">
    <link rel="stylesheet" href="paginacentral/css/Pract.css">
</head>
<body id="menu">
    <section id="interfas">
        <article id="inter">
            <div id="titulo">
                <img class="logo" src="G-assets/imagenes/logo.png">
                <h1 id="titul">SIGA</h1>
                <img class="logo" src="G-assets/imagenes/logo.png">
            </div>
            <div class="part">
                <a class="quitar" href="#contenedor" data-desplazamiento="90">Inicio</a>
            </div>
            <div class="part">
                Información
            </div>
            <div class="part">
                <a class="quitar" href="#contacto" data-desplazamiento="80px">Contacto</a>
            </div>
        </article>
    </section>
    <section id="contenedor">
        <!--Administrador-->
        <div>
            <a target="_blank" href="admin/login_admin/index.php"><img class="opciones" src="G-assets/imagenes/administrador.png"></a>
        </div>
        <!--Estudiante-->
        <div>
            <a target="_blank" href="estudiante/login_user/index.php"><img class="opciones" src="G-assets/imagenes/estudiante.png"></a>
        </div>  
        <!--Docente--> 
        <div>
            <a target="_blank" href="docente/login_docente/index.php"><img class="opciones" src="G-assets/imagenes/docente.png"></a>
        </div>       
    </section>


    <footer id="contacto">
        <article class="minic1">
            <div id="config">
                <p class="cont">Contacto</p>
            </div>
        </article>
        <article class="minic1">
                <label id="con">Gmail:</label>    
                <a class="quitar" href="mailto:urbanodiaze@gmail.com">urbanodiaze@gmail.com</a>
        </article>
        <article class="minic1">
                <fieldset id="caja">
                    <form action="paginacentral/php/comentarios.php" method="POST" id="form" novalidate>
                        <div class="cont1">
                            <label for="gmail">Gmail:</label>
                            <input name="gmail" class="gmail" type="email" cols="15px" placeholder="example@gmail.com">
                        </div>
                        
                        <div class="cont1">
                            <div>
                                <label for="coment">Comentario: </label>
                            </div>
                            <div>
                                <textarea name="comentario" class="coment" cols="25px" rows="8px" placeholder="Comentario..."></textarea>
                            </div>  
                        </div>
                        <button class="boton" type="submit">Enviar</button>
                        <button class="boton" type="reset">Borrar</button>
                        <div class="alerta-exito">Enviado Correctamente</div>
                        <div class="alerta-error">Rellene Correctamente</div>                    
                    </form>                        
                </fieldset>
        </article>
        <br>
        <br>
        <br>
    </footer>

    <script src="paginacentral/js/desplazamiento.js"></script>
    <script src="paginacentral/js/comentario.js"></script>
    
</body>
</html>