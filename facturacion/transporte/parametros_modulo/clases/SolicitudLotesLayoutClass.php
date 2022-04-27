<?php

require_once("../../../framework/clases/ViewClass.php");

final class SolicitudLotesLayout extends View{

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
	 
	 $Form1      = new Form("SolicitudLotesClass.php","SolicitudLotesForm","SolicitudLotesForm");	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");	
     $this -> TplInclude -> IncludeCss("../../../transporte/parametros_modulo/css/SolicitudLotes.css");	 
	 
//     $this -> TplInclude -> IncludeCss("../../../seguimiento/parametros_modulo/css/SolicitudLotes.css");	 
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		   
     $this -> TplInclude -> IncludeJs("../../../transporte/parametros_modulo/js/SolicitudLotes.js");
	 
     $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		$Form1 -> FormBegin());
     $this -> assign("FORM1END",	$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 
     $this -> assign("CAMPOARCHIVOID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[campo_archivo_solicitud_id]));
     $this -> assign("CAMPOARCHIVO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[campo_archivo]));
	 
	 
	 
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
   public function setCliente($Options){
     $this->fields[cliente_id]['options'] = $Options;
	 $this->assign("CLIENTEID",$this->objectsHtml->GetobjectHtml($this->fields[cliente_id]));
   }
   
   public function SetColSolicitud($Options){
	 $this -> fields[campo_solicitud_id]['options'] = $Options;
     $this -> assign("COLUMNAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[campo_solicitud_id])); 
   }
	 
   


//// GRID ////
   public function SetGridSolicitudLotes($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDSolicitudLotes",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",		$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",			$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('SolicitudLotes.tpl');
	 
   }


}


?>