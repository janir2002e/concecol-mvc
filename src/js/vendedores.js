(function(){
    const vendedoresInput = document.querySelector('#vendedores')

    if(vendedoresInput) {
        let vendedores = [];
        let vendedoresFiltrados = [];

        const listadoVendedores = document.querySelector('#listado-vendedores');
        const vendedorHidden = document.querySelector('[name="vendedorid"]');

        obtenerVendedores();

        vendedoresInput.addEventListener('input', buscarVendedores)

        if(vendedorHidden.value){
            (async() => {
                const vendedor = await obtenerVendedor(vendedorHidden.value);
                
                const { nombre, apellido} = vendedor
              
                // insertar en el html
                const vendedorDOM = document.createElement('LI');
                vendedorDOM.classList.add('listado-vendedores__vendedor', 'listado-vendedores__vendedor--seleccionado')
                vendedorDOM.textContent = `${nombre} ${apellido}` 
                listadoVendedores.appendChild(vendedorDOM)
            })();
        }

        async function obtenerVendedor(id){
            const url = `/api/vendedor?id=${id}`
            const respuesta = await fetch(url)
            const resultado = await respuesta.json()
            return resultado
        }

        // obtener los vendedor por medio de la api
        async function obtenerVendedores(){
            const url = `/api/vendedores`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json()
            formatearVendedores(resultado);
        }

        function formatearVendedores(arrarVendedores = []){
            vendedores = arrarVendedores.map( vendedor => {
                return {
                    nombre: `${vendedor.nombre.trim()} ${vendedor.apellido.trim()}`,
                    id: vendedor.id
                }
            })
        }

        function buscarVendedores(e){
            const busqueda = e.target.value

            if(busqueda.length > 1) {
                const expresion = new RegExp(busqueda, "i");

                vendedoresFiltrados = vendedores.filter( vendedor => {
                    if(vendedor.nombre.toLowerCase().search(expresion) != -1) {
                        return vendedor
                    }
                })
                

            } else {
                vendedoresFiltrados = []
            }

            mostrarVendedores();

        }

        function mostrarVendedores() {
            // eliminar el primer hijo del listado para evitar vendedores repetidos
            while(listadoVendedores.firstChild){
                listadoVendedores.removeChild(listadoVendedores.firstChild)
            }

            if(vendedoresFiltrados.length > 0) {
                vendedoresFiltrados.forEach(vendedor => {
                    const vendedorHTML = document.createElement('LI');
                    vendedorHTML.classList.add('listado-vendedores__vendedor');
                    vendedorHTML.textContent = vendedor.nombre
                    vendedorHTML.dataset.vendedorId = vendedor.id
                    vendedorHTML.onclick = seleccionarVendedor

                    // añadir elemento al DOM
                    listadoVendedores.appendChild(vendedorHTML)

                })
            } else {
                const noResultado = document.createElement('P');
                noResultado.classList.add('listado-vendedores__no-resultado')
                noResultado.textContent = 'No hay resultados para tu busqueda'
                listadoVendedores.appendChild(noResultado)
            }
        }

        function seleccionarVendedor(e){
            const vendedor = e.target;
            
            
            const vendedorPrevio =  document.querySelector('.listado-vendedores__vendedor--seleccionado')

            if(vendedorPrevio) {
                vendedorPrevio.classList.remove('listado-vendedores__vendedor--seleccionado')
            }

            vendedor.classList.add('listado-vendedores__vendedor--seleccionado')

            vendedorHidden.value = vendedor.dataset.vendedorId
          

        }

        


    }
})();