<?php
session_start();
$_SESSION['pag']=1;
$_SESSION['page']=1;
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
            if (!isset($_SESSION['id'])){
                echo '<a class="inicio" href="login.php"><h2>Iniciar sesión</h2></a>';
            }else{
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
        <div class="titulo-1">
            <div class="imagen-2">
                    <img class="img-3" src="image/taza2.png" alt="">
            </div>
            <div class="introduccion">
                <h4>¡Bienvenido! Coffee and Tea.</h4>
                <p class="text-1">¡Bienvenido a nuestro mundo de historias cautivadoras! En nuestro servicio de blogs, nos enorgullece presentarte un espacio donde las palabras cobran vida y las historias se convierten en experiencias inolvidables. Aquí, cada blog es una ventana hacia un universo único, donde escritores talentosos comparten sus emociones, aventuras y reflexiones. <br>
                    Sumérgete en un océano de relatos fascinantes que abarcan géneros, desde lo inspirador hasta lo misterioso, lo humorístico y lo conmovedor. Nuestro servicio de blogs es un lugar donde las voces encuentran su eco, donde cada historia se convierte en un viaje compartido.</p>
            </div>
        </div>  
        <div class="botones">
            <?php
            if(isset($_SESSION['id'])){
                echo '<a href="crear-blog.php" class="boton-1">Crear Blog</a>';
            }else{
                echo '<a href="login.php" class="boton-1">Crear Blog</a>';
            }
            ?>
            <a href="explorar.php" class="boton-2">Explorar</a>
        </div>      
    </main>
    <footer>Copyright © 2023 · COFFEE AND TEA</footer>
</body>
</html>