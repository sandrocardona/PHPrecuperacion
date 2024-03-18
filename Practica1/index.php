<?php
if(isset($_POST["btnGuardar"])){
    $error_usuario=$_POST["usuario"]=="";
    $error_nombre=$_POST["nombre"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_dni=$_POST["dni"]=="";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 1</title>
    <style>
        .error{color: red;}
    </style>
</head>
<body>
    <h1>Rellena tu CV</h1>
    <form action="index.php" method="post">
        <!-- Usuario -->
        <p>
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
            <?php 
            if(isset($_POST["btnGuardar"]) && $error_usuario){
                echo "<span class='error'>Campo obligatorio</span>";
            }
            ?>
        </p>
        <!-- nombre -->
        <p>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"] ?>">
            <?php 
            if(isset($_POST["btnGuardar"]) && $error_nombre){
                echo "<span class='error'>Campo obligatorio</span>";
            }
            ?>
        </p>
        <!-- contraseña -->
        <p>
            <label for="clave">Clave</label>
            <input type="password" name="clave">
            <?php 
            if(isset($_POST["btnGuardar"]) && $error_clave){
                echo "<span class='error'>Campo obligatorio</span>";
            }
            ?>
        </p>
        <!-- DNI -->
        <p>
            <label for="dni">DNI</label>
            <input type="text" name="dni" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"] ?>">
            <?php 
            if(isset($_POST["btnGuardar"]) && $error_dni){
                echo "<span class='error'>Campo obligatorio</span>";
            }
            ?>
        </p>
        <!-- sexo -->
        <p>
            <!-- Hombre -->
            <label for="hombre">Hombre</label>
            <input type="radio" name="sexo" value="hombre" checked>
            <!-- mujer -->
            <label for="mujer">Mujer</label>
            <input type="radio" name="sexo" value="mujer">
        </p>
        <!-- Subir archivo -->
        <p>
            Incluir mi foto (Máx 500KB) <button name="btnSubir">Seleccionar archivo</button>
            <?php ?>
        </p>
        <!-- Suscribirse -->
        <p>
            <input type="radio" name="suscrito">
            <label for="suscrito">Suscribirme al boletín de novedades</label>
        </p>
        <!-- botones formulario -->
        <p>
            <button name="btnGuardar" type="submit">Guardar</button>
            <button name="btnBorrar" type="submit">Borrar</button>
        </p>
    </form>
</body>
</html>