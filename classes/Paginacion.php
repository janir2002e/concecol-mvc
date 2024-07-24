<?php 
namespace Classes;

class Paginacion{
    public $pagina_actual;
    public $registros_por_pagina;
    public $total_registros;
    public $condicion;

    public function __construct($pagina_actual = 1, $registros_por_pagina = 1, $total_registros = 0, $condicion = '')
    {
        $this->pagina_actual = (int) $pagina_actual;
        $this->registros_por_pagina = (int) $registros_por_pagina;
        $this->total_registros = (int) $total_registros;
        $this->condicion = $condicion;
    }

    // calcular registros por pagina
    public function offset(){
        return $this->registros_por_pagina * ($this->pagina_actual -1);
    }

    public function total_paginas(){
        return ceil($this->total_registros / $this->registros_por_pagina);
    }

    public function pagina_anterior(){
        $anterior = $this->pagina_actual - 1;
        return ($anterior > 0) ? $anterior : false;
    }

    public function pagina_siguiente(){
        $siguiente = $this->pagina_actual + 1;
        return ($siguiente <= $this->total_paginas()) ? $siguiente : false;
    }

    public function enlace_anterior(){
        $html = '';
        if($this->pagina_anterior()){
            if(!$this->condicion){
                $html .= "<a  class=\"paginacion__enlace--texto\" href=\"?page={$this->pagina_anterior()}\">&laquo; Anterior</a>";
            }else {
                $html .= "<a  class=\"paginacion__enlace--texto\" href=\"?page={$this->pagina_anterior()}&marca={$this->condicion}\">&laquo; Anterior</a>"; 
            }

        }
        return $html;
    }

    public function enlace_siguiente(){
        $html = '';
        if($this->pagina_siguiente()){
            if(!$this->condicion){
                $html .= "<a  class=\"paginacion__enlace--texto\" href=\"?page={$this->pagina_siguiente()}\">&raquo; Siguiente</a>";
            } else {
                $html .= "<a  class=\"paginacion__enlace--texto\" href=\"?page={$this->pagina_siguiente()}&marca={$this->condicion}\">&raquo; Siguiente</a>";
            }
            
        }
        return $html;
    }

    public function numeros_paginas() {
        $html = '';
        for($i = 1; $i <= $this->total_paginas(); $i++) {
            if($i === $this->pagina_actual) {
                $html .= "<spam class=\"paginacion__enlace paginacion__enlace--actual\">{$i}</spam>";
            } else {
                if(!$this->condicion){
                    $html .= "<a class=\"paginacion__enlace paginacion__enlace--numero\" href=\"?page={$i}\">{$i}</a>";
                } else {
                    $html .= "<a class=\"paginacion__enlace paginacion__enlace--numero\" href=\"?page={$i}&marca={$this->condicion}\">{$i}</a>";
                }
                
            }
        }
        return $html;
    }

    public function paginacion(){
        $html = '';
        if($this->total_registros > 1){
            $html .= '<div class="paginacion">';
            $html .= $this->enlace_anterior();
            $html .= $this->numeros_paginas();
            $html .= $this->enlace_siguiente();
            $html .= '</div>';
        }

        return $html;
    }

}
?>

