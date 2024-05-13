<?php
require "./src/constantes.php";

session_name("intento1");
session_start();

if(isset($_POST["btnSalir"])){
    session_destroy();
    header("Location:index.php");
    exit;
}

if(isset($_SESSION["usuario"])){
    require "./vistas/vista_home.php";
} else {
    require "./vistas/vista_login.php";
}

?>

