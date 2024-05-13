<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Home</title>
</head>
<body>
    <h1>Gestión de Guardias</h1>
    <div>
        <p>Bienvenido <?php $_SESSION["usuario"] ?></p>
        <form action="index.php" method="post">
            <button name="btnSalir">Salir</button>
        </form>
    </div>
</body>
</html>