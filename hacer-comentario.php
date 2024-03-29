<?php
session_start();
    if(isset($_POST['id_blog'])){
        $id_blog=$_POST['id_blog'];
    }else{
        header('location:index.php');//verifica que se haya enviado un comentario o si no redirecciona al inicio
        exit();
    }
    if(!isset($_SESSION['id'])){
        header('location:blog.php');
        exit();
    }
    $id=$_SESSION['id'];
    $comentario=$_POST['comentario'];
    if(empty($comentario)){
        header('location:blog.php');
        exit();
    }
    
    include('conexion.php');//esto hace un insert en la base de datos para regisrar el comentario
    $query="INSERT INTO comentarios(id_usuario,comentario,id_publicacion) Values(:id_usuario,:comentario,:id_blog)";
    $consulta=$conexion->prepare($query);
    $consulta->bindParam(':id_usuario',$id);
    $consulta->bindParam(':comentario',$comentario);
    $consulta->bindParam(':id_blog',$id_blog);
    $consulta->execute();
    header('location:blog.php');
    exit();

?>