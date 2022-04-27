<?php
require_once("../../../framework/clases/ViewClass.php");

final class TipoDineroLayout extends View{

   private $fields;
   private $Guardar;
   private $Actualizar;
   private $Borrar;
   private $Limpiar;
   
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
	 
	 $Form1 = new Form("TipoDineroClass.php","TipoDineroForm","TipoDineroForm");
	 
	 $this -> fields = $campos;
	
	 $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");

	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/generalterceros.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
	 $this -> TplInclude -> IncludeJs("../../../tesoreria/parametros/js/tipodinero.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 
	 $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",		$Form1 -> FormBegin());
	 $this -> assign("FORM1END",	$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 $this -> assign("TIPODINID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_dinero_id]));
	 $this -> assign("TIPO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo]));
	 $this -> assign("NOMBRE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre_dinero]));
	 $this -> assign("VALOR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_dinero]));	 
	 $this -> assign("ESTADO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_dinero]));
 
			
	 if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }
	       
   public function SetGridTipoDinero($Attributes,$Titles,$Cols,$Query){
	 require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
	 $this -> assign("GRIDTIPODINERO",$TableGrid -> RenderJqGrid());
	 $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
	 $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
   }	 

   public function RenderMain(){
	 $this ->RenderLayout('tipodinero.tpl');
   }

}

?>