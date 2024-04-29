<?php
    //Variables constantes
        define("DIR_BD", "Localhost");
        define("NAME_BD", "bd_libreria_exam");
        define("USER_BD", "jose");
        define("PWD_BD", "josefa");

    //Funciones
        function error_page($title, $body)
        {
            $html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
            $html .= '<title>' . $title . '</title></head>';
            $html .= '<body>' . $body . '</body></html>';
            return $html;
        }
?>