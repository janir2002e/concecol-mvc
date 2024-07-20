<div class="contenedor-autos">
    <?php foreach ($automoviles as $key => $automovil) { ?>
    
    <div class="auto-grid">
        <picture>
            <source srcset="<?php echo $_ENV['HOST'] . '/img/automoviles/' . $automovil->fotouno; ?>.webp" type="image/webp">
            <source srcset="<?php echo $_ENV['HOST'] . '/img/automoviles/' . $automovil->fotouno; ?>.png" type="image/png">
            <img class="auto-grid__imagen" loading="lazy" width="400" height="350" src="<?php echo $_ENV['HOST'] . '/img/automoviles/' . $automovil->fotouno; ?>.png" alt="Imagen Auto">
        </picture>

        <div class="contenido-auto">
            <h3 class="heading cortar"><?php echo $automovil->version; ?></h3>
            <p class="descripcion"><?php echo $automovil->descripcion; ?></p>
            <p class="precio">Precio: $<?php echo $automovil->precio; ?></p>

            <ul class="caracteristas reset_list">
                <li>Cambio:<br><?php echo $automovil->cambio; ?></li>
                <li>Combustible: <?php echo $automovil->combustible; ?></li>
            </ul>
        </div>

        <a href="/automovil?id=<?php echo $automovil->id; ?>" class="boton-verde-block">
            Ver Automovil
        </a>
    </div>
        
    <?php } ?>

</div>