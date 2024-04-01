<?php

    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }

    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    try{
        $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }
    
    catch(PDOException $e){
        $conexion=null;
        $sentencia=null;
        $respuesta["error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    if($sentencia->rowCount() > 0){
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"]="Usuario no registrado en BD";
    }
?>