<h1 class="dashboard__heading"><?php echo $titulo; ?></h1>

<div class="dashboard__contenedor-boton">
    <a href="/admin/vendedores/crear" class="dashboard__boton">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir Vendedor
    </a>
</div>



<div class="dashboard__contenedor">
    <?php if(!empty($vendedores)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr class="table__tr">
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Telefono</th>
                    <th scope="col" class="table__th">Email</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($vendedores as $vendedor) { ?>   
                    <tr class="table__tr">
                        <td class="table__td">
                           <?php echo $vendedor->nombre . ' ' . $vendedor->apellido; ?> 
                        </td>
                        <td class="table__td">
                            <?php echo $vendedor->telefono; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $vendedor->email; ?>
                        </td>

                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/vendedores/editar?id=<?php echo $vendedor->id; ?>"> 
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>

                            <!-- <form method="POST" action="/admin/vendedores/eliminar" class="table__formulario">
                                <input type="hidden" name="vendedor_id" value="php echo $vendedor->id; ?>"> -->

                                <button class="table__accion table__accion--eliminar" data-id="<?php echo $vendedor->id; ?>"  type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Eliminar
                                </button>
                            </form>

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        
    <?php } else { ?>
        <p>No Hay Vendedores</p>
    <?php } ?>
</div>

<?php 
    if($paginacion){
        echo $paginacion;
    }
?>