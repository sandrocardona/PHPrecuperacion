<?php
$url_horario = DIR_SERV."/horarioProfesor/".$datos_usuario_logueado["id_usuario"];
$respuesta = consumir_servicios_REST($url_horario, "GET", $datos_env);
$obj_horario = json_decode($respuesta, true);

if(!$obj_horario){
    session_destroy();
    die(error_page("NO OBJ","no hay obj en login: ".$url_horario));
}

if(isset($obj_horario["error"])){
    session_destroy();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    die(error_page("ERROR","error en login: ".$obj_horario["error"]));
}

$horario_profesor = $obj_horario["horario"];


foreach ($horario_profesor as $key) {
    if(isset($grupo[$key["dia"]][$key["hora"]])){
        $grupo[$key["dia"]][$key["hora"]].="/".$key["grupo"];
    } else {
        $grupo[$key["dia"]][$key["hora"]] = $key["grupo"];
    }

    $aula[$key["dia"]][$key["hora"]] = $key["aula"];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APP</title>
    <style>
        table{
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
            width: 90%;
        }
        th{
            background-color: lightblue;
            border: 1px solid black;
            border-collapse: collapse;
        }
        td{
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <h1>Examen final</h1>
    <p>Bienvenido: <?php echo "<strong>" . $datos_usuario_logueado["usuario"] . "</strong>" ?></p>
    <p>Bienvenido: <?php echo "<strong>" . $datos_usuario_logueado["id_usuario"] . "</strong>" ?></p>
    <form action="index.php" method="post">
        <button type="submit" name="btnSalir">Salir</button>
    </form>
    <h2>Su horario</h2>
    <?php
    $dias[0] = "";
    $dias[] = "Lunes";
    $dias[] = "Martes";
    $dias[] = "Miércoles";
    $dias[] = "Jueves";
    $dias[] = "Viernes";

    $horas[1] = "8:15 - 9:15";
    $horas[] = "9:15 - 10:15";
    $horas[] = "10:15 - 11:15";
    $horas[] = "11:15 - 11:45";
    $horas[] = "11:45 - 12:45";
    $horas[] = "12:45 - 13:45";
    $horas[] = "13:45 - 14:45";


    echo "<table>";
    echo "<tr>";
    for ($dia = 0; $dia < count($dias); $dia++) { 
        echo "<th>".$dias[$dia]."</th>";
    }
    echo "</tr>";
    for ($hora = 1; $hora < count($horas)+1; $hora ++) { 
        echo "<tr>";
        if($hora==4)
            echo "<th>".$horas[$hora]."</th><td colspan='5'>R E C R E O</td>";
        else{
            for ($dia = 0; $dia < count($dias) ; $dia ++) {
                if($dia == 0)
                    echo "<th>".$horas[$hora]."</th>";
                else{
                    echo "<td>";
                    if(isset($grupo[$dia][$hora])){
                        echo $grupo[$dia][$hora];
                        if(isset($aula[$dia][$hora])){
                            echo "<br/>";
                            echo $aula[$dia][$hora];
                        }
                    }
                    echo "</td>";
                }
            }
        }
        echo "</tr>";
    }
    echo "</table>";
    ?>
</body>
</html>