<?php

require_once("../../../framework/clases/ViewClass.php");

final class ParametrosLiquidacionLayout extends View{

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
	 
	 $Form1      = new Form("ParametrosLiquidacionClass.php","ParametrosLiquidacionForm","ParametrosLiquidacionForm");
	 
	 $this -> fields = $campos;
	
	 $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("../../../transporte/operacion/css/Remesas.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.autocomplete.css");	
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css"); 	
	 $this -> TplInclude -> IncludeCss("../../../framework/css/bootstrap.css"); 	 

	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");		 
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");	 	 
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");	 
	 $this -> TplInclude -> IncludeJs("../js/ParametrosLiquidacion.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
	 
	 $this -> assign("CSSSYSTEM",			    $this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",			    $this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",				    $Form1 -> FormBegin());
	 $this -> assign("FORM1END",			    $Form1 -> FormEnd());
	 $this -> assign("BUSQUEDA",			    $this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 $this -> assign("OFICINAID",			    $this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));		 	 
	 $this -> assign("PARAMETROLIQUIDACIONID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[parametros_liquidacion_id]));	 
	 
	 $this -> assign("FLETEPACTADO",           $this -> objectsHtml -> GetobjectHtml($this -> fields[valor_comision])); 	 
	 $this -> assign("FLETEPACTADOID",	        $this -> objectsHtml -> GetobjectHtml($this -> fields[valor_comision_id]));	 
	 $this -> assign("NATURALEZAFLETEPACTADO", $this -> objectsHtml -> GetobjectHtml($this -> fields[naturaleza_valor_comision]));	 
	 
	 $this -> assign("SOBREFLETE",           $this -> objectsHtml -> GetobjectHtml($this -> fields[sobre_flete])); 	 
	 $this -> assign("SOBREFLETEID",	     $this -> objectsHtml -> GetobjectHtml($this -> fields[sobre_flete_id]));	 
	 $this -> assign("NATURALEZASOBREFLETE", $this -> objectsHtml -> GetobjectHtml($this -> fields[naturaleza_sobre_flete]));	 	 	 
	 
	 
	 $this -> assign("ANTICIPO",                     $this -> objectsHtml -> GetobjectHtml($this -> fields[reteica])); 	 
	 $this -> assign("ANTICIPOID",                   $this -> objectsHtml -> GetobjectHtml($this -> fields[reteica_id]));	 
	 $this -> assign("NATURALEZAANTICIPO",           $this -> objectsHtml -> GetobjectHtml($this -> fields[naturaleza_reteica]));	 
	 
	 $this -> assign("SALDOPAGAR",                   $this -> objectsHtml -> GetobjectHtml($this -> fields[comisiones_por_pagar])); 	 
	 $this -> assign("SALDOPAGARID",	             $this -> objectsHtml -> GetobjectHtml($this -> fields[comisiones_por_pagar_id]));	 
	 $this -> assign("NATURALEZASALDOPAGAR",         $this -> objectsHtml -> GetobjectHtml($this -> fields[naturaleza_comisiones_por_pagar]));	 	 
	
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

   
   public function SetGridParametrosLiquidacion($Attributes,$Titles,$Cols,$Query){
	 require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
	 $head = "'<head>".
	 
	 $TableGrid -> GetJqGridJs()." ".
	 
	 $TableGrid -> GetJqGridCss()."
	 
	 </head>";
	 
	 $body = "<body>".$TableGrid -> RenderJqGrid()."</body>";
	 
	 return "<html>".$head." ".$body."</html>";
	 
   }
	 

   public function RenderMain(){
	 $this ->RenderLayout('ParametrosLiquidacion.tpl');
   }

}

?>