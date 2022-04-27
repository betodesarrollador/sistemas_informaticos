<?php

require_once("../../../framework/clases/ViewClass.php");

final class CausarLayout extends View{

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
	 
     $Form1      = new Form("CausarClass.php","CausarForm","CausarForm");
	 
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
     $this -> TplInclude -> IncludeJs("../../../proveedores/causar/js/causar.js");
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
	 $this -> assign("PROVEEDORVACIO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[proveedorvacio]));
	 $this -> assign("PROVEEDOROC",			$this -> objectsHtml -> GetobjectHtml($this -> fields[proveedor]));
     $this -> assign("PROVEEDORMC",			$this -> objectsHtml -> GetobjectHtml($this -> fields[proveedormc]));	 
     $this -> assign("PROVEEDORDU",			$this -> objectsHtml -> GetobjectHtml($this -> fields[proveedordu]));	 	 
     $this -> assign("PROVEEDORNN",			$this -> objectsHtml -> GetobjectHtml($this -> fields[proveedornn]));	 	 	 
     $this -> assign("PROVEEDORID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[proveedor_id]));	 	 	 	 
	 
	 $this -> assign("TERCEROID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[tercero_id]));	 	 	 	 
	 	 
	 $this -> assign("PROVEEDORNIT",		$this -> objectsHtml -> GetobjectHtml($this -> fields[proveedor_nit]));		 	 
     $this -> assign("ORDENID", 			$this -> objectsHtml -> GetobjectHtml($this -> fields[orden_compra_id]));
	 $this -> assign("ORDEN", 			    $this -> objectsHtml -> GetobjectHtml($this -> fields[orden_compra]));
	 $this -> assign("SERVICIOID", 			$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_bien_servicio_ord]));
	 $this -> assign("BIENID", 				$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_bien_servicio_id]));	 
     $this -> assign("MANIFIESTOID", 		$this -> objectsHtml -> GetobjectHtml($this -> fields[manifiesto_id]));
     $this -> assign("DESPACHOID", 			$this -> objectsHtml -> GetobjectHtml($this -> fields[despacho_id]));
	 $this -> assign("LIQUIDAID", 			$this -> objectsHtml -> GetobjectHtml($this -> fields[liquidacion_despacho_id]));	 
     $this -> assign("IDVACIO", 			$this -> objectsHtml -> GetobjectHtml($this -> fields[idvacio]));	 
     $this -> assign("CAMPOVACIO", 			$this -> objectsHtml -> GetobjectHtml($this -> fields[camp_vacio]));	 	 
	 $this -> assign("FACPRO", 				$this -> objectsHtml -> GetobjectHtml($this -> fields[codfactura_proveedor]));	
	 $this -> assign("FACPRONN",			$this -> objectsHtml -> GetobjectHtml($this -> fields[codfactura_proveedornn]));		 
	 $this -> assign("FECHAFACPRO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_factura_proveedor]));		 	 
	 $this -> assign("VENCEFACPRO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[vence_factura_proveedor]));		 	 	 
	 $this -> assign("VALOR",				$this -> objectsHtml -> GetobjectHtml($this -> fields[valor]));	
	 $this -> assign("VALORFACT", 				$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_factura_proveedor]));	 	 
	 $this -> assign("FECHAINGRESO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[ingreso_factura_proveedor]));		 
	 $this -> assign("ESTADO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_factura_proveedor]));	
	 $this -> assign("ESTADO1",				$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));		 
	 $this -> assign("NPAGOS",				$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_pagos]));		 	  
     $this -> assign("CONCEPTO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[concepto_factura_proveedor]));	
   $this -> assign("FACTURASCAN",  		$this -> objectsHtml -> GetobjectHtml($this -> fields[factura_scan]));	 	
   $this -> assign("EQUIVALENTE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[equivalente]));
 $this -> assign("IMPDOCCONTABLE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[imp_doc_contable])); 
	 
	 $this -> assign("DIASVENCE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[dias_vencimiento]));
	 $this -> assign("ANTICIPOS",			$this -> objectsHtml -> GetobjectHtml($this -> fields[anticipos]));
	 $this -> assign("ANTICIPOSCRUZAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[anticipos_cruzar]));
	 $this -> assign("VALANTICIPOSCRUZAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[val_anticipos_cruzar]));


$this -> assign("ARCHIVO",     $this -> objectsHtml -> GetobjectHtml($this -> fields[archivo]));	

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


    public function SetFuente($IdFuente){
	  $this -> fields[fuente_servicio_cod]['options'] = $IdFuente;
      $this -> assign("FUENTEID",$this -> objectsHtml -> GetobjectHtml($this -> fields[fuente_servicio_cod]));
    }

    public function SetServinn($IdServinn){
	  $this -> fields[tipo_bien_servicio_nn]['options'] = $IdServinn;
      $this -> assign("SERV_NN",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_bien_servicio_nn]));
    }

   public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALESID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   }

   public function setFactura($factura_proveedor_id){
	    $this -> fields[factura_proveedor_id]['value'] = $factura_proveedor_id;
      $this -> assign("CAUSARID",$this -> objectsHtml -> GetobjectHtml($this -> fields[factura_proveedor_id]));	  	   
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

    public function SetGridCausar($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
      $this -> assign("GRIDCAUSAR",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
    }
     
    public function RenderMain(){
      $this ->RenderLayout('causar.tpl');
    }

}

?>