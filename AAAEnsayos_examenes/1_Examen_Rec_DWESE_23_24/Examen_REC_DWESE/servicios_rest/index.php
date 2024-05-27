<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;



//login
$app->post('/login',function($request){

    $datos[]=$request->getParam("usuario");
    $datos[]=$request->getParam("clave");


    echo json_encode(login($datos));
});


//logeado
$app->get('/logueado',function($request){

    $api_session=$request->getParam("api_session");
    session_id($api_session);
    session_start();

    if(isset($_SESSION["usuario"])){
        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];

        echo json_encode(logueado($datos));
    } else {
        session_destroy();

        $respuesta["no_auth"] = "No tienes permiso para usar este servicio";
        echo json_encode($respuesta);
    }
});

$app->post('/salir',function($request){

    $api_session=$request->getParam("api_session");
    session_id($api_session);
    session_start();
    session_destroy();
    echo json_encode(array("log_out"=>"Cerrada sesión en la API"));
});



// Una vez creado servicios los pongo a disposición
$app->run();
?>
