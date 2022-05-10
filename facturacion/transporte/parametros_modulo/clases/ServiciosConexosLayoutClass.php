<?php

require_once("../../../framework/clases/ViewClass.php");

final class ServiciosConexosLayout extends View{

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
	 
	 $Form1      = new Form("ServiciosConexosClass.php","ServiciosConexosForm","ServiciosConexosForm");	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");	
     //$this -> TplInclude -> IncludeCss("../../../transporte/parametros_modulo/css/ServiciosConexos.css");	 
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		   
     $this -> TplInclude -> IncludeJs("../../../transporte/parametros_modulo/js/ServiciosConexos.js");
	 
     $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		$Form1 -> FormBegin());
     $this -> assign("FORM1END",	$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 
     $this -> assign("SERVICONEXID", 	$this -> objectsHtml -> GetobjectHtml($this -> fields[servi_conex_id]));
     $this -> assign("AGENCIA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
     $this -> assign("SERVICONEX",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[servi_conex]));
	 
     $this -> assign("PUCINGRESO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[puc_ingreso]));
     $this -> assign("PUCINGRESOID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[puc_ingreso_id]));
     $this -> assign("PUCCXC",			$this -> objectsHtml -> GetobjectHtml($this -> fields[puc_cxc]));
     $this -> assign("PUCCXCID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[puc_cxc_id]));
	 
     $this -> assign("PUCCOSTO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[puc_costo]));
     $this -> assign("PUCCOSTOID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[puc_costo_id]));
     $this -> assign("PUCCXP",			$this -> objectsHtml -> GetobjectHtml($this -> fields[puc_cxp]));
     $this -> assign("PUCCXPID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[puc_cxp_id]));
	 
     $this -> assign("ESTADO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
	 
	 	 
	 
	 
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
   public function SetGridServiciosConexos($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDServiciosConexos",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",		$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",			$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('ServiciosConexos.tpl');
	 
   }


}


?>