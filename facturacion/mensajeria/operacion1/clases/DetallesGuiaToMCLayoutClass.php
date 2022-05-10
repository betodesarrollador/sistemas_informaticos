<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetallesGuiaToMCLayout extends View{

   private $fields;
   
   public function setFiltro($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }       
     
   public function setFiltro1($detalles){
     $this -> assign("DETALLES",$detalles);	  
   } 
   
   public function setFiltro2($detalles){
     $this -> assign("DETALLES",$detalles);	  
   } 
   
   public function setFiltro3($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }    
   
   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("/velotax/mensajeria/reportes/css/reportes.css");	
	 $this -> TplInclude -> IncludeCss("/velotax/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");   	
	 $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/mensajeria/reportes/css/detalles.css");	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");	
     $this -> TplInclude -> IncludeJs("/velotax/mensajeria/operacion/js/DetallesGuiaToMC.js");	 
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");	 		   	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.hotkeys.js");	 
   	 $this -> TplInclude -> IncludeJs("/velotax/mensajeria/operacion/js/detalles.js");
	  	  
     $this -> assign("CSSSYSTEM",	    	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	    	$this -> TplInclude -> GetJsInclude());
     $this -> assign("departamento_id", 	$_REQUEST['departamento_id']);	 
	 $this -> assign("destino_id",  		$_REQUEST['destino_id']);	 
	 $this -> assign("fecha_guia",  		$_REQUEST['fecha_guia']);
	 $this -> assign("manifiesto_id",  		$_REQUEST['manifiesto_id']);
   }

   public function RenderMain(){
   
        $this -> RenderLayout('detallesGuiaToMC.tpl');	 
   }

}

?>