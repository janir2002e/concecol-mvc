<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>

    <?php 
        require_once __DIR__ . '/../templates/alertas.php';
    ?>
    
    <form class="formulario" method="POST" action="/registro" novalidate>
        <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Nombre:</label>
            <input 
                type="text" 
                name="nombre" 
                id="nombre"
                placeholder="Escribe tu Nombre"
                class="formulario__input"
                value="<?php echo $usuario->nombre; ?>"
            >
        </div>

        <div class="formulario__campo">
            <label for="apellido" class="formulario__label">Apellido:</label>
            <input 
                type="text" 
                name="apellido" 
                id="apellido"
                placeholder="Escribe tu Apellido"
                class="formulario__input"
                value="<?php echo $usuario->apellido ?>"
            >
        </div>

        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email:</label>
            <input 
                type="email" 
                name="email" 
                id="email"
                placeholder="Escribe tu Email"
                class="formulario__input"
                value="<?php echo $usuario->email; ?>"
            >
        </div>

        <div class="formulario__campo">
            <label for="password" class="formulario__label">Password:</label>
            <input 
                type="password" 
                name="password" 
                id="password"
                placeholder="Password" 
                class="formulario__input"
            >
        </div>

        <div class="formulario__campo">
            <label for="password__confirmation" class="formulario__label">Confirmar Password:</label>
            <input 
                type="password" 
                name="password__confirmation" 
                id="password__confirmation"
                placeholder="Confirma tu Password" 
                class="formulario__input"
            >
        </div>

        <input class="formulario__submit" type="submit" value="Crear">
        
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">Iniciar Sesión</a>
        <a href="/olvide" class="acciones__enlace">¿Olvidaste Tu Password?</a>
    </div>
</main>