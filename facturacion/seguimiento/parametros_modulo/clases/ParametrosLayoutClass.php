<?php

require_once("../../../framework/clases/ViewClass.php");

final class ParametrosLayout extends View{

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
	 
	 $Form1      = new Form("ParametrosClass.php","ParametrosForm","ParametrosForm"); 
	 
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
     $this -> TplInclude -> IncludeJs("/roa/seguimiento/parametros_modulo/js/Parametros.js");
	 
     $this -> assign("CSSSYSTEM",		$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",		$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",			$Form1 -> FormBegin());
     $this -> assign("FORM1END",		$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("PARAMETROSID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[parametros_reporte_trafico_id]));
     $this -> assign("CLIENTE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));
     $this -> assign("CLIENTE_ID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));
     $this -> assign("MINUTO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[minuto]));
     $this -> assign("HORAS",			$this -> objectsHtml -> GetobjectHtml($this -> fields[horas]));
     $this -> assign("DIAS",			$this -> objectsHtml -> GetobjectHtml($this -> fields[dias]));
     $this -> assign("VERDE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[tiempo_verde]));
     $this -> assign("AMARILLO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[tiempo_amarillo]));
     $this -> assign("ROJO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[tiempo_rojo]));
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

//LISTA MENU
   public function SetMinuto($Minuto){
     $this -> fields[minuto][options] = $Minuto;
	 $this -> assign("MINUTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[minuto]));
   }
   
   public function SetHoras($Horas){
	 $this -> fields[horas]['options'] = $Horas;
     $this -> assign("HORAS",$this -> objectsHtml -> GetobjectHtml($this -> fields[horas])); 
   }
   
   public function SetDias($Dias){
	 $this -> fields[dias]['options'] = $Dias;
     $this -> assign("DIAS",$this -> objectsHtml -> GetobjectHtml($this -> fields[dias])); 
   }
   
   public function SetEstado($Estado){
	 $this -> fields[estado]['options'] = $Estado;
     $this -> assign("ESTADO",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado])); 
   }
   


//// GRID ////
   public function SetGridParametros($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDParametros",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",	$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",		$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('Parametros.tpl');
	 
   }


}


?>