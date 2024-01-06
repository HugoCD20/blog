<?php 
    if ($_SERVER["REQUEST_METHOD"] === "POST") {//este codigo sirve para crear un blog
        $blog=$_POST['blog'];
        $genero=$_POST['genero'];
        $id=$_SESSION['id'];
        if($verificar){
            include('conexion.php');
            $query="SELECT * from usuario where id=:id";//esta consulta sirve para verificar si el usuario no tiene más de dos blogs
            $consulta=$conexion->prepare($query);
            $consulta->bindParam(':id',$id);
            $consulta->execute();
            if ($consulta->rowCount() > 0) {
                while ($registro = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $cantidad=$registro['cantidad'];
                    if($cantidad==2){
                        echo '<center> <p class="error">Lo siento pero solo puedes crear 2 blogs</p> </center>';
                    }else{
                        $query2="INSERT INTO blogs(id_usuario,nombre,genero)VALUES(:id,:blog,:genero)";//esta consulta de aqui sirve para crear el blog
                        $consulta2=$conexion->prepare($query2);
                        $consulta2->bindParam(':id',$id);
                        $consulta2->bindParam(':blog',$blog);
                        $consulta2->bindParam(':genero',$genero);
                        $consulta2->execute();
                        //---------------------------------------------------------------
                        $cantidad+=1;//esta consulta sirve para aumentar la cantidad que tiene registrada de blogs
                        $query3="UPDATE usuario set cantidad=:cantidad where id=:id";
                        $consulta3=$conexion->prepare($query3);
                        $consulta3->bindParam(':id',$id);
                        $consulta3->bindParam(':cantidad',$cantidad);
                        $consulta3->execute();
                        header('location:blog.php');
                        exit();
                    }
                }
            }
        }
    }else{
        header('location:index.php');
        exit();
    }
?>