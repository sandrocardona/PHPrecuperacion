<?php
    if(isset($_POST["btnLogin"])){
        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";
        $error_form = $error_usuario || $error_clave;

        if(!$error_form){
            $datos["usuario"] = $_POST["usuario"];
            $datos["clave"] = md5($_POST["clave"]);
            $url_login = DIR_SERV."/login";
            $respuesta = consumir_servicios_REST($url_login, "POST", $datos);
            $obj_login = json_decode($respuesta, true);

            if(!$obj_login){
                session_destroy();
                die(error_page("NO OBJ", "NO HAY OBJ en obj_login".$url_login));
            }

            if(isset($obj_login["error"])){
                session_destroy();
                die(error_page("ERROR", "ERROR en obj_login".$obj_login["error"]));
            }

            if(isset($obj_login["mensaje"])){
                $error_usuario = true;
            } else {

                $_SESSION["usuario"] = $obj_login["usuario"]["usuario"];
                $_SESSION["clave"] = $obj_login["usuario"]["clave"];
                $_SESSION["ult_accion"] = time();
                $_SESSION["api_session"] = $obj_login["api_session"];

                if($obj_login["usuario"]["tipo"] == "tutor"){
                    header("Location:index.php");
                    exit;
                } else {
                    header("Location:index.php");
                    exit;
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <style>
        .error{color: red; font-weight: bold;}
    </style>
</head>
<body>
    <h1>Notas de los alumnos</h1>
    <form action="index.php" method="post">
        <!-- usuario -->
         <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"]?>">
            <?php
                if(isset($_POST["btnLogin"]) && $error_usuario){
                    if($_POST["usuario"]=="")
                        echo "<span class='error'>Campo vacío</span>";
                    else
                        echo "<span class='error'>Usuario o contraseña incorrectos</span>";
                }
            ?>
         </p>
        <!-- clave -->
        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave">
            <?php
                if(isset($_POST["btnLogin"]) && $error_clave){
                    echo "<span class='error'>Campo vacío</span>";
                }
            ?>
         </p>
         <button type="submit" name="btnLogin">Login</button>
    </form>
</body>
</html>