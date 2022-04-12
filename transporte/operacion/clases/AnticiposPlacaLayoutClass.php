<?php

require_once("../../../framework/clases/ViewClass.php");

final class AnticiposPlacaLayout extends View{

   private $fields;
   private $Imprimir;
    
   public function setImprimir($Permiso){
     $this -> Imprimir = $Permiso;
   }	

   public function setBorrar($Permiso){
	 $this -> Borrar = $Permiso;
   }      

   public function SetAnular($Permiso){
  	 $this -> Anular = $Permiso;
   }   

   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1          = new Form("AnticiposPlacaClass.php","AnticiposPlacaForm","AnticiposPlacaForm");	 
	 $this -> fields = $campos;
	
	 $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.autocomplete.css");	 

	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");	 
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
	 $this -> TplInclude -> IncludeJs("../../../transporte/operacion/js/anticiposplaca.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",	  $Form1 -> FormBegin());
	 $this -> assign("FORM1END",  $Form1 -> FormEnd());
	 $this -> assign("PLACA",$this -> objectsHtml -> GetobjectHtml($this -> fields[placa]));	
	 $this -> assign("PLACAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[placa_id]));	

	 $this -> assign("TENEDOR",$this -> objectsHtml -> GetobjectHtml($this -> fields[tenedor]));	
	 $this -> assign("TENEDORID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tenedor_id]));	
	 $this -> assign("TENEDORIDENTIFICACION",$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_identificacion_tenedor]));	

	 $this -> assign("CONDUCTOR",$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));	
	 $this -> assign("CONDUCTORID",$this -> objectsHtml -> GetobjectHtml($this -> fields[conductor_id]));	
	 $this -> assign("CONDUCTORIDENTIFICACION",$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_identificacion]));	
	 $this -> assign("PROPIO",$this -> objectsHtml -> GetobjectHtml($this -> fields[propio]));
	 $this -> assign("ENCABEZADOREGISTROID",$this -> objectsHtml -> GetobjectHtml($this -> fields[encabezado_registro_id]));		 
 	 

	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));

	 if($this -> Anular)
	   $this -> assign("ANULAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));	   
	 
	 if($this -> Imprimir){
	   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));		 
	 } 
	 
     $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));		 	 

   }   
   
   public function RenderMain(){
	 $this ->RenderLayout('anticiposplaca.tpl');
   }

}

?>