<?php
require "config_bd.php";


    /* === login === */
    function login($usuario, $clave)
    {
        try{
            $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible conectar a BD en login():".$e->getMessage();
        }

        try{
            $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$usuario, $clave]);
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta en login()".$e->getMessage();
        }

        if($sentencia->rowCount() > 0){
            $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            session_name("api");
            session_start();
            $respuesta["api_session"] = session_id();
            $_SESSION["usuario"] = $respuesta["usuario"]["usuario"];
            $_SESSION["clave"] = $respuesta["usuario"]["clave"];

        } else {
            $respuesta["mensaje"] = "usuario no registrado en la BD";
        }

        return $respuesta;
    }

    /* === logueado === */
    function logueado($usuario, $clave)
    {
        try{
            $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible conectar a BD en logueado():".$e->getMessage();
        }

        try{
            $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$usuario, $clave]);
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta en logueado()".$e->getMessage();
        }

        if($sentencia->rowCount() > 0){

            $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

        } else {
            $respuesta["mensaje"] = "usted ya no está registrado en la BD";
        }

        return $respuesta;
    }

?>
