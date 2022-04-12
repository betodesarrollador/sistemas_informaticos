<?php

require_once("../../../framework/clases/ViewClass.php");

final class AnticiposLayout extends View{

   private $fields;
   private $Imprimir;
    
   public function setImprimir($Permiso){
     $this -> Imprimir = $Permiso;
   }	

   public function SetAnular($Permiso){
  	 $this -> Anular = $Permiso;
   }
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1          = new Form("AnticiposClass.php","AnticiposForm","AnticiposForm");	 
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
	 $this -> TplInclude -> IncludeJs("../../../transporte/operacion/js/anticipos.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",	  $Form1 -> FormBegin());
	 $this -> assign("FORM1END",  $Form1 -> FormEnd());
	 $this -> assign("MANIFIESTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[manifiesto]));	
	 $this -> assign("DESPACHO",$this -> objectsHtml -> GetobjectHtml($this -> fields[despacho]));		 
	 $this -> assign("MANIFIESTOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[manifiesto_id]));	
	 $this -> assign("DESPACHOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[despachos_urbanos_id]));		 	 
	 $this -> assign("ENCABEZADOREGISTROID",$this -> objectsHtml -> GetobjectHtml($this -> fields[encabezado_registro_id]));		 
	 $this -> assign("TIPOANTICIPO",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_anticipo]));		 	 
	 
	 

	 if($this -> Anular)
	   $this -> assign("ANULAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));
	 
	 
	 if($this -> Imprimir){
	   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));		 
	 } 
	 
     $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));		 	 

   }   
   
   public function RenderMain(){
	 $this ->RenderLayout('anticipos.tpl');
   }

}

?>