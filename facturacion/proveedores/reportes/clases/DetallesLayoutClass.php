<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetallesLayout extends View{

   private $fields;
     
   public function setReporteFP1($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   

   public function setReporteRF1($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   

   public function setReporteEC1($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   public function setReportePE1($detalles){
     $this -> assign("DETALLES",$detalles);	  
   } 
   
   public function setReporteRC1($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   
   public function setReporteSP1($detalles){
     $this -> assign("DETALLES",$detalles);	  
   } 
   
    public function setReporteRS1($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   


   public function setReporteFP_ALL($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   

   public function setReporteRF_ALL($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   

   public function setReporteEC_ALL($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   public function setReportePE_ALL($detalles){
     $this -> assign("DETALLES",$detalles);	  
   } 
   
   public function setReporteRC_ALL($detalles){
     $this -> assign("DETALLES",$detalles);	  
   } 
   
   public function setReporteRS_ALL($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }  
   
   public function setReporteSP_ALL($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }  


   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../proveedores/reportes/css/detalles.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");		 	 
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		   	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.hotkeys.js");	
	 $this -> TplInclude -> IncludeJs("../../../proveedores/reportes/js/detalles.js");
	  	  
     $this -> assign("CSSSYSTEM",	          $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	          $this -> TplInclude -> GetJsInclude());
     $this -> assign("tipo",  				  $_REQUEST['tipo']);	 
	 $this -> assign("desde",  				  $_REQUEST['desde']);	 
   $this -> assign("hasta",  				  $_REQUEST['hasta']);	
   $this -> assign("proveedor",  				  $_REQUEST['proveedor']);
	 
   }

   public function RenderMain(){
   
        $this -> RenderLayout('detalles.tpl');
	 
   }


}


?>