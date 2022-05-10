<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetalleRutaLayout extends View{

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
   
   public function setDetallesRuta($detallesRuta){
   
     $this -> assign("DETALLESRUTA",$detallesRuta);	  
   
   }   
   
   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.alerts.css");	 
     $this -> TplInclude -> IncludeCss("/roa/seguimiento/parametros_modulo/css/detalle_ruta.css");	 
		 	 
	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.tablednd.js");	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funciones.js");
	 $this -> TplInclude -> IncludeJs("/roa/framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("/roa/seguimiento/parametros_modulo/js/detalle_ruta.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.alerts.js");	 		   	 
	  	  
	 $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("RUTAID",		$_REQUEST['ruta_id']);	 

   }

   public function RenderMain(){
   
        $this -> RenderLayout('detalleRuta.tpl');
	 
   }


}


?>