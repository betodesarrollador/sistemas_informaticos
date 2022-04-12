<?php
require_once("../../../framework/clases/ViewClass.php");

final class PlantillaTesoreriaLayout extends View{

   private $fields;
   
   public function SetGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function SetActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }   
   
   public function SetLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
    public function setBorrar($Permiso){
   	 $this -> Borrar = $Permiso;
   }
   
   public function SetAnular($Permiso){
  	 $this -> Anular = $Permiso;
   }   
   public function SetImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   }     
   
   public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("PlantillaTesoreriaClass.php","PlantillaTesoreriaForm","PlantillaTesoreriaForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	 $this -> TplInclude -> IncludeCss("../../../tesoreria/movimientos/css/plantillatesoreria.css");	 
	
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
     $this -> TplInclude -> IncludeJs("../../../tesoreria/movimientos/js/plantillatesoreria.js");

     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("PLANTESOID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[plantilla_tesoreria_id]));	 
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("NUMSOPORTE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_soporte]));
	 $this -> assign("ENCABEZADOID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[encabezado_registro_id]));
	 $this -> assign("FECHA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_plantilla_tesoreria]));		 
	 $this -> assign("CODFACPRO", 			$this -> objectsHtml -> GetobjectHtml($this -> fields[codplantilla_tesoreria]));
	 $this -> assign("VALOR",				$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_plantilla_tesoreria]));
     $this -> assign("CONCEPTO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[concepto_plantilla_tesoreria]));
	 $this -> assign("PROVEEDOR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[proveedor]));
     $this -> assign("PROVEEDORID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[proveedor_id]));	 	 	 	 
	 $this -> assign("PROVEEDORNIT",		$this -> objectsHtml -> GetobjectHtml($this -> fields[proveedor_nit]));	 
	 $this -> assign("ESTADO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_plantilla_tesoreria]));
	 $this -> assign("FECHALOG",			$this -> objectsHtml -> GetobjectHtml($this -> fields[anul_plantilla_tesoreria]));	   
	 $this -> assign("OBSERVACIONES",		$this -> objectsHtml -> GetobjectHtml($this -> fields[desc_anul_plantilla_tesoreria]));	 
	 $this -> assign("FECHAINGRESO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[ingreso_plantilla_tesoreria]));
	 $this -> assign("CHEQUES",		$this -> objectsHtml -> GetobjectHtml($this -> fields[cheques]));		 
	 $this -> assign("CHEQUES_IDS",		$this -> objectsHtml -> GetobjectHtml($this -> fields[cheques_ids]));		 	 

     if($this -> Guardar)
	   $this -> assign("GUARDAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	  
	 if($this -> Actualizar){
	   $this -> assign("ACTUALIZAR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
 	   $this -> assign("CONTABILIZAR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[contabilizar]));
	 }
	 
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	  
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	   
	 if($this -> Anular)
	   $this -> assign("ANULAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));	   

	 if($this -> Imprimir)
	   $this -> assign("IMPRIMIR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	 
    }
	
   public function setTipoBienServicioTesoreria($tipobienservicio){
	 $this -> fields[tipo_bien_servicio_teso_id]['options'] = $tipobienservicio;
     $this -> assign("TIPOBIENSERVICIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_bien_servicio_teso_id]));	  	   
   }	   

   public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALESID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   }
   public function setFormaPago($formas_pago){
	 $this -> fields[forma_pago_id]['options'] = $formas_pago;
     $this -> assign("FPAGO",$this -> objectsHtml -> GetobjectHtml($this -> fields[forma_pago_id]));	   	   	   
   }

   public function setUsuarioId($usuario,$oficina){
	 $this -> fields[oficina_id]['value'] = $oficina;
     $this -> assign("OFICINAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	  
	 $this -> fields[usuario_id]['value'] = $usuario;
     $this -> assign("USUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));	  
	 $this -> fields[anul_usuario_id]['value'] = $usuario;
     $this -> assign("ANULUSUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[anul_usuario_id]));	  
	 $this -> fields[anul_oficina_id]['value'] = $oficina;
     $this -> assign("ANULOFICINAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[anul_oficina_id]));	  
   }   

    public function SetGridPlantillaTesoreria($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
      $this -> assign("GRIDCAUSAR",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
    }
     
    public function RenderMain(){
      $this ->RenderLayout('plantillatesoreria.tpl');
    }

}

?>