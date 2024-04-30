<?php
    //Variables constantes
        define("SERVIDOR_BD", "localhost");
        define("NOMBRE_BD", "bd_libreria_exam");
        define("USUARIO_BD", "jose");
        define("CLAVE_BD", "josefa");

        define("MINUTOS", 55);

    //Funciones
        function error_page($title, $body)
        {
            $html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
            $html .= '<title>' . $title . '</title></head>';
            $html .= '<body>' . $body . '</body></html>';
            return $html;
        }
?>