<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetalleMonitoreoLayout extends View{

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
   
   public function setDetallesSeguimiento($detallesSeguimiento){
   
     $this -> assign("DETALLESSEGUIMIENTO",$detallesSeguimiento);	  
   
   } 
   
   public function setFechaHoraSalida($FechaHoraSalida){
   
     $this -> assign("FECHAHORASALIDA",$FechaHoraSalida[0]['salida']);
   
   }   
   
   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/roa/seguimiento/seguimiento_monitoreo/css/detalle_monitoreo.css");	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.autocomplete.css");	 	 
	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.tablednd.js");	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/roa/seguimiento/seguimiento_monitoreo/js/detalle_monitoreo.js");
	  	  
	 $this -> assign("CSSSYSTEM",	  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	  $this -> TplInclude -> GetJsInclude());
     $this -> assign("SEGUIMIENTOID", $_REQUEST['seguimiento_id']);	 

   }

   public function RenderMain(){
   
        $this -> RenderLayout('DetalleMonitoreo.tpl');
	 
   }


}


?>