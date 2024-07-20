import Swal from "sweetalert2";
(function(){

    const vendedorHidden = document.querySelectorAll('[data-id]');
    
    vendedorHidden.forEach( vendedor => vendedor.addEventListener('click', EliminarVendedor))

    function EliminarVendedor(e){
        const id = parseInt(e.target.dataset.id);
        
        obtenerVendedor(id);
    }

    async function obtenerVendedor(id){
        const id_vendedor = id
        const url = `/admin/vendedores/eliminarValidar?id=${id_vendedor}`;
        const respuesta = await fetch(url);
        const resultado = await respuesta.json();
        ConfirmarEliminarVendedor(resultado)
    }

   function ConfirmarEliminarVendedor(vendedor){
        Swal.fire({
            title: '¿Seguro que quieres eliminar el vendedor?',
            showCancelButton: true,
            confirmButtonText: "Si",
            cancelButtonText: 'No'
            }).then((result) => {
            if (result.isConfirmed) {
                eliminarVendedor(vendedor);
            } 
            });
    }

    async function eliminarVendedor(vendedor){
        const datos = new FormData();
        datos.append('id', vendedor.id);

        try {
            const url = '/admin/vendedores/eliminar';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();
            if(resultado.resultado){
                Swal.fire('Eliminando!', resultado.mensaje, 'success')
                
            }
            setTimeout(() => {
                window.location.href ='/admin/vendedores';
            }, 1500);
            
        } catch (error) {
            console.log(error)
        }
    }
    
})();