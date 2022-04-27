<?php

require_once("../../../framework/clases/ViewClass.php");

final class TablaImpuestosLayout extends View{

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
	 
	 $Form1      = new Form("TablaImpuestosClass.php","TablaImpuestosForm","TablaImpuestosForm");	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");	
     $this -> TplInclude -> IncludeCss("../../../transporte/parametros_modulo/css/TablaImpuestos.css");	 
	 
//     $this -> TplInclude -> IncludeCss("../../../seguimiento/parametros_modulo/css/TablaImpuestos.css");	 
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		   
     $this -> TplInclude -> IncludeJs("../../../transporte/parametros_modulo/js/TablaImpuestos.js");
	 
     $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		$Form1 -> FormBegin());
     $this -> assign("FORM1END",	$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 
     $this -> assign("TABLAIMPUESTOID", $this -> objectsHtml -> GetobjectHtml($this -> fields[tabla_impuestos_id]));
     $this -> assign("AGENCIA",	    	$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
     $this -> assign("NOMBRE",	    	$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));	 
     $this -> assign("BASE",	    	$this -> objectsHtml -> GetobjectHtml($this -> fields[base]));	 	 
     $this -> assign("ORDEN",	    	$this -> objectsHtml -> GetobjectHtml($this -> fields[orden]));	 	 	 	 
     $this -> assign("IMPUESTOID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[impuesto_id]));
     $this -> assign("ESTADO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
     $this -> assign("VISIBLE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[visible_en_impresion]));
     $this -> assign("ICA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[ica]));	 
     $this -> assign("RTE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[rte]));	 	 
 
	 
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
   
     $this->fields[empresa_id]['options'] = $Empresas;
	 $this->assign("EMPRESAS",$this->objectsHtml->GetobjectHtml($this->fields[empresa_id]));
	 
   }
   
   public function setOficinas(){
   
     $this->fields[oficina_id]['options'] = $Empresas;
	 $this->assign("OFICINAS",$this->objectsHtml->GetobjectHtml($this->fields[oficina_id]));	   
	 
   }
   
   public function setImpuestos($impuestos){
   
     $this->fields[impuesto_id]['options']      = $impuestos;
     $this->fields[base_impuesto_id]['options'] = $impuestos;	 
	 
	 $this->assign("IMPUESTOID",$this->objectsHtml->GetobjectHtml($this->fields[impuesto_id]));	   
	 $this->assign("BASEIMPUESTOID",$this->objectsHtml->GetobjectHtml($this->fields[base_impuesto_id]));	   	 
	 
   }
   
//// GRID ////
   public function SetGridTablaImpuestos($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDTABLAIMPUESTOS",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",		$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",			$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('TablaImpuestos.tpl');
	 
   }


}


?>