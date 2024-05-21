<?php
session_name("Pract2_libreria_Exam_23_24");
session_start();
require "src/funciones_ctes.php";

if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location:index.php");
    exit();
}


if (isset($_SESSION["usuario"])) {
    $salto="index.php";// variable para realizar el salto de seguridad correcto si hay baneo o errores
    require "src/seguridad.php";    

    if ($datos_usuario_log["tipo"] == "normal")
    {
        require "vistas/vista_normal.php";
    }
        
    else
    {
        header("Location:admin/gest_libros.php");
        exit();
    }
    
} else {
    require "vistas/vista_home.php";
}