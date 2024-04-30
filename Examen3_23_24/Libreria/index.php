<?php
session_name("Examen3_23_24");
session_start();

if(isset($_POST["btnSalir"])){
    session_destroy();
    header("Location:index.php");
    exit;
}

if(isset($_SESSION["usuario"])){
    if($_SESSION["tipo"]=="admin"){
        header("Location:admin/gest_libros.php");
        exit;
    }
    else
        require "./vistas/vista_normal.php";
    
} else {
    header("Location:index.php");
    exit;
}

?>
