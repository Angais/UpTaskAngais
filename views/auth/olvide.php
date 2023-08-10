<div class="contenedor olvide">
<?php include_once __DIR__ . "/../templates/nombre-sitio.php"; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Solicita recuperar tu Contraseña</p>
        <?php include_once __DIR__ . "/../templates/alertas.php"; ?>

        <form action="/olvide" class="formulario" method="POST">

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email">
            </div>

            <input type="submit" class="boton" value="Solicitar">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
            <a href="/crear">Crear Cuenta</a>
        </div>
    </div> <!--Contenedor -->

</div>