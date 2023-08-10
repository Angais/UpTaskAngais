<?php include_once __DIR__ . "/header-dashboard.php"; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    <div class="contendor-enlace">
        <a href="/perfil" class="enlace">Volver a Perfil</a>
    </div>

    <form class="formulario" method="POST" action="/cambiar-password">
        <div class="campo">
            <label for="password_actual">Contraseña Actual</label>
            <input type="password" name="password_actual" placeholder="Contraseña Actual">
        </div>
        <div class="campo">
            <label for="password_nuevo">Nueva Contraseña</label>
            <input type="password" name="password_nuevo" placeholder="Nueva Contraseña">
        </div>

        <input type="submit" value="Guardar">
    </form>
</div>

<?php include_once __DIR__ . "/footer-dashboard.php"; ?>