<?php
$datos_envio["api_session"] = $_SESSION["api_session"];

$url = DIR_SERV."/logueado";
$respuesta = consumir_servicios_REST($url, "POST", $datos_envio);
$obj_logueado = json_decode($respuesta);

if(!$obj_logueado){
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_envio);
    session_destroy();
    die(error_page("NO OBJ", "NO OBJ_LOGUEADO", "Error consumiendo servicio: ".$url));
}

if(isset($obj_logueado->error)){
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_envio);
    session_destroy();
    die(error_page("ERROR", "ERROR EN SEGURIDAD", $obj_logueado->error));
}

if(isset($obj_logueado->mensaje)){
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_envio);
    session_unset();

    $_SESSION["seguridad"] = "Ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}

//no_auth es de la api
if(isset($obj_logueado->no_auth)){
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_envio);
    session_unset();

    $_SESSION["seguridad"] = "Tiempo de sesión la API expirado";
    header("Location:index.php");
    exit;
}

$datos_usu_log = $obj_logueado->usuario;

if(time() - $_SESSION["ult_accion"] > MINUTOS*60){
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_envio);
    session_unset();

    $_SESSION["seguridad"] = "Su tiempo de sesión ha expirado";
    header("Location:index.php");
    exit;
}

$_SESSION["ult_accion"] = time();

?>