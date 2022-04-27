<?php
require_once("../../../framework/clases/ViewClass.php");
final class ImpuestosOficinaLayout extends View{
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
	 
	 $Form1      = new Form("ImpuestosOficinaClass.php","ImpuestosOficinaForm","ImpuestosOficinaForm");
	 
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
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
	 $this -> TplInclude -> IncludeJs("../js/impuestosoficina.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 
	 $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",				$Form1 -> FormBegin());
	 $this -> assign("FORM1END",			$Form1 -> FormEnd());
	 $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 $this -> assign("OFICINAID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));		 	 
	 $this -> assign("IMPUESTOOFICINAID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[impuesto_oficina_id]));	 
	 $this -> assign("IMPUESTOID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[impuesto_id]));
	 $this -> assign("PUC",                 $this -> objectsHtml -> GetobjectHtml($this -> fields[puc])); 	 
	 $this -> assign("NOMBRE",	            $this -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));
	 $this -> assign("DESCRIPCION",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[descripcion]));
	 $this -> assign("UBICACION",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[ubicacion]));
	 $this -> assign("PORCENTAJE",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[porcentaje]));
	 $this -> assign("FORMULA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[formula]));
	 $this -> assign("NATURALEZA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[naturaleza]));	
	 $this -> assign("ESTADO",			    $this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));		 
	 
	
	 if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }
	 
   public function setEmpresas($Empresas){
   
     $this -> fields[empresa_id]['options'] = $Empresas;
	 $this -> assign("EMPRESAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[empresa_id]));	
   }	 
   
   public function SetTiposUbicacion($TiposUbicacionId){
	 $this -> fields[tipo_ubicacion_id]['options'] = $TiposUbicacionId;
	 $this -> assign("TIPOUBICACION",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_ubicacion_id]));	 
   }
   
   public function SetActividadesEconomicas($actividadesEconomicas){
	 $this -> fields[actividad_economica_id]['options'] = $actividadesEconomicas;
	 $this -> assign("ACTIVIDADECONOMICA",$this -> objectsHtml -> GetobjectHtml($this -> fields[actividad_economica_id]));
   }
   
   public function SetGridImpuestosOficina($Attributes,$Titles,$Cols,$Query){
	 require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
	 $this -> assign("GRIDIMPUESTOS",$TableGrid -> RenderJqGrid());
	 $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
	 $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
   }
	 
   public function RenderMain(){
	 $this ->RenderLayout('impuestosoficina.tpl');
   }
}
?>