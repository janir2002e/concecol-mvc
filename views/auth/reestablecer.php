<main class="auth">
    <h2 class="auth_heading"><?php echo $titulo ?></h2>
    <p class="auth__textoc">Escribe tu nuevo password</p>

    <?php
        require_once __DIR__ . '/../templates/alertas.php';
    ?>

    <?php if($token_valido) { ?>
        <form  method="POST" class="formulario" novalidate>
            <div class="formulario__campo">
                <label class="formulario__label" for="password">Password:</label>
                <input 
                    type="password" 
                    name="password"
                    id="password"
                    class="formulario__input"
                    placeholder="Tu nuevo password"
                />

            </div>

            <input class="formulario__submit" type="submit" value="Guardar Password">

        </form>
    <?php } ?>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes una cuenta? Iniciar Sesión</a>
        <a href="/registro"  class="acciones__enlace">¿Aún no tienes una cuenta? Obtener una</a>
    </div>
</main>