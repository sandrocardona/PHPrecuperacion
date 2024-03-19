<h1>Rellena tu CV</h1>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <!-- USUARIO -->
        <p>
            <label for="usuario">Usuario</label><br>
            <input type="text" name="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
            <?php 
            if(isset($_POST["btnGuardar"]) && $error_usuario){
                echo "<span class='error'>Campo obligatorio</span>";
            }
            ?>
        </p>
        <!-- NOMBRE -->
        <p>
            <label for="nombre">Nombre</label><br>
            <input type="text" name="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"] ?>">
            <?php 
            if(isset($_POST["btnGuardar"]) && $error_nombre){
                echo "<span class='error'>Campo obligatorio</span>";
            }
            ?>
        </p>
        <!-- CONTRASEÑA -->
        <p>
            <label for="clave">Clave</label><br>
            <input type="password" name="clave">
            <?php 
            if(isset($_POST["btnGuardar"]) && $error_clave){
                echo "<span class='error'>Campo obligatorio</span>";
            }
            ?>
        </p>
        <!-- DNI -->
        <p>
            <label for="dni">DNI</label><br>
            <input type="text" name="dni" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"] ?>">
            <?php 
            if(isset($_POST["btnGuardar"]) && $error_dni){
                echo "<span class='error'>Campo obligatorio</span>";
            }
            ?>
        </p>
        <!-- SEXO -->
        <p>
            <label><strong>Sexo</strong></label><br>
            <!-- Hombre -->
            <input type="radio" name="sexo" value="hombre" <?php if(!isset($_POST["sexo"]) || isset($_POST["sexo"]) && $_POST["sexo"]=="hombre") echo "checked";?>>
            <label for="hombre">Hombre</label><br>
            <!-- mujer -->
            <input type="radio" name="sexo" value="mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="mujer") echo "checked";?>>
            <label for="mujer">Mujer</label>
        </p>
        <!-- SUBIR ARCHIVO -->
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
        <!-- SUSCRIBIRSE -->
        <p>
            <input type="checkbox" name="suscrito" <?php if(isset($_POST["suscrito"])) echo "checked"?>>
            <label for="suscrito">Suscribirme al boletín de novedades</label>
            <?php 
            if(isset($_POST["btnGuardar"]) && $error_suscrito){
                echo "<span class='error'>Campo obligatorio</span>";
            }
            ?>
        </p>
        <!-- BOTONES FORMULARIO -->
        <p>
            <button name="btnGuardar" type="submit">Guardar</button>
            <button name="btnBorrar" type="submit">Borrar</button>
        </p>
    </form>