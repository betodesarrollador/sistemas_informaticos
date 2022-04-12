<?php

require_once("../../../framework/clases/ViewClass.php");

final class TarifasLayout extends View{

   private $fields;
   
   public function SetGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function SetActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }   
   
   public function SetBorrar($Permiso){
   	 $this -> Borrar = $Permiso;
   }      
   
   public function SetLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("TarifasClass.php","TarifasForm","TarifasForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../proveedores/tarifas/js/tarifas.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("TARIFASID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[tarifa_proveedor_id]));
     $this -> assign("ORIGEN",				$this -> objectsHtml -> GetobjectHtml($this -> fields[origen_ubicacion]));	 
     $this -> assign("ORIGENID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[origen_ubicacion_id]));
	 $this -> assign("DESTINO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[destino_ubicacion]));	 
     $this -> assign("DESTINOID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[destino_ubicacion_id]));
     $this -> assign("CONFIGID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_vehiculo_id]));
     $this -> assign("CAPACIDAD",			$this -> objectsHtml -> GetobjectHtml($this -> fields[capacidad_carga]));	 
     $this -> assign("PERIODO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[periodo_proveedor]));	 
	 $this -> assign("CUPO",		    	$this -> objectsHtml -> GetobjectHtml($this -> fields[cupo_proveedor]));
	 $this -> assign("CUPOFIN",		    	$this -> objectsHtml -> GetobjectHtml($this -> fields[cupofin_proveedor]));
	 
	 $this -> assign("CANTIDAD",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[cant_proveedor]));
	 $this -> assign("CANTIDADFIN",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[cantfin_proveedor]));
	 
	 $this -> assign("TONELADA",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[tone_proveedor]));
	 $this -> assign("TONELADAFIN",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[tonefin_proveedor]));
	 $this -> assign("VOLUMEN",		    	$this -> objectsHtml -> GetobjectHtml($this -> fields[vol_proveedor]));
	 $this -> assign("VOLUMENFIN",		   	$this -> objectsHtml -> GetobjectHtml($this -> fields[volfin_proveedor]));
	 $this -> assign("ANTINI",		    	$this -> objectsHtml -> GetobjectHtml($this -> fields[ant_proveedor]));
	 $this -> assign("ANTFIN",		   		$this -> objectsHtml -> GetobjectHtml($this -> fields[antfin_proveedor]));

	 $this -> assign("ANTPROPIOINI",		    	$this -> objectsHtml -> GetobjectHtml($this -> fields[antpropio_proveedor]));
	 $this -> assign("ANTPROPIOFIN",		   		$this -> objectsHtml -> GetobjectHtml($this -> fields[antfinpropio_proveedor]));

     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	  
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	 
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	  
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
    }
	 
   
    public function SetTipoConfig($TiposConfig){
      $this -> fields[tipo_vehiculo_id]['options'] = $TiposConfig;
      $this -> assign("CONFIGID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_vehiculo_id]));
    }
   

   
    public function SetGridTarifas($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
      $this -> assign("GRIDTARIFAS",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
    }
     
    public function RenderMain(){
      $this ->RenderLayout('tarifas.tpl');
    }

}

?>