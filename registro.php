<?php
    session_start();
    if(isset($_SESSION['id'])){
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
                <a class="regreso" href="login.php">
                    <img class="img-2" src="image/regreso.png" alt="regreso">
                </a>
                <h5 class="title-5">REGISTRARSE</h5>
                <form class="form-1" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
                    <div>
                    <label for="nombre">Nombre:</label></div>
                    <input class="text-box1" type="text" id="nombre" name="nombre">
                    <?php 
                     if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        $nombre=$_POST['nombre'];
                        if(empty($nombre)){
                            echo '<center> <p class="error">Coloca un nombre de usuario</p> </center>';
                        }
                        if(strlen($nombre)>200){
                            echo '<center> <p class="error">Nombre de usuario demasiado largo</p> </center>';
                        }
                    }
                    ?>
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
                            $correoFiltrado = filter_var($Correo, FILTER_VALIDATE_EMAIL);                        
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

                    <div>
                    <label  for="confirmarContrasena">Confirmar contraseña:</label></div>
                    <input class="text-box1" type="password" id="confirmarContrasena" name="confirmarContrasena">
                    <?php 
                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        $contraseña=$_POST['contrasena'];
                        $Contra=$_POST['confirmarContrasena'];
                        if($contraseña!=$Contra){
                            echo '<center> <p class="error">Las contraseñas no coinciden</p> </center>';
                        }
                    }
                    ?>    
                    <div>
                    <label  for="imagen">Foto de perfil:</label></div>
                    <input style="margin-top:1rem;" type="file" id="foto" name="foto" accept="image/*"><br>
                    <center><p>¿Ya tienes una cuenta? <a href="login.php"> has click aqui</a></p></center>                    
                    <center style="margin-top:1rem;"><input class="button-5" type="submit" value="Registrarse"></center>
                    
                    <?php 
                        if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        include("validar-registro.php");
                        }
                    ?>
                </form>
        </div>
       
        
    </div>
    </main>
    <footer>Copyright © 2023 · COFFEE AND TEA</footer>
</body>
</html>