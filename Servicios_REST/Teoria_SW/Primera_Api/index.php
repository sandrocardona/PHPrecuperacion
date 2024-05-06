<?php
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

//Sintaxis
//$app->("url del servicio","function(){}");

/* 
$app->get();
$app->post();
$app->put();
$app->delete();
*/

$app->get("/saludo", function(){

    $respuesta["mensaje"]="SALUDO";

    echo json_encode($respuesta);
});

$app->get("/saludo/{nombre}", function($request){

    $nombre=$request->getAttribute("nombre");

    $respuesta["mensaje"]="Hola ".$nombre;

    echo json_encode($respuesta);
});

$app->post("/saludo", function($request){

    $nombre=$request->getParam("nombre");

    $respuesta["mensaje"]="Hola ".$nombre;

    echo json_encode($respuesta);
});


$app->delete("/borrar_saludo/{id}", function($request){
    $id_saludo = $request->getAttribute("id");
    
    $respuesta["mensaje"] = "Se ha borrado el saludo con la id: ".$id_saludo;

    echo json_encode($respuesta);
});

$app->run();
?>