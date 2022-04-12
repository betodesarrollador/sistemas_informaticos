<?php

require_once("../../../framework/clases/ViewClass.php");

final class RangoRemesasLayout extends View{

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
	 
	 $Form1      = new Form("RangoRemesasClass.php","RangoRemesasForm","RangoRemesasForm");	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");		 
	 
//     $this -> TplInclude -> IncludeCss("/velotax/seguimiento/parametros_modulo/css/RangoRemesas.css");	 
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/iColorPicker.js");	
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");	 		   
     $this -> TplInclude -> IncludeJs("/velotax/transporte/parametros_modulo/js/RangoRemesas.js");
	 
     $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		$Form1 -> FormBegin());
     $this -> assign("FORM1END",	$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 
     $this -> assign("RANGOID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_remesa_id]));
     $this -> assign("AGENCIA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
     $this -> assign("FECHA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_rango_remesa]));
     $this -> assign("INICIAL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_remesa_ini]));
     $this -> assign("DISPOINICIAL",$this -> objectsHtml -> GetobjectHtml($this -> fields[inicio_disponible_res]));
     $this -> assign("TOTAL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[total_rango_remesa]));
     $this -> assign("FINAL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_remesa_fin]));
     $this -> assign("UTILIZADO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[utilizado_rango_remesa]));
     $this -> assign("SALDO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[saldo_rango_remesa]));
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
	 
   
   public function setEmpresas($Empresas){
     $this->fields[empresa_id]['options'] = $Empresas;
	 $this->assign("EMPRESAS",$this->objectsHtml->GetobjectHtml($this->fields[empresa_id]));
   }


//// GRID ////
   public function SetGridRangoRemesas($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDRANGOMANIF",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",	$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",		$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('RangoRemesas.tpl');
	 
   }


}


?>