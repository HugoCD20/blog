<?php
    session_start();
    if(!isset($_SESSION['id'])){//verifica si inicio sesion
        header('location:index.php');
    }
    $_SESSION['pag']= 4;
    $_SESSION['page']= 4;//indices de pagina
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
      var select = document.getElementById("menuDesplegable");//redirecciona a diferentes paginas segun la opcion elegida
      var opcionSeleccionada = select.value;
      switch (opcionSeleccionada) {
        case 'opcion1':
          break;
        case 'opcion2':
            window.location.href = 'perfil.php';
          break;
        case 'Blogs':
            window.location.href = 'blogs.php';
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
            if (isset($_SESSION['id'])){
                echo "<select class='seleccion-1' id='menuDesplegable' onchange='ejecutarAccion()'> 
                        <option value='' selected disabled>$_SESSION[nombre]</option>
                        <option value='opcion2'>Perfil</option>
                        <option value='Blogs'>Blogs</option>
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
                <h5>Nuevo blog</h5>
                <form class="form-1" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                    <div>
                    <label for="correo">Nombre del blog:</label></div>
                    <input class="text-box1" type="text" id="blog" name="blog">
                    <?php 
                        if ($_SERVER["REQUEST_METHOD"] === "POST") {//este metodo sirve para comprobar si está vacio o si es demaciado grande el nombre
                            $blog=$_POST['blog'];
                            if(empty($blog)){
                                echo '<center> <p class="error">Coloca un nombre para el blog</p> </center>';
                                $verificar=false;
                            }elseif(strlen($blog)>200){
                                echo '<center> <p class="error">El nombre es demasiado largo</p> </center>';
                                $verificar=false;
                            }else{
                                $verificar=true;
                            }
                         }
                    ?>
                    <div>
                    <label for="contrasena">Genero:</label></div>
                    <select name="genero" class="text-box1"><!--en esta parte tengo que validar cuantos blogs tiene el usuario-->
                    <option value="Humor">Humor</option>
                    <option value="Drama">Drama</option>
                    <option value="Aventura">Aventura</option>
                    <option value="Misterio">Misterio</option>
                    <option value="Fantasia">Fantasia</option>
                    <option value="Romance">Romance</option>
                    <option value="Terror">Terror</option>
                    <option value="Otro">Otro</option>
                    </select>
                   
                                   
                    <center style="margin-top:1rem;"><input class="button-5" type="submit" value="Crear"></center>
                    
                    <?php 
                        if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        include("validar-blog.php");
                        }
                    ?>
                </form>
        </div>
       
        
    </div>
    </main>
    <footer>Copyright © 2023 · COFFEE AND TEA</footer>
</body>
</html>