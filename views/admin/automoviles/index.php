<h1 class="dashboard__heading"><?php echo $titulo; ?></h1>

<div class="dashboard__contenedor-boton">
    <a href="/admin/automoviles/crear" class="dashboard__boton">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir Automovil
    </a>
</div>



<div class="dashboard__contenedor">
    <?php if(!empty($automoviles)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr class="table__tr">
                    <th scope="col" class="table__th">Modelo</th>
                    <th scope="col" class="table__th">Versión</th>
                    <th scope="col" class="table__th">marca</th>
                    <th scope="col" class="table__th">Combustible</th>
                    <th scope="col" class="table__th">Precio</th>
                    <th scope="col" class="table__th">Cambio</th>
                    <th scope="col" class="table__th"></th>

                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($automoviles as $automovil) { ?>   
                    <tr class="table__tr">
                        <td class="table__td">
                           <?php echo $automovil->modelo; ?> 
                        </td>
                        <td class="table__td">
                            <?php echo $automovil->version; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $automovil->nomMarca->nombre; ?>
                        </td>

                        <td class="table__td">
                           <?php echo $automovil->combustible; ?> 
                        </td>
                        <td class="table__td">
                            <?php echo $automovil->precio; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $automovil->cambio; ?>
                        </td>

                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/automoviles/update?id=<?php echo $automovil->id; ?>"> 
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>

                            <button class="table__accion table__accion--eliminar" data-auto-id="<?php echo $automovil->id; ?>"  type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Eliminar
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        
    <?php } else { ?>
        <p>No Hay $automoviles</p>
    <?php } ?>
</div>

<?php 
    if($paginacion){
        echo $paginacion;
    }
?>
