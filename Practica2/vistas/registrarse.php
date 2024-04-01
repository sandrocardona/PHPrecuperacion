<h1>Práct Rec 2</h1>
<h2>Registrarse</h2>
<form action="index.php">
    <!-- usuario -->
    <p>
        <label for="usuario">Usuario</label><br>
        <input type="text" name="usuario" placeholder="Usuario">
        <?php
        
        ?>
    </p>
    <!-- nombre -->
    <p>
        <label for="nombre">Nombre</label><br>
        <input type="text" name="nombre" placeholder="Nombre">
        <?php
        
        ?>
    </p>
    <!-- contraseña -->
    <p>
        <label for="clave">Contraseña</label><br>
        <input type="text" name="clave" placeholder="Contraseña">
        <?php
        
        ?>
    </p>
    <!-- dni -->
    <p>
        <label for="dni">DNI</label><br>
        <input type="text" name="dni" placeholder="DNI">
        <?php
        
        ?>
    </p>
    <!-- sexo -->
    <p>
        <label><strong>Sexo</strong></label><br>
        <!-- Hombre -->
        <input type="radio" name="sexo" value="hombre" <?php if(!isset($_POST["sexo"]) || isset($_POST["sexo"]) && $_POST["sexo"]=="hombre") echo "checked";?>>
        <label for="hombre">Hombre</label><br>
        <!-- mujer -->
        <input type="radio" name="sexo" value="mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="mujer") echo "checked";?>>
        <label for="mujer">Mujer</label>
    </p>
    <!-- foto -->
    <!-- suscribirse -->
    <!-- botones -->
</form>