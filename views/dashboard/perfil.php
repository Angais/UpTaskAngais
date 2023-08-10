<?php include_once __DIR__ . "/header-dashboard.php"; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <div class="contenedor-enlace">
        <a href="/cambiar-password" class="enlace">Cambiar Contraseña</a>
    </div>

    <form class="formulario" method="POST" action="/perfil">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" placeholder="Nombre de Usuario" value="<?php echo $usuario->nombre ?>">
        </div>
        <div class="campo">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Dirección de Correo Electrónico" value="<?php echo $usuario->email ?>">
        </div>

        <input type="submit" value="Guardar">
    </form>
</div>

<?php include_once __DIR__ . "/footer-dashboard.php"; ?>