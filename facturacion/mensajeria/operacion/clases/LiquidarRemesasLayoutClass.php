<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class LiquidarRemesasLayout extends View{

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
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("LiquidarRemesasClass.php","LiquidarRemesasForm","LiquidarRemesasForm");
	 
     $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/transporte/operacion/css/solicitud_servicios.css");	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");	
 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.filestyle.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery-uploader/swfobject.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery-uploader/jquery.uploadify.v2.1.0.min.js");
     $this -> TplInclude -> IncludeJs("/velotax/transporte/operacion/js/LiquidarRemesas.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");
	 
     $this -> assign("CSSSYSTEM",	        $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	        $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		        $Form1 -> FormBegin());
     $this -> assign("FORM1END",	        $Form1 -> FormEnd());
     $this -> assign("MANIFIESTODESPACHO",  $this -> objectsHtml -> GetobjectHtml($this -> fields[manifiesto_despacho]));
     $this -> assign("MANIFIESTODESPACHOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[manifiesto_despacho_id]));	 	 
     $this -> assign("FECHA",$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha]));	 	 	 
     $this -> assign("PLACA",$this -> objectsHtml -> GetobjectHtml($this -> fields[placa]));	 	 
     $this -> assign("ORIGEN",$this -> objectsHtml -> GetobjectHtml($this -> fields[origen]));	 	 	 
     $this -> assign("DESTINO",$this -> objectsHtml -> GetobjectHtml($this -> fields[destino]));	
	 
     $this -> assign("TIPOLIQUIDACION",	        $this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_liquidacion]));	 
     $this -> assign("VALORFACTURAR",	        $this -> objectsHtml -> GetobjectHtml($this -> fields[valor_facturar]));	 
     $this -> assign("VALORUNIDADFACTURAR",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[valor_unidad_facturar]));	 	 	 	 
	  	 	 	 
	 

	 
   }

//LISTA MENU

   public function RenderMain(){
   
        $this -> RenderLayout('LiquidarRemesas.tpl');
	 
   }


}


?>