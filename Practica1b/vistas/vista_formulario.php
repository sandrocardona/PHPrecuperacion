<h1>Segundo Formulario</h1>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <!-- NOMBRE -->
        <p>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"] ?>">
            <?php
                if(isset($_POST["btnEnviar"])&& $error_nombre){
                    echo "<span class='error'>*Campo obligatorio*</span>";
                }
            ?>
        </p>
        <!-- CIUDAD -->
        <p>
            <label for="nacido">Nacido en :</label>
            <select name="nacido" id="nacido">
                <option value="malaga" <?php if(isset($_POST["nacido"])&& $_POST["nacido"]=="malaga") echo "selected"?>>Málaga</option>
                <option value="cadiz" <?php if(isset($_POST["nacido"])&& $_POST["nacido"]=="cadiz") echo "selected"?>>Cádiz</option>
                <option value="granada<?php if(isset($_POST["nacido"])&& $_POST["nacido"]=="granada") echo "selected"?>">Granada</option>
            </select>
        </p>
        <!-- SEXO -->
        <p>
            Sexo:
            <label for="hombre">Hombre</label>
            <input type="radio" id="hombre" name="sexo" value="hombre" <?php if(isset($_POST["sexo"])&& $_POST["sexo"]=="hombre") echo "checked"?>>
            <label for="mujer">Mujer</label>
            <input type="radio" id="mujer" name="sexo" value="mujer" <?php if(isset($_POST["sexo"])&& $_POST["sexo"]=="mujer") echo "checked"?>>
            <?php
                if(isset($_POST["btnEnviar"])&& $error_sexo){
                    echo "<span class='error'>*Campo obligatorio*</span>";
                }
            ?>
        </p>
        <!-- AFICIONES -->
        <p>
            Aficiones:
            <label for="deportes">Deportes</label>
            <input type="checkbox" id="deportes" name="aficiones[]" value="deportes" <?php if(isset($_POST["aficiones"])&& in_array("deportes", $_POST["aficiones"])) echo "checked";?>>
            <label for="lectura">Lectura</label>
            <input type="checkbox" id="lectura" name="aficiones[]" value="lectura" <?php if(isset($_POST["aficiones"])&& in_array("lectura", $_POST["aficiones"])) echo "checked";?>>
            <label for="otros">Otros</label>
            <input type="checkbox" id="otros" name="aficiones[]" value="otros" <?php if(isset($_POST["aficiones"])&& in_array("otros", $_POST["aficiones"])) echo "checked";?>>
        </p>
        <!-- COMENTARIOS -->
        <p>
            <label for="comentarios">Comentarios:</label>
            <textarea id="comentarios" name="comentarios" ><?php if(isset($_POST["comentarios"])) echo $_POST["comentarios"]?></textarea>
            <?php
                if(isset($_POST["btnEnviar"])&& $error_comentarios){
                    echo "<span class='error'>*Campo obligatorio*</span>";
                }
            ?>
        </p>
        <!-- FOTO -->
        <p>
            <label for="archivo">Incluir mi foto (Archivo de tipo imagen Máx 500KB)</label>
            <input class="oculta" type="file" id="archivo" onchange="document.getElementById('nombre_archivo').innerHTML=' '+document.getElementById('archivo').files[0].name;" name="archivo"accept="image/*" >
            <button onclick="event.preventDefault(); document.getElementById('archivo').click();">Examinar</button>
            <span id="nombre_archivo">
            <?php
                    if (isset($_POST["btnEnviar"]) && $error_archivo) {
                        
                            if ($_FILES["archivo"]["name"] == "") {
                                echo " <span class='error'> debes de seleccionar un archivo</span>";
                            }
                            else if ($_FILES["archivo"]["error"]) {
                                echo " <span class='error'> No se ha podido subir el archivo al servidor</span>";
                            } elseif (!getimagesize($_FILES["archivo"]["tmp_name"])) {

                                echo " <span class='error'>El archivo subido debe de ser una imagen </span>";
                            } elseif(!explode(".",$_FILES["archivo"]["name"])) {
                                echo " <span class='error'> El archivo tiene que tener extension</span>";
                            }else{
                                echo " <span class='error'> El archivo seleccionado supera los 500 KB MAX</span>";
                            }
                        }
                    
                    ?>
                    </span>
        </p>
        <p>
            <input type="submit"  name="btnEnviar" value="Enviar">
            <input type="submit"  name="btnBorrar" value="Borrar">
        </p>
    </form>