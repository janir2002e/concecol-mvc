import Swal from "sweetalert2";

(function () {
    const automovilC = document.querySelectorAll('[data-auto-id]');

    automovilC.forEach(automovil => automovil.addEventListener('click', ExtraerAutomovil))

    function ExtraerAutomovil(e) {
        const id = parseInt(e.target.dataset.autoId);
        confirmarEliminar(id)
    }

    function confirmarEliminar(idC) {

        var autoid = {
            id : idC
        }
        
        Swal.fire({
            title: '¿Seguro que quieres eliminar este auto?',
            showCancelButton: true,
            confirmButtonText: "Si",
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                eliminarAutomovil(autoid);
            }
        });
    }
    
    async function eliminarAutomovil(autoid){
        const { id } = autoid
        
        const datos = new FormData();
        datos.append('id', id);

        console.log(datos.append)
        try {
            const url = '/admin/automoviles/eliminar';

            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();
            
            console.log(resultado);
            if(resultado.resultado){
                Swal.fire('Eliminando!', resultado.mensaje, 'success')
                
            }
            setTimeout(() => {
                window.location.href ='/admin/automoviles';
            }, 1500);

        } catch (error) {
            console.log(error);
        }
    }
})();