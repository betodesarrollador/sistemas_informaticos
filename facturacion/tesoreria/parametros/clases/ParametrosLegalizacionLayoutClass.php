<?php
require_once("../../../framework/clases/ViewClass.php");

final class ParametrosLegalizacionLayout extends View{

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
	 $Form1      = new Form("ParametrosLegalizacionClass.php","ParametrosLegalizacionForm","ParametrosLegalizacionForm");
	 
	 $this -> fields = $campos;
	
	 $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("../../../transporte/operacion/css/Remesas.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.autocomplete.css");	 	 	 

	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");		 
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");	 	 
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");	 
	 $this -> TplInclude -> IncludeJs("../../../tesoreria/parametros/js/ParametrosLegalizacion.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 
	 $this -> assign("CSSSYSTEM",			    $this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",			    $this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",				    $Form1 -> FormBegin());
	 $this -> assign("FORM1END",			    $Form1 -> FormEnd());
	 $this -> assign("BUSQUEDA",			    $this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 $this -> assign("OFICINAID",			    $this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));		 	 
	 $this -> assign("PARAMETROLEGALIZACIONID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[parametros_legalizacion_caja_id]));	 
	 $this -> assign("CONTRAPARTIDA",           $this -> objectsHtml -> GetobjectHtml($this -> fields[contrapartida])); 	 
	 $this -> assign("CONTRAPARTIDAID",	        $this -> objectsHtml -> GetobjectHtml($this -> fields[contrapartida_id]));	 
	 $this -> assign("NOMBRECONTRAPARTIDA",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[nombre_contrapartida]));
	 $this -> assign("NATURALEZACONTRAPARTIDA", $this -> objectsHtml -> GetobjectHtml($this -> fields[naturaleza_contrapartida]));	 
	
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
   
   public function SetTiposDocumentoContable($DocumentosContables){
	 $this -> fields[tipo_documento_id]['options'] = $DocumentosContables;
	 $this -> assign("DOCUMENTOCONTABLE",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_documento_id]));	 
   }
   
   public function SetNaturalezas($naturalezas){
	 $this -> fields[naturaleza_id]['options'] = $naturalezas;
	 $this -> assign("NATURALEZA",$this -> objectsHtml -> GetobjectHtml($this -> fields[naturaleza_id]));
   }
   
   public function SetGridParametrosLegalizacion($Attributes,$Titles,$Cols,$Query){
	 require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
	 $this -> assign("GRIDPARAMETROSLEG",$TableGrid -> RenderJqGrid());
	 $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
	 $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
   }	 

   public function RenderMain(){
	 $this ->RenderLayout('ParametrosLegalizacion.tpl');
   }
}

?>