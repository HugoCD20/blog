<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    $_SESSION['page']=8;
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
        <?php
             include("conexion.php");
             $id = $_SESSION['id'];
             $conexion->exec("SET CHARACTER SET utf8");
             $query = "SELECT * FROM usuario WHERE id=?";
             $consulta = $conexion->prepare($query);
             $consulta->execute(array($id));
             if ($consulta->rowCount() > 0) {
                 while ($registro = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $nombre=$registro['nombre'];
                    $foto=$registro['foto'];
                    $correo=$registro['correo'];
                    $contraseña=$registro['contraseña'];
                 }
             } else {
                 echo '<center> <p class="error">Contraseña o correo electrónico incorrectos</p> </center>';
             }
        ?>
        <div class="cont-3">
            <?php
                if(isset($_SESSION['pag'])){
                    switch($_SESSION['pag']){
                        case 1:
                            echo '<a class="regreso" href="index.php">';
                            break;
                        case 2:
                            echo '<a class="regreso" href="explorar.php">';
                            break;
                        case 3:
                            echo '<a class="regreso" href="blog.php">';
                            break;
                        case 4:
                            echo '<a class="regreso" href="crear-blog.php">';
                            break;
                        case 5:
                            echo '<a class="regreso" href="crear-publicacion.php">';
                            break;
                        case 6:
                            echo '<a class="regreso" href="modificar-publicacion.php">';
                            break;
                        case 7:
                            echo '<a class="regreso" href="eliminar-publicacion.php">';
                            break;
                        case 8:
                            echo '<a class="regreso" href="blogs.php">';
                            break;
                    }
                }
            ?>
                    <img class="img-2" src="image/regreso.png" alt="regreso">
                </a>
                <h5 class="title-5">Perfil</h5>
                <div class="foto">
                    <img class="img-3" src="<?php echo $foto;?>">
                </div>
                <form class="form-1" action="actualizar-perfil.php" method="POST" enctype="multipart/form-data">
                    <div>
                    <label for="nombre">Nombre:</label></div>
                    <input class="text-box1" type="text" id="nombre" name="nombre" value="<?php echo $nombre;?>">
                    
                    <div>
                    <label for="correo">Correo electrónico:</label></div>
                    <input class="text-box1" type="text" id="correo" name="correo" value="<?php echo $correo;?>">
                    
                    <div>
                    <label for="contrasena">Contraseña:</label></div>
                    <input class="text-box1" type="password" id="contrasena" name="contrasena" value="<?php echo $contraseña;?>">
                    
                    <div>
                    <label  for="imagen">Foto de perfil:</label></div>
                    <input class="input" style="margin-top:1rem;" type="file" id="foto" name="imagen" accept="image/*"><br>    
                    <center style="margin-top:1rem;"><input class="button-5" type="submit" value="Actualizar"></center>
                    
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