<?php

if(time() - $_SESSION["ult_accion"] > MINUTOS*60){
    session_unset();
    $_SESSION["seguridad"] = "Vuelva a loguearse. Baneado por inactividad";
    header("Location:index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APP</title>
    <style>
        table{
            width: 90%;
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }
        th{
            border: 1px solid black;
            border-collapse: collapse;
            background-color: lightblue;
        }
        td{
            border: 1px solid black;
            border-collapse: collapse;    
        }
        .enlace{
            background: none;
            color: blue;
            text-decoration: underline;
            border: none;
            cursor: pointer;
        }
        .tr-half{
            width: 100%;
            display: flex;
            flex-flow: column;
        }

        .td-full{
            flex: 100%;
        }
    </style>
</head>
<body>
    <h1>Gestión de guardias</h1>
    <div>
        <form action="index.php" method="post">
            Bienvenido: <?php echo "<strong>".$_SESSION["usuario"]."</strong> -- ".$_SESSION["id_usuario"] ?>&nbsp;&nbsp;
            <button type="submit" name="btnSalir">Salir</button>
        </form>
    </div>
    <h2>Equipos de Guardia del IES mar de Alborán</h2>
    <?php
    
    $dias[0] = "";
    $dias[1] = "Lunes";
    $dias[2] = "Martes";
    $dias[3] = "Miércoles";
    $dias[4] = "Jueves";
    $dias[5] = "Viernes";

    $horas[1] = "1 hora";
    $horas[2] = "2 hora";
    $horas[3] = "3 hora";
    $horas[4] = " RECREO";
    $horas[5] = "4 hora";
    $horas[6] = "5 hora";
    $horas[7] = "6 hora";

    echo "<table>";
    echo "<tr>";
    foreach ($dias as $key) {
        echo "<th>".$key."</th>";
    }
    echo "<tr>";
    $numero=1;
    for ($hora=1; $hora <=7 ; $hora++) {
        echo "<tr>";
        if($hora == 4)
            echo "<td colspan='7'>".$horas[$hora]."</td>";
        else{
            echo "<th>".$horas[$hora]."</th>";
            for ($dia=1; $dia <=5 ; $dia++) {
                echo "<td><form action='index.php' method='post'>";
                echo "<button type='submit' name='btnEquipo' class='enlace' value='".$dia."-".$hora."'>Equipo ".$numero."</button>";
                echo "</form></td>";
                $numero++;
            }
        }
        echo "</tr>";
    }
    echo "</table>";

    if(isset($_POST["btnEquipo"])){
        $arrayAux = explode("-", $_POST["btnEquipo"]);
        $datos_guardia["dia"] = $arrayAux[0];
        $datos_guardia["hora"] = $arrayAux[1];

        echo "<p>Día seleccionado: ".$datos_guardia["dia"]."</p>";
        echo "<p>Hora seleccionada: ".$datos_guardia["hora"]."</p>";
        echo "<p>ID PROFESOR: ".$_SESSION["id_usuario"]."</p>";

        $url_guardias = DIR_SERV."/usuariosGuardia/dia/hora";
        $respuesta = consumir_servicios_REST($url_guardias, "GET", $datos_guardia);
        $obj_guardias = json_decode($respuesta, true);

        if(!$obj_guardias){
            session_destroy();
            die(error_page("NO OBJ","no hay obj en obj guardias".$url_guardias));
        }

        if(isset($obj_guardias["error"])){
            session_destroy();
            die(error_page("ERROR","ERROR en obj guardias".$obj_guardias["error"]));
        }

        if(isset($obj_guardias["mensaje"])){
            echo "<p>".$obj_guardias["mensaje"]."</p>";
        } else {

            echo "<table>";
            echo "<tr><th>PROFESORES</th><th>INFORMACION</th></tr>";
            echo "<tr class='tr-half'>";
            foreach ($obj_guardias["usuarios"] as $key) {
                echo "<td class='td-full'>";
                echo "<form action='index.php' method='post'>";
                echo "<button class='enlace'>".$key["nombre"]."</button>";
                echo "</form>";
                echo "</td>";
            }
            echo "</tr>";
            echo "</table>";
        }
    }
    ?>
</body>
</html>