<?php
require_once("../../../framework/clases/ViewClass.php"); 

final class DetallesEdadesLayout extends View{

   private $fields;
     
   public function setReporteMC1($detallesEdades){
     $this -> assign("DETALLESEDADES",$detallesEdades);	//print_r ($detallesEdades);
   }    
   public function setReporteDU1($detallesEdades){
     $this -> assign("DETALLESEDADES",$detallesEdades);	  
   }   
      
   
   public function setReporteMC2($detallesEdades){
     $this -> assign("DETALLESEDADES",$detallesEdades);	  
   }    
   public function setReporteDU2($detallesEdades){
     $this -> assign("DETALLESEDADES",$detallesEdades);	  
   }   
   
   
   public function setReporteMC3($detallesEdades){
     $this -> assign("DETALLESEDADES",$detallesEdades);	  
   }    
   public function setReporteDU3($detallesEdades){
     $this -> assign("DETALLESEDADES",$detallesEdades);	  
   }
   
   public function setReporteMC4($detallesEdades){
     $this -> assign("DETALLESEDADES",$detallesEdades);	  
   }    
   public function setReporteDU4($detallesEdades){
     $this -> assign("DETALLESEDADES",$detallesEdades);	  
   }
   
   public function setReporteALL1($detallesEdades){
     $this -> assign("DETALLESEDADES",$detallesEdades);	  
   }
   public function setReporteALL2($detallesEdades){
     $this -> assign("DETALLESEDADES",$detallesEdades);	  
   }
   public function setReporteALL3($detallesEdades){
     $this -> assign("DETALLESEDADES",$detallesEdades);	  
   }
   public function setReporteALL4($detallesEdades){
     $this -> assign("DETALLESEDADES",$detallesEdades);	  
   }
   
  

   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("../../../transporte/reportes/css/reportes.css");	
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
   	 $this -> TplInclude -> IncludeJs("../../../transporte/reportes/js/detallesEdades.js");
	  	  
     $this -> assign("CSSSYSTEM",	   $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	   $this -> TplInclude -> GetJsInclude());
     $this -> assign("tipo",  		   $_REQUEST['tipo']);	 
	 $this -> assign("desde",  		   $_REQUEST['desde']);	 
	 $this -> assign("hasta",  		   $_REQUEST['hasta']);	
	 $this -> assign("vehiculo",  	   $_REQUEST['vehiculo']);	 
	 $this -> assign("tenedor",  	   $_REQUEST['tenedor']);
   }

   public function RenderMain(){   
        $this -> RenderLayout('detallesEdades.tpl');	 
   }

}

?>