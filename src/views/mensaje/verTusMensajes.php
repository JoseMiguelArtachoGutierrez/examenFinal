
    <table>
        <tr>
            <td>De</td>
            <td>Asunto</td>
            <td>Fecha</td>
            <td>Operaciones</td> 
        </tr>
        <?php
        foreach ($mensajes as $mensaje):if($_SESSION["identity"]->email == $mensaje['para']):?>
        <tr>
            <td><?=$mensaje['de']?></td>
            <td><?=$mensaje['asunto']?></td>
            <td><?=$mensaje['fecha']?></td>
            <td><a href="<?= BASE_URL ?>Mensaje/eliminar/<?= $mensaje['id'] ?>">Eliminar</a></td>
        </tr>
        <?php endif;endforeach;?>

    </table>

