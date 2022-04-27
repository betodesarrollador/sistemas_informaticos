<?php
require_once("../../../framework/clases/ViewClass.php"); 
final class LibroMayorLayout extends View{
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
   
   public function SetAnular($Permiso){
  	 $this -> Anular = $Permiso;
   }   
   
   public function setCampos($campos){
     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("LibroMayorClass.php","LibroMayor","LibroMayor");	 	 
	 $Form2 = new Form("ReporteLibroMayorClass.php","ReporteLibroMayor","ReporteLibroMayor");	 	 	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");		 
     $this -> TplInclude -> IncludeCss("../css/libromayor.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");	 	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");     
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		  
     $this -> TplInclude -> IncludeJs("../js/libromayor.js");
	 
     $this -> assign("CSSSYSTEM",	 $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	 $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		 $Form1 -> FormBegin());
     $this -> assign("FORM1END",	 $Form1 -> FormEnd());
     $this -> assign("FORM2",		 $Form2 -> FormBegin());
     $this -> assign("FORM2END",	 $Form2 -> FormEnd());	 
     $this -> assign("REPORTE",      $this -> objectsHtml -> GetobjectHtml($this -> fields[reporte]));
     $this -> assign("CORTE",	     $this -> objectsHtml -> GetobjectHtml($this -> fields[corte]));
     $this -> assign("NIVEL",	     $this -> objectsHtml -> GetobjectHtml($this -> fields[nivel]));	 
     $this -> assign("TERCERO",	     $this -> objectsHtml -> GetobjectHtml($this -> fields[tercero]));	 	 
     $this -> assign("GENERAR",	     $this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));
  
	   
   }
//LISTA MENU
  
   public function setEmpresas($empresas){
	 $this -> fields[empresa_id]['options'] = $empresas;
     $this -> assign("EMPRESASID",$this -> objectsHtml -> GetobjectHtml($this -> fields[empresa_id]));	   
   }
      
 
   public function RenderMain(){
   
        $this -> RenderLayout('libromayor.tpl');
	 
   }

}

?>