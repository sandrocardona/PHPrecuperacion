<?php
    require __DIR__ . '/Slim/autoload.php';

    $app = new \Slim\App;

    //Obtener libros
    $app->get("/obtener_libros", function () {

        $respuesta["libros"] = "Json con los libros";

        echo json_encode($respuesta);
    });

    //Detalles libros
    $app->get("/detalles_libro/{referencia}", function ($request) {

        $referencia = $request->getAttribute("referencia");
        $respuesta["libro"] = "Json con detalles de los libros";

        echo json_encode($respuesta);
    });

    //Borrar libros
    $app->delete("/borrar_libro/{referencia}", function ($request) {

        $referencia = $request->getAttribute("referencia");
        $respuesta["mensaje"] = "Libro borrado";

        echo json_encode($respuesta);
    });

    //Editar libros
    $app->put("/editar_libro/{referencia}", function ($request) {

        $referencia = $request->getAttribute("referencia");
        $titulo = $request->getParamm("titulo");
        $autor = $request->getParamm("autor");
        //todos los datos a actualizar

        $respuesta["mensaje"] = "Libro actualizado";

        echo json_encode($respuesta);
    });

    //Repetido
    $app->get("/repetido_libro/{tabla}/{columna}/{valor}", function ($request) {

        $referencia = $request->getAttribute("referencia");

        $tabla = $request->getParamm("tabla");
        $columna = $request->getParamm("columna");
        $valor = $request->getParamm("valor");

        $id_columna = $request->getParamm("id_columna");
        $id_valor = $request->getParamm("id_valor");

        $respuesta["libro"] = "Valor repetido o no";
        echo json_encode($respuesta);
    });

    //Actualizar foto
    $app->put("/actualizar_foto/{referencia}", function ($request) {

        $referencia = $request->getAttribute("referencia");
        $nombre_foto = $request->getParamm("nombre_foto");
        //todos los datos a actualizar

        $respuesta["mensaje"] = "Foto actualizada";

        echo json_encode($respuesta);
    });


$app->run();
