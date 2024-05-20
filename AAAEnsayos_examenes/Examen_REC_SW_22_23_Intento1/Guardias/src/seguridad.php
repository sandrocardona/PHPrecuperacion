<?php

$url = DIR_SERV."/logueado";
$respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
$obj_logueado = json_decode($respuesta);

if(!$obj_logueado){
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $_SESSION["api_session"]);
    session_destroy();
    die(error_page("NO OBJ", "NO OBJ_LOGUEADO", "Error consumiendo servicio: ".$url));
}

if(isset($obj_logueado->error)){
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $_SESSION["api_session"]);
    session_destroy();
    die(error_page("ERROR", "ERROR EN SEGURIDAD", $obj_logueado->error));
}

if(isset($obj_logueado->mensaje)){
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $_SESSION["api_session"]);
    session_unset();

    $_SESSION["seguridad"] = "Ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}

//no_auth es de la api
if(isset($obj_logueado->no_auth)){
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $_SESSION["api_session"]);
    session_unset();

    $_SESSION["seguridad"] = "Tiempo de sesión la API expirado";
    header("Location:index.php");
    exit;
}

$datos_usu_log = $obj_logueado->usuario;

if(time() - $_SESSION["ultima_accion"] > MINUTOS*60){
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $_SESSION["api_session"]);
    session_unset();

    $_SESSION["seguridad"] = "Su tiempo de sesión ha expirado";
    header("Location:index.php");
    exit;
}

$_SESSION["ultima_accion"] = time();

?>