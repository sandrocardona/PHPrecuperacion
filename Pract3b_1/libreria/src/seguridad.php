<?php
$datos_envio["api_key"] = $_SESSION["api_session"];
$url_salir = DIR_SERV."/salir";

$url = DIR_SERV."/logueado";
$respuesta = consumir_servicios_REST($url, "POST", $datos_envio);
$obj_logueado = json_decode($respuesta);

if(!$obj_logueado){
    consumir_servicios_REST($url_salir, "POST", $datos_envio);
    session_destroy();
    die(error_page("NO OBJ", "<p>No hay obj_logueado: ".$url."</p>"));
}

if(isset($obj_logueado->error_bd)){
    consumir_servicios_REST($url_salir, "POST", $datos_envio);
    session_destroy();
    die(error_page("ERROR", "<p>ERROR en obj_logueado: ".$obj_logueado->error_bd."</p>"));
}

if(isset($obj_logueado->no_auth)){
    consumir_servicios_REST($url_salir, "POST", $datos_envio);
    session_unset();

    $_SESSION["seguridad"] = "Tiempo de sesión de la API expirado en seguridad";
    header("Location:".$salto);
    exit;
}

if(isset($obj_logueado->mensaje)){
    consumir_servicios_REST($url_salir, "POST", $datos_envio);
    session_unset();

    $_SESSION["seguridad"] = "Ya no se encuentra registrado en seguridad";
    header("Location:".$salto);
    exit;
}

$datos_usuario_log = $obj_logueado->usuario;

if(time()-$_SESSION["ultima_accion"]>MINUTOS*60555555)
{
    consumir_servicios_REST($url_salir, "POST", $datos_envio);
    session_unset();

    $_SESSION["seguridad"]="Su tiempo de sesión ha expirado2. Por favor vuelva a loguearse";
    header("Location:".$salto);// depende donde estamos $salto varia; esta variable la cambiamos antes del require de seguridad
    exit();
}
// Paso el control de tiempo y lo renuevo
$_SESSION["ultima_accion"]=time();

?>