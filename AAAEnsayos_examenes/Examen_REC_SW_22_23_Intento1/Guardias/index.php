<?php
require "./src/constantes.php";

session_name("intento1");
session_start();

if(isset($_POST["btnSalir"])){
    $datos_envio["api_session"] = $_SESSION["api_session"];

    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_envio);
    session_destroy();
    header("Location:index.php");
    exit;
}

if(isset($_SESSION["usuario"])){
    //pasar la seguridad
    require "./src/seguridad.php";

    //mostrar la vista home
    require "./vistas/vista_home.php";

} else {
    require "./vistas/vista_login.php";
}

?>

