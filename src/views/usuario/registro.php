<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mensajeria</title>
</head>
<body>
<?php ?>
<?php ?>
<h1>Registrate</h1>
<a href="<?=BASE_URL?>DashBoard/index">Cancelar</a><br>

<form action="<?=BASE_URL?>Usuario/registro/" method="post">
    <label>Usuario: </label>
    <input type="text" name="data[nombreUsuario]" require value=""><br>
    <label>Correo: </label>
    <input type="email" name="data[email]" require value=""><br>
    <label>Password: </label>
    <input type="password" name="data[password]" require value=""><br>
    <br><input type="submit" value="Registrarse">
</form>
</body>
</html>


