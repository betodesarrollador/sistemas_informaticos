<?php
require_once("../../../framework/clases/ViewClass.php"); 

final class ReenvioXMLMinTransporteLayout extends View{

   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/DatosBasicos.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/bootstrap1.css");
	 
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");			 

	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");	 
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
	 $this -> TplInclude -> IncludeJs("../../../transporte/operacion/js/ReenvioXMLMinTransporte.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");  
	 
	 $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());	  	 
   
   }
   

   
   public function SetReporteManifiesto3($reporte){
     $this -> assign("MANIFIESTOS3",$reporte);	  	   
   }        
         
   public function RenderMain(){   
     $this -> RenderLayout('ReenvioXMLMinTransporteLayout.tpl');	 
   }   

}


?>