<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;


$app->post('/salir',function($request){
    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();
    $respuesta["log_out"]="Cerrada sesión en la API";
    echo json_encode($respuesta);
});

/* login */
$app->post('/login',function($request){
    $usuario=$request->getParam("usuario");
    $clave=$request->getParam("clave");

    echo json_encode(login($usuario,$clave));

});

/* logueado */
$app->post('/logueado',function($request){
    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["usuario"])){
        $usuario=$_SESSION["usuario"];
        $clave=$_SESSION["clave"];
    
        echo json_encode(logueado($usuario,$clave));
    } else {
        session_destroy();
        $respuesta["no_auth"] = "No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});

/* d) horarioProfesor/{id_usuario} */
$app->get('/horarioProfesor/{id_usuario}',function($request){
    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["usuario"])){
        $id_usuario = $request->getAttribute("id_usuario");
    
        echo json_encode(horarioProfesor($id_usuario));
    } else {
        session_destroy();
        $respuesta["no_auth"] = "No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});

/* f) horarioGrupo/{id_grupo} */
$app->get('/horarioGrupo/{id_grupo}',function($request){
    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin"){
        $id_grupo = $request->getAttribute("id_grupo");

        echo json_encode(horarioGrupo($id_grupo));
    } else {
        session_destroy();
        $respuesta["no_auth"] = "No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});

/* f) horarioProfesor/{id_usuario} */
$app->get('/grupos',function($request){
    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin"){
        
        echo json_encode(grupos());
    } else {
        session_destroy();
        $respuesta["no_auth"] = "No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
