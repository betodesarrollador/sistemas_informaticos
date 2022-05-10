<?php

require_once("../../../framework/clases/ViewClass.php");

final class CambioLayout extends View{

   private $fields;
   
   public function setIncludes(){
	   
	   
     $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/roa/seguimiento/seguimiento_monitoreo/css/Cambio.css");	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.alerts.css");		 	 
	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("/roa/seguimiento/seguimiento_monitoreo/js/Cambio.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.alerts.js");	 		   	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.hotkeys.js");	 
	   
	 $this -> assign("CSSSYSTEM",	  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	  $this -> TplInclude -> GetJsInclude());
     $this -> assign("trafico_id",	  $_REQUEST['trafico_id']);
 

   }
   
   public function SetCampos($campos){
	   
     require_once("../../../framework/clases/FormClass.php");
	   
  	 $this -> fields = $campos;
	 
	 $this -> assign("ACTUALIZAR", $this -> GetobjectHtml($this -> fields[actualizar]));	 
 
   }

 	public function SetRutas($Rutas){
     $this -> fields[ruta_id][options] = $Rutas;
	 $this -> assign("RUTAS",$this -> GetObjectHtml($this -> fields[ruta_id]));

   }

 	public function SetOrden($Orden){
     $this -> fields[ordenar][options] = $Orden;
	 $this -> assign("ORDEN",$this -> GetObjectHtml($this -> fields[ordenar]));

   }

   public function RenderMain(){
        $this -> RenderLayout('Cambio.tpl');
   }
}

?>