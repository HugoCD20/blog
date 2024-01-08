<?php
    if(isset($_POST['id-publicacion'])){
        $id_publicacion=$_POST['id-publicacion'];
    }else{
        header('location:index.php');//verifica que se haya enviado el id de la publicacion para evitar errores
        exit();
    }
    if($_POST['accion']=="cancelar"){
        header("location:blog.php");
        exit();
    }else{
        include('conexion.php');//elimina publicacion
        $query="DELETE from publicaciones where id=:id";
        $consulta=$conexion->prepare($query);
        $consulta->bindParam(":id",$id_publicacion);
        $consulta->execute();
        header("location:blog.php");
        exit();
    }
    
?>