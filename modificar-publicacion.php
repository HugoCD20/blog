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
        <div class="cont-4">
                <a class="regreso" href="blog.php">
                    <img class="img-2" src="image/regreso.png" alt="regreso">
                </a>
                    <?php
                        include('conexion.php');//esta consulta sirve para imprimir el titulo
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
                         $query2="SELECT* FROM publicaciones WHERE id=:id_publicacion";
                         $consulta2=$conexion->prepare($query2);
                         $consulta2->bindParam(':id_publicacion',$id_publicacion);
                         $consulta2->execute();
                         if ($consulta2->rowCount() > 0) {
                             while ($registro2 = $consulta2->fetch(PDO::FETCH_ASSOC)) {
                                $titulo=$registro2['titulo'];
                                $texto=$registro2['texto'];
                                
                             }
                        }
                    ?>
                   <form class="form-2" action="realizar-actualizacion-publicacion.php" method="POST" enctype="multipart/form-data">
                        <label for="titulo">Titulo</label>
                        <input class="text-box1" type="text" name="titulo" value="<?php echo $titulo;?>">
                    
                        <label for="texto">Ingresa el contenido:</label>
                        <textarea class="text-box2" name="texto"><?php echo $texto;?></textarea>
                        
                        <label for="foto">Ingresa una foto(opcional):</label>
                        <input class="input" type="file" name="imagen" accept="image/*">

                        <input type="hidden" name='id_publicacion' value="<?php echo $_POST['id_publicacion']?>">

                        <center style="margin-top:1rem;"><input class="button-5" type="submit" value="Actualizar"></center>
            
                   </form>
                    
        </div>
       
        
    </div>
    </main>
    <footer>Copyright © 2023 · COFFEE AND TEA</footer>
</body>
</html>