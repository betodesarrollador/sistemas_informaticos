<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetalleDevolucionProveedorLayout extends View{

   private $fields;
   
   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("/sistemas_informaticos/framework/css/ajax-dynamic-list.css");
	 $this -> TplInclude -> IncludeCss("/sistemas_informaticos/framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("/sistemas_informaticos/framework/css/jquery.alerts.css");
	 $this -> TplInclude -> IncludeCss("/sistemas_informaticos/framework/css/generalDetalle.css");	
	 $this -> TplInclude -> IncludeCss("/sistemas_informaticos/proveedores/anticipos/css/detalle_anticipos_placa.css");		  

	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/jquery.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/jqcalendar/jquery.ui.datepicker.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/jqueryform.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/funciones.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/funcionesDetalle.js");	 
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/ajax-list.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/ajax-dynamic-list.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/proveedores/anticipos/js/detalle_devolucion_proveedor.js");
	 $this -> TplInclude -> IncludeJs("/chiquinquira/framework/js/jquery.alerts.js");  
	 
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
   
   public function setTiposAnticipo($tipo_anticipos){      
   	 $this -> assign("TIPOSANTICIPO",$tipo_anticipos);	 	       
   }

   public function RenderMain(){

        //$this -> enableDebugging();   
        $this -> RenderLayout('detalle_devolucion_proveedor.tpl');
	 
   }


}


?>