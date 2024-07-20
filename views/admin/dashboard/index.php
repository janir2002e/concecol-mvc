<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="autos">
    <div class="autos__listado slider swiper">
        <div class="swiper-wrapper">
            <?php foreach ($automoviles as $key => $automovil) { ?>
                <div class="auto swiper-slide ">
                    <p><?php echo $automovil->modelo; ?></p>
                    <div class="auto__imagen">
                        <picture>
                            <source srcset="<?php echo $_ENV['HOST'] . '/img/automoviles/' . $automovil->fotouno; ?>.webp" type="image/webp">
                            <source srcset="<?php echo $_ENV['HOST'] . '/img/automoviles/' . $automovil->fotouno; ?>.png" type="image/png">
                            <img class="evento__imagen-autor" loading="lazy" width="500" height="450" src="<?php echo $_ENV['HOST'] . '/img/automoviles/' . $automovil->fotouno; ?>.png" alt="Imagen Auto">
                        </picture>
                    </div>
                </div>
            <?php } ?>
        </div>
        
        <div class="swiper-pagination"></div>

    </div>

    <p class="autos__texto">Bienvenido al aréa de administración aquí podras crear, actualizar y eliminar automovíles o vendedores</p>
</div>