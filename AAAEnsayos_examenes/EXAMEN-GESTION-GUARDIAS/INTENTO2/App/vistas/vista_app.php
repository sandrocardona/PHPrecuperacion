<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APP</title>
    <style>
        table {
            border: 1px solid black;
            border-collapse: collapse;
            width: 90%;
            text-align: center;
        }

        th {
            border: 1px solid black;
            border-collapse: collapse;
            background-color: lightblue;
            text-align: center;
        }
        td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }

        .enlace{
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Gestión de guardias</h1>
    <p>Bienvenido: <?php echo "<strong>" . $datos_usuario_logueado["usuario"] . "</strong>"; ?></p>
    <form action="index.php" method="post">
        <button type="submit" name="btnSalir">Salir</button>
    </form>
    <h3>Equipos de Guardia</h3>
    <?php

    $dias[0] = "";
    $dias[] = "Lunes";
    $dias[] = "Martes";
    $dias[] = "Miércoles";
    $dias[] = "Jueves";
    $dias[] = "Viernes";

    $horas[1] = "1º Hora";
    $horas[] = "2º Hora";
    $horas[] = "3º Hora";
    $horas[] = "R E C R E O";
    $horas[] = "4º Hora";
    $horas[] = "5º Hora";
    $horas[] = "6º Hora";

    echo "<table>";
    echo "<tr>";
    foreach ($dias as $key) {
        echo "<th>" . $key . "</th>";
    }
    echo "</tr>";
    $numero = 1;
    for ($hora = 1; $hora <= 7; $hora++) {
        echo "<tr>";
        if ($hora ==  4) {
            echo "<td colspan='6'>" . $horas[$hora] . "</td>";
        } else {
            for ($dia = 0; $dia <= 5; $dia++) {
                $valor = $dia." - ".$hora;
                if($dia == 0)
                    echo "<th>".$horas[$hora]."</th>";
                else{
                    echo "<td>";
                    echo "<form action='index.php' method='post'>";
                    echo "<button class='enlace' type='submit' name='btnEquipo' value='".$valor."'>Equipo".$numero."</button>";
                    echo "</form>";
                    echo "</td>";
                    $numero++; 
                }
            }
            echo "</tr>";
        }
    }
    echo "</table>";

    if(isset($_POST["btnEquipo"])){
        $array = explode("-", $_POST["btnEquipo"]);
        $datos["dia"] = $array[0];
        $datos["hora"] = $array[1];
        echo "<p>Dia: ".$datos["dia"]."</p>";
        echo "<p>Hora: ".$datos["hora"]."</p>";
    }

    

    ?>
</body>

</html>