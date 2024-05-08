<?php
    //Variables constantes
    define("SERVIDOR_BD","localhost");
    define("USUARIO_BD","jose");
    define("CLAVE_BD","josefa");
    define("NOMBRE_BD","bd_rec_cv");
    
    
    define("MINUTOS",55);
    
    define("FOTO_DEFECTO","no_imagen.jpg");

    /* ===== FUNCIONES ===== */

    //login
    function login($datos){
        try{
            $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        }
    
        catch(PDOException $e){
            $respuesta["error"]="Imposible conectar a la BD en login(). Error:".$e->getMessage();
            return $respuesta;
        }
    
        try{
            $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
        }
        
        catch(PDOException $e){
            $conexion=null;
            $sentencia=null;
            $respuesta["error"]="Imposible realizar la consulta en login(). Error:".$e->getMessage();
            return $respuesta;
        }

        if($sentencia->rowCount() > 0){

            session_name("API_Pract2_Rec_23_24");
            session_start();

            $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

            $_SESSION["usuario"] = $respuesta["usuario"]["usuario"];
            $_SESSION["clave"] = $respuesta["usuario"]["clave"];
            $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];

            $respuesta["api_key"] = session_id();
        } else {
            $respuesta["mensaje"] = "Usuario no registrado en la BD";
        }

        $sentencia=null;
        $conexion=null;
        
        return $respuesta;
    }

    //logueado
    function logueado($datos){
        try{
            $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        }
    
        catch(PDOException $e){
            $respuesta["error"]="Imposible conectar a la BD en login(). Error:".$e->getMessage();
            return $respuesta;
        }
    
        try{
            $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
        }
        
        catch(PDOException $e){
            $conexion=null;
            $sentencia=null;
            $respuesta["error"]="Imposible realizar la consulta en login(). Error:".$e->getMessage();
            return $respuesta;
        }

        if($sentencia->rowCount() > 0)
            $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        else 
            $respuesta["mensaje"] = "Usuario no registrado en la BD";

        $sentencia=null;
        $conexion=null;
        
        return $respuesta;
    }

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

    // actualizar usuario

    function actualizar_usuario_clave($nombre, $usuario, $clave, $dni, $sexo, $suscripcion, $id_usuario){
        try{
            $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        }
    
        catch(PDOException $e){
            $respuesta["error"]="Imposible conectar a la BD en insertar_usuario(). Error:".$e->getMessage();
            return $respuesta;
        }
    
        try{
            $consulta = "UPDATE INTO usuarios set nombre=?, usuario=?, dni=?, sexo=?, suscripcion=?, WHERE id_usuario=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$nombre, $usuario, $clave, $dni, $sexo, $suscripcion, $id_usuario]);

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

?>