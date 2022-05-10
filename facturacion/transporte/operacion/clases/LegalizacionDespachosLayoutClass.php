<?php

require_once("../../../framework/clases/ViewClass.php");

final class LegalizacionDespachosLayout extends View{

   private $fields;
   
   public function setGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function setActualizar($Permiso){
	 $this -> Actualizar = $Permiso;
   }   
   
   public function setBorrar($Permiso){
	 $this -> Borrar = $Permiso;
   }      
   
   public function setLimpiar($Permiso){
	 $this -> Limpiar = $Permiso;
   }   
   
   public function setImprimir($Permiso){
     $this -> Imprimir = $Permiso;
   }   
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("LegalizacionDespachosClass.php","LegalizacionDespachosForm","LegalizacionDespachosForm");
	 
	 $this -> fields = $campos;
	
	 $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("../../../transporte/operacion/css/legalizacion.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.autocomplete.css");	 	 	 

	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");		 
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");	 	 
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");	 
	 $this -> TplInclude -> IncludeJs("../../../transporte/operacion/js/LegalizacionDespachos.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 
	 $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",$Form1 -> FormBegin());
	 $this -> assign("FORM1END",$Form1 -> FormEnd());
	 $this -> assign("BUSQUEDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 $this -> assign("LEGALIZACIONID",$this -> objectsHtml -> GetobjectHtml($this -> fields[legalizacion_despacho_id]));		 	 
	 $this -> assign("ENCABEZADOREGISTROID",$this -> objectsHtml -> GetobjectHtml($this -> fields[encabezado_registro_id]));		 	 	 
	 $this -> assign("DESPACHOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[despachos_urbanos_id]));		
 	 $this -> assign("DESPACHO",$this -> objectsHtml -> GetobjectHtml($this -> fields[despacho]));			
	 $this -> assign("FECHA",$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha]));
	 $this -> assign("FECHASTATIC",$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_static]));	 
	 $this -> assign("CONDUCTOR",$this -> objectsHtml -> GetobjectHtml($this -> fields[conductor]));	 
	 $this -> assign("CONDUCTORID",$this -> objectsHtml -> GetobjectHtml($this -> fields[conductor_id]));	 	 
	 $this -> assign("PLACA",$this -> objectsHtml -> GetobjectHtml($this -> fields[placa]));	 	 
	 $this -> assign("PLACAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[placa_id]));	 	 	 
	 $this -> assign("ORIGEN",$this -> objectsHtml -> GetobjectHtml($this -> fields[origen]));	 	 	 
	 $this -> assign("ORIGENID",$this -> objectsHtml -> GetobjectHtml($this -> fields[origen_id]));	 	 	
	 $this -> assign("DESTINO",$this -> objectsHtml -> GetobjectHtml($this -> fields[destino]));	 	 	 
	 $this -> assign("DESTINOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[destino_id]));	 	 	
	 $this -> assign("TOTALANTICIPOS",$this -> objectsHtml -> GetobjectHtml($this -> fields[total_anticipos]));	 	
	 $this -> assign("TOTALCOSTOSVIAJE",$this -> objectsHtml -> GetobjectHtml($this -> fields[total_costos_viaje]));	
	 $this -> assign("DIFERENCIA",$this -> objectsHtml -> GetobjectHtml($this -> fields[diferencia]));		 
	 $this -> assign("USUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));		 	
	 $this -> assign("USUARIO",$this -> objectsHtml -> GetobjectHtml($this -> fields[elaboro]));	 	
	 $this -> assign("CONCEPTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[concepto]));	 		 
	 
	 $this -> assign("CONTABILIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[contabilizar]));	 	
	 	
	 if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Imprimir)	   
   	   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }
   
   public function setCostosViaje($costosViaje){
       $this -> assign("COSTOSVIAJE",$costosViaje);       
   }
	  

   public function RenderMain(){
	 $this ->RenderLayout('LegalizacionDespachos.tpl');
   }

}

?>