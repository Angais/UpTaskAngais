<div class="contenedor reestablecer">
<?php include_once __DIR__ . "/../templates/nombre-sitio.php"; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Reestablecer Contraseña</p>

        <?php include_once __DIR__ . "/../templates/alertas.php"; ?>

        <?php if($mostrar){ ?>

        <form class="formulario" method="POST">
            <div class="campo">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Contraseña">
            </div>

            <input type="submit" class="boton" value="Guardar Contraseña">
        </form>
            <?php } ?>
        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
            <a href="/crear">¿No tienes cuenta? Crea una gratis</a>
        </div>
    </div> <!--Contenedor -->

</div>