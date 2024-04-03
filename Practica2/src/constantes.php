<?php
define("SERVIDOR_BD","localhost");
define("USUARIO_BD","josed");
define("CLAVE_BD","josefa");
define("NOMBRE_BD","bd_rec_cv");

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

?>