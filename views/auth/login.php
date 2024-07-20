<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>

    <?php 
        require_once __DIR__ . '/../templates/alertas.php';
    ?>

    <form class="formulario" method="POST" action="/login" novalidate>
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email:</label>
            <input 
                type="email" 
                name="email"
                id="email" 
                placeholder="Tu Email" 
                class="formulario__input"
            />
        </div>

        <div class="formulario__campo">
            <label for="password" class="formulario__label">Password:</label>
            <input 
                type="password" 
                name="password"
                id="password" 
                placeholder="Tu Password" 
                class="formulario__input"
            />
        </div>

        <input class="formulario__submit" type="submit" value="Iniciar Sesión">
    </form>
    
    <div class="acciones">
        <a href="/registro" class="acciones__enlace">Crea Tu cuenta</a>
        <a href="/olvide" class="acciones__enlace">¿Olvidaste Tu Password?</a>
    </div>

</main>