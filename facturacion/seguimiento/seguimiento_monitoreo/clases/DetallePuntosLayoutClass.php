<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetallePuntosLayout extends View{

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
   
   
   public function setDetallesPuntos($detallesPuntos){
   
     $this -> assign("DETALLESPUNTOS",$detallesPuntos);	  
   
   } 

   public function ultimoPuntos($UltimoPunto){
   
     $this -> assign("ULTPUNTO",$UltimoPunto[0]);	  
   
   } 



   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/roa/seguimiento/seguimiento_monitoreo/css/detalle_seguimiento.css");	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.alerts.css");		 
	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.tablednd.js");	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("/roa/seguimiento/seguimiento_monitoreo/js/detalle_puntos.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.alerts.js");	 		 
	  	  
	 $this -> assign("CSSSYSTEM",	  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	  $this -> TplInclude -> GetJsInclude());
     $this -> assign("TRAFICOID", 	  $_REQUEST['trafico_id']);	
	 $this -> assign("RUTAID", 	  	  $_REQUEST['ruta_id']);	

   }

   public function RenderMain(){
   
        $this -> RenderLayout('DetallePuntos.tpl');
	 
   }


}


?>