<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetallesReporteGuiasInterLayout extends View{

   private $fields;
     
   public function setReporte1($detalles){
     $this -> assign("DETALLES",$detalles);	  
   } 

   public function setIncludes(){
	 
    $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
    $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");/*
	  $this -> TplInclude -> IncludeCss("/velotax/mensajeria/reportes/css/reportes.css");	*/
	  $this -> TplInclude ->  IncludeCss("/velotax/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");   	
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
    $this -> assign("origen_id",        $_REQUEST['origen_id']);
    $this -> assign("destino_id",       $_REQUEST['destino_id']);
    $this -> assign("estado_id",        $_REQUEST['estado_id']);
    $this -> assign("tipo_servicio_mensajeria_id",        $_REQUEST['tipo_servicio_mensajeria_id']);	
    $this -> assign("cliente_id",       $_REQUEST['cliente_id']);
    $this -> assign("$si_cliente",      $_REQUEST['si_cliente']);
    $this -> assign("$all_estado",      $_REQUEST['all_estado']);
    $this -> assign("$all_servicio",    $_REQUEST['all_servicio']);
   }

   public function RenderMain(){
   
        $this -> RenderLayout('DetallesReporteGuiasInter.tpl');	 
   }

}

?>