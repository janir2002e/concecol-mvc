(function(){
    const metodosContacto = document.querySelectorAll('input[name="contacto[contacto]"]')
    metodosContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto ))

    function mostrarMetodosContacto(e){
        const contactoDiv = document.querySelector('#contacto')

        if (e.target.value === 'telefono') {
            contactoDiv.innerHTML = `
                <div class="formulario__campo">
                    <label class="formulario__label" for="telefono">Escribe tú Teléfono</label>
                    <input class="formulario__input" type="tel" placeholder="Tu Teléfono" id="telefono" name="contacto[telefono]">
                </div>

                <p class="formulario__p">Elija fecha y la hora:</p>
                
                <div class="formulario__contacto">
                    <div class="formulario__div">
                        <label class="formulario__label" for="fecha">Fecha:</label>
                        <input type="date" id="fecha" required name="contacto[fecha]">
                    </div>
                    <div class="formulario__div">
                        <label class="formulario__label" for="hora">Hora:</label>
                        <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">
                    </div>
                </div>
            `;
        }else{
            contactoDiv.innerHTML = `
                <div class="formulario__campo">
                    <label class="formulario__label" for="email">Escribe tú Email: </label>
                    <input class="formulario__input" type="email" placeholder="Tu email" id="email" name="contacto[email]">
                </div>
            `;
        }
    }


})();
