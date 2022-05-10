<?php

require_once("../../../framework/clases/ViewClass.php");

final class NovedadesLayout extends View{

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
	 
	 $Form1      = new Form("NovedadesClass.php","NovedadesForm","NovedadesForm"); 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/DatosBasicos.css");
	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/roa/seguimiento/parametros_modulo/js/Novedades.js");
	 
     $this -> assign("CSSSYSTEM",		$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",		$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",			$Form1 -> FormBegin());
     $this -> assign("FORM1END",		$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("NOVEDADID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[novedad_id]));
     $this -> assign("NOVEDAD",			$this -> objectsHtml -> GetobjectHtml($this -> fields[novedad]));
     $this -> assign("ALERTAPANICO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[alerta_id]));
     $this -> assign("DETIENE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[detiene_recorrido_novedad]));
     $this -> assign("TIEMPODETIENE",	$this -> objectsHtml -> GetobjectHtml($this -> fields[tiempo_detenido_novedad]));
     $this -> assign("REPORTA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[reporte_cliente]));
	 $this -> assign("ESTADONOVEDAD",	$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_novedad]));
	 
	 
	 
	 
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }

//LISTA MENU
   public function SetAlertasPanico($AlertasPanico){
     $this -> fields[alerta_id][options] = $AlertasPanico;
	 $this -> assign("ALERTAPANICO",$this -> objectsHtml -> GetobjectHtml($this -> fields[alerta_id]));
   }
   
   public function SetDetiene($Detiene){
	 $this -> fields[detiene_recorrido_novedad]['options'] = $Detiene;
     $this -> assign("DETIENE",$this -> objectsHtml -> GetobjectHtml($this -> fields[detiene_recorrido_novedad])); 
   }
   
   public function SetReporte($Reporte){
	 $this -> fields[reporte_interno]['options'] = $Reporte;
     $this -> assign("REPORTAINT",$this -> objectsHtml -> GetobjectHtml($this -> fields[reporte_interno])); 
	 $this -> fields[finaliza_recorrido]['options'] = $Reporte;
     $this -> assign("FINALIZAREC",$this -> objectsHtml -> GetobjectHtml($this -> fields[finaliza_recorrido])); 
	 $this -> fields[requiere_remesa]['options'] = $Reporte;
     $this -> assign("REQREMESA",$this -> objectsHtml -> GetobjectHtml($this -> fields[requiere_remesa])); 

	 $this -> fields[finaliza_remesa]['options'] = $Reporte;
     $this -> assign("FINREMESA",$this -> objectsHtml -> GetobjectHtml($this -> fields[finaliza_remesa])); 

   }
   public function SetReportecliente($Reporte){
	 $this -> fields[reporte_cliente]['options'] = $Reporte;
     $this -> assign("REPORTA",$this -> objectsHtml -> GetobjectHtml($this -> fields[reporte_cliente])); 

   }
   
   public function SetEstadoNovedad($EstadoNovedad){
	 $this -> fields[estado_novedad]['options'] = $EstadoNovedad;
     $this -> assign("ESTADONOVEDAD",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_novedad])); 
   }
   


//// GRID ////
   public function SetGridNovedades($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDNovedades",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",	$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",		$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('Novedades.tpl');
	 
   }


}


?>