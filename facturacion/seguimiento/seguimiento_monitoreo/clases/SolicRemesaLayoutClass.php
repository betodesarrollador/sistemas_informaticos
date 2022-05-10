<?php

require_once("../../../framework/clases/ViewClass.php");

final class SolicRemesaLayout extends View{

   private $fields;
   
   public function setIncludes(){
	   
	   
     $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/roa/seguimiento/seguimiento_monitoreo/css/detalle_seguimiento.css");	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.alerts.css");		 	 
	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("/roa/seguimiento/seguimiento_monitoreo/js/SolicRemesa.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.alerts.js");	 		   	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.hotkeys.js");	 
	   
	 $this -> assign("CSSSYSTEM",	  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	  $this -> TplInclude -> GetJsInclude());
     $this -> assign("detalle_seg_id",$_REQUEST['detalle_seg_id']);

   }
   
   public function SetCampos($campos){
	   
     require_once("../../../framework/clases/FormClass.php");
	   
  	 $this -> fields = $campos;
	 
	 $this -> assign("ADICIONAR", $this -> GetobjectHtml($this -> fields[adicionar]));	 
 
   }


 	public function SetSolicRemesa($detalles){
   
     $this -> assign("DETALLES",$detalles);	  
   
   }
   
   public function RenderMain(){
   
        $this -> RenderLayout('SolicRemesa.tpl');
	 
   }

}

?>