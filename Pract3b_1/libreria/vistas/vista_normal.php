<?php

$url = DIR_SERV."/obtener_libros";
$respuesta=consumir_servicios_REST($url,"GET");
//$obj=json_decode($respuesta,true); // asi te traes el array asociativo
$obj=json_decode($respuesta,true); // asi te tres el objeto
if(!$obj)
 {
     session_destroy();
     die("<p>Error consumiendo el servicio en obtener_libro: ".$url."</p></body></html>");
 }
 if(isset($obj->error))
 {
     session_destroy();
     die("<p>".$obj->error."</p></body></html>");
 }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 2</title>
    <style>
        .en_linea {
            display: inline
        }

        .enlace {
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer
        }

        .mensaje {
            font-size: 1.25em;
            color: blue
        }

        .reducida {
            height: 100px
        }

        .img_editar {
            width: 30%
        }

        .contenedor {
            display: flex;
            flex-wrap: wrap;
        }

        .list_libros {
            border: 1px solid black;
            margin: 0.5rem;
            flex: 0 25%;
        }
    </style>
</head>

<body>
    <h1>Práctica Rec 2</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log->lector; ?></strong> -
        <form class="en_linea" action="index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>
    </div>
    <h1>Listado de los Libros</h1>

    <?php

    //si te traes el array asociativo 
    echo "<div class='contenedor'>";
    foreach ($obj["libros"] as $tupla) {
        echo "<div class='list_libros'>";
        echo "<img class='reducida' src='images/" .$tupla['portada'] . "' alt='Foto' title='Foto'></br>";
        echo "<p>" . $tupla['titulo'] . " -- " .$tupla['precio'] . "</p>";
        echo "</div>";
    }

    ?>


</body>

</html>