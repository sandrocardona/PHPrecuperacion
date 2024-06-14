<?php
    $url_grupos = DIR_SERV."/grupos";
    $respuesta = consumir_servicios_REST($url_grupos, "GET", $datos_env);
    $json_grupos = json_decode($respuesta, true);
    if(!$json_grupos){
        session_destroy();
        die(error_page("NO OBJ","no hay obj en login: ".$url_login));
    }

    if(isset($json_grupos["error"])){
        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
        die(error_page("ERROR","error en login: ".$json_grupos["error"]));
    }

    $grupos = $json_grupos["grupos"];

    if(isset($_POST["btnVerHorario"]) || isset($_POST["btnEditar"])){
        echo $_POST["grupo"];
        $url_horario_grupo = DIR_SERV."/horarioGrupo/".$_POST["grupo"];
        $respuesta = consumir_servicios_REST($url_horario_grupo, "GET", $datos_env);
        $json_horario_grupo = json_decode($respuesta, true);
        if(!$json_horario_grupo){
            session_destroy();
            die(error_page("NO OBJ","no hay obj en horario_grupo: ".$url_horario_grupo));
        }
    
        if(isset($json_horario_grupo["error"])){
            session_destroy();
            consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
            die(error_page("ERROR","error en horario_grupo: ".$json_horario_grupo["error"]));
        }

        $horario_grupo = $json_horario_grupo["horario"];

        foreach ($horario_grupo as $key) {
            if(isset($clase[$key["dia"]][$key["hora"]])){
                $clase[$key["dia"]][$key["hora"]].="<br/>".$key["usuario"]." (".$key["aula"].")";
            } else {
                $clase[$key["dia"]][$key["hora"]] = $key["usuario"]." (".$key["aula"].")";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    <style>
        .centrado{
            width: 100%;
            text-align: center;
        }
        table{
            width: 90%;
            text-align: center;
            border: 1px solid black;
            border-collapse: collapse;
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
        .enlace{
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Examen final</h1>
    <p>Bienvenido: <?php echo "<strong>" . $datos_usuario_logueado["nombre"] . "</strong>" ?></p>
    <form action="index.php" method="post">
        <button type="submit" name="btnSalir">Salir</button>
    </form>
    <h2>Horario de los grupos</h2>
    <form action="index.php" method="post">
        <label for="grupo">Elija el grupo</label>
        <select name="grupo">
            <?php
            
            foreach ($grupos as $key) {
                if(isset($_POST["btnVerHorario"]) && $_POST["grupo"]==$key["id_grupo"] || isset($_POST["btnEditar"]) && $_POST["grupo"]==$key["id_grupo"]){
                    echo "<option selected value='".$key["id_grupo"]."'>".$key["nombre"]."</option>";
                    $nombre_grupo = $key["nombre"];
                    $id_grupo = $key["id_grupo"];

                } else {
                    echo "<option value='".$key["id_grupo"]."'>".$key["nombre"]."</option>";
                }
            }
            
            ?>
        </select>
        <button type="submit" name="btnVerHorario">Ver Horario</button>
    </form>
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
    
    if(isset($_POST["btnVerHorario"]) || isset($_POST["btnEditar"])){
        echo "<h3 class='centrado'>Horario del Grupo: ".$nombre_grupo."</h3>";
        echo "<table>";
        echo "<tr>";
        for ($dia=0; $dia < count($dias); $dia++) { 
            echo "<th>".$dias[$dia]."</th>";
        }
        
        for ($hora = 1; $hora < count($horas)+1; $hora++) { 
            echo "<tr>";
            if($hora == 4){
                echo "<th>".$horas[$hora]."</th><td colspan='5'>R E C R E O</td>";
            }
            else{
                for ($dia=0; $dia < count($dias); $dia++) {
                    if($dia==0){
                        echo "<th>".$horas[$hora]."</th>";
                    } else {
                        echo "<td>";
                        if(isset($clase[$dia][$hora])){
                            echo $clase[$dia][$hora];
                        }
                        echo "<form action='index.php' method='post'>";
                        echo "<input type='hidden' value='".$dia."' name='dia' />";
                        echo "<input type='hidden' value='".$hora."' name='hora' />";
                        echo "<input type='hidden' value='".$_POST["grupo"]."' name='grupo' />"; 
                        echo "<button type='submit' name='btnEditar' class='enlace'>Editar</button>";
                        echo "</form>";
                        echo "</td>";  
                    }
                }
            }
            echo "</tr>";
        }
        echo "</tr>";
        echo "</table>";
    }
    if(isset($_POST["btnEditar"])){

        //hora auxiliar
        if($_POST["hora"] > 3){
            $horaAux = $_POST["hora"]-1;
        } else {
            $horaAux = $_POST["hora"];
        }

        echo "<h3>Editando la ".$horaAux."ª Hora (".$horas[$_POST["hora"]].") del ".$dias[$_POST["dia"]]."</h3>";

        echo "<table>";
        echo "<tr><th>PROFESOR(AULA)</th><th>ACCIÓN</th></tr>";
        echo "<tr>";
        echo "<td>";
        echo $clase[$_POST["dia"]][$_POST["hora"]];
        echo "</td>";
        echo "</tr>";
        echo "</table>";
    }
    ?>
</body>
</html>