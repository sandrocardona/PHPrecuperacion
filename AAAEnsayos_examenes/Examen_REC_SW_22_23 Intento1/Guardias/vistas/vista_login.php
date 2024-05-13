<?php

if(isset($_POST["btnLogin"])){
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_clave;
    if(!isset($error_form)){
        
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