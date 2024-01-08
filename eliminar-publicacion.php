<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    $_SESSION['pag']= 7;
    $_SESSION['page']= 7;//indices de pagina
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
      var select = document.getElementById("menuDesplegable");//redirecciona
      var opcionSeleccionada = select.value;
      switch (opcionSeleccionada) {
        case 'opcion1':
          break;
        case 'opcion2':
            window.location.href = 'perfil.php';
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
                <a class="regreso" href="blogs.php">
                    <img class="img-2" src="image/regreso.png" alt="regreso">
                </a>
                    <?php
                        include('conexion.php');//esta consulta sirve para imprimir el titulo
                        if(isset($_POST['id_blog'])){
                            $_SESSION['id-blog']=$_POST['id_blog'];
                        }
                        $id=$_SESSION['id-blog'];
                        $query="SELECT* FROM blogs WHERE id=:id";
                        $consulta=$conexion->prepare($query);
                        $consulta->bindParam(':id',$id);
                        $consulta->execute();
                        if ($consulta->rowCount() > 0) {
                            while ($registro = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                echo '<h3>'.$registro["nombre"].'</h3>';
                            }
                        }
                        $id_publicacion=$_POST['id_publicacion'];
                         if($id_publicacion==null){
                            header('location:blog.php');
                            exit();
                         }
                    ?>

                    <form class="cont-5" method="POST" action="procesar-eliminar-publicacion.php">
                        <p class="text-2">¿Seguro qué quiere eliminar este post?</p>
                        <input type="hidden" name="id-publicacion" value="<?php echo $id_publicacion;?>">
                        <div class="eliminacion">
                            <button class="boton-1" name="accion" value="cancelar">cancelar</button>
                            <button class="boton-2" name="accion" value="eliminar">eliminar</button>
                        </div>
                    </form>  

        </div>
       
        
    </div>
    </main>
    <footer>Copyright © 2023 · COFFEE AND TEA</footer>
</body>
</html>