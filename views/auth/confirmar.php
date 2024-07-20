<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__textoc">Confirma tu cuenta</p>

    <?php if(isset($alertas['exito'])) { ?>
        <?php
            require_once __DIR__ . '/../templates/alertas.php'
        ?>
        
        <div class="acciones acciones--centrar">
            <a href="/login" class="acciones__enlace">Iniciar Sesión</a>
        </div>
    
    <?php } else { ?>
    
        <?php
            require_once __DIR__ . '/../templates/alertas.php'
        ?>

    <?php } ?>
</main