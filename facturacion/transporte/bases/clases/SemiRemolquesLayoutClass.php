<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class SemiRemolquesLayout extends View{

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
   
   public function setCambioEstado($Permiso){
     $this -> CambiarEstado = $Permiso;   
   }    
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("SemiRemolquesClass.php","SemiRemolquesForm","SemiRemolquesForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/keyhandler.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");	 
     $this -> TplInclude -> IncludeJs("../../../transporte/bases/js/SemiRemolques.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js"); 
 
	 
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> getObjectHtml($this -> fields[busqueda]));
     $this -> assign("PLACAID",				$this -> getObjectHtml($this -> fields[placa_remolque_id]));	 
     $this -> assign("PLACA",				$this -> getObjectHtml($this -> fields[placa_remolque]));
     $this -> assign("MARCA",				$this -> getObjectHtml($this -> fields[marca_remolque]));
     $this -> assign("MARCAID",				$this -> getObjectHtml($this -> fields[marca_remolque_id]));
//     $this -> assign("COLOR",				$this -> getObjectHtml($this -> fields[color]));	 	 	 
//     $this -> assign("COLORID",				$this -> getObjectHtml($this -> fields[color_id]));	 	 	 	 	 
	 $this -> assign("MODELO",				$this -> getObjectHtml($this -> fields[modelo_remolque]));	 
     $this -> assign("TIPOSEMIRREMOLQUE",	$this -> getObjectHtml($this -> fields[tipo_remolque_id]));
     $this -> assign("PESOVACIO",			$this -> getObjectHtml($this -> fields[peso_vacio_remolque]));
     $this -> assign("CAPACIDADCARGA",		$this -> getObjectHtml($this -> fields[capacidad_carga_remolque]));	 
     $this -> assign("UNIDADCAPACIDADCARGA",$this -> getObjectHtml($this -> fields[unidad_capacidad_carga]));	 	 	 
     $this -> assign("IMAGENLATERAL",		$this -> getObjectHtml($this -> fields[archivo_imagen_lateral]));
     $this -> assign("IMAGENATRAS",		    $this -> getObjectHtml($this -> fields[archivo_imagen_atras]));	 
     $this -> assign("IDENTIDADTENEDOR",	$this -> getObjectHtml($this -> fields[tenedor_id]));
     $this -> assign("NOMBRETENEDOR",		$this -> getObjectHtml($this -> fields[tenedor]));
     $this -> assign("IDENTIDADPROPIETARIO",$this -> getObjectHtml($this -> fields[propietario_id]));
     $this -> assign("NOMBREPROPIETARIO",	$this -> getObjectHtml($this -> fields[propietario]));
     
	 
     if($this -> Guardar)
	   $this -> assign("GUARDAR",$this -> getObjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> getObjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",$this -> getObjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",$this -> getObjectHtml($this -> fields[limpiar]));
   }

//LISTA MENU

   public function setEstado(){
   
     if(!$this -> CambiarEstado) $this -> fields[estado][disabled] = 'true';
	 
     $this -> assign("ESTADO",	$this -> getObjectHtml($this -> fields[estado]));	   	        
   
   }	

   public function SetConfig($TipoConfig){
     $this -> fields[tipo_remolque_id][options] = $TipoConfig;
	 $this -> assign("TIPOSEMIRREMOLQUE",$this -> getObjectHtml($this -> fields[tipo_remolque_id]));
   }
   
   public function SetCarroceria($TipoCarroceria){
	 $this -> fields[carroceria_remolque_id]['options'] = $TipoCarroceria;
     $this -> assign("CARROCERIA",$this -> getObjectHtml($this -> fields[carroceria_remolque_id])); 
   }


//// GRID ////
  public function SetGridRemolques($Attributes,$Titles,$Cols,$Query){
	require_once("../../../framework/clases/grid/JqGridClass.php");
	$TableGrid = new JqGrid();
	$TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
	
	$this -> assign("GRIDREMOLQUES",$TableGrid -> RenderJqGrid());
	$this -> assign("TABLEGRIDCSS",	$TableGrid -> GetJqGridCss());
	$this -> assign("TABLEGRIDJS",	$TableGrid -> GetJqGridJs());   
  }

   public function RenderMain(){
   
        $this -> RenderLayout('semiremolque.tpl');
		
   }


}


?>