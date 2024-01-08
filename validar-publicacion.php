<?php 
 if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
$img='sin-imagen';
if(isset($verifica)){
    if($verifica){//esta sirver para crear una publicacion
            $query2="INSERT INTO publicaciones(id_blog,titulo,texto,imagen)VALUES(:id,:titulo,:texto,:imagen)";
        $consulta2 = $conexion->prepare($query2);
        $consulta2->bindParam(':id', $id);
        $consulta2->bindParam(':titulo', $titulo);
        $consulta2->bindParam(':texto', $texto);
        $consulta2->bindParam(':imagen', $imagen);
        $consulta2->execute();
        header('location:blog.php');
    }
}
 }else{
    header('location:index.php');

 }


?>