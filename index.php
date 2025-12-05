<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horario De Trabajo</title>

    <link rel="icon" href="/imagenes/logo.png">
    
    <link rel="stylesheet" href="/tabla.css">
</head>
<body>
    
    
    <div class="calculos">
        <table>
            <thead>
                <tr>
                    <th>HORA</th>
                    <th>LUNES</th>
                    <th>MARTES</th>
                    <th>MIERCOLES</th>
                    <th>JUEVES</th>
                    <th>VIERNES</th>
                    <th>SABADO</th>
                    <th>DOMINGO</th>
                </tr> 
            </thead>
            <tbody>           
                <tr>
                    <td>7 am</td>
                    <td></td>
                    <td></td>
                    <td class="Programación" rowspan="2">
                        <p class="color">Fundamentos de Programación</p>
                        <p><strong>(Practica)</strong></p>
                        <p><strong>7-9 pm</strong></p>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>8 am</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>9 am</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>10 am</td>
                    <td class="Programación" rowspan="3">
                        <p class="color">Fundamentos de Programación</p>
                        <p><strong>(Teoria)</strong></p>
                        <p><strong>10-1 pm</strong></p>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>11 am</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="Medio" rowspan="2">
                        <p class="color">Medio Ambiente y Desarrollo Sostenible</p>
                        <p><strong>(Practica)</strong></p>
                        <p><strong>11-1 pm</strong></p>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>12 pm</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>1 pm</td>
                    <td class="recreo" colspan="7" style="color: antiquewhite;"><strong>RECREO</strong></td>
                </tr>
                <tr>
                    <td>2 pm</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>3 pm</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>4 pm</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>5 pm</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>6 pm</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>7 pm</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>8 pm</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </tbody>
        </table>
    </div>
    <div class="caja2">
        <h3>Usuarios Registrados</h3>
        
        <div>
            <form id="form" novalidate>
                <p class="message" style="font-size: 1.2rem;">Datos del usuario nuevo</p>
                <div>
                    <label>
                    <input name="userName" class="input usuario" type="text" placeholder="" required>
                    <span class="span">Primer Nombre</span>
                    </label>
                </div>
                
                <div>
                    <label>
                    <input name="userEmail" class="input email" type="email" placeholder="" required>
                    <span class="span">Gmail</span>
                    </label>
                </div>
                
                <div>
                    <label>
                    <input name="userPassword" class="input password" type="password" placeholder="" required>
                    <span class="span">Contraseña</span>
                    </label>
                </div>
                
                <div>
                    <button type="submit" name="mejoramiento" class="submit">Resgistrar</button>
                    <div class="alerta-correct"></div>
                    <div class="alerta-deneg"></div>
                </div>
            </form>
        </div>

        <div style="margin-bottom: 20px;">
            <table id="registro">
                <tr>
                    <th>Usuario</th>
                    <th>Gmail</th>
                    <th>Contraseña</th>
                </tr>
            </table>
        </div>
    </div>
</body>
    
    <script src="/js/table_regis.js"></script>
</html>