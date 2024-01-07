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
                    ?>
                   <form class="form-2" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
                        <label for="titulo">Titulo</label>
                        <input class="text-box1" type="text" name="titulo">
                        <?php 
                            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                                if(isset($_POST['titulo'])){
                                    $titulo=$_POST['titulo'];
                                    $verifica=true;
                                    if(empty($titulo)){
                                        echo '<center> <p class="error"> ⚠️Coloca un titulo ⚠️</p> </center>';
                                        $verifica=false;
                                    }
                                    if(strlen($titulo)>200){
                                        echo '<center> <p class="error"> ⚠️El titulo es demasiado largo ⚠️</p> </center>';
                                        $verifica=false;
                                    }
                                }
                            }
                        ?>

                        <label for="texto">Ingresa el contenido:</label>
                        <textarea class="text-box2" name="texto"></textarea>
                        <?php 
                            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                                if(isset($_POST['texto'])){
                                    $texto=$_POST['texto'];
                                    if(empty($texto)){
                                        echo '<center> <p class="error"> ⚠️El contenido no puede estar vacio ⚠️</p> </center>';
                                        $verifica=false;
                                    }
                                    
                                }
                            }
                        ?>

                        <label for="foto">Ingresa una foto(opcional):</label>
                        <input class="input" type="file" name="imagen" accept="image/*">

                        <center style="margin-top:1rem;"><input class="button-5" type="submit" value="Crear"></center>
                        <?php 
                            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                                include("validar-publicacion.php");
                            }
                        ?>
                   </form>
                    
        </div>
       
        
    </div>
    </main>
    <footer>Copyright © 2023 · COFFEE AND TEA</footer>
</body>
</html>