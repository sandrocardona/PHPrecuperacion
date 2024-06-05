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


/* === login === */

function login($usuario, $clave)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar en login:".$e->getMessage();
    }

    try{
        $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    }

    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar consulta en login:".$e->getMessage();
    }

    if($sentencia->rowCount() > 0){

        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

        session_name("sesion_de_api");
        session_start();

        $respuesta["api_session"] = session_id();
        $_SESSION["usuario"] = $respuesta["usuario"]["usuario"];
        $_SESSION["clave"] = $respuesta["usuario"]["clave"];
        $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];

    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD";
    }

    $sentencia = null;
    $conexion = null;

    return $respuesta;
}

/* === logueado === */

function logueado($usuario, $clave)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar en logueado:".$e->getMessage();
    }

    try{
        $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    }

    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar consulta en logueado:".$e->getMessage();
    }

    if($sentencia->rowCount() > 0){

        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD";
    }

    $sentencia = null;
    $conexion = null;

    return $respuesta;
}


/* === obtener_notas_alumno === */

function obtener_notas_alumno($cod_usu)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar en logueado:".$e->getMessage();
    }

    try{
        $consulta = "SELECT asignaturas.cod_asig, asignaturas.denominacion, notas.nota FROM asignaturas, nota WHERE asignaturas.cod_asig=notas.cod_asig AND cod_usu=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($cod_usu);
    }

    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar consulta en logueado:".$e->getMessage();
    }

    $respuesta["notas"] = $sentencia->fetch(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;

    return $respuesta;
}

/* === obtener_alumnos === */

function obtener_alumnos()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar en logueado:".$e->getMessage();
    }

    try{
        $consulta = "SELECT * FROM usuarios WHERE tipo = 'alumno'";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    }

    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar consulta en obtener_alumnos():".$e->getMessage();
    }

    $respuesta["notas"] = $sentencia->fetch(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;

    return $respuesta;
}

/* === quitar_nota_alumno_asig === */

function quitar_nota_alumno_asig($cod_usu, $cod_asig)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar en logueado:".$e->getMessage();
    }

    try{
        $consulta = "DELETE FROM notas WHERE cod_usu=? AND cod_asig=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod_usu, $cod_asig]);
    }

    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar consulta en obtener_alumnos():".$e->getMessage();
    }

    $respuesta["mensaje"] = "Asignatura descalificada con éxito";

    $sentencia = null;
    $conexion = null;

    return $respuesta;
}

?>
