<?php

$datos_env["api_session"] = $_SESSION["api_session"];
$url_logueado = DIR_SERV."/logueado";
$respuesta = consumir_servicios_REST($url_logueado, "POST", $datos_env);
$json_logueado = json_decode($respuesta, true);

if(!$json_logueado){
    session_destroy();
    die(error_page("NO OBJ","no hay obj en login: ".$url_logueado));
}

if(isset($json_logueado["error"])){
    session_destroy();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    die(error_page("ERROR","error en login: ".$json_logueado["error"]));
}

if(isset($json_logueado["no_auth"])){
    session_unset();
    $_SESSION["seguridad"] = "No tienes permisos para usar este servicio";
    header("Location:index.php");
    exit;
}

if(isset($json_logueado["mensaje"])){
    session_unset();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    $_SESSION["seguridad"] = "Ya no se encuentra registrado en la base de datos";
    header("Location:index.php");
    exit;
}

$datos_usuario_logueado = $json_logueado["usuario"];

if(time() - $_SESSION["ult_accion"] > MINUTOS*60){
    session_unset();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    $_SESSION["seguridad"] = "Tiempo de sesión ha expirado";
    header("Location:index.php");
    exit;
}

$_SESSION["ult_accion"] = time();

?>