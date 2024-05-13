<?php
require "./src/constantes.php";

if(isset($_POST["btnSalir"])){

}

if(isset($_SESSION["usuario"])){
    require "./vistas/vista_home.php";
} else {
    require "./vistas/vista_login.php";
}

?>

