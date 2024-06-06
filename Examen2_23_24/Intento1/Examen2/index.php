<?php
    session_name("Examen2");
    session_start();
    require "../Examen2/src/constantes.php";
    ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Intento 1</title>
        <style>
            table{
                border: 1px solid black;
                border-collapse: collapse;
                width: 80%;
                text-align: center;
            }

            th{
                border: 1px solid black;
                border-collapse: collapse;
                background-color: lightblue;
                text-align: center;
            }

            td{
                border: 1px solid black;
                border-collapse: collapse;
                text-align: center;
            }

            .td-hora{
                background-color: lightblue;
                font-weight: bold;
            }

        </style>
    </head>
    <body>
        <h1>Examen2 PHP</h1>
        <h2>Horario de los Profesores</h2>
        <label for="profesores">Horario del profesor: </label>
        <?php
                $url_profesores = DIR_SERV."/profesores";
                $respuesta = consumir_servicios_REST($url_profesores, "GET");
                $obj_profesores = json_decode($respuesta);
                
                if(!$obj_profesores){
                    session_destroy();
                    die(error_page("NO OBJ","No hay objeto en obj_profesores".$url_profesores));
                }

                if(isset($obj_profesores->error)){
                    session_destroy();
                    die(error_page("ERROR","Error en obj_profesores: ".$obj_profesores->error));
                }

                $profesores = $obj_profesores->profesores;

                echo "<form method='post' action='index.php'>";
                echo "<select name='profesores'>";
                foreach ($profesores as $tupla) {
                    if(isset($_POST["btnVerHorario"]) && $_POST["profesores"]==$tupla->id_usuario){
                            echo "<option selected value='".$tupla->id_usuario."'>";
                            $nombre_profesor = $tupla->nombre;
                            $usuario["usuario"] = $tupla->id_usuario;

                        }
                    else
                        echo "<option value='".$tupla->id_usuario."'>";
                    echo $tupla->nombre;
                    echo "</option>";
                }
                echo "</select>";
                echo "&nbsp;<button name='btnVerHorario'>Ver Horario</button>";
                echo "&nbsp;<button name='btnClear'>Clear</button>";
                echo "</form>";
                /* === servicio horarios_profesor === */
                if(isset($_POST["btnVerHorario"])){
                    $url_horario = DIR_SERV."/horarios_profesor/{usuario}";
                    $respuesta = consumir_servicios_REST($url_horario, "GET", $usuario);
                    $obj_horario = json_decode($respuesta, true);

                    if(!$obj_horario){
                        session_destroy();
                        die(error_page("NO OBJ", "No hay obj en obj_horario".$url_horario));
                    }

                    if(isset($obj_horario["error"])){
                        session_destroy();
                        die(error_page("ERROR", "ERROR en obj_horario".$obj_horario["error"]));
                    }

                    $grupo = $obj_horario["horarios"];

                    echo "<p>".var_dump($usuario)."</p>";
                    
                    var_dump($grupo);
                }

                // === tabla === //
                $dia[0] = "Horas";
                $dia[1] = "Lunes";
                $dia[] = "Martes";
                $dia[] = "Miercoles";
                $dia[] = "Jueves";
                $dia[] = "Viernes";

                $hora[1] = "8:15 - 9:15";
                $hora[2] = "9:15 - 10:15";
                $hora[3] = "10:15 - 11:15";
                $hora[4] = "11:15 - 11:45";
                $hora[5] = "11:45 - 12:45";
                $hora[6] = "12:45 - 13:45";
                $hora[7] = "13:45 - 14:45";

                if(isset($_POST["btnVerHorario"])){
                    echo "<h2>Horario del profesor: ".$nombre_profesor."</h2>";
                    echo "<table>";
                    for ($j=0; $j < 8; $j++) {
                        echo "<tr>";
                        if($j == 4){
                            echo "<td class='td-hora'>".$hora[$j]."</td><td colspan='5'>R E C R E O</td>";
                        } else{ 
                        
                        for($i = 0; $i <= 5; $i++){
                            if($j == 0)
                                echo "<th>".$dia[$i]."</th>";
                            else{
                                if($i == 0){
                                    echo "<td class='td-hora'>".$hora[$j]."</td>";
                                } else {
                                    echo "<td>".$usuario["usuario"]."</td>";
                                }
                            }
                        }
                        echo "</tr>";
                    }
                    }
                    echo "</table>";
                }

                if(isset($_POST["btnClear"]))
                    $_POST["btnVerHorario"]=null;

            ?>
    </body>
</html>