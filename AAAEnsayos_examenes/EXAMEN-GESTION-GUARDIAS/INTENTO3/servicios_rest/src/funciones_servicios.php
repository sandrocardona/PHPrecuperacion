<?php
require "config_bd.php";

/* === login === */
function login($usuario, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD en login():" . $e->getMessage();
    }

    try {
        $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible realizar la consulta en login():" . $e->getMessage();
        $conexion = null;
        $sentencia = null;
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("API");
        session_start();
        $respuesta["api_session"] = session_id();
        $_SESSION["usuario"] = $respuesta["usuario"]["usuario"];
        $_SESSION["clave"] = $respuesta["usuario"]["clave"];
    } else {
        $respuesta["mensaje"] = "Usuario no registrado en la BD";
    }

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

/* === logueado === */
function logueado($usuario, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD en logueado():" . $e->getMessage();
    }

    try {
        $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible realizar la consulta en logueado():" . $e->getMessage();
        $conexion = null;
        $sentencia = null;
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"] = "Usted ya no se encuentra registrado en la BD";
    }

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

/* === esta_de_guardia === */
function esta_de_guardia($dia, $hora, $id_usuario)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD en logueado():" . $e->getMessage();
    }

    try {
        $consulta = "SELECT horario_guardias.id_hor_gua FROM horario_guardias WHERE dia=? and hora=? and usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$dia, $hora, $id_usuario]);
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible realizar la consulta en logueado():" . $e->getMessage();
        $conexion = null;
        $sentencia = null;
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["de_guardia"] = true;
    } else {
        $respuesta["de_guardia"] = false;
    }

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

/* === esta_de_guardia === */
function usuariosGuardia($dia, $hora)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD en logueado():" . $e->getMessage();
    }

    try {
        $consulta = "SELECT * FROM usuarios WHERE usuarios.id_usuario IN (SELECT horario_guardias.usuario FROM horario_guardias WHERE dia=? AND hora=?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$dia, $hora]);
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible realizar la consulta en logueado():" . $e->getMessage();
        $conexion = null;
        $sentencia = null;
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"] =  "No hay profesores de guardia";
    }

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}
?>
