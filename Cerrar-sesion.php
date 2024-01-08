<?php 
session_start();//esto sirve para cerrar sesion
session_destroy();
header('location:index.php');
?>