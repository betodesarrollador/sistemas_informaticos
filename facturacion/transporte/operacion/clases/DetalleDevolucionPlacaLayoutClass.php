<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetalleDevolucionPlacaLayout extends View{

   private $fields;
   
   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/generalDetalle.css");	
	 $this -> TplInclude -> IncludeCss("../../../transporte/operacion/css/detalle_devolucion_placa.css");		  

	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");	 
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
	 $this -> TplInclude -> IncludeJs("../../../transporte/operacion/js/detalle_devolucion_placa.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");  
	 
	 $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());	  	 
   
   }
   
   public function setDataPlaca($dataPlaca){
     $this -> assign("DATASERVICIO",$dataPlaca);	 	       
   }

   public function setRegDataPlaca($dataPlaca){
     $this -> assign("REGIS",$dataPlaca);	 	       
   }

      
   public function setAnticiposPlaca($anticipos){   
   	 $this -> assign("ANTICIPOS",$anticipos);	 	    
   }

   public function setAnticiposPlacaCruce($anticipos){   
   	 $this -> assign("ANTICIPOSCRUCE",$anticipos);	 	    
   }

   
   public function setFormasPago($formas_pago){      
   	 $this -> assign("FORMASPAGO",$formas_pago);	 	       
   }

   public function setTipoDoc($tipo_doc){      
   	 $this -> assign("TIPODOC",$tipo_doc);	 	       
   }

   public function RenderMain(){

        //$this -> enableDebugging();   
        $this -> RenderLayout('detalle_devolucion_placa.tpl');
	 
   }


}


?>