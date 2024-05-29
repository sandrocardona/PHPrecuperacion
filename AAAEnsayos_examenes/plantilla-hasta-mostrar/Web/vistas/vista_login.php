<?php
if(isset($_POST["btnEntrar"]))
{
    $error_usuario=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_form=$error_usuario||$error_clave;
    if(!$error_form)
    {
        $datos_env["usuario"]=$_POST["usuario"];
        $datos_env["clave"]=md5($_POST["clave"]);
        $respuesta=consumir_servicios_REST(DIR_SERV."/login","POST",$datos_env);
        $json=json_decode($respuesta,true);
        if(!$json)
        {
            session_destroy();
            die(error_page("Práctica ExamenRec_Horarios_SW_23_24","<h1>Práctica ExamenRec_Horarios_SW_23_24</h1><p>Sin respuesta oportuna de la API login</p>"));  
        }
        if(isset($json["error_bd"]))
        {
            session_destroy();
            die(error_page("Práctica ExamenRec_Horarios_SW_23_24","<h1>Práctica ExamenRec_Horarios_SW_23_24</h1><p>".$json["error_bd"]."</p>"));
        }

        if(isset($json["usuario"]))
        {
            $_SESSION["usuario"]=$json["usuario"]["usuario"];
            $_SESSION["clave"]=$json["usuario"]["clave"];
            $_SESSION["ultm_accion"]=time();
            $_SESSION["api_session"]=$json["api_session"];

            header("Location:index.php");
            exit();
        }
        else
            $error_usuario=true;

    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen Recuperación</title>
</head>
<body>
    <h1>Gestión de Guardias</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
            <?php
            if(isset($_POST["btnEntrar"])&& $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'> Campo vacío</span>";
                else
                    echo "<span class='error'> Usuario y/o Contraseña no válidos</span>";
            }
                
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave">
            <?php
            if(isset($_POST["btnEntrar"])&& $error_clave)
                echo "<span class='error'> Campo vacío</span>";
            ?>
        </p>
        <p>
            <button type="submit" name="btnEntrar">Entrar</button> 
          
        </p>
    </form>
    <?php
    if(isset($_SESSION["seguridad"]))
    {
        echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
        session_destroy();
    }

    ?>
    
</body>
</html>