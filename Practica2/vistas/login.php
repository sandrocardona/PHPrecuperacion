<h1>Práct Rec 2</h1>
    <form action="index.php" method="post">
        <!-- usuario -->
        <p>
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
            <?php
                if(isset($_POST["btnEntrar"]) && $error_usuario){
                    echo "<span class='error'>Campo vacío</span>";
                }
            ?>
        </p>
        <!-- contraseña -->
        <p>
            <label for="clave">Contraseña</label>
            <input type="password" name="clave">
            <?php
                if(isset($_POST["btnEntrar"]) && $error_clave){
                    echo "<span class='error'>Campo vacío</span>";
                }
            ?>
        </p>
        <button name="btnEntrar">Entrar</button>
        <button name="btnRegistrarse">Registrarse</button>
    </form>