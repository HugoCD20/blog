<?php 
$titulo=$_POST['titulo'];//este codigo es igual al de actualizar-perfil.php
$texto=$_POST['texto'];
$id_publicacion=$_POST['id_publicacion'];
include('conexion.php');
$ima = true;
$imagen = '';

if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK){
$file = $_FILES['imagen'];
$nombreF = $file["name"];
$tipo = $file["type"];
$size = $file["size"];
$ruta_provisional = $file["tmp_name"];

if ($nombreF != '') {
$dimension = getimagesize($ruta_provisional);
$with = $dimension[0];
$height = $dimension[1];
$carpeta = "Fotos/";
$src = $carpeta . $nombreF;

if ($tipo != "image/jpg" && $tipo != "image/png" && $tipo != "image/JPG" && $tipo != "image/jpeg") {
    echo "La imagen no es compatible";
    $ima = false;
} elseif ($size > 3 * 1024 * 1024) {
    echo "La imagen es demasiado pesada";
    $ima = false;
} /*elseif($with != 800 && $height != 800){
    echo "-La imagen no cumple con el tamaño-";
    $ima=false;
}*/ else {
    move_uploaded_file($ruta_provisional, $src);
    $imagen = "Fotos/" . $nombreF;
}
} else {
$imagen = 'sin-imagen';
}
} else {
// No se envió ninguna foto
$imagen = 'sin-imagen';
$ima = false;
}
if(strlen($titulo)>200){
    header('location:modificar-publicacion.php');
    exit();
}

if ($ima) {
    $query = "UPDATE publicaciones SET imagen=:imagen WHERE id=:id";
    $consulta2 = $conexion->prepare($query);
    $consulta2->bindParam(':imagen', $imagen);
    $consulta2->bindParam(':id', $id_publicacion);

    if ($consulta2->execute()) {
        echo "La foto se ha actualizado correctamente.";
    } else {
        echo "Error al actualizar la foto.";
    }
}
if(!empty($titulo)){
    $query = "UPDATE publicaciones set titulo=:titulo where id=:id";
    $consulta3 = $conexion->prepare($query);
    $consulta3->bindParam(':titulo',$titulo);
    $consulta3->bindParam(':id',$id_publicacion);
    $consulta3->execute();

}

if(!empty($texto)){
    $query = "UPDATE publicaciones set texto=:texto where id=:id";
    $consulta4 = $conexion->prepare($query);
    $consulta4->bindParam(':texto',$texto);
    $consulta4->bindParam(':id',$id_publicacion);
    $consulta4->execute();

}

header('location:blog.php');

?>