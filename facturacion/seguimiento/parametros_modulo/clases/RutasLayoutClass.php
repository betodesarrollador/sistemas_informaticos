<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class RutasLayout extends View{

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
	 
	 $Form1 = new Form("RutasClass.php","RutasForm","RutasForm");	 	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.alerts.css");		 
     $this -> TplInclude -> IncludeCss("/roa/seguimiento/parametros_modulo/css/rutas.css");	 
	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.alerts.js");	 		  
     $this -> TplInclude -> IncludeJs("/roa/seguimiento/parametros_modulo/js/Rutas.js");
	 
     $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		$Form1 -> FormBegin());
     $this -> assign("FORM1END",	$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("RUTA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[ruta]));
     $this -> assign("RUTAID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[ruta_id]));
     $this -> assign("PASADORVIAL",	$this -> objectsHtml -> GetobjectHtml($this -> fields[pasador_vial]));
	 $this -> assign("ORIGEN",		$this -> objectsHtml -> GetobjectHtml($this -> fields[origen]));
     $this -> assign("ORIGENID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[origen_id]));
     $this -> assign("DESTINO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[destino]));
	 $this -> assign("DESTINOID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[destino_id]));
	 $this -> assign("DISTANCIA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[distancia]));
	 $this -> assign("ESTADORUTA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_ruta]));
	 $this -> assign("CANTIDAD",	$this -> objectsHtml -> GetobjectHtml($this -> fields[cantidad]));
	 
	 
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
   public function SetEstadoRuta($EstadoRuta){
	 $this -> fields[estado_ruta]['options'] = $EstadoRuta;
     $this -> assign("ESTADORUTA",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_ruta])); 
   }


//// GRID ////
   public function SetGridRutas($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDRutas",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",	$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('Rutas.tpl');
	 
   }


}


?>