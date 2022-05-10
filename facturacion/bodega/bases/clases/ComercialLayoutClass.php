<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class ComercialLayout extends View{

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
   
   public function setComerciales($detalles){
   
     $this -> assign("DETALLES",$detalles);	  
   
   }   
   
   public function setComercial($Comercial){
   
     $this -> assign("COMERCIAL",$Comercial);
   
   }   
   public function setAgencia($Agencia){
   
     $this -> assign("AGENCIA",$Agencia);
   
   }  
   
   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/bodega/bases/css/operativa.css");	 
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jquery.alerts.css");		 	 
	 
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.js");
	
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/bodega/bases/js/Comercial.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.alerts.js");	 		   	 
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.hotkeys.js");	 
	  	  
     $this -> assign("CSSSYSTEM",	          $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	          $this -> TplInclude -> GetJsInclude());
     $this -> assign("tercero_id",  		  $_REQUEST['tercero_id']);	 

   }

   public function RenderMain(){
        $this -> RenderLayout('comerciales.tpl');
	 
   }


}


?>