<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetallesReporteTotalLayout extends View{

   private $fields;
     
   public function setReporte1($detalles){
     $this -> assign("DETALLES",$detalles);	  
   } 

   public function setIncludes(){
	 
    $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
    $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");/*
	$this -> TplInclude -> IncludeCss("/velotax/mensajeria/reportes/css/reportes.css");	*/
	$this -> TplInclude -> IncludeCss("/velotax/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");   	
	$this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
    $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
    $this -> TplInclude -> IncludeCss("/velotax/mensajeria/reportes/css/detalles.css");	 
    $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.autocomplete.css");	 	 
    $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");		 	 
	 
    $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
    $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.autocomplete.js");	
    $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
    $this -> TplInclude -> IncludeJs("/velotax/framework/js/funcionesDetalle.js");
    $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");	 		   	 
    $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.hotkeys.js");	 

	  	  
    $this -> assign("CSSSYSTEM",	   $this -> TplInclude -> GetCssInclude());
    $this -> assign("JAVASCRIPT",	   $this -> TplInclude -> GetJsInclude());
    $this -> assign("desde",            $_REQUEST['desde']);
    $this -> assign("hasta",            $_REQUEST['hasta']);
    $this -> assign("cliente_id",       $_REQUEST['cliente_id']);
    $this -> assign("$si_cliente",      $_REQUEST['si_cliente']);
   }

   public function RenderMain(){
   
        $this -> RenderLayout('DetallesReporteTotal.tpl');	 
   }

}

?>