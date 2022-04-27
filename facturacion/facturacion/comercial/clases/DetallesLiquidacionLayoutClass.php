<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetallesLiquidacionLayout extends View{

   private $fields;
     
   public function setReporteF1($detalles){
     $this -> assign("DETALLES",$detalles);	  
   } 
   
   public function setReporteR1($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   

   public function setReporteF2($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   
   public function setReporteR2($detalles){
     $this -> assign("DETALLES",$detalles);	  
   } 
   
   public function setReporteR3($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   

   public function setReporteF3($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   
   public function setReporteMC3($detalles){
     $this -> assign("DETALLES",$detalles);	  
   } 
   
   public function setReporteDU3($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   

   public function setReporteDP3($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }  
   
   public function setReporteMC4($detalles){
     $this -> assign("DETALLES",$detalles);	  
   } 
   
   public function setReporteDU4($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   

   public function setReporteDP4($detalles){
     $this -> assign("DETALLES",$detalles);	  
   } 

   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");   	
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
   	 $this -> TplInclude -> IncludeJs("../../../facturacion/comercial/js/DetallesLiquidacionComercial.js");
	  	  
     $this -> assign("CSSSYSTEM",	   $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	   $this -> TplInclude -> GetJsInclude());
     $this -> assign("tipo",  		   $_REQUEST['tipo']);	 
	 $this -> assign("desde",  		   $_REQUEST['desde']);	 
	 $this -> assign("hasta",  		   $_REQUEST['hasta']);	
	 //$this -> assign("vehiculo",  	   $_REQUEST['vehiculo']);	 
//	 $this -> assign("tenedor",  	   $_REQUEST['tenedor']);
   }

   public function RenderMain(){
   
        $this -> RenderLayout('detallesLiquidacionComercial.tpl');
	 
   }

}

?>