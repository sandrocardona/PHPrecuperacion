<?php
session_name("Guardias");
session_start();

require "./src/funciones_ctes.php";

if(isset($_POST["btnSalir"])){
    $url_salir = DIR_SERV."/salir";
    $datos_salir["api_session"] = $_SESSION["api_session"];
    $respuesta = consumir_servicios_REST($url_salir, "POST", $datos_salir);
    session_destroy();
    header("Location:index.php");
    exit;
}

if(isset($_SESSION["usuario"])){
    require "./src/seguridad.php";
    require "./vistas/vista_app.php";
} else {
    require "./vistas/vista_login.php";
}

?>