<?php

require "./src/constantes.php";

session_name("Practica2index");
session_start();

if(isset($_POST["btnEntrar"])){
    
    $error_usuario=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";

    if(!$error_usuario || !$error_clave){
        $datos = [$_POST["usuario"], md5($_POST["clave"])];
        require "./src/conexion.php";
    }
}


if(isset($_POST["btnGuardar"])){
    $error_usuario=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_nombre=$_POST["nombre"]=="";
    $error_dni=$_POST["dni"]=="" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !explode("." , $_FILES["foto"]["tmp_name"]) || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500*1024);

    $error_form = $error_usuario || $error_nombre || $error_clave || $error_dni || $error_foto;
    if(!$error_form){
        $datos = [$_POST["usuario"], $_POST["clave"], $_POST["nombre"], $_POST["dni"], $_POST["sexo"], $_FILES["foto"], $_POST["suscrito"]];
    }
    
}

if(isset($_POST["btnSalir"])){
    session_destroy();
    header("Location:index.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 2</title>
    <style>
        .error{color: red;font-weight: bold;}
        img{width: 200px;}
    </style>
</head>
<body>
    <?php

    if(isset($_SESSION["usuario"])){

        if($_SESSION["tipo"]=="normal"){
            require "./vistas/normal.php";
        } else {
            require "./vistas/admin.php";
        }

    } else {

        if(isset($_POST["btnRegistrarse"])){
            require "./vistas/registrarse.php";
        } else {
            require "./vistas/login.php";
            if(isset($respuesta["mensaje"])){
                echo "<p class='error'>".$respuesta["mensaje"]."</p>";
            }
        }
    }

    ?>
</body>
</html>