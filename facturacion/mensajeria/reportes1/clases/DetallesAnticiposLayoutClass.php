<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetallesAnticiposLayout extends View{

   private $fields;
     
   public function setReporteMC1($detallesAnticipos){
     $this -> assign("DETALLESANTICIPOS",$detallesAnticipos);	  
   } 
   
   public function setReporteDU1($detallesAnticipos){
     $this -> assign("DETALLESANTICIPOS",$detallesAnticipos);	  
   }   

   public function setReporteDP1($detallesAnticipos){
     $this -> assign("DETALLESANTICIPOS",$detallesAnticipos);	  
   }   
   
   public function setReporteMC2($detallesAnticipos){
     $this -> assign("DETALLESANTICIPOS",$detallesAnticipos);	  
   } 
   
   public function setReporteDU2($detallesAnticipos){
     $this -> assign("DETALLESANTICIPOS",$detallesAnticipos);	  
   }   

   public function setReporteDP2($detallesAnticipos){
     $this -> assign("DETALLESANTICIPOS",$detallesAnticipos);	  
   }   
   
   public function setReporteMC3($detallesAnticipos){
     $this -> assign("DETALLESANTICIPOS",$detallesAnticipos);	  
   } 
   
   public function setReporteDU3($detallesAnticipos){
     $this -> assign("DETALLESANTICIPOS",$detallesAnticipos);	  
   }   

   public function setReporteDP3($detallesAnticipos){
     $this -> assign("DETALLESANTICIPOS",$detallesAnticipos);	  
   }  
   
   public function setReporteMC4($detallesAnticipos){
     $this -> assign("DETALLESANTICIPOS",$detallesAnticipos);	  
   } 
   
   public function setReporteDU4($detallesAnticipos){
     $this -> assign("DETALLESANTICIPOS",$detallesAnticipos);	  
   }   

   public function setReporteDP4($detallesAnticipos){
     $this -> assign("DETALLESANTICIPOS",$detallesAnticipos);	  
   } 

   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("/velotax/transporte/reportes/css/reportes.css");	
	 $this -> TplInclude -> IncludeCss("/velotax/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");   	
	 $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/transporte/reportes/css/detalles.css");	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");		 	 
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");	 		   	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.hotkeys.js");	 
   	 $this -> TplInclude -> IncludeJs("/velotax/transporte/reportes/js/detalles.js");
	  	  
     $this -> assign("CSSSYSTEM",	   $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	   $this -> TplInclude -> GetJsInclude());
     $this -> assign("tipo",  		   $_REQUEST['tipo']);	 
	 $this -> assign("desde",  		   $_REQUEST['desde']);	 
	 $this -> assign("hasta",  		   $_REQUEST['hasta']);	
	 $this -> assign("vehiculo",  	   $_REQUEST['vehiculo']);	 
	 $this -> assign("tenedor",  	   $_REQUEST['tenedor']);
   }

   public function RenderMain(){
   
        $this -> RenderLayout('detallesAnticipos.tpl');
	 
   }

}

?>