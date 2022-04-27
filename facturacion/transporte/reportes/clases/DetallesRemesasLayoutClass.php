<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetallesRemesasLayout extends View{

   private $fields;
     
   public function setReporte1($detallesRemesas){
     $this -> assign("DETALLESREMESAS",$detallesRemesas);	  
   } 
   
   public function setReporte2($detallesRemesas){
     $this -> assign("DETALLESREMESAS",$detallesRemesas);	  
   }   

   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("../../../transporte/reportes/css/reportes.css");	
	 $this -> TplInclude ->  IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");   	
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../transporte/reportes/css/detalles.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");		 	 
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		   	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.hotkeys.js");	 
   	 $this -> TplInclude -> IncludeJs("../../../transporte/reportes/js/detalles.js");
	  	  
     $this -> assign("CSSSYSTEM",	   $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	   $this -> TplInclude -> GetJsInclude());
     $this -> assign("estado_id", 	   $_REQUEST['estado_id']);	 
     $this -> assign("clase_id", 	   $_REQUEST['clase_id']);	 	 
	 $this -> assign("desde",  		   $_REQUEST['desde']);	 
	 $this -> assign("hasta",  		   $_REQUEST['hasta']);	 
	 $this -> assign("cliente",  	   $_REQUEST['cliente']);
   }

   public function RenderMain(){
   
        $this -> RenderLayout('detallesRemesas.tpl');	 
   }

}

?>