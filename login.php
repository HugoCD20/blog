<?php
    session_start();
    if(isset($_SESSION['id'])){//verrifica que no este iniciada la sesion si es asi no deja entrar a esta pagina
        header('location:index.php');
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee and  Tea</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="cont-1">
            <h1>Coffee and Tea</h1>
            <img class="img-1" src="image/taza.png" alt="taza">
        </div>
    </header>
    <main>
        <div class="cont-3">
            <?php
            if(isset( $_SESSION['pag'])){
                switch( $_SESSION['pag']){
                    case 2:
                        echo '<a class="regreso" href="explorar.php">';
                        break;
                    case 3:
                        echo '<a class="regreso" href="blog.php">';
                        break;
                    default:
                        echo '<a class="regreso" href="index.php">';
                        break;
                }
            }
            ?>
                
                    <img class="img-2" src="image/regreso.png" alt="regreso">
                </a>
                <h5>Iniciar sesión</h5>
                <form class="form-1" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                    <div>
                    <label for="correo">Correo electrónico:</label></div>
                    <input class="text-box1" type="text" id="correo" name="correo">
                    <?php 
                        if ($_SERVER["REQUEST_METHOD"] === "POST") {
                            $Correo=$_POST['correo'];
                            if(strlen($Correo)>200){
                                echo '<center> <p class="error">Correo electronico demasiado largo</p> </center>';
                            }

                            // Filtrar el correo electrónico usando filter_var
                            $correoFiltrado = filter_var($Correo, FILTER_VALIDATE_EMAIL);//ESTA FUNCION VALIDA QUE SEA UN CORREO ELECTRONICO                   
                            if ($correoFiltrado == false) {
                                echo '<center> <p class="error">Correo no valido</p> </center>';
                            } 
                        
                         }
                    ?>
                    <div>
                    <label for="contrasena">Contraseña:</label></div>
                    <input class="text-box1" type="password" id="contrasena" name="contrasena">
                    <?php 
                        if ($_SERVER["REQUEST_METHOD"] === "POST") {
                            $Contraseña=$_POST['contrasena'];
                            if(empty($Contraseña)){
                                echo '<center> <p class="error">Coloca una contraseña</p> </center>';
                            }elseif(strlen($Contraseña)<3){
                                echo '<center> <p class="error">Contraseña demasiado corta</p> </center>';
                            }
                            if(strlen($Contraseña)>100){
                                echo '<center> <p class="error">Contraseña demasiada larga</p> </center>';
                            }
                        }
                    ?>
                    
                    <center><p>¿No tienes una cuenta? <a href="registro.php"> has click aqui</a></p></center>                    
                    <center style="margin-top:1rem;"><input class="button-5" type="submit" value="Iniciar sesión"></center>
                    
                    <?php 
                        if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        include("validar-login.php");
                        }
                    ?>
                </form>
        </div>
       
        
    </div>
    </main>
    <footer>Copyright © 2023 · COFFEE AND TEA</footer>
</body>
</html>