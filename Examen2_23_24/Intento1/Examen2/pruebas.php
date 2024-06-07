<?php

foreach($obj2->horario as $tupla)
        {
            if(isset($horario[$tupla->dia][$tupla->hora]))
                $horario[$tupla->dia][$tupla->hora].="/".$tupla->nombre;
            else
                $horario[$tupla->dia][$tupla->hora]=$tupla->nombre;
        }


        $dias[]="";
        $dias[]="Lunes";
        $dias[]="Martes";
        $dias[]="Miércoles";
        $dias[]="Jueves";
        $dias[]="Viernes";
        $horas[1]="8:15 - 9:15";
        $horas[]="9:15 - 10:15";
        $horas[]="10:15 - 11:15";
        $horas[]="11:15 - 11:45";
        $horas[]="11:45 - 12:45";
        $horas[]="12:45 - 13:45";
        $horas[]="13:45 - 14:45";

        echo "<h3 class='centro'>Horario del Profesor: ".$nombre_profesor."</h3>";
        echo "<table class='tabla_hor'>";
        echo "<tr>";
        for($i=0;$i<=5;$i++)
            echo "<th>".$dias[$i]."</th>";
        echo "</tr>";
        for($hora=1;$hora<=7;$hora++)
        {
            echo "<tr>";
            echo "<th>".$horas[$hora]."</th>";
            if($hora==4)
                echo "<td colspan='5'>RECREO</td>";
            else
            {
                for($dia=1;$dia<=5;$dia++)
                {
                    if(isset($horario[$dia][$hora]))
                    {
                        echo "<td>".$horario[$dia][$hora];
                        echo "<form action='index.php' method='post'>";
                        echo "<input type='hidden' name='profesor' value='".$_POST["profesor"]."'><input type='hidden' name='dia' value='".$dia."'><input type='hidden' name='hora' value='".$hora."'>";
                        echo "<button class='enlace' name='btnEditar'>Editar</button>";
                        echo "</form></td>";
                    }
                    else
                    {
                        echo "<td>";
                        echo "<form action='index.php' method='post'>";
                        echo "<input type='hidden' name='profesor' value='".$_POST["profesor"]."'><input type='hidden' name='dia' value='".$dia."'><input type='hidden' name='hora' value='".$hora."'>";
                        echo "<button class='enlace' name='btnEditar'>Editar</button>";
                        echo "</form></td>";
                    }

                }
            }
            echo "</tr>";
            echo "</table>";
        }

?>