<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;


/* === login === */
$app->post('/login',function($request){
    $usuario = $request->getParam("usuario");
    $clave = $request->getParam("clave");

    echo json_encode(login($usuario, $clave));
});

/* === usuariosGuardia/dia/hora === */
$app->get('/usuariosGuardia/dia/hora',function($request){
    $dia = $request->getParam("dia");
    $hora = $request->getParam("hora");

    echo json_encode(usuariosGuardia_dia_hora($dia, $hora));
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
