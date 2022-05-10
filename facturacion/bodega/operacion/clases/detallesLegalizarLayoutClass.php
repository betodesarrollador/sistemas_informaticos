<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class detallesLegalizarLayout extends View{

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
   
   public function setDetalles($detallesLegalizar){
   
     $this -> assign("DETALLES",$detallesLegalizar);	  
   
   }   

   public function setDetallesLegalizados($detallesLegalizar){
   
     $this -> assign("DETALLES",$detallesLegalizar);	  
   
   }   
   
   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/bodega/operacion/css/detallesEnturnamiento.css");	 
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jquery.alerts.css");	
     $this -> TplInclude -> IncludeCss("/colpinones/framework/css/generalDetalle.css");	 	 
	 
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/bodega/operacion/js/detallesLegalizar.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.alerts.js");	 		   	 
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.hotkeys.js");	 
	  	  
     $this -> assign("CSSSYSTEM",	          $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	          $this -> TplInclude -> GetJsInclude()); 
     
     $this -> assign("recepcion_id",  		  $_REQUEST['recepcion_id']); 
	 //$this -> assign("fuente_facturacion_cod",$_REQUEST['fuente_facturacion_cod']);	 

   }

   public function RenderMain(){
   
        $this -> RenderLayout('detallesLegalizar.tpl');
	 
   }


}


?>