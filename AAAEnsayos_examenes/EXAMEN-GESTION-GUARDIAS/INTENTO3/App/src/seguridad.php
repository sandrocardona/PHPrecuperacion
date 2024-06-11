<?php
$datos_api["api_session"] = $_SESSION["api_session"];
$url_logueado = DIR_SERV."/logueado";
$respuesta = consumir_servicios_REST($url_logueado, "GET", $datos_api);
$json_logueado = json_decode($respuesta, true);

if(!$json_logueado){
    session_destroy();
    die(error_page("NO OBJ","NO HAY OBJen json_logueado".$url_logueado));
} 

if(isset($json_logueado["error"])){
    session_destroy();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_api);
    die(error_page("ERROR", "ERROR en json logueaod".$json_logueado["error"]));
}

if(isset($json_logueado["no_auth"])){
    session_unset();
    $_SESSION["seguridad"] = "No tiene permisos en logueado en seguridad";
    header("Location:index.php");
    exit();
}

if(isset($json_logueado["mensaje"])){
    session_unset();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_api);
    $_SESSION["seguridad"] = "Usted ya no está registrado en la base de datos";
    header("Location:index.php");
    exit();
}

$datos_usuario_logueado = $json_logueado["usuario"];

if(time() - $_SESSION["ult_accion"] > MINUTOS*60){
    session_unset();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_api);
    $_SESSION["seguridad"] = "Tiempo expirado. Vuelva a loguearse";
    header("Location:index.php");
    exit();
}

$_SESSION["ult_accion"] = time();

?>