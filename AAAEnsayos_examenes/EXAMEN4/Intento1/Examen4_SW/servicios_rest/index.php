<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;



$app->get('/conexion_PDO',function($request){

    echo json_encode(conexion_pdo());
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
        $respuesta["no_auth"] = "No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});

/* === salir ===  */
$app->post('/salir',function($request){
    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();
    $respuesta["log_out"]="Cerrada sesión en la API";
    echo json_encode($respuesta);
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
