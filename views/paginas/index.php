<h2 class="heading">Compra o vende tus automovíles</h2>
<section class="contenedor-p"
    <div class="concecol">
        <picture>
            <img class="concecol__img" loading="lazy" src="<?php echo $_ENV['HOST'] . '/img/imagen_principal'?>.jpg" alt="Imagen Auto">
        </picture>
    </div>
</section>

<section class="contenedor-p">
    <h3 class="heading">Automovíles</h1>
    <div class="autos__listado slider swiper">
        <div class="swiper-wrapper">
            <?php foreach ($automoviles as $key => $automovil) : ?>
                <?php include __DIR__ . '/sliderAutos.php'; ?>
            <?php endforeach; ?>
        </div>
        
        <div style="color: black;" class="swiper-button-prev"></div>
        <div style="color: black;" class="swiper-button-next"></div>

    </div>

    <a href="/automoviles" class="boton-verde-inline">Ver Todos</a>

</section>

<section class="contacto-info contenedor-p">
    <h3 class="contacto-info__heading">Encuentra el auto de tus sueños</h3>
    <p class="contacto-info__p">LLena el formulario de contacto y un asesor se pondrá en contacto contigo a la brevedad </p>
    <a href="/contacto" class="contacto-info__enlace">Contactános...</a>

</section>
