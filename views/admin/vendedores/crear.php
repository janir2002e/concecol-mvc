<h1 class="dashboard__heading"><?php echo $titulo; ?></h1>

<div class="dashboard__contenedor-boton">
    <a href="/admin/vendedores" class="dashboard__boton">
        <i class="fa-solid fa-circle-arrow-left"></i>
        volver
    </a>
</div>

<div class="dashboard__formulario">
    <?php 
        include_once __DIR__ . '/../../templates/alertas.php';
    ?>

    <form action="/admin/vendedores/crear" method="POST" class="formulario" enctype="multipart/form-data">
        <?php 
            include_once __DIR__ . '/formulario.php';
        ?>
        <input type="submit" class="formulario__submit" value="Registrar Vendedor">
    </form>
</div>


