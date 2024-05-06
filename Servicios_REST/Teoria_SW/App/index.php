<?php
require "./src/constantes.php";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APP API</title>
</head>
<body>
    <h1>App primera api</h1>

    <?php
    //SERVICIO SALUDO
        $respuesta=consumir_servicios_REST(DIR_SERV."/saludo","GET");
        $json = json_decode($respuesta);

        if(!$json){
            die("<p>Error consumiendo servicios REST. No hay json</p>");
        }

        echo "<p>Saludo recibido: <strong>".$json->mensaje."</strong></p>";

    //SERVICIO SALUDO + NOMBRE metodo get
        $respuesta=consumir_servicios_REST(DIR_SERV."/saludo/".urlencode("Pedro Miguel"), "GET");
        $json = json_decode($respuesta);

        if(!$json){
            die("<p>Error consumiendo servicios REST. No hay json</p>");
        }

        echo "<p>Saludo recibido: <strong>".$json->mensaje."</strong></p>";

    //SERVICIO SALUDO + NOMBRE metodo post
        $datos_env["nombre"]="María Antonia";

        $respuesta=consumir_servicios_REST(DIR_SERV."/saludo", "POST", $datos_env);
        $json = json_decode($respuesta, true);

        if(!$json){
            die("<p>Error consumiendo servicios REST. No hay json</p>");
        }

        echo "<p>Saludo recibido: <strong>".$json["mensaje"]."</strong></p>";

    //SERVICIO SALUDO + NOMBRE metodo post
        $respuesta=consumir_servicios_REST(DIR_SERV."/borrar_saludo/7", "DELETE");
        $json = json_decode($respuesta, true);

        if(!$json){
            die("<p>Error consumiendo servicios REST. No hay json</p>");
        }

        echo "<p>Saludo recibido: <strong>".$json["mensaje"]."</strong></p>";
    ?>
</body>
</html>