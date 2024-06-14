<?php
    if(isset($_POST["btnLogin"])){
        $error_usuario = $_POST["usuario"]=="";
        $error_clave = $_POST["clave"]=="";

        $error_form = $error_clave || $error_usuario;
        if(!$error_form){
            $datos["usuario"] = $_POST["usuario"];
            $datos["clave"] = md5($_POST["clave"]);

            $url_login = DIR_SERV."/login";
            $respuesta = consumir_servicios_REST($url_login, "POST", $datos);
            $json_login = json_decode($respuesta, true);
            if(!$json_login){
                session_destroy();
                die(error_page("NO OBJ","no hay obj en login: ".$url_login));
            }

            if(isset($json_login["error"])){
                session_destroy();
                die(error_page("ERROR","error en login: ".$json_login["error"]));
            }

            if(isset($json_login["mensaje"])){
                $error_usuario = true;
            } else {
                $_SESSION["usuario"] = $json_login["usuario"]["usuario"];
                $_SESSION["clave"] = $json_login["usuario"]["clave"];
                $_SESSION["ult_accion"] = time();
                $_SESSION["api_session"] = $json_login["api_session"];

                header("Location:index.php");
                exit();
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <style>
        .error{
            color: red;
            font-weight: bold;
        }
        .mensaje{
            font-size: 2rem;
            color: blue;
        }
    </style>
</head>
<body>
    <h1>Examen Final PHP</h1>
    <form action="index.php" method="post">
        <!-- usuario -->
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
            <?php
            if(isset($_POST["btnLogin"]) && $error_usuario){
                if($_POST["usuario"] == "")
                    echo "<span class='error'>Campo vacío</span>";
                else
                    echo "<span class='error'>Usuario/clave incorrectos</span>";
            }
            ?>
        </p>
            <!-- clave -->
            <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave">
            <?php
            if(isset($_POST["btnLogin"]) && $error_clave){
                echo "<span class='error'>Campo vacío</span>";
            }
            ?>
        </p>
        <button type="submit" name="btnLogin">Login</button>
    </form>
    <?php
    
    if(isset($_SESSION["seguridad"])){
        echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
    }
    
    ?>
</body>
</html>