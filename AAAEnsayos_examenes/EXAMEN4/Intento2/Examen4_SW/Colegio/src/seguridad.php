<?php

    $datos_env["api_session"] = $_SESSION["api_session"];
    $url_logueado = DIR_SERV."/logueado";
    $respuesta = consumir_servicios_REST($url_logueado, "GET", $datos_env);
    $obj_logueado = json_decode($respuesta, true);

    if(!$obj_logueado){
        session_destroy();
        die(error_page("NO OBJ", "NO OBJ en obj_logueado"));
    }

    if(isset($obj_logueado["error"])){
        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
        die(error_page("ERROR","Error en obj_logueado".$obj_logueado["error"]));
    }

    if(isset($obj_logueado["no_auth"])){
        session_unset();
        $_SESSION["seguridad"] = "Ha dejado de tener acceso a la API. Vuelva a loguearse";
        header("Location:".$salto);
        exit();
    }

    if(isset($obj_logueado["mensaje"])){
        session_unset();
        consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
        $_SESSION["seguridad"] = "ya no estás registrado en la db";
        header("Location:".$salto);
        exit();
    }

    $datos_usuario_logueado = $obj_logueado["usuario"];

    if(time() - $_SESSION["ult_accion"] > MINUTOS*60){
        session_unset();
        consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
        $_SESSION["seguridad"]="Su tiempo de sesión ha expirado. Por favor vuelva a loguearse";
        header("Location:".$salto);
        exit();
    }

    $_SESSION["ult_accion"] = time();

?>