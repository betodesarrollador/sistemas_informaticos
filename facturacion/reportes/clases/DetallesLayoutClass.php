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
   public function setReporteRP1($detalles){
     $this -> assign("DETALLES",$detalles);	  
   } 
    public function setReporteCP1($detalles){
     $this -> assign("DETALLES",$detalles);	  
   } 
   public function setReporteCC1($detalles){
     $this -> assign("DETALLES",$detalles);	  
   } 

   public function setReporteRE1($detalles){
     $this -> assign("DETALLES",$detalles);	  
   } 

   

   
   
   public function setReporteRE_ALL($detalles){
     
     $this -> assign("DETALLES",$detalles);	

   }   
   public function setReporteFP_ALL($detalles){
     
     $this -> assign("DETALLES",$detalles);	

   }   
   public function setReporteRF_ALL($detalles){
     $this -> assign("DETALLES",$detalles);	  
    //exit(print_r($detalles));
   }   

   public function setReporteEC_ALL($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   public function setReportePE_ALL($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   

   public function setReporteRP_ALL($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }  
   
    public function setReporteCP_ALL($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }  
   public function setReporteCC_ALL($detalles){
     $this -> assign("DETALLES",$detalles);	  
   } 

   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/bootstrap-4.0.0/dist/css/bootstrap.min.css");
     $this -> TplInclude -> IncludeCss("../../../facturacion/reportes/css/detalles.css");	 
     $this -> TplInclude -> IncludeCss("../css/head_static.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");		 	 
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		   	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.hotkeys.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/bootstrap-4.0.0/dist/js/bootstrap.min.js");
   	 $this -> TplInclude -> IncludeJs("../../../facturacion/reportes/js/detalles.js");
	  	  
     $this -> assign("CSSSYSTEM",	          $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	          $this -> TplInclude -> GetJsInclude());
     $this -> assign("tipo",  				  $_REQUEST['tipo']);	 
	 $this -> assign("desde",  				  $_REQUEST['desde']);	 
   $this -> assign("hasta",  				  $_REQUEST['hasta']);
   $this -> assign("cliente",  				  $_REQUEST['cliente']);	 
   }

   public function RenderMain(){
    $this -> RenderLayout('detalles.tpl'); 
   }

    public function RenderPdfInd($numero_identificacion){
	        
		  $ruta="../pdf_email/";
  
      $this -> fetch('detalles.tpl');

		  $this -> exportToPdf('detalles.tpl',$numero_identificacion,$ruta);
	   
    }


}


?>