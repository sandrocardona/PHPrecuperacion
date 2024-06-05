<h1>DATOS ENVIADOS</h1>
<p>El nombre enviado ha sido: <strong><?php echo $_POST["nombre"]?></strong></p>
<p>Nacido en: <strong><?php echo $_POST["nacido"]?></strong></p>
<p>El sexo es: <strong><?php echo $_POST["sexo"]?></strong></p>
<?php
    if(isset($_POST["aficiones"]))
    {
        echo "<p>Las aficiones marcadas son:</p>";
        echo"<ol>";
        for ($i=0; $i <count($_POST["aficiones"]) ; $i++) { 
            echo "<li>".$_POST["aficiones"][$i]."</li>";
        }
        echo"</ol>";

    }
    else{
        echo"<p>No has seleccionado ninguna afición</p>";
    }

    echo "<p>El comentario realizado  ha sido: <strong>".$_POST["comentarios"]."</strong></p>";

    if($_FILES["archivo"]["name"]!="")
    {
        $array_ext=explode(".",$_FILES["archivo"]["name"]);
        $ext=".".strtolower(end($array_ext));
        $nombre_nuevo=md5(uniqid(uniqid(),true));
        $nombre_archivo=$nombre_nuevo.$ext;
        @$var=move_uploaded_file($_FILES["archivo"]["tmp_name"],"images/".$nombre_archivo);


        echo "<h3>Foto</h3>";
        echo "<p><strong>Nombre: </strong>" . $_FILES["archivo"]["name"] . "</p>";
        echo "<p><strong>Tipo: </strong>" . $_FILES["archivo"]["type"] . "</p>";
        echo "<p><strong>Tamanio: </strong>" . $_FILES["archivo"]["size"] . "</p>";
        echo "<p><strong>Error: </strong>" . $_FILES["archivo"]["error"] . "</p>";
        echo "<p><strong>El tmp_name: </strong>" . $_FILES["archivo"]["tmp_name"] . "</p>";
        echo "<p>La imagen subida con exito</p>";
        echo "<p><img class='tan_img' src='images/" . $nombre_archivo . "' alt='Foto' title='Foto'/></p>";
    } else {
        echo "<span> No se ha podido mover la imgen a la carpeta destino en el servidor</span>";


    }
?>