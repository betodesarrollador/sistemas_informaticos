<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetalleReportePresupuestoLayout extends View{

   public function setDetalleReportePresupuesto($detalles){   
     $this -> assign("DETALLES",$detalles);
   }
   
   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/generalDetalle.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.autocomplete.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("../css/detalle_presupuesto.css");     
	 	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");	 
     $this -> TplInclude -> IncludeJs("../js/DetalleReportePresupuesto.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/colResizable-1.3.min.js");
	  	  
     $this -> assign("CSSSYSTEM",  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT", $this -> TplInclude -> GetJsInclude()); 

     $this -> assign("ENERO", $_REQUEST['enero']); 
     $this -> assign("FEBRERO", $_REQUEST['febrero']); 
     $this -> assign("MARZO",  $_REQUEST['marzo']); 
     $this -> assign("ABRIL",  $_REQUEST['abril']); 
     $this -> assign("MAYO",  $_REQUEST['mayo']); 
     $this -> assign("JUNIO",  $_REQUEST['junio']); 
     $this -> assign("JULIO",  $_REQUEST['julio']); 
     $this -> assign("AGOSTO",  $_REQUEST['agosto']); 
     $this -> assign("SEPTIEMBRE",  $_REQUEST['septiembre']); 
     $this -> assign("OCTUBRE",  $_REQUEST['octubre']);             
     $this -> assign("NOVIEMBRE", $_REQUEST['noviembre']);             
     $this -> assign("DICIEMBRE", $_REQUEST['diciembre']);             
     $this -> assign("ANO", $_REQUEST['ano']);             
                                                     

   }

   public function RenderMain(){
     //$this -> enableDebugging();   
     $this -> RenderLayout('DetalleReportePresupuesto.tpl');	 
   }


}


?>