<?php

require_once("../../../framework/clases/ViewClass.php");

final class PuestosControlLayout extends View{

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
	 
	 $Form1      = new Form("PuestosControlClass.php","PuestosControlForm","PuestosControlForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.alerts.css");
	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("/roa/seguimiento/parametros_modulo/js/PuestosControl.js");
	 
     $this -> assign("CSSSYSTEM",		$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",		$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",			$Form1 -> FormBegin());
     $this -> assign("FORM1END",		$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("PUESTROCONTROLID",$this -> objectsHtml -> GetobjectHtml($this -> fields[puesto_control_id]));
     $this -> assign("UBICACION",		$this -> objectsHtml -> GetobjectHtml($this -> fields[ubicacion]));
     $this -> assign("UBICACIONID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[ubicacion_id]));
     $this -> assign("PUESTOCONTROL",	$this -> objectsHtml -> GetobjectHtml($this -> fields[puesto_control]));
	 $this -> assign("RESPONSABLE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[responsable_puesto_control]));
     $this -> assign("DIRECCION",		$this -> objectsHtml -> GetobjectHtml($this -> fields[direccion_puesto_control]));
     $this -> assign("TELEFONO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[telefono_puesto_control]));
     $this -> assign("TELEFONO2",		$this -> objectsHtml -> GetobjectHtml($this -> fields[telefono2_puesto_control]));
	 $this -> assign("MOVIL",			$this -> objectsHtml -> GetobjectHtml($this -> fields[movil_puesto_control]));
	 $this -> assign("MOVIL2",			$this -> objectsHtml -> GetobjectHtml($this -> fields[movil2_puesto_control]));
	 $this -> assign("EMAIL",			$this -> objectsHtml -> GetobjectHtml($this -> fields[email_puesto_control]));
	 $this -> assign("ESTADOPUESTO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_puesto_control]));
	 
	 
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
   public function SetEstadoPuesto($EstadoPuesto){
	 $this -> fields[estado_puesto_control]['options'] = $EstadoPuesto;
     $this -> assign("ESTADOPUESTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_puesto_control])); 
   }


//// GRID ////
   public function SetGridPuestosControl($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDPUESTOSCONTROL",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",		$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",			$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
        $this -> RenderLayout('PuestosControl.tpl'); 
   }


}


?>