<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de USER</title>

    <!-- los iconos de google,github, usos de diferentes iconos -->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>

    <!-- conexcion a la decoración-->
    <link rel="stylesheet" href="css/form.css">

    <!-- ICONO de la pagina web-->
    <link rel="icon" href="../../G-assets/imagenes/logo.png">

</head>
<body>
    <!--   INICIO DE SESION   -->
    <div class="container-form login">
        <div class="information">
            <div class="info-childs">
                <h2>Bienvenido Estudiante</h2>
                <p>Solicita a un ADMIN para que seas registrado</p>
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Iniciar sesión</h2>
                <div class="icons">
                    <i class='bx bxl-google' ></i>
                    <i class='bx bxl-github' ></i>
                    <i class='bx bxl-linkedin' ></i>
                </div>
            </div>
            <p>Rellenar las casillas correspondientes</p>
            <form action="php/login_estudiante.php" method="POST" class="form form-login" novalidate>
                <div>
                    <label>
                    <i class='bx bx-envelope' ></i>
                    <input type="email" placeholder="example@gmail.com" name="userEmail">
                    </label>
                </div>
                <div>
                    <label>
                    <i class='bx bx-lock-alt' ></i>
                    <input type="password" placeholder="Contraseña" name="userPassword">
                </label>
                </div>
                
                <input type="submit" value="Iniciar Sesión">
                <div class="alerta-exito">Inicio exitoso</div>
                <div class="alerta-error">Rellana las casillas</div>
            </form>
        </div>
    </div>

    <script src="js/register.js" type="module"></script>
    <script src="js/login_modulo.js" type="module"></script>
</body>
</html>