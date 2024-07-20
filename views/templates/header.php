<header class="header">
    <div class="header__contenedor">
        <a href="/" class="header__titulo">CONCECOL</a>
        <nav class="navegacion">
            <a href="/automoviles" class="navegacion__enlace <?php echo pagina_actual('/automoviles') ? 'navegacion__enlace--actual' : ''; ?>">Automovíles</a>
            <a href="/consejos" class="navegacion__enlace <?php echo pagina_actual('/consejos') ? 'navegacion__enlace--actual' : ''; ?>">Tips o Consejos</a>
            <a href="/contacto" class="navegacion__enlace <?php echo pagina_actual('/contacto') ? 'navegacion__enlace--actual' : ''; ?>">Contacto</a>
            <?php if(is_auth()) { ?>
                <form method="POST" action="/logout" class="dashboard__form">
                    <input type="submit" value="Cerrar Sesión" class="navegacion__enlace">
                </form>
            <?php } else { ?>
                <a href="/login" class="navegacion__enlace <?php echo pagina_actual('/login') ? 'navegacion__enlace--actual' : ''; ?>">Iniciar Sesión</a>
            <?php } ?>            
           
        </nav>
    </div>
</header>