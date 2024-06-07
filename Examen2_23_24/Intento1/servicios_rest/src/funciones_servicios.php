<?php
require "config_bd.php";

    /* === profesores === */

    function profesores()
    {
        try{
            $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible conectar a BD en profesores():".$e->getMessage();
            return $respuesta;
        }

        try{
            $consulta = "SELECT * FROM usuarios";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta en profesores():".$e->getMessage();
            return $respuesta;
            $conexion = null;
            $sentencia = null;
        }

        $respuesta["profesores"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $respuesta;
    }

    /* === horarios_profesor === */

    function horarios_profesor($usuario)
    {
        try{
            $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible conectar a BD en horarios_profesor():".$e->getMessage();
            return $respuesta;
        }

        try{
            $consulta = "SELECT horario_lectivo.dia, horario_lectivo.grupo, horario_lectivo.hora, grupos.nombre FROM horario_lectivo, grupos WHERE grupos.id_grupo = horario_lectivo.grupo AND horario_lectivo.usuario=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$usuario]);
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta en horarios_profesor():".$e->getMessage();
            return $respuesta;
        }

        $respuesta["horarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);


        return $respuesta;
    }

?>