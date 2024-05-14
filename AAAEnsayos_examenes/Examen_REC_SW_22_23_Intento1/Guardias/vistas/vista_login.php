<?php

if(isset($_POST["btnLogin"])){
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_clave;
    if(!$error_form){

        $url = DIR_SERV."/login";
        $datos["usuario"] = $_POST["usuario"];
        $datos["clave"] = md5($_POST["clave"]);

        $respuesta = consumir_servicios_REST($url, "POST", $datos);
        $obj = json_decode($respuesta);

        //si no existe objeto, destruir sesión y devolver respuesta
        if(!$obj){
            session_destroy();
            die(error_page("NO OBJ", "NO OBJ", "No hay objeto en vista_login: ".$respuesta));
        }
        //si existe objeto->error destruir sesión y devolver respuesta
        if(isset($obj->error)){
            session_destroy();
            die(error_page("OBJ ERROR", "OBJ ERROR", "ERROR en vista_login: ".$obj->error));
        }

        if(isset($obj->mensaje)){
            $error_form = true;
        } else {
            //si no existe ninguno de los errores anteriores, asigno los valores a las sessiones
            $_SESSION["usuario"] = $datos["usuario"];
            $_SESSION["clave"] = $datos["clave"];
            $_SESSION["ult_accion"] = time();

            $_SESSION["api_session"] = $obj->api_session;

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
    <title>Document</title>
    <style>
        .error{color: red; font-weight: bold;}
    </style>
</head>
<body>
    <h1>Gestión de Guardias</h1>
    <div>
        <form action="index.php" method="post">
            <!-- usuario -->
            <p>
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
                <?php
                    if(isset($_POST["btnLogin"])){
                        if($_POST["usuario"] == "")
                            echo "<span class='error'>Campo vacío</span>";
                        else
                            echo "<span class='error'>Usuario o clave incorrectos</span>";
                    }
                ?>
            </p>
            <!-- contraseña -->
            <p>
                <label for="clave">Contraseña</label>
                <input type="text" name="clave" id="clave">
                <?php
                    if(isset($_POST["btnLogin"])){
                        if($_POST["clave"] == "")
                            echo "<span class='error'>Campo vacío</span>";
                    }
                ?>
            </p>
            <button name="btnLogin">Login</button>
        </form>
    </div>
</body>
</html>