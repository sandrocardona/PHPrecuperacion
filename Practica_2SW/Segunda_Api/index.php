<?php
    require __DIR__ . '/Slim/autoload.php';
    require "./src/constantes.php";

    $app = new \Slim\App;


    //insertar usuario
    $app->post("/insertar_usuario", function($request){

        $nombre =$request->getParamm("nombre");
        $usuario =$request->getParamm("usuario");
        $clave =$request->getParamm("clave");
        $dni =$request->getParamm("dni");
        $sexo =$request->getParamm("sexo");
        $suscripcion = $request->getParamm("suscripcion");

        echo json_encode(insertar_usuario($nombre, $usuario, $clave, $dni, $sexo, $suscripcion));
    });

    //Actualizar foto
    $app->put("/actualizar_foto/{id_usuario}", function ($request) {

        $id_usuario = $request->getAttribute("id_usuario");
        $nombre_foto = $request->getParamm("nombre_foto");

        echo json_encode(actualizar_foto($id_usuario, $nombre_foto));
    });


$app->run();
