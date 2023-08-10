<div class="contenedor crear">
<?php include_once __DIR__ . "/../templates/nombre-sitio.php"; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu Cuenta</p>
        <?php include_once __DIR__ . "/../templates/alertas.php"; ?>

        <form action="/crear" class="formulario" method="POST">
        <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $usuario->nombre; ?>"> 
            </div>
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" value="<?php echo $usuario->email; ?>">
            </div>
            <div class="campo">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Contraseña">
            </div>
            <div class="campo">
                <label for="password2">Repetir Contraseña</label>
                <input type="password" id="password2" name="password2" placeholder="Repite tu Contraseña">
            </div>

            <input type="submit" class="boton" value="Crear Cuenta">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
            <a href="/olvide">Recuperar Contraseña</a>
        </div>
    </div> <!--Contenedor -->

</div>