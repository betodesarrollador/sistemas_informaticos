<?php

require_once("../../../framework/clases/ViewClass.php");

final class DirectoriosApoyoLayout extends View{

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
	 
	 $Form1      = new Form("DirectoriosApoyoClass.php","DirectoriosApoyoForm","DirectoriosApoyoForm");
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.alerts.css");		  
	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.alerts.js");	 		   	 
     $this -> TplInclude -> IncludeJs("/roa/seguimiento/bases/js/DirectoriosApoyo.js");
	 
     $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		$Form1		-> FormBegin());
     $this -> assign("FORM1END",	$Form1		-> FormEnd());
     $this -> assign("BUSQUEDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("UBICACION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[ubicacion]));
     $this -> assign("UBICACIONID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[ubicacion_id]));
     $this -> assign("IDENAPOYO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[identificacion_apoyo]));
	 $this -> assign("APOYO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[apoyo]));
	 $this -> assign("APOYOID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[apoyo_id]));
     $this -> assign("TELEFONO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[tel_apoyo]));
     $this -> assign("DIRECCION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[dir_apoyo]));
     $this -> assign("CONTACTO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[contacto_apoyo]));
	 $this -> assign("PLACA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[placa_apoyo]));
	 $this -> assign("MOVIL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[cel_apoyo]));
 	 $this -> assign("CORREO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[cor_apoyo]));
	 
	 
	 
	 
	 
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }

   public function SetTipoApoyo($TiposApoyo){
	 $this -> fields[tipo_apoyo_id]['options'] = $TiposApoyo;
     $this -> assign("TIPOAPOYO",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_apoyo_id])); 
   }

//// GRID ////
   public function SetGridDirectoriosApoyo($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDDirectoriosApoyo",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",			$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",				$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this ->RenderLayout('DirectoriosApoyo.tpl');
	 
   }


}


?>