<?php
require_once("../../../framework/clases/ViewClass.php");

final class RndcLayout extends View{

   private $fields;
   
   public function setActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }
   
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1      = new Form("RndcClass.php","RndcForm","RndcForm");	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("../../../transporte/parametros_modulo/css/resolucionhabilitacion.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");		 
	 
//     $this -> TplInclude -> IncludeCss("../../../seguimiento/parametros_modulo/css/Rndc.css");	 
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/iColorPicker.js");	
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		   
     $this -> TplInclude -> IncludeJs("../../../transporte/parametros_modulo/js/Rndc.js");
	 
     $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		$Form1 -> FormBegin());
     $this -> assign("FORM1END",	$Form1 -> FormEnd());

	 
     $this -> assign("RNDCID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[rndc_id]));
     $this -> assign("ACTIVOENVIO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[activo_envio]));
     $this -> assign("ACTIVOIMPRESION",			$this -> objectsHtml -> GetobjectHtml($this -> fields[activo_impresion]));
	 
	 
	 
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
   }
	 
   
   
   public function setActivo($activo){
   
     $this->fields[activo_envio]['options'] = $activo[0];
	 $this->assign("ACTIVOENVIO",$this->objectsHtml->GetobjectHtml($this->fields[activo_envio]));	

     $this->fields[activo_impresion]['options'] = $activo[1];
	 $this->assign("ACTIVOIMPRESION",$this->objectsHtml->GetobjectHtml($this->fields[activo_impresion]));	
	 
	  $this->fields[rndc_id]['value'] = $activo[2];
		$this->assign("RNDCID",$this->objectsHtml->GetobjectHtml($this->fields[rndc_id]));	
   }



   public function RenderMain(){
   
        $this -> RenderLayout('Rndc.tpl');
	 
   }


}


?>