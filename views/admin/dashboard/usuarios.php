<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor">
    <?php if(!empty($usuarios)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr class="table__tr">
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Apellido</th>
                    <th scope="col" class="table__th">Email</th>
                    <th scope="col" class="table__th">Confirmado</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($usuarios as $usuario) { ?>   
                    <tr class="table__tr">
                        <td class="table__td">
                           <?php echo $usuario->nombre; ?> 
                        </td>
                        <td class="table__td">
                            <?php echo $usuario->apellido; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $usuario->email; ?>
                        </td>

                        <td class="table__td">
                            <?php echo $usuario->confirmado == '1' ? 'Si' : 'No'; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        
    <?php } else { ?>
        <p>No Hay usuarios</p>
    <?php } ?>
</div>

<?php 
    if($paginacion){
        echo $paginacion;
    }
?>
