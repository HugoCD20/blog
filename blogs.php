<?php
    session_start();
    if(!isset($_SESSION['id'])){
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
    <script>
    function ejecutarAccion() {
      var select = document.getElementById("menuDesplegable");
      var opcionSeleccionada = select.value;
      switch (opcionSeleccionada) {
        case 'opcion1':
          break;
        case 'opcion2':
            window.location.href = '';
          break;
        case 'Explorar':
            window.location.href = 'Explorar.php';
            break;
        case 'Cerrar-sesion':
          window.location.href = 'Cerrar-sesion.php';
          break;
        default:
          break;
      }
    }
    </script>
</head>
<body>
    <header>
        <div class="cont-1">
            <h1>Coffee and Tea</h1>
            <img class="img-1" src="image/taza.png" alt="taza">
        </div>
        <div class="cont-2">
            <?php
            if (isset($_SESSION['id'])){//este if sirve para verificar si esta logueado o no aunque no es necesario hacerlo
                echo "<select class='seleccion-1' id='menuDesplegable' onchange='ejecutarAccion()'>
                        <option value='' selected disabled>$_SESSION[nombre]</option>
                        <option value='opcion2'>Perfil</option>
                        <option value='Explorar'>Explorar</option>
                        <option value='Cerrar-sesion'>Cerrar Sesión</option>
                      </select>";
                echo "<div class='imagen-1'>
                         <img class='img-3' src='$_SESSION[imagen]' alt='perfil'>
                      </div>";
            }
            ?>
        </div>
    </header>
    <main>
        <div class="cont-3">
                <a class="regreso" href="index.php">
                    <img class="img-2" src="image/regreso.png" alt="regreso">
                </a>
                <h5>Mis blogs</h5>
                    <?php
                        include('conexion.php');//esta consulta sirve para mostrar todos los blogs del usuario
                        $id=$_SESSION['id'];
                        $query="SELECT* FROM blogs WHERE id_usuario=:id";
                        $consulta=$conexion->prepare($query);
                        $consulta->bindParam(':id',$id);
                        $consulta->execute();
                        if ($consulta->rowCount() > 0) {
                            while ($registro = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                echo '<form class="cont-3" method="POST" action="blog.php">
                                <input type="hidden" name="id_blog" value='."$registro[id]".'>
                                <button class="boton-3">'.$registro['nombre'].'</button>
                                </form>';
                            }
                        }else{
                            echo "<center>Aun no tienes ningun blog</center>";
                            echo '<a href="crear-blog.php" class="boton-1">Crear Blog</a>';
                        }
                    ?>
        </div>
       
        
    </div>
    </main>
    <footer>Copyright © 2023 · COFFEE AND TEA</footer>
</body>
</html>