<h2 class="heading"><?php echo $titulo; ?></h2>

<main class="contenedor-auto">
    <div class="auto">
        <div class="auto_imagen_grid">
            <picture>
                <source srcset="<?php echo $_ENV['HOST'] . '/img/automoviles/' . $automovil->fotouno; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'] . '/img/automoviles/' . $automovil->fotouno; ?>.png" type="image/png">
                <img class="auto-grid__imagen" loading="lazy" width="400" height="350" src="<?php echo $_ENV['HOST'] . '/img/automoviles/' . $automovil->fotouno; ?>.png" alt="Imagen Auto">
            </picture>

            <picture>
                <source srcset="<?php echo $_ENV['HOST'] . '/img/automoviles/' . $automovil->fotodos; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'] . '/img/automoviles/' . $automovil->fotodos; ?>.png" type="image/png">
                <img class="auto-grid__imagen" loading="lazy" width="400" height="350" src="<?php echo $_ENV['HOST'] . '/img/automoviles/' . $automovil->fotodos; ?>.png" alt="Imagen Auto">
            </picture>
        </div>


        <div class="contenido-auto">
            <h3 class="heading"><?php echo $automovil->version; ?></h3>
            <p class="texto-j"><?php echo $automovil->descripcion; ?></p>
            <p class="precio">Precio: $<?php echo $automovil->precio; ?></p>

            <ul class="caracteristas reset_list">
                <li>Cambio: <?php echo $automovil->cambio; ?></li>
                <li class="combustible">Combustible: <?php echo $automovil->combustible; ?></li>
            </ul>
        </div>

        <a href="/contacto?id=<?php echo $automovil->id; ?>" class="boton-verde-inline">
            Contáctanos
        </a>
    </div>
</main>