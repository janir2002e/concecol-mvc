<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Informacion Personal</legend>

    <div class="formulario__campo">
        <label class="formulario_label" for="nombre">Nombre</label>
        <input 
            type="text"
            name="nombre"
            id="nombre"
            value="<?php echo $vendedor->nombre ?? '';?>"
            class="formulario__input"
            placeholder="Nombre vendedor"
        />
    </div>

    <div class="formulario__campo">
        <label class="formulario_label" for="apellido">Apellido</label>
        <input 
            type="text"
            name="apellido"
            id="apellido"
            value="<?php echo $vendedor->apellido ?? ''; ?>"
            class="formulario__input"
            placeholder="Apellido vendedor"
        />
    </div>

    <div class="formulario__campo">
        <label class="formulario_label" for="telefono">Telefono</label>
        <input 
            type="number"
            name="telefono"
            id="telefono"
            value="<?php echo $vendedor->telefono ?? ''; ?>"
            class="formulario__input"
            placeholder="Telefono vendedor"
        />
    </div>

    <div class="formulario__campo">
        <label class="formulario_label" for="email">Email</label>
        <input 
            type="email"
            name="email"
            id="email"
            value="<?php echo $vendedor->email ?? '' ?>"
            class="formulario__input"
            placeholder="Email vendedor"
        />
    </div>

    <div class="formulario__campo">
        <label class="formulario_label" for="imagen">Imagen</label>
        <input 
            type="file"
            name="imagen"
            id="imagen"
            class="formulario__input formulario__input--file"
            accept="image/png,image/jpeg"
        />
    </div>

    <?php if(isset($vendedor->imagen_actual)) { ?>
        <p class="formulario__texto--imagen">Imagen Actual</p>
        <div class="formulario__imagen">
            <source  srcset="<?php echo $_ENV['HOST'] . '/img/vendedores/' . $vendedor->imagen_actual ?>.webp" type="image/webp">
            <source  srcset="<?php echo $_ENV['HOST'] . '/img/vendedores/' . $vendedor->imagen_actual ?>.png" type="image/png">
            <img src="<?php echo $_ENV['HOST'] .  '/img/vendedores/' . $vendedor->imagen_actual; ?>.png" alt="Imagen vendedor">
        </div>
    <?php } ?>
</fieldset>

<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Redes sociales</legend>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-facebook"></i>
            </div>
            <input
                type="text"
                class="formulario__input--sociales" 
                name="redes[facebook]" 
                placeholder="Facebook"
                value="<?php echo $redes->facebook ?? ''; ?>"
            >
        </div>
    </div>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-twitter"></i>
            </div>
            <input
                type="text"
                class="formulario__input--sociales" 
                name="redes[twitter]" 
                placeholder="twitter"
                value="<?php echo $redes->twitter ?? ''; ?>"
            >
        </div>
    </div>
    
    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <input
                type="text"
                class="formulario__input--sociales" 
                name="redes[youtube]" 
                placeholder="Youtube"
                value="<?php echo $redes->youtube ?? ''; ?>"
            >
        </div>
    </div>
</fieldset>