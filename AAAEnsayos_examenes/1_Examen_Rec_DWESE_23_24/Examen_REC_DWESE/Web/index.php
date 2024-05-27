<?php
    session_name("ExamenRec_SW_23_24");
    session_start();

    require "./src/constantes.php";

    if(isset($_POST["btnSalir"])){
        $datos_env["api_session"];
        $url_salir = DIR_SERV."/salir";
        consumir_servicios_REST($url_salir, "POST", $datos_env);

        session_destroy();
        header("Location:index.php");
        exit;
    }

    if(isset($_SESSION["usuario"])){
        //seguridad
        require "./src/seguridad.php";

        //continua la app
        require "./vistas/vista_examen.php";

    } else {
        require "./vistas/vista_login.php";
    }

?>
