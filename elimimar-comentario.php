<?php
session_start();
    if(isset($_POST['id_comentario'])){
        $id=$_POST['id_comentario'];
    }else{
        header('location:index.php');
        exit();
    }
    
    include('conexion.php');
    $query="DELETE from comentarios where id=:id";
    $consulta=$conexion->prepare($query);
    $consulta->bindParam(':id',$id);
    $consulta->execute();
    header('location:blog.php');
    exit();

?>