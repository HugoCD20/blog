<?php 
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Correo = $_POST['correo'];
    $Contraseña = $_POST['contrasena'];
    $Contra = $_POST['confirmarContrasena'];
    $Nusuario = $_POST['nombre'];
    $valida = true;
    if ($Contraseña != $Contra) {
        $valida = false;
    }
    if(strlen($Nusuario)>200 && strlen($Correo)>200 && strlen($Contraseña)>200){
        $largo=false;
    }else{
        $largo=true;
    }
    $correoFiltrado = filter_var($Correo, FILTER_VALIDATE_EMAIL);                        
    if ($correoFiltrado == false) {
        $cor=false;
    }else{
        $cor=true;
    }
    $ima = true;
    $imagen = '';

    if (isset($_FILES['foto'])) {
        $file = $_FILES['foto'];
        $nombreF = $file["name"];
        $tipo = $file["type"];
        $size = $file["size"];
        $ruta_provisional = $file["tmp_name"];

        if ($nombreF != '') {
            $dimension = getimagesize($ruta_provisional);

            if ($dimension !== false) {
                $with = $dimension[0];
                $height = $dimension[1];

                $carpeta = "Fotos/";
                $src = $carpeta . $nombreF;

                if ($tipo != "image/jpg" && $tipo != "image/png" && $tipo != "image/jpeg") {
                    echo "<br>La imagen no es compatible";
                    $ima = false;
                } elseif ($size > 3 * 1024 * 1024) {
                    echo "<br>La imagen es demasiado pesada";
                    $ima = false;
                } else {
                    move_uploaded_file($ruta_provisional, $src);
                    $imagen = "Fotos/" . $nombreF;
                }
            } else {
                echo "<br>El archivo no es una imagen válida";
                $ima = false;
            }
        } else {
            $imagen = 'image/default.jpg';
        }
    } else {
        $ima = true;
    }

    if (!$ima) {
        $ima=false;
    }

    if(!empty($Correo) && !empty($Contraseña) && !empty($Contra) && !empty($Nusuario) && $valida && $cor && $largo && $ima){
        try {
            include('conexion.php');
            $nombreU = $_POST['nombre'];
            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];
            $cantidad=0;
            $query = "INSERT INTO usuario(nombre, correo, contraseña,foto,cantidad) 
                         VALUES (:nombreU, :correo, :contrasena,:imagen,:cantidad)";
            $consulta = $conexion->prepare($query);
            $consulta->bindParam(':nombreU', $nombreU);
            $consulta->bindParam(':correo', $correo);
            $consulta->bindParam(':contrasena', $contrasena);
            $consulta->bindParam(':imagen', $imagen);
            $consulta->bindParam(':cantidad', $cantidad);
            $consulta->execute();
            header("location: login.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
            
        
    } 
}else{
    header("location: index.php");
}
    
?>