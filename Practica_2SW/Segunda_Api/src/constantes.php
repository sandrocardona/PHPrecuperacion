<?php
    //Variables constantes
    define("SERVIDOR_BD","localhost");
    define("USUARIO_BD","jose");
    define("CLAVE_BD","josefa");
    define("NOMBRE_BD","bd_rec_cv");
    
    
    define("MINUTOS",55);
    
    define("FOTO_DEFECTO","no_imagen.jpg");

    /* ===== FUNCIONES ===== */


    //insertar usuario

    function insertar_usuario($nombre, $usuario, $clave, $dni, $sexo, $suscripcion){
        try{
            $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        }
    
        catch(PDOException $e){
            $respuesta["error"]="Imposible conectar a la BD en insertar_usuario(). Error:".$e->getMessage();
            return $respuesta;
        }
    
        try{
            $consulta = "INSERT INTO usuarios(nombre,usuario,clave,dni,sexo,suscripcion) values(?,?,?,?,?,?)";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$nombre, $usuario, $clave, $dni, $sexo, $suscripcion]);

            $respuesta["ultm_id"] = $conexion->lastInsertId();

            return $respuesta;
        }
        
        catch(PDOException $e){
            $conexion=null;
            $sentencia=null;
            $respuesta["error"]="Imposible realizar la consulta en instertar_usuario(). Error:".$e->getMessage();
            return $respuesta;
        }

        $sentencia=null;
        $conexion=null;
    }

    //actualizar foto

    function actualizar_foto($id_usuario, $nombre_foto){
        try{
            $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        }
    
        catch(PDOException $e){
            $respuesta["error"]="Imposible conectar a la BD en actualizar_foto(). Error:".$e->getMessage();
            return $respuesta["error"];
        }
    
        try{
            $consulta = "UPDATE usuarios SET foto=? WHERE id_usuario=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$id_usuario, $nombre_foto]);

            $respuesta["mensaje"] = "Foto actualizada con éxito";
            return $respuesta;
        }
        
        catch(PDOException $e){
            $conexion=null;
            $sentencia=null;
            $respuesta["error"]="Imposible realizar la consulta en actualizar_foto(). Error:".$e->getMessage();
            return $respuesta;
        }

        $sentencia=null;
        $conexion=null;
    }

?>