<?php 
    // la key es error o exito y el valor son las alertas
    foreach($alertas as $key => $alertas){
        // accedemos al los valores 
        foreach($alertas as $mensaje){
?>
    <div class="alerta alerta__<?php echo $key; ?>"> <?php echo $mensaje ?> </div>

<?php 
      }
    }
?>
