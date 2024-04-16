<?php
if(isset($_POST["btnContBorrar"]))
{
    try{
    
        $consulta = "DELETE from usuarios where id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$_POST["btnContBorrar"]]);
        if($_POST["foto"]!=FOTO_DEFECTO)
            unlink("images/".$_POST["foto"]);

        $_SESSION["mensaje_accion"]="Usuario borrado con éxito";
        header("Location:index.php");
        exit;
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        session_destroy();
        die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:".$e->getMessage()."</p>"));
    }
}




//// Consulta para obtener los usuarios a listar en la Tabla

try{
    
    $consulta = "SELECT * FROM usuarios WHERE tipo<>'admin'";
    $sentencia=$conexion->prepare($consulta);
    $sentencia->execute();
}
catch(PDOException $e){
    $sentencia=null;
    $conexion=null;
    session_destroy();
    die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:".$e->getMessage()."</p>"));
}
$usuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);
$sentencia=null;
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
        table{border-collapse:collapse;}
        table,th,td{border:1px solid black}
        th{background-color:#CCC}
        table td img{height:100px}
        .centrar{ width:80%;margin:0 auto; text-align: center; } 
        .mensaje{font-size: 1.25rem;color:blue}
    </style>
</head>
<body>
    <h1>Práctica Rec 2</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"];?></strong> - 
        <form class="en_linea" action="index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>
    </div>

    <?php
    if(isset($_POST["btnBorrar"]))
    {
        echo "<div class='centrar'>";
        echo "<form method='post' action='index.php'>";
        echo "<input type='hidden' name='foto' value='".$_POST["foto"]."'/>";
        echo "<h2>Borrado del usuario con id: ".$_POST["btnBorrar"]."</h2>";
        echo "<p>¿ Estás seguro ?</p>";
        echo "<p><button type='submit'>No</button> <button type='submit' name='btnContBorrar' value='".$_POST["btnBorrar"]."'>Sí</button></p>";
        echo "</form>";
        echo "</div>";
    }


    if(isset($_SESSION["mensaje_accion"]))
    {
        echo "<p class='mensaje'>".$_SESSION["mensaje_accion"]."</p>";
        unset($_SESSION["mensaje_accion"]);
    }

    echo "<h2>Listado de los usuarios (no admin)</h2>";
    echo "<table class='centrar'>";
    echo "<tr><th>#</th><th>Foto</th><th>Nombre</th><th>Usuario+</th></tr>";
    foreach($usuarios as $tupla)
    {
        echo "<tr>";
        echo "<td>".$tupla["id_usuario"]."</td>";
        echo "<td><img src='images/".$tupla["foto"]."' alt='Foto' title='Foto'></td>";
        echo "<td>".$tupla["nombre"]."</td>";
        echo "<td><form action='index.php' method='post'><input type='hidden' name='foto' value='".$tupla["foto"]."'/><button class='enlace' type='submit' name='btnBorrar' value='".$tupla["id_usuario"]."'>Borrar</button> - Editar</form></td>";
        echo "</tr>";
    }
    echo "</table>";

    ?>
</body>
</html>