<main class="contenedor">
    <h1 class="heading"><?php echo $titulo; ?></h2>

    <?php 
        include 'listado.php';
    ?>  

    <?php 
    if($paginacion){
        echo $paginacion;
    }
    ?>
</main>
