<?php
/* === FUNCIONES === */

/* funciones dni */
function LetraNIF($dni){
    return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni%23, 1);
}

function dni_bien_escrito($texto){
    $dni = strtoupper($texto);
    return strlen($dni)==9 && is_numeric(substr($dni,0,8)) && substr($dni,-1)>="A" && substr($dni,-1)<="Z";
}

function dni_valido($texto){
    $numero=substr($texto,0,8);
    $letra=substr($texto,-1);
    $valido=LetraNIF($numero)==$letra;
    return $valido;
}


/* errores formulario */
if(isset($_POST["btnGuardar"])){
    $error_usuario=$_POST["usuario"]=="";
    $error_nombre=$_POST["nombre"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_dni=$_POST["dni"]=="" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    $error_suscrito=!isset($_POST["suscrito"]);
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !explode("." , $_FILES["foto"]["tmp_name"]) || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500*1024);

    $error_form = $error_usuario || $error_nombre || $error_clave || $error_dni || $error_suscrito;
    if($error_form){
        echo "error en el formulario";
    } else {
        echo "TODO CORRECTO";
    }
}

if(isset($_POST["btnBorrar"])){
    header("Location:index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 1</title>
    <style>
        .error{color: red;}
        img{
            width: 200px;
            height: auto;
        }
    </style>
</head>
<body>
    <?php
        if(isset($_POST["btnGuardar"]) && !$error_form){
            require "vistas/vista_respuesta.php";
        } else {
            require "vistas/vista_formulario.php";
        }
    ?>
</body>
</html>