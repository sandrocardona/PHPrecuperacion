<?php

if(isset($_POST["btnEntrar"])){
    $error_usuario = $_POST["usuario"]=="";
    $error_clave = $_POST["clave"]=="";

    $error_form = $error_usuario || $error_clave;

    if(!$error_form){
        $datos["usuario"] = $_POST["usuario"];
        $datos["clave"] = md5($_POST["clave"]);

        $url_login = DIR_SERV."/login";
        $respuesta = consumir_servicios_REST($url_login, "POST", $datos);
        $obj_login = json_decode($respuesta);

        if(!$obj_login){
            session_destroy();
            die(error_page("NO OBJ LOGIN","No hay obj login: ".$url_login));
        }

        if(isset($obj_login->error)){
            session_destroy();
            die(error_page("ERROR LOGIN","Error obj login: ".$obj_login->error));
        }

        if(isset($obj_login->mensaje)){
            $error_form = true;
        } else {

            $_SESSION["usuario"] = $datos["usuario"];
            $_SESSION["clave"] = $datos["clave"];
            $_SESSION["ult_accion"] = time();
            $_SESSION["api_session"] = $obj_login->api_session;

            header("Location:index.php");
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intento 1</title>
    <style>
        .error{color: red; font-weight: bold;}
    </style>
</head>
<body>
    <h1>REC 23 24</h1>
    <h2>Gestión de Guardias</h2>
    <form action="index.php" method="post">
        <!-- usuario -->
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario">
            <?php
                if(isset($_POST["btnEntrar"]) && $error_usuario){
                    echo "<span class='error'>Campo vacío</span>";
                }
            ?>
        </p>
        <!-- clave -->
        <p>
            <label for="clave">Contraseña: </label>
            <input type="text" name="clave">
            <?php
                if(isset($_POST["btnEntrar"]) && $error_clave){
                    echo "<span class='error'>Campo vacío</span>";
                }
            ?>
        </p>
        <button type="submit" name="btnEntrar">Enviar</button>
    </form>
</body> 
</html>