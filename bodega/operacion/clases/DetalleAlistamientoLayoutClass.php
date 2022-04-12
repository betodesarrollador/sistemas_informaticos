<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetalleAlistamientoLayout extends View{

 private $fields;

 public function setGuardar($Permiso){
  $this -> Guardar = $Permiso;
}

public function setActualizar($Permiso){
 $this -> Actualizar = $Permiso;
}

public function setBorrar($Permiso){
 $this -> Borrar = $Permiso;
}

public function setLimpiar($Permiso){
  $this -> Limpiar = $Permiso;
}

public function setDetallesAlistamiento($detallesAlistamiento){

 $this -> assign("DETALLESALISTAMIENTOS",$detallesAlistamiento);	  

}   

public function setOficina($oficina_id){

 $this -> assign("OFICINAID",$oficina_id);	  

}


public function setIncludes($campos){

     $this -> fields = $campos;	
     
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/bodega/operacion/css/operativa.css");	 
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jquery.alerts.css");	
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/generalDetalle.css");  
	 
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js"); 
	   $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.autocomplete.js"); 
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/bodega/operacion/js/detalleAlistamiento.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.alerts.js");	

 $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
 $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());

 $this -> assign("ALISTAMIENTOSID",   $this -> objectsHtml -> GetobjectHtml($this -> fields[alistamiento_salida_id]));	 

}


public function RenderMain(){

  $this -> RenderLayout('detalleAlistamiento.tpl');

}


}


?>