

<div class="contenedor-auto">
    <?php if ($mensaje) { ?>
        <p class="alerta alerta__exito"><?php echo $mensaje; ?></p>
    <?php } ?>

    <picture>
        <img style="padding-top: 2rem;" loading="lazy" width="1200" src="<?php echo $_ENV['HOST'] . '/img/2024'?>.png" alt="Imagen Auto">
    </picture>

    <h2 class="tituloC">Llene el formulario de contacto</h2>

    <form class="formulario" action="/contacto" method="POST">
        <fieldset class="formulario__info">
            <legend class="formulario__legend2">Información Personal</legend>

            <div class="formulario__campo">
                <label for="nombre" class="formulario__label">Nombre:</label>
                <input 
                    type="text" 
                    name="contacto[nombre]"
                    id="nombre" 
                    placeholder="Tu nombre completo" 
                    class="formulario__input"
                    value="<?php echo $nombre; ?>"
                />
            </div>

            <div class="formulario__campo">
                <label class="formulario__label" for="mensaje">Mensaje:</label>
                <textarea name="contacto[mensaje]" id="mensaje" required rows="6">
                </textarea>
            </div>

        </fieldset>

        <fieldset class="formulario__info">
            <legend class="formulario__legend2">Información sobre el automovil</legend>

            <div class="formulario__campo">
                <label for="nombreAuto" class="formulario__label">Nombre o versión del auto:</label>
                <input 
                    type="text" 
                    name="contacto[Auto]"
                    id="nombreAuto" 
                    placeholder="Automovil" 
                    class="formulario__input"
                    value="<?php echo $automovil->version ?? '';?>"
                />
            </div>
            
            <div class="formulario__campo">
                <label class="formulario__label" for="opciones">Vende o Compra: </label>
                <select id="opciones" name="contacto[tipo]" required>
                    <option value="" disabled selected>--Seleccione--</option>
                    <option value="Compra">Compra</option>
                    <option value="Vende">Vende</option>
                </select>
            </div>
           
            <div class="formulario__campo">
                <label class="formulario__label" for="presupuesto">Precio o Presupuesto:</label>
                <input class="formulario__input" type="number" placeholder="Tu Precio o Presupuesto" id="Presupuesto" name="contacto[precio]" required>
            </div>

        </fieldset>

        <fieldset class="formulario__info" >
            <legend class="formulario__legend2">Contacto</legend>

            <p class="formulario__p">Como desea ser contactado:</p>

            <div class="formulario__contacto">
                <div class="formulario__div">
                    <label for="contactar-telefono">Teléfono</label>
                    <input type="radio" value="telefono" id="contactar-telefono" name="contacto[contacto]" required>
                </div>
                
                <div class="formulario__div">   
                    <label for="contactar-email">email</label>
                    <input type="radio" value="email" id="contactar-email" name="contacto[contacto]" required>
                </div>

            </div>
            
            <div id="contacto"></div>

        </fieldset>

        <input type="submit" value="Enviar" class="boton-verde-inline">
    </form>

</div>