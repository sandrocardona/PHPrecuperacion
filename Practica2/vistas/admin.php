<h1>Vista de Admin</h1>
<p>Bienvenido <?php echo "<strong>".$_SESSION["usuario"]."</strong>"?></p>
<form action="index.php" method="post">
    <button name="btnSalir">Salir</button>
</form>