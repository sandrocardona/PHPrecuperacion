<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Normal</title>
</head>
<body>
    <h1>Notas de los alumnos</h1>
    <p>Bienvenido: <?php echo $_SESSION["usuario"] ?></p>
    <p>Bienvenido: <?php echo $_SESSION["tipo"] ?></p>
    <form action="index.php" method="post"><button type="submit" name="btnSalir">Salir</button></form>
</body>
</html>