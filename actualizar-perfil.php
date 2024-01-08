<?php 
session_start();
$correo=$_POST['correo'];
$contraseña=$_POST['contrasena'];//aqui requerimos los parametros del formulario
$nombre=$_POST['nombre'];
$id=$_SESSION['id'];
include('conexion.php');
$ima = true;
$imagen = '';

if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK){
$file = $_FILES['imagen'];// en este lado lo que se desmenuzamos las propiedades de las imagenes
$nombreF = $file["name"];//como el nombre del archivo el tipo de foto
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
} elseif ($size > 3 * 1024 * 1024) {//aqui se validan algunas porpiedades de la imagen como el peso y que sea una imagen
    echo "La imagen es demasiado pesada";
    $ima = false;
} else {
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

if ($ima) {//aqui se actualiza la foto siempre y cuando las validaciones anteriores digan que es posicitivo
    $query = "UPDATE usuario SET foto=:imagen WHERE id=:id";
    $consulta2 = $conexion->prepare($query);
    $consulta2->bindParam(':imagen', $imagen);
    $consulta2->bindParam(':id', $id);

    if ($consulta2->execute()) {
        echo "La foto se ha actualizado correctamente.";
    } else {
        echo "Error al actualizar la foto.";
    }
}
if(!empty($nombre)){
    $query = "UPDATE usuario set nombre=:nombre where id=:id";//aqui se actualiza el nombre siempre y cuando no este vacio
    $consulta3 = $conexion->prepare($query);
    $consulta3->bindParam(':nombre',$nombre);
    $consulta3->bindParam(':id',$id);
    $consulta3->execute();

}

if(!empty($contraseña)){
    $query = "UPDATE usuario set contraseña=:contrasena where id=:id";
    $consulta4 = $conexion->prepare($query);
    $consulta4->bindParam(':contrasena',$contraseña);
    $consulta4->bindParam(':id',$id);
    $consulta4->execute();

}
if(!empty($correo)){
    $correoFiltrado = filter_var($correo, FILTER_VALIDATE_EMAIL);                        
    if ($correoFiltrado) {
        $query = "UPDATE usuario set correo=:correo where id=:id";
        $consulta5 = $conexion->prepare($query);
        $consulta5->bindParam(':correo',$correo);
        $consulta5->bindParam(':id',$id);
        $consulta5->execute();
    } 

}

header('location:perfil.php');

?>