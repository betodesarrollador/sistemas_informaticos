<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetallesHistoricoLayout extends View{

   private $fields;
     
   public function setReporte1($detallesHistorico){
     $this -> assign("DETALLESHISTORICO",$detallesHistorico);	  
   }
   public function setReporte2($detallesHistorico){
     $this -> assign("DETALLESHISTORICO",$detallesHistorico);	  
   }
   public function setReporte3($detallesHistorico){
     $this -> assign("DETALLESHISTORICO",$detallesHistorico);	  
   } 
   public function setReporte4($detallesHistorico){
     $this -> assign("DETALLESHISTORICO",$detallesHistorico);	  
   }    
   public function setReporte5($detallesHistorico){
     $this -> assign("DETALLESHISTORICO",$detallesHistorico);	  
   } 
   public function setReporte6($detallesHistorico){
     $this -> assign("DETALLESHISTORICO",$detallesHistorico);	  
   }
   public function setReporte7($detallesHistorico){
     $this -> assign("DETALLESHISTORICO",$detallesHistorico);	  
   }
   public function setReporte8($detallesHistorico){
     $this -> assign("DETALLESHISTORICO",$detallesHistorico);	  
   } 
   public function setReporte9($detallesHistorico){
     $this -> assign("DETALLESHISTORICO",$detallesHistorico);	  
   }    
   public function setReporte10($detallesHistorico){
     $this -> assign("DETALLESHISTORICO",$detallesHistorico);	  
   } 
   public function setReporte11($detallesHistorico){
     $this -> assign("DETALLESHISTORICO",$detallesHistorico);	  
   }
   public function setReporte12($detallesHistorico){
     $this -> assign("DETALLESHISTORICO",$detallesHistorico);	  
   }
   public function setReporte13($detallesHistorico){
     $this -> assign("DETALLESHISTORICO",$detallesHistorico);	  
   } 
   public function setReporte14($detallesHistorico){
     $this -> assign("DETALLESHISTORICO",$detallesHistorico);	  
   }    
   public function setReporte15($detallesHistorico){
     $this -> assign("DETALLESHISTORICO",$detallesHistorico);	  
   } 
   public function setReporte16($detallesHistorico){
     $this -> assign("DETALLESHISTORICO",$detallesHistorico);	  
   } 
   

   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("../../../facturacion/reportes/css/Reporte.css");	
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
   	 $this -> TplInclude -> IncludeJs("../../../transporte/reportes/js/detalles.js");
	  	  
     $this -> assign("CSSSYSTEM",	   $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	   $this -> TplInclude -> GetJsInclude());
	 $this -> assign("desde",  		   $_REQUEST['desde']);	 
	 $this -> assign("hasta",  		   $_REQUEST['hasta']);	 
	 $this -> assign("si_cliente",     $_REQUEST['si_cliente']);
	 $this -> assign("si_vehiculo",    $_REQUEST['si_vehiculo']);	 
	 $this -> assign("si_tenedor",     $_REQUEST['si_tenedor']);
	 $this -> assign("si_conductor",   $_REQUEST['si_conductor']);		 
   }

   public function RenderMain(){
   
        $this -> RenderLayout('detallesHistorico.tpl');	 
   }

}

?>