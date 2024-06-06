<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

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


// Una vez creado servicios los pongo a disposición
$app->run();
?>
