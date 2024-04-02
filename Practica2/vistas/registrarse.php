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
    <p>
        <label for="foto">Incluir mi foto (MAX 500 KB)</label>
        <input type="file" name="foto" accept="image/*">
        <?php
            if(isset($_POST["btnGuardar"]) && $error_foto){
                if(!explode("." , $_FILES["foto"]["tmp_name"])){
                    echo "<span class='error'>El archivo debe tener extensión</span>";
                } elseif(!getimagesize($_FILES["foto"]["tmp_name"])){
                    echo "<span class='error'>El archivo debe ser una imagen</span>";
                } elseif($_FILES["foto"]["size"] > 500*1024){
                    echo "<span class='error'>El archivo debe ser menor de 500 KB</span>";
                } else {
                    echo "<span class='error'>Error al subir el archivo</span>";
                }
            }
        ?>
    </p>
    <!-- suscribirse -->
    <p>
        <input type="checkbox" name="suscrito" <?php if(isset($_POST["suscrito"])) echo "checked"?>>
        <label for="suscrito">Suscribirme al boletín de novedades</label>
        <?php 
            if(isset($_POST["btnGuardar"]) && $error_suscrito){
                echo "<span class='error'>Campo obligatorio</span>";
            }
        ?>
    </p>
    <!-- botones -->
    <button name="btnGuardar">Guardar</button>
    <button name="btnBorrar">Borrar</button>
</form>