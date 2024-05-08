<?php
require __DIR__ . '/Slim/autoload.php';
require "./src/constantes.php";

$app = new \Slim\App;


//login
$app->post("/login", function($request){

    $datos[] = $request->getParamm("usuario");
    $datos[] = $request->getParamm("clave");

    echo json_encode(login($datos));
});

//logueado
$app->post("/logueado", function($request){

    session_id($request->getParamm("api_key"));
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

//salir
$app->post("/salir", function($request){
    session_id($request->getParamm("api_key"));
    session_start();
    session_destroy();

    $respuesta["logout"] = "Sesión cerrada";

    echo json_encode($respuesta);
});


//insertar usuario
$app->post("/insertar_usuario", function ($request) {

    $nombre = $request->getParamm("nombre");
    $usuario = $request->getParamm("usuario");
    $clave = $request->getParamm("clave");
    $dni = $request->getParamm("dni");
    $sexo = $request->getParamm("sexo");
    $suscripcion = $request->getParamm("suscripcion");

    echo json_encode(insertar_usuario($nombre, $usuario, $clave, $dni, $sexo, $suscripcion));
});

//Actualizar foto
$app->put("/actualizar_foto/{id_usuario}", function ($request) {

    $id_usuario = $request->getAttribute("id_usuario");
    $nombre_foto = $request->getParamm("nombre_foto");

    echo json_encode(actualizar_foto($id_usuario, $nombre_foto));
});

//actualizar usuario
$app->post("/actualizar_usuario_clave/{id_usuario}", function ($request) {

    $nombre = $request->getParamm("nombre");
    $usuario = $request->getParamm("usuario");
    $clave = $request->getParamm("clave");
    $dni = $request->getParamm("dni");
    $sexo = $request->getParamm("sexo");
    $suscripcion = $request->getParamm("suscripcion");

    $id_usuario = $request->getAttribute("id_usuario");

    echo json_encode(insertar_usuario($nombre, $usuario, $clave, $dni, $sexo, $suscripcion, $id_usuario));
});

$app->run();
