<main class="contenedor">
    <h1 class="heading"><?php echo $titulo; ?></h2>
    
    <div class="filtro" style="margin-bottom:2rem;">
        <p>Seleccione la marca:</p>
        <?php foreach($marcas as $key => $marca) { ?>
            
            <a href="/automoviles?page=1&marca=<?php echo $marca->nombre; ?>" class="boton-verde-inline">
                <?php echo $marca->nombre; ?>
            </a>
        <?php } ?>
    </div>

    <?php 
        include 'listado.php';
    ?>  

    <?php 
    if($paginacion){
        echo $paginacion;
    }
    ?>
</main>
