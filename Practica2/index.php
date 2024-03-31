<?php
if(isset($_POST["btnEntrar"])){
    
    $error_usuario=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";
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
    </style>
</head>
<body>
    <?php
    if(isset($_POST["btnRegistrarse"])){

        require "./vistas/registrarse.php";

    } else {

        require "./vistas/login.php";
        
    }
    ?>
</body>
</html>