<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Informacion Automóvil</legend>

    <div class="formulario__campo">
        <label for="modelo" class="formulario__label">Modelo</label>

        <input 
            type="text"
            name="modelo"
            id="modelo"
            class="formulario__input"
            placeholder="Nombre del Modelo"
            value="<?php echo $automovil->modelo ?? ''; ?>"
        >
    </div>

    <div class="formulario__campo">
        <label for="version" class="formulario__label">Versión</label>

        <input 
            type="text"
            name="version"
            id="version"
            class="formulario__input"
            placeholder="Version del Auto"
            value="<?php echo $automovil->version ?? ''; ?>"
        >
    </div>

    <div class="formulario__campo">
        <label for="marca">Marca</label>
        <select name="marcaid" id="marca">
            <option selected value="">--Seleccionar Marca--</option>
            <?php foreach ($marcas as $marca) { ?>
                <option 
                    <?php echo $automovil->marcaid === $marca->id ? 'selected' : ''; ?>
                    value="<?php echo s($marca->id); ?>">
                        <?php echo s($marca->nombre); ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="combustible">Combustible</label>
        <input 
            type="text" 
            name="combustible" 
            id="combustible"
            placeholder="Combustible"
            class="formulario__input"
            value="<?php echo $automovil->combustible ?? ''; ?>"
        >
    </div>  
    
    <div class="formulario__campo">
        <label for="precio">Precio:</label>
        <input 
            type="text"
            name="precio"
            id="precio"
            class="formulario__input"
            placeholder="Precio Automóvil"
            value="<?php echo $automovil->precio ?? ''; ?>"
        >
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="cambio">Cambio</label>
        <input 
            type="text" 
            name="cambio" 
            id="cambio"
            placeholder="Cambio"
            class="formulario__input"
            value="<?php echo $automovil->cambio ?? ''; ?>"
        >
    </div>

    <div class="formulario__campo">
        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="10">
<?php echo $automovil->descripcion ?? ''; ?>
        </textarea>
    </div>

    <div class="formulario__campo">
        <label for="fotouno">Foto auto exterior</label>
        <input 
            type="file" 
            id="fotouno" 
            accept="image/jpeg,image/png/,image/webp"
            name="fotouno"
        >
    </div>

    <?php if(isset($automovil->imagen_actual_1)) { ?>
        <p class="formulario__texto--imagen">Imagen Actual</p>
        <div class="formulario__imagen">
            <picture>
                <source srcset="<?php echo $_ENV['HOST'] . '/img/automoviles/' . $automovil->imagen_actual_1; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'] . '/img/automoviles/' . $automovil->imagen_actual_1; ?>.png" type="image/png">
                <img src="<?php echo $_ENV['HOST'] . '/img/automoviles/' . $automovil->imagen_actual_1; ?>.png" alt="Imagen Exterior">
            </picture>
        </div>
    <?php } ?>

    <div class="formulario__campo">
        <label for="fotodos">Foto auto interior</label>
        <input 
            type="file" 
            id="fotodos" 
            accept="image/jpeg,image/png/,image/webp"
            name="fotodos"
        >
    </div>
        <?php if(isset($automovil->imagen_actual_2)) { ?>
            <p class="formulario__texto--imagen">Imagen Actual</p>
            <div class="formulario__imagen">
                <picture>
                    <source srcset="<?php echo $_ENV['HOST'] . '/img/automoviles/' . $automovil->imagen_actual_2; ?>.webp" type="image/webp">
                    <source srcset="<?php echo $_ENV['HOST'] . '/img/automoviles/' . $automovil->imagen_actual_2; ?>.png" type="image/png">
                    <img src="<?php echo $_ENV['HOST'] . '/img/automoviles/' . $automovil->imagen_actual_2; ?>.png" alt="Imagen interior">
                </picture>
            </div>
        <?php } ?>

    <div class="formulario__campo">
        <label for="vendedores" class="formulario__label"></label>
        <input 
            type="text"
            id="vendedores"
            class="formulario__input"
            placeholder="Buscar vendedor"
        >

        <ul id="listado-vendedores" class="listado-vendedores"></ul>

        <input type="hidden" name="vendedorid" value="<?php echo $automovil->vendedorid ?>">
    </div> 
</fieldset>