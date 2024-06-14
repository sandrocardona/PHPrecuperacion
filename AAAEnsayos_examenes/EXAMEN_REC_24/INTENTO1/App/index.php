<?php

session_name("INTENTO1");
session_start();

require "./src/constantes.php";

if(isset($_POST["btnSalir"])){
    $datos_env["api_session"] = $_SESSION["api_session"];
    session_destroy();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    header("Location:index.php");
    exit();
}

if(isset($_SESSION["usuario"])){
    //seguridad
    require "./src/seguridad.php";
    //if admin
    if($datos_usuario_logueado["tipo"]=="admin")
        require "./vistas/vista_admin.php";
    else
        require "./vistas/vista_app.php";
} else {
    require "./vistas/vista_login.php";
}

?>