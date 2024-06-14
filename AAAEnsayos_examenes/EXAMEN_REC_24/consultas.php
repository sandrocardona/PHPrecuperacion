<?php

//servicio d
//SELECT horario_lectivo.dia, horario_lectivo.hora, grupos.nombre as grupo, aulas.nombre as aula FROM grupos, aulas, horario_lectivo WHERE grupos.id_grupo = horario_lectivo.grupo AND aulas.id_aula = horario_lectivo.aula AND horario_lectivo.usuario = ?

//servicio e
//SELECT horario_lectivo.dia, horario_lectivo.hora, usuarios.usuario as usuario, aulas.nombre as aula FROM horario_lectivo, usuarios, aulas WHERE aulas.id_aula = horario_lectivo.aula AND usuarios.id_usuario = horario_lectivo.usuario AND horario_lectivo.grupo = ?

//servicio h
//SELECT horario_lectivo.usuario, usuarios.usuario as usuario, aulas.nombre as aula FROM horario_lectivo, usuarios, aulas WHERE usuarios.id_usuario = horario_lectivo.usuario AND aulas.id_aula = horario_lectivo.aula AND horario_lectivo.grupo = 4 AND horario_lectivo.dia = 1 AND horario_lectivo.hora = 1
?>