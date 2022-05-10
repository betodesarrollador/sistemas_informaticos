<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class ContactosLayout extends View{

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
   
   public function setContactos($contactos){
   
     $this -> assign("CONTACTOS",$contactos);	  
   
   }   
   
   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/roa/seguimiento/bases/css/contactos.css");	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.alerts.css");		    
	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.autocomplete.js");	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/roa/seguimiento/bases/js/contactos.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.alerts.js");	 		   	  	 
	  	  
	 $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("CLIENTEID",	$_REQUEST['cliente_id']);	 

   }

   public function RenderMain(){
   
        $this -> RenderLayout('Contactos.tpl');
	 
   }


}


?>