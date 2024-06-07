<?php

require __DIR__ . '/Slim/autoload.php';
require "src/funciones_servicios.php";

$app= new \Slim\App;

/* === login === */

$app->post('/login',function($request){
    $user=$request->getParam("usuario");
    $pass=$request->getParam("clave");

    echo json_encode(login($user,$pass));

});

/* === profesores === */

$app->get('/profesores',function($request){

    echo json_encode(profesores());
});

/* === horarios_profesor === */

$app->get('/horarios_profesor/{usuario}',function($request){

    $usuario = $request->getAttribute("usuario");
    echo json_encode(horarios_profesor($usuario));
});


// Una vez creado servicios los pongo a disposición
$app->run();
?>
