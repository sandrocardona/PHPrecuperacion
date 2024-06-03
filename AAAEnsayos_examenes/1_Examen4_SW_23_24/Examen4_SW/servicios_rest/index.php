<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;



// LOGIN

$app->post('/login',function($request){

    $usuario = $request->getParam("usuario");
    $clave = $request->getParam("clave");

    echo json_encode(login($usuario, $clave));
});

// LOGUEADO

$app->get('/logueado',function($request){

    $api_session = $request->getParam("api_session");
    session_id($api_session);
    session_start();
    if(isset($_SESSION["usuario"])){

    $usuario = $_SESSION["usuario"];
    $clave = $_SESSION["clave"];

    echo json_encode(logueado($usuario, $clave));

    } else {
        session_destroy();
        $respuesta["no_auth"] = "No tienes premisos para usar este servicio en la api";
        echo json_encode($respuesta);
    }
});

// SALIR

$app->post('/salir',function($request){

    $api_session = $request->getParam("api_session");
    session_id($api_session);
    session_start();
    session_destroy();

    $respuesta["log_out"] = "Cerrada la session en la API";
    echo json_encode($respuesta);

});

//

$app->get('/conexion_PDO',function($request){

    echo json_encode(conexion_pdo());
});

$app->get('/conexion_MYSQLI',function($request){
    
    echo json_encode(conexion_mysqli());
});



// Una vez creado servicios los pongo a disposición
$app->run();
?>
