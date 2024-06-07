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
                width: 100%;
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
            .enlace{
                background: none;
                border: none;
                color: blue;
                text-decoration: underline;
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
                    if(isset($_POST["btnVerHorario"]) && $_POST["profesores"]==$tupla->id_usuario || isset($_POST["btnEditar"]) && $_POST["profesores"]==$tupla->id_usuario){
                            echo "<option selected value='".$tupla->id_usuario."'>";
                            $nombre_profesor = $tupla->nombre;
                            $usuario = $tupla->id_usuario;
                        }
                    else
                        echo "<option value='".$tupla->id_usuario."'>";
                    echo $tupla->nombre;
                    echo "</option>";
                }
                echo "</select>";
                echo "&nbsp;<button name='btnVerHorario'>Ver Horario</button>";
                echo "</form>";
                /* === servicio horarios_profesor === */
                if(isset($_POST["btnVerHorario"]) || isset($_POST["btnEditar"])){
                    $url_horario = DIR_SERV."/horarios_profesor/".$_POST["profesores"];
                    $respuesta = consumir_servicios_REST($url_horario, "GET");
                    $obj_horario = json_decode($respuesta);

                    if(!$obj_horario){
                        session_destroy();
                        die(error_page("NO OBJ", "No hay obj en obj_horario".$url_horario));
                    }

                    if(isset($obj_horario->error)){
                        session_destroy();
                        die(error_page("ERROR", "ERROR en obj_horario".$obj_horario->error));
                    }
                

                // === tabla === //
                foreach($obj_horario->horarios as $tupla){
                    if(isset($horario[$tupla->dia][$tupla->hora]))
                        $horario[$tupla->dia][$tupla->hora].="/".$tupla->nombre;
                    else
                        $horario[$tupla->dia][$tupla->hora] = $tupla->nombre;
                }

                $dias[] = "";
                $dias[] = "Lunes";
                $dias[] = "Martes";
                $dias[] = "Miércoles";
                $dias[] = "Jueves";
                $dias[] = "Viernes";

                $horas[1]="8:15 - 9:15";
                $horas[]="9:15 - 10:15";
                $horas[]="10:15 - 11:15";
                $horas[]="11:15 - 11:45";
                $horas[]="11:45 - 12:45";
                $horas[]="12:45 - 13:45";
                $horas[]="13:45 - 14:45";

                echo "<h3 class='centro'>Horario del Profesor: ".$nombre_profesor."</h3>";
                echo "<h3 class='centro'>Horario del Profesor: ".$_POST["profesores"]."</h3>";
                echo "<table>";
                //tr para los dias de la cabecera
                echo "<tr>";
                    for($i = 0; $i <= 5; $i++){
                        echo "<th>".$dias[$i]."</th>";
                    }
                echo "</tr>";
                for($hora=1; $hora <= 7; $hora++){
                    echo "<tr>";
                    echo "<th>".$horas[$hora]."</th>";
                    if($hora == 4)
                        echo "<td colspan='5'>R E C R E O</td>";
                    else{
                        for ($dia = 1; $dia <=5 ; $dia++) { 
                            if(isset($horario[$dia][$hora])){
                                echo "<td>".$horario[$dia][$hora];
                                echo "<form action='index.php' method='post'>";
                                echo "<input type='hidden' value='".$_POST["profesores"]."' name='profesores'></input>";
                                echo "<input type='hidden' value='".$dia."' name='dia'></input>";
                                echo "<input type='hidden' value='".$hora."' name='hora'></input>";
                                echo "<button class='enlace' name='btnEditar'>Editar</button>";
                                echo "</form></td>";
                            }
                            else{
                                echo "<td>";
                                echo "<form action='index.php' method='post'>";
                                echo "<input type='hidden' value='".$_POST["profesores"]."' name='profesores'></input>";
                                echo "<input type='hidden' value='".$dia."' name='dia'></input>";
                                echo "<input type='hidden' value='".$hora."' name='hora'></input>";
                                echo "<button class='enlace' name='btnEditar'>Editar</button>";
                                echo "</form></td>";
                            }
                        }
                    }
                    echo "</tr>";
                }
                echo "</table>";

                if(isset($_POST["btnEditar"])){
                    echo "<p>".$_POST["profesores"]."</p>";
                    echo "<p>".$_POST["dia"]."</p>";
                    echo "<p>".$_POST["hora"]."</p>";
                }
            }
            ?>
    </body>
</html>