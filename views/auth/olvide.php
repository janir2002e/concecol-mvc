<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>

    <?php 
        require_once __DIR__ . '/../templates/alertas.php';
    ?>

    <form class="formulario" action="/olvide" method="POST" novalidate>
        <div class="formulario__campo">
            <label class="formulario__label" for="email">Email</label>
            <input 
                type="email"
                name="email"
                id="email"
                placeholder="Tu email"
                class="formulario__input"
            />
        </div>

        <input type="submit" class="formulario__submit" value="Enviar Instrucciones">
        
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes una cuenta? Iniciar Sesión</a>
        <a href="/registro" class="acciones__enlace">¿Aún no tienes una cuenta? Obtener una</a>
    </div>

</main>