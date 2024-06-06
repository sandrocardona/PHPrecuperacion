<?php
require "config_bd.php";


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

?>