<?php

require_once("../../../framework/clases/ViewClass.php");

final class EstadosLayout extends View{

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
	 
	 $Form1      = new Form("EstadosClass.php","EstadosForm","EstadosForm"); 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/general.css");
	 $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.alerts.css");

	 $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/general.js");	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/roa/seguimiento/parametros_modulo/js/Estados.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.filestyle.js");
	 
	 
     $this -> assign("CSSSYSTEM",		$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",		$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",			$Form1 -> FormBegin());
     $this -> assign("FORM1END",		$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("ESTADOID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_segui_id]));
     $this -> assign("ESTADO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_segui]));
	 
	 
	 
	 
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }

   
   
   


//// GRID ////
   public function SetGridEstados($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDNovedades",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",	$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",		$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('Estados.tpl');
	 
   }


}


?>