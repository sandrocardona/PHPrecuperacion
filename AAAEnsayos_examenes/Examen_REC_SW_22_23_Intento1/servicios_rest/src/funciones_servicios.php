<?php
require "config_bd.php";

function conexion_pdo()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
        
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}


// Login

function login($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar a la BD en login():".$e->getMessage();
    }

    try{
        $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar consulta en login():".$e->getMessage();
        $conexion=null;
        $sentencia=null;
    }

    //si la sentencia recibe datos
    if($sentencia->rowCount() > 0){

        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        
        //iniciar sesiones
        session_name("idlogin");
        session_start();
        //recoger datos de usuario + id session

        $respuesta["api_session"] = session_id();

        //asignar los datos del usuario
        $_SESSION["usuario"] = $respuesta["usuario"]["usuario"];
        $_SESSION["clave"] = $respuesta["usuario"]["clave"];
        
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD en login()";
    }

    $conexion=null;
    $sentencia=null;

    return $respuesta;
}

?>
