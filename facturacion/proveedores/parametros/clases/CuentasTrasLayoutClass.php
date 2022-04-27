<?php

require_once("../../../framework/clases/ViewClass.php");

final class CuentasTrasLayout extends View{

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
	 
	 $Form1      = new Form("CuentasTrasClass.php","CuentasTrasForm","CuentsaTrasForm");
	 
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
	 $this -> TplInclude -> IncludeJs("../../../proveedores/parametros/js/CuentasTras.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 
	 $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",$Form1 -> FormBegin());
	 $this -> assign("FORM1END",$Form1 -> FormEnd());
	 $this -> assign("BUSQUEDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 $this -> assign("CUENTAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[cuenta_traslado_id]));
	 $this -> assign("PUCID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[puc_id]));
	 $this -> assign("DESCRIPCION",$this -> objectsHtml -> GetobjectHtml($this -> fields[descripcion]));		 	 
	 $this -> assign("DESCRIPCIONCORTA",$this -> objectsHtml -> GetobjectHtml($this -> fields[descripcion_corta]));		 	 
	 
	 $this -> assign("ACTIVO",$this -> objectsHtml -> GetobjectHtml($this -> fields[activo]));
	 $this -> assign("INACTIVO",$this -> objectsHtml -> GetobjectHtml($this -> fields[inactivo]));
			
	 if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }

   public function setOficina($oficinas){
	 $this -> fields[oficina_id]['options'] = $oficinas;
     $this -> assign("OFICINA",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	   	   	   
   }

   public function SetGridCuentasTras($Attributes,$Titles,$Cols,$Query){
	 require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
	 $this -> assign("GRIDFORMASPAGO",$TableGrid -> RenderJqGrid());
	 $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
	 $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
   }
	 

   public function RenderMain(){
	 $this ->RenderLayout('CuentasTras.tpl');
   }

}

?>