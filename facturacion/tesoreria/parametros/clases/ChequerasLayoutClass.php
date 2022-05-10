<?php
require_once("../../../framework/clases/ViewClass.php");

final class ChequerasLayout extends View{

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
	 
	 $Form1 = new Form("ChequerasClass.php","ChequerasForm","ChequerasForm");
	 
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
	 $this -> TplInclude -> IncludeJs("../../../tesoreria/parametros/js/chequeras.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 
	 $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",		$Form1 -> FormBegin());
	 $this -> assign("FORM1END",	$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 $this -> assign("CHEQUERAID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[chequeras_id]));
	 $this -> assign("PUCID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[puc_id]));
	 $this -> assign("PUC",			$this -> objectsHtml -> GetobjectHtml($this -> fields[puc]));	 
	 $this -> assign("BANCOID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[banco_id]));	 
	 $this -> assign("BANCO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[banco]));	 	 
     $this -> assign("REFERENCIA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[referencia]));
     $this -> assign("TIPOCUEN",	$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_cuenta]));	 
     $this -> assign("RANGOINI",	$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_ini]));	 	 
     $this -> assign("RANGOFIN",	$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_fin]));	
	 $this -> assign("ESTADO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
 
			
	 if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }
	       
   public function SetGridChequeras($Attributes,$Titles,$Cols,$Query){
	 require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
	 $this -> assign("GRIDCHEQUERAS",$TableGrid -> RenderJqGrid());
	 $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
	 $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
   }	 

   public function RenderMain(){
	 $this ->RenderLayout('chequeras.tpl');
   }

}

?>