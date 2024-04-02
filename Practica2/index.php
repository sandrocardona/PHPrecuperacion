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


if(isset($_POST["btnRegistrarse"])){

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
        }
    }

    ?>
</body>
</html>