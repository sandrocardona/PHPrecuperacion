<?php

session_name("Intento3");
session_start();

require "./src/funciones_ctes.php";

if(isset($_POST["btnSalir"])){
    $datos["api_session"] = $_SESSION["api_session"];
    $url_salir = DIR_SERV."/salir";
    consumir_servicios_REST($url_salir, "POST", $datos);
    session_destroy();
    header("Location:index.php");
    exit();
}

if(isset($_SESSION["usuario"])){
    //seguridad
    require "./src/seguridad.php";
    //app
    require "./vistas/vista_app.php";
} else {
    require "./vistas/vista_login.php";
}

?>