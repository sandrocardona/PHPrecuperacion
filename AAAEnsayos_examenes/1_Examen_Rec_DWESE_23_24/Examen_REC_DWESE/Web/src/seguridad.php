<?php

//enviamos la id de la session
$datos_envio["api_session"] = $_SESSION["api_session"];

//consumir servicio logueado
$url_logueado = DIR_SERV."/logueado";
$url_salir = DIR_SERV."/salir";

$respuesta = consumir_servicios_REST($url_logueado, "GET", $datos_envio);
$obj_logueado = json_decode($respuesta);

if(!$obj_logueado){
    consumir_servicios_REST($url_salir, "POST", $datos_envio);
    session_destroy();
    die(error_page("NO OBJ LOGUEADO", "No hay objeto logueado: ".$url_logueado));
}

if(isset($obj_logueado->error)){
    consumir_servicios_REST($url_salir, "POST", $datos_envio);
    session_destroy();
    die(error_page("ERROR", "Error en obj_logueado: ".$obj_logueado->error));
}

if(isset($obj_logueado->mensaje)){
    consumir_servicios_REST($url_salir, "POST", $datos_envio);
    session_unset();

    $_SESSION["seguridad"] = "Ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}

if(isset($obj_logueado->no_auth)){
    consumir_servicios_REST($url_salir, "POST", $datos_envio);
    session_unset();

    $_SESSION["seguridad"] = "Tiempo de sesión de la API expirado";
    header("Location:index.php");
    exit;
}

//recogemos al usuario logueado

$datos_usu_log = $obj_logueado->usuario;

//comprobar tiempo
if(time() - $_SESSION["ult_accion"] > MINUTOS*60){
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_envio);
    session_unset();

    $_SESSION["seguridad"] = "Su tiempo de sesión ha expirado";
    header("Location:index.php");
    exit;
}

$_SESSION["ult_accion"] = time();

?>