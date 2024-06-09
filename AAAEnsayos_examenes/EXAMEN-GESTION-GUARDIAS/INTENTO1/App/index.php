<?php

session_name("Intento1");
session_start();

require "./src/funciones_ctes.php";

if(isset($_POST["btnSalir"])){
    session_destroy();
    header("Location:index.php");
}

if(isset($_SESSION["usuario"])){
    require "./vistas/vista_app.php";
} else {
    require "./vistas/vista_login.php";
}

?>
