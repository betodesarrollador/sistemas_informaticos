<?php
require_once("../../../framework/clases/ViewClass.php"); 
final class InformacionExogenaDisLayout extends View{
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
	 
     $Form1 = new Form("InformacionExogenaDisClass.php","InformacionExogenaDisForm","InformacionExogenaDisForm");
	 
     $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");	
 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery-uploader/swfobject.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery-uploader/jquery.uploadify.v2.1.0.min.js");
     $this -> TplInclude -> IncludeJs("../js/InformacionExogenaDis.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 
     $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		$Form1 -> FormBegin());
     $this -> assign("FORM1END",	$Form1 -> FormEnd());

   }
//LISTA MENU
   public function setPeriodo($periodos){
     $this -> fields[periodo_contable_id][options] = $periodos;
     $this->assign("PERIODOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[periodo_contable_id]));
	   
   }
   public function setFormatos($formatos){
     $this -> fields[formato_exogena_id][options] = $formatos;
     $this->assign("FORMATOS",$this -> objectsHtml -> GetobjectHtml($this -> fields[formato_exogena_id]));
	   
   }
   public function RenderMain(){
   
        $this -> RenderLayout('InformacionExogenaDis.tpl');
	 
   }

}

?>