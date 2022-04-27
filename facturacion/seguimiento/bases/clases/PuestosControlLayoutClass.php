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
	 $this -> TplInclude -> IncludeCss("/roa/seguimiento/bases/css/ubicacion.css");
	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("/roa/seguimiento/bases/js/PuestosControl.js");
	 
     $this -> assign("CSSSYSTEM",		$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",		$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",			$Form1 -> FormBegin());
     $this -> assign("FORM1END",		$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("REFERENCIAID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[punto_referencia_id]));
     $this -> assign("TIPOREFERENCIA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_punto_referencia_id]));
//	 $this -> assign("CLASIFICACION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[clasificacion]));	 
     $this -> assign("UBICACION",		$this -> objectsHtml -> GetobjectHtml($this -> fields[ubicacion]));
     $this -> assign("UBICACIONID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[ubicacion_id]));
     $this -> assign("NOMBRE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));
	 $this -> assign("OBSERVACION",		$this -> objectsHtml -> GetobjectHtml($this -> fields[observacion]));
	 $this -> assign("CONTACTO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[contacto]));
     $this -> assign("DIRECCION",		$this -> objectsHtml -> GetobjectHtml($this -> fields[direccion]));
     $this -> assign("AVANTEL",			$this -> objectsHtml -> GetobjectHtml($this -> fields[avantel]));
	 $this -> assign("MOVIL",			$this -> objectsHtml -> GetobjectHtml($this -> fields[movil]));
	 $this -> assign("EMAIL",			$this -> objectsHtml -> GetobjectHtml($this -> fields[correo]));
	 $this -> assign("ESTADOPUESTO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
	 $this -> assign("X",				$this -> objectsHtml -> GetobjectHtml($this -> fields[x]));
	 $this -> assign("Y",				$this -> objectsHtml -> GetobjectHtml($this -> fields[y]));
	 $this -> assign("IMPRIMIR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	 
	 //$this -> assign("MAPEAR",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[mapear]));	 	 
	 
	 
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
	 $this -> fields[estado]['options'] = $EstadoPuesto;
     $this -> assign("ESTADOPUESTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado])); 
   }

  public function SetTipoPunto($TiposPunto){
	 $this -> fields[tipo_punto_referencia_id]['options'] = $TiposPunto;
     $this -> assign("TIPOREFERENCIA",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_punto_referencia_id])); 
   }
   
   
   /*public function SetClasificacion($Clasificacion){
	 $this -> fields[tipo_punto]['options'] = $Clasificacion;
     $this -> assign("TIPOPUNTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_punto])); 
   }*/


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