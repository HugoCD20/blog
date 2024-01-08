<?php
    session_start();
    $_SESSION['pag']= 3;
    $_SESSION['page']= 3;
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
      switch (opcionSeleccionada) {//esto sirve para que cuando se seleccione una opcion de la lista desplegable se redireccione a otra pagina
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
            if (!isset($_SESSION['id'])){//este sirve para verificar si se inicio sesion el !isset sirve para verificar si una variable existe o no
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
        <div class="cont-3">
                <a class="regreso" href="blogs.php">
                    <img class="img-2" src="image/regreso.png" alt="regreso">
                </a>
                    <?php
                        include('conexion.php');//esta consulta sirve para imprimir el titulo
                        if(isset($_POST['id_blog'])){
                            $_SESSION['id-blog']=$_POST['id_blog'];
                        }
                        if(!isset($_SESSION['id-blog'])){
                            header('location:index.php');
                            exit();
                        }
                        $id=$_SESSION['id-blog'];
                        $query="SELECT* FROM blogs WHERE id=:id";
                        $consulta=$conexion->prepare($query);
                        $consulta->bindParam(':id',$id);
                        $consulta->execute();
                        if ($consulta->rowCount() > 0) {
                            while ($registro = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                echo '<h3>'.$registro["nombre"].'</h3>';
                                $id_usuario=$registro['id_usuario'];
                            }
                        }
                    ?>
                    <?php
                        if(isset($_SESSION['id']) && $_SESSION['id']==$id_usuario){//esto sirve para mostrar el contenido siempre y cuando se haya iniciado sesion y se el propetario
                            echo "
                            <form class='publicacion' method='POST' action='Crear-publicacion.php'>
                                <div class='imagen-4'>
                                    <img class='img-3' src='$_SESSION[imagen]' alt='perfil'>
                                </div>
                                <div class='post'>
                                    <p>¡Bienvenido! ¿Quieres hacer un nuevo post?</p>
                                    <input type='hidden' name='id_blog' value='$id'>
                                    <button class='boton-4'>Nuevo Post</button>
                                </div>                        
                            </form>
                            ";
                        }
                    ?>
                    <?php
                         $query2="SELECT* FROM publicaciones WHERE id_blog=:id";//esta consulta sirve para mostrar las publicaciones
                         $consulta2=$conexion->prepare($query2);
                         $consulta2->bindParam(':id',$id);
                         $consulta2->execute();
                         if ($consulta2->rowCount() > 0) {
                             while ($registro2 = $consulta2->fetch(PDO::FETCH_ASSOC)) {
                                $texto=nl2br($registro2['texto']);//esta funcion sirve para implementar br en los saltos de linea
                                 echo '<div class="cont-5">
                                            <p class="text-2">'.$registro2["titulo"].'</p>';
                                            
                                    if($registro2['imagen']!='sin-imagen'){
                                        echo  '<div class="imagen-3">
                                                    <img class="img-3" src="'.$registro2['imagen'].'" alt="texto">
                                                </div>';
                                    }
                                           
                                echo'<p class="text-3">'.$texto.'</p>';
                                echo "
                                <form class='publicacion' method='POST' action='hacer-comentario.php'>
                                    <div class='imagen-4'>";
                                    if(isset($_SESSION['id'])){
                                        echo "<img class='img-3' src='$_SESSION[imagen]' alt='perfil'>";
                                    }else{
                                        echo "<img class='img-3' src='image/default.jpg' alt='perfil'>";
                                    }
                                    echo "</div>
                                    <div class='post'>
                                        <input type='hidden' name='id_blog' value='$registro2[id]'>
                                        <label for='comentario' class='comenta'>Comentar:</label>
                                        <input class='text-box-2' type='text' id='comentario' name='comentario'>
                                        <button class='boton-4'>añadir comentario</button>
                                    </div>                        
                                </form>
                                ";
                                $query3="SELECT * from comentarios where id_publicacion=:id";//esta consulta sirve para mostrar los comentarios
                                $consulta3=$conexion->prepare($query3);
                                $consulta3->bindParam(':id',$registro2['id']);
                                $consulta3->execute();
                                if ($consulta3->rowCount() > 0) {
                                    while ($registro3 = $consulta3->fetch(PDO::FETCH_ASSOC)) {
                                        $query4="SELECT * from usuario where id=:id_usuario";
                                        $consulta4=$conexion->prepare($query4);
                                        $consulta4->bindParam(':id_usuario',$registro3['id_usuario']);
                                        $consulta4->execute();
                                        if ($consulta4->rowCount() > 0) {
                                            while ($registro4 = $consulta4->fetch(PDO::FETCH_ASSOC)) {
                                                echo "
                                                    <form class='publicacion-2' method='POST' action='elimimar-comentario.php'>
                                                        <div class='imagen-4'>";
                                                            echo "<img class='img-3' src='$registro4[foto]' alt='perfil'>";
                                                        echo "</div>
                                                        <input type='hidden' name='id_comentario' value='$registro3[id]'>
                                                        <div class='post'>
                                                            <p> $registro4[nombre] <br> $registro3[comentario]</p>
                                                        </div>";  
                                                    if(isset($_SESSION['id']) && $_SESSION['id']==$registro4['id']){
                                                        echo "<button class='boton-5'>eliminar</button>";
                                                    }
                                                    echo "</form>
                                                    ";
                                            }
                                        }
                                    }
                                }
                                
                                if(isset($_SESSION['id']) && $_SESSION['id']==$id_usuario){
                                            echo '<div class="botones-2">
                                                <form method="POST" action="modificar-publicacion.php">
                                                    <input type="hidden" name="id_publicacion" value="'.$registro2["id"].'">
                                                    <button class="administrar">modificar</button>
                                                </form>
                                                <form method="POST" action="eliminar-publicacion.php">
                                                    <input type="hidden" name="id_publicacion" value="'.$registro2["id"].'">
                                                    <button class="administrar">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>';
                                    }
                                   
                             }
                         }else{
                           echo '<center style="margin-top:4%;">No hay ningun post</center>';
                         }
                    ?>


        </div>
       
        
    </div>
    </main>
    <footer>Copyright © 2023 · COFFEE AND TEA</footer>
</body>
</html>