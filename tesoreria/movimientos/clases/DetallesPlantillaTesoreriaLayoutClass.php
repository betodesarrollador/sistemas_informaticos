<?php
require_once("../../../framework/clases/ViewClass.php"); 

final class DetallesPlantillaTesoreriaLayout extends View{

   private $fields;
     
   public function SetGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function SetActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }
   
   public function SetBorrar($Permiso){
   	 $this -> Borrar = $Permiso;
   }
   
   public function SetLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function setImputacionesContables($detalles){   
     $this -> assign("DETALLES",$detalles);	     
   }  
   
   public function setTipo($tipo){   
     $this -> assign("TIPO",$tipo[0][puc_manual]);	    
	 $this -> assign("CENTRO_IN",$tipo[0][centro_manual]);	 
	 $this -> assign("TERCERO_IN",$tipo[0][tercero_manual]);	
   }   
   
   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../tesoreria/movimientos/css/detallesplantillatesoreria.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");		 	 
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("../../../tesoreria/movimientos/js/detallesplantillatesoreria.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		   	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.hotkeys.js");	 
	  	  
     $this -> assign("CSSSYSTEM",	          	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	          	$this -> TplInclude -> GetJsInclude());
     $this -> assign("plantilla_tesoreria_id",  $_REQUEST['plantilla_tesoreria_id']);	
   }

   public function RenderMain(){   
        $this -> RenderLayout('detallesplantillatesoreria.tpl');	 
   }
   
}

?>