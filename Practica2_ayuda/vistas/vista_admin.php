<?php

    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        session_destroy();
        die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>Imposible conectar a la BD. Error:".$e->getMessage()."</p>"));
    }

    try{
        $consulta = "SELECT * FROM usuarios";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    }
    catch(PDOException $e){
        session_destroy();
        die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>Imposible conectar a la BD. Error:".$e->getMessage()."</p>"));
    }

    if($sentencia->rowCount() > 0){
        $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $respuesta = "No hay usuarios registrados en la base de datos";
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 2</title>
    <style>
        .en_linea{display:inline}
        .enlace{border:none;background:none;color:blue;text-decoration:underline;cursor:pointer}
        table{
            width: 80%;
            border: 1px solid black;
            border-collapse: collapse;
            margin: 2rem;
        }

        tr, th, td{
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }

        th{
            background-color: lightblue;
        }

    </style>
</head>
<body>
    <h1>Práctica Rec 2</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"];?></strong> - 
        <form class="en_linea" action="index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>
        <table>
            <tr><th>#</th><th>Foto</th><th>Nombre</th><th>Usuario+</th></tr>
        
            <?php
                if(is_string($respuesta)){
                    echo $respuesta;
                } else {
                    foreach ($respuesta as $tupla) {
                        echo "<tr>";
                        echo "<td>".$tupla["id_usuario"]."</td>";
                        echo "<td>".$tupla["foto"]."</td>";
                        echo "<td>".$tupla["nombre"]."</td>";
                        echo "<td><form><button class='enlace'>Borrar</button><button>Editar</button></form></td>";
                        echo "</tr>";
                    }
                }
            ?>
        </table>
    </div>
</body>
</html>