<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TiendaAcA</title>
</head>
<body>
<h1>Mandar mensaje</h1>
<?php
if (isset($_SESSION['registerMensaje'])) {
    if ( $_SESSION['registerMensaje']=="failed") {
        echo "<p>Ha habido un error en su mensaje no se a podido mandar un mensaje</p>";
    }else{
        echo "<p>Su mensaje se a mandado con exito</p>";
    }
    unset($_SESSION['registerMensaje']);
}
?>

<a href="<?=BASE_URL?>DashBoard/index">Cancelar</a><br>

<form action="<?=BASE_URL?>Mensaje/registro/" method="post">
    <input type="text" name="data[de]" value="<?= $_SESSION['identity']->nombreUsuario ?>" style="display: none;">
    <label>Asunto: </label>
    <input type="text" name="data[asunto]" require value=""><br>
    <label>Cuerpo: </label>
    <input type="text" name="data[cuerpo]" require value=""><br>
    <label>Para: </label>
    <select require name="data[para]">
        <option value="" selected>Ningun usuario seleccionado</option>
        <?php foreach($usuarios as $usuario):?>
                <option value="<?= $usuario['email']?>"><?= $usuario['email']?></option>
        <?php endforeach;?>
    </select>
    <input type="text" name="data[fecha]" value="<?= date("Y-m-d")?>" style="display: none;"><br>
    <br><input type="submit" value="Registrarse">
</form>
</body>
</html>

