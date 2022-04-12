<?php

require_once("../../../framework/clases/ViewClass.php");

final class TrasladosLayout extends View{

   private $fields;
   
   public function setGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function setActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }

   public function SetAnular($Permiso){
		$this -> Anular = $Permiso;
	 }
   
   public function setBorrar($Permiso){
   	 $this -> Borrar = $Permiso;
   }
   
   public function setLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1      = new Form("TrasladosClass.php","TrasladosForm","TrasladosForm"); 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/DatosBasicos.css");
	 
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/bodega/operacion/js/Traslados.js");
	 
     $this -> assign("CSSSYSTEM",		    $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",		  $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",			      $Form1 -> FormBegin());
     $this -> assign("FORM1END",		    $Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("TRASLADO",      	$this -> objectsHtml -> GetobjectHtml($this -> fields[traslado_id]));
     $this -> assign("ESTADO",	        $this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
     $this -> assign("FECHA",			      $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha]));
     $this -> assign("USUARIOACTUALIZA", $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_actualiza_id]));
     $this -> assign("FECHAACTUALIZA",  $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_actualiza]));
     $this -> assign("FECHAREGISTRO",   $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_registro]));
     $this -> assign("USUARIO",         $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));
     $this -> assign("USUARIOSTATIC",   $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_static]));
     $this -> assign("OBSERVANULACION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[observacion_anulacion]));
	

	 
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	  $this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
     $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
     
      if($this -> Anular)
			$this -> assign("ANULAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	  $this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	  $this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }

  public function setProducto($producto_id){
   $this -> fields[producto_id]['options'] = $producto_id;
     $this -> assign("PRODUCTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[producto_id])); 
  }
   public function setCausalesAnulacion($causales){
				$this -> fields[causal_anulacion_id]['options'] = $causales;
				$this -> assign("CAUSALANULACIONID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
		}
  

//// GRID ////
   public function SetGridTraslados($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDTRASLADOS",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",	$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",		$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('Traslados.tpl');
	 
   }


}


?>