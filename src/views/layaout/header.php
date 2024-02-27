<h1>Header</h1>

<ul>

    <li><a href="<?=BASE_URL?>">Inicio</a></li>
    
    <?php if (isset($_SESSION['identity'])): ?>
        
        <li><a href="<?= BASE_URL ?>Usuario/logout/">Cerrar sesion</a></li>
        <li><a href="<?= BASE_URL ?>Mensaje/indetifica/">Mandar mensaje</a></li>
        <li><a href="<?= BASE_URL ?>Mensaje/mostrarTodos/">Mis mensajes</a></li>
        <p><?php print_r($_SESSION['identity']); ?></p>

    <?php else: ?>
        <li><a href="<?= BASE_URL ?>Usuario/indetifica/">Identificate</a></li>
        <li><a href="<?= BASE_URL ?>Usuario/registro/">Crear cuenta</a></li>
    <?php endif; ?>
</ul>