<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

/* === salir === */
$app->post('/salir',function($request){
    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();
    $respuesta["log_out"] = "Cerrada la session en la api";
    echo json_encode($respuesta);
});

/* === login === */
$app->post('/login',function($request){
    $usuario = $request->getParam("usuario");
    $clave = $request->getParam("clave");

    echo json_encode(login($usuario, $clave));
});

/* === logueado === */
$app->get('/logueado',function($request){
    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["usuario"])){
        $usuario = $_SESSION["usuario"];
        $clave = $_SESSION["clave"];
    
        echo json_encode(logueado($usuario, $clave));
    } else {
        session_destroy();
        $respuesta["no_auth"] = "No tienes permisos en logueado";
        echo json_encode($respuesta);
    }
});


/* === deGuardia/dia/hora/id_usuario === */
$app->get('/deGuardia/dia/hora/id_usuario',function($request){
    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["usuario"])){
        $dia = $request->getParam("dia");
        $hora = $request->getParam("hora");
        $id_usuario = $request->getParam("id_usuario");
    
        echo json_encode(esta_de_guardia($dia, $hora, $id_usuario));
    } else {
        session_destroy();
        $respuesta["no_auth"] = "No tienes permisos en API DE GUARDIA";
        echo json_encode($respuesta);
    }
});

/* === usuariosGuardia/dia/hora === */
$app->get('/usuariosGuardia/dia/hora',function($request){
    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["usuario"])){
        $dia = $request->getParam("dia");
        $hora = $request->getParam("hora");
        $id_usuario = $request->getParam("id_usuario");
    
        echo json_encode(usuariosGuardia($dia, $hora));
    } else {
        session_destroy();
        $respuesta["no_auth"] = "No tienes permisos en API DE GUARDIA";
        echo json_encode($respuesta);
    }
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
