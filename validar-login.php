<?php 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Contraseña = $_POST['contrasena'];
    $Correo = $_POST['correo'];
    if(strlen($Contraseña)>200 && strlen($Correo)>200){
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
    if(!empty($Contraseña) && !empty($Correo) && $largo && $cor){
        try {
            include("conexion.php");
            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];
            $conexion->exec("SET CHARACTER SET utf8");
            $query = "SELECT * FROM usuario WHERE correo=? AND contraseña=?";
            $consulta = $conexion->prepare($query);
            $consulta->execute(array($correo, $contrasena));
            if ($consulta->rowCount() > 0) {
                while ($registro = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $_SESSION['id']=$registro['id'];
                    $_SESSION['nombre']=$registro['nombre'];
                    $_SESSION['Correo']=$registro['correo'];
                    $_SESSION['imagen']=$registro['foto'];
                    header("location:index.php");
                }
            } else {
                echo '<center> <p class="error">Contraseña o correo electrónico incorrectos</p> </center>';
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

}else{
    header("location:index.php");
}
?>