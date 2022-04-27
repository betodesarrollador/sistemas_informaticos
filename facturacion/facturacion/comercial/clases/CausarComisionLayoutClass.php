<?php

require_once("../../../framework/clases/ViewClass.php");

final class CausarComisionLayout extends View{

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
   public function SetAnular($Permiso){
  	 $this -> Anular = $Permiso;
   }   
   public function SetImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   }   
  
   
   public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("CausarComisionClass.php","CausarComisionForm","CausarComisionForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	 $this -> TplInclude -> IncludeCss("../../../proveedores/causar/css/causar.css");	 
	
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../facturacion/comercial/js/CausarComision.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("CAUSARID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[factura_proveedor_id]));
     $this -> assign("NUMSOPORTE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_soporte]));
	 $this -> assign("ENCABEZADOID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[encabezado_registro_id]));
	 $this -> assign("COMERCIAL",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[comercial]));
     $this -> assign("COMERCIALID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[comercial_id]));	 	 	 	 
	 $this -> assign("PROVEEDORNIT",		$this -> objectsHtml -> GetobjectHtml($this -> fields[proveedor_nit]));		 	 
	 $this -> assign("FECHAFACPRO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_factura_proveedor]));		 	 
	 $this -> assign("VENCEFACPRO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[vence_factura_proveedor]));		 	 	 
	 $this -> assign("VALOR",				$this -> objectsHtml -> GetobjectHtml($this -> fields[valor]));	
	 $this -> assign("FECHAINGRESO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[ingreso_factura_proveedor]));		 
	 $this -> assign("ESTADO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_factura_proveedor]));		 	 
	 $this -> assign("NPAGOS",				$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_pagos]));		 	  
     $this -> assign("CONCEPTOFAC",			$this -> objectsHtml -> GetobjectHtml($this -> fields[concepto_factura_proveedor]));		 	  
     $this -> assign("CONCEPTO",	        $this -> objectsHtml -> GetobjectHtml($this -> fields[concepto]));	 
     $this -> assign("CONCEPTOITEMS",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[concepto_item]));		 	     
	 $this -> assign("FUENTEID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fuente_servicio_cod]));
	 $this -> assign("FUENTE",			    $this -> objectsHtml -> GetobjectHtml($this -> fields[fuente_servicio]));
	 
	 /***********************
	     Anulacion Registro
	 ***********************/
	 
	 $this -> assign("FECHALOG",$this -> objectsHtml -> GetobjectHtml($this -> fields[anul_factura_proveedor]));	   
	 $this -> assign("OBSERVACIONES",$this -> objectsHtml -> GetobjectHtml($this -> fields[desc_anul_factura_proveedor]));	   	 


	
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	  
	 if($this -> Actualizar){
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
 	   $this -> assign("CONTABILIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[contabilizar]));	   	 	   

	 }
	  
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	   
	 if($this -> Anular)
	   $this -> assign("ANULAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));	   

	 if($this -> Imprimir)
	   $this -> assign("IMPRIMIR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	   

    }



   public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALESID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
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

    public function SetGridCausarComision($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
      $this -> assign("GRIDCAUSARCOMISION",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
    }
     
    public function RenderMain(){
      $this ->RenderLayout('CausarComision.tpl');
    }

}

?>