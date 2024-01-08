<?php //este es para la conexion con el servidor
$servidor = "localhost:3308";
$usuario = "root";
$password = "";
$conexion = new PDO("mysql:host=$servidor;dbname=coffeeblog", $usuario, $password);
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>