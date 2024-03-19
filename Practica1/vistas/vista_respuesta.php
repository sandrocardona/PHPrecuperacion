<h1>Datos del usuario</h1>
<p><strong>Usuario: </strong></p>
<p><strong>Nombre: </strong></p>
<p><strong>Contraseña: </strong></p>
<p><strong>DNI: </strong></p>
<p><strong>Sexo: </strong></p>
<p><strong>Suscripción: </strong></p>

<?php
if($_FILES["foto"]["name"]!=""){

    $array_ext = explode(".", $_FILES["foto"]["name"]);
    $ext = ".".strtolower(end($array_ext));
    $nombre_nuevo = md5(uniqid(uniqid(), true));
    $nombre_archivo = $nombre_nuevo.$ext;

    @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "images/".$nombre_archivo);

    if($var){

    } else {
        echo "<p><strong>Foto: </strong> No se ha podido mover la imagen a la carpeta destino</p>";
    }
    
} else {
    echo "<p><strong>Foto: </strong> No seleccionada</p>";
}

?>