<?php

require_once("../../../framework/clases/ViewClass.php");

final class estadoLayout extends View{

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
	 
	 $Form1      = new Form("estadoClass.php", "estadoForm","estadoForm");	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jquery.alerts.css");	
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/bodega/parametros_modulo/css/estado.css");	 
	 
//     $this -> TplInclude -> IncludeCss("sistemas_informaticos/seguimiento/parametros_modulo/css/estado.css");	 
	 
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/iColorPicker.js");	
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.alerts.js");	 		   
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/bodega/parametros_modulo/js/estado.js");
	 
     $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		$Form1 -> FormBegin());
     $this -> assign("FORM1END",	$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));

    $this->assign("NOMBRE",    $this->objectsHtml->GetobjectHtml($this->fields[nombre]));
    $this->assign("ESTADO_ID",    $this->objectsHtml->GetobjectHtml($this->fields[estado_producto_id]));
    $this->assign("CODIGO",    $this->objectsHtml->GetobjectHtml($this->fields[codigo]));
    $this->assign("DESCRIPCION",    $this->objectsHtml->GetobjectHtml($this->fields[descripcion]));
    $this -> assign("ESTADO",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));	
    $this->assign("USUARIO_ID",    $this->objectsHtml->GetobjectHtml($this->fields[usuario_id]));
    $this->assign("USUARIO_ACTUALIZA_ID",    $this->objectsHtml->GetobjectHtml($this->fields[usuario_actualiza_id]));
    $this->assign("FECHA_ACTUALIZA",    $this->objectsHtml->GetobjectHtml($this->fields[fecha_actualiza]));
    $this->assign("FECHA_REGISTRO",    $this->objectsHtml->GetobjectHtml($this->fields[fecha_registro]));;		  	 	 	 
    	  	 	 	 	  
	 
	 
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }
	 


//// GRID ////
   public function SetGridestado($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDESTADO",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",		$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",			$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('estado.tpl');
	 
   }


}


?>