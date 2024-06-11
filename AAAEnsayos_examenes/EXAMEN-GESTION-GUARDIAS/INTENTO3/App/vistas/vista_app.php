<?php
    if(isset($_POST["btnEquipo"])){

        $datos_deguardia["api_session"] = $_SESSION["api_session"];
        $datos_deguardia["dia"] = $_POST["dia"];
        $datos_deguardia["hora"] = $_POST["hora"];
        $datos_deguardia["id_usuario"] = $datos_usuario_logueado["id_usuario"];

            $url_deguardia = DIR_SERV."/deGuardia/dia/hora/id_usuario";
            $respuesta = consumir_servicios_REST($url_deguardia, "GET", $datos_deguardia);
            $json_deguardia = json_decode($respuesta, true);

            if(!$json_deguardia){
                session_destroy();
                die(error_page("NO OBJ","NO OBJ en json deguardia".$url_deguardia));
            }

            if(isset($json_deguardia["error"])){
                session_destroy();
                consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_api);
                die(error_page("NO OBJ","NO OBJ en json deguardia".$url_deguardia));
            }

            if(isset($json_deguardia["no_auth"])){
                session_unset();
                $_SESSION["seguridad"] = "No tiene permisos";
                header("Location:index.php");
                exit();
            }

            $guardia = $json_deguardia["de_guardia"];
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
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
        .tr-half{
            width: 50%;
        }
    </style>
</head>

<body>
    <h1>Gestión de Guardias</h1>
    <p>Bienvenido <?php echo "<strong>" . $datos_usuario_logueado["usuario"] . "</strong>" ?></p>
    <p>Bienvenido <?php echo "<strong>" . $_SESSION["usuario"] . "</strong>" ?></p>
    <form action="index.php" method="post">
        <button type="submit" name="btnSalir">Salir</button>
    </form>
    <h2>Equipos de guardia</h2>
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
            echo "<th>".$key."</th>";
        }
        echo "</tr>";
        $numero = 1;
        for ($hora = 1; $hora < count($horas)+1; $hora++) { 
            echo "<tr>";
            if($hora == 4){
                echo "<th colspan='6'>".$horas[$hora]."</th>";
            } else {
                for ($dia = 0; $dia < count($dias) ; $dia++) { 
                    if($dia == 0){
                        echo "<th>".$horas[$hora]."</th>";
                    } else {
                        echo "<td>";
                        echo "<form action='index.php' method='post'>";
                        echo "<input type='hidden' name='dia' value='".$dia."'>";
                        echo "<input type='hidden' name='hora' value='".$hora."'>";
                        echo "<button name='btnEquipo' class='enlace'>Equipo ".$numero."</button>";
                        echo "</form>";
                        echo "</td>"; 
                    $numero++;
                    }
                }
            }
            echo "</tr>";
        }
        echo "</table>";

        if(isset($_POST["btnEquipo"]) || isset($_POST["btnProfesor"])){
            if(isset($guardia) && $guardia==false)
            {
                echo "<h2>Usted no tiene guardia el ".$dias[$_POST["dia"]]." a ".$horas[$_POST["hora"]]."</h2>";
            }
            else{
                echo "<h2>".$dias[$_POST["dia"]]." a ".$horas[$_POST["hora"]]."</h2>";
                $datos_guardias["api_session"] = $_SESSION["api_session"];
                $datos_guardias["dia"] = $_POST["dia"];
                $datos_guardias["hora"] = $_POST["hora"];

                $url_guardias = DIR_SERV."/usuariosGuardia/dia/hora";
                $respuesta = consumir_servicios_REST($url_guardias, "GET", $datos_guardias);
                $json_guardias = json_decode($respuesta, true);

                if(!$json_guardias){
                    session_destroy();
                    die(error_page("no obj", "no hay obj en json guardias".$url_guardias));
                }

                if(isset($json_guardias["error"])){
                    session_destroy();
                    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_guardias);
                    die(error_page("Error","Error en json guardias".$json_guardias));
                }

                $profesores = $json_guardias["usuarios"];

                echo "<table>";
                echo "<tr><th>Profesores</th><th>Info</th></tr>";
                for ($i=0; $i < count($profesores); $i++) { 
                    echo "<tr>";
                    echo "<td>";
                    echo "<form action='index.php' method='post'>";
                    echo "<input type='hidden' name='dia' value='".$_POST["dia"]."' />";
                    echo "<input type='hidden' name='hora' value='".$_POST["hora"]."' />";
                    echo "<input type='hidden' name='nombre' value='".$profesores[$i]["nombre"]."' />";
                    echo "<input type='hidden' name='id_usuario' value='".$datos_usuario_logueado["id_usuario"]."' />";
                    echo "<button class='enlace' name='btnProfesor'>".$profesores[$i]["nombre"]."</button>";
                    echo "</form>";
                    echo "</td>";
                    if(isset($_POST["btnProfesor"]) && $i==0){
                        echo "<td rowspan='".count($profesores)."'>";
                        echo "Nombre: ";
                        echo "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
        }

    ?>
</body>

</html>