<?php

require_once("../../../framework/clases/ViewClass.php");

final class PagoLayout extends View{

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
	 
     $Form1      = new Form("PagoClass.php","PagoForm","PagoForm");
	 
	   $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	   $this -> TplInclude -> IncludeCss("../../../facturacion/pago/css/pago.css");
     
     $this -> TplInclude -> IncludeCss("../../../framework/css/bootstrap1.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");	 
	
	   $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../facturacion/pago/js/pago.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	   $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("ABONOID",				$this -> objectsHtml -> GetobjectHtml($this -> fields[abono_factura_id]));
     $this -> assign("NUMSOPORTE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_soporte]));
     $this -> assign("NUMCHEQUE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[num_cheque]));
	 $this -> assign("CLIENTEID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));	 
	 $this -> assign("CLIENTE",				$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));
	 $this -> assign("CLIENTENIT",			$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_nit]));	
	 $this -> assign("ENCABEZADOID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[encabezado_registro_id]));	 	 
	 $this -> assign("FECHA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha]));		 
		 $this -> assign("VALORPAGO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_abono_factura]));		 
		 $this -> assign("VALORPAGONOTA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_abono_nota]));		 
	 $this -> assign("VALORDESCU",			$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_descu_factura]));		 
	 $this -> assign("VALORMAYOR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_mayor_factura]));		 
	 $this -> assign("VALORNETO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_neto_factura]));			 
	 $this -> assign("OBSERVACIONES1",		$this -> objectsHtml -> GetobjectHtml($this -> fields[observaciones]));	
	 
	 $this -> assign("CONCEPTOFACTU",		$this -> objectsHtml -> GetobjectHtml($this -> fields[concepto_abono_factura]));		 	 	 
	 $this -> assign("CAUSACIONFACTU",		$this -> objectsHtml -> GetobjectHtml($this -> fields[causaciones_abono_factura]));	
	 $this -> assign("CAUSACIONNOTA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[causaciones_abono_nota]));	
	 $this -> assign("DESCUENTOITEMS",		$this -> objectsHtml -> GetobjectHtml($this -> fields[descuentos_items]));	
	 $this -> assign("DESCUENTOITEMSNOTA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[descuentos_items_nota]));	
	 $this -> assign("VALORESCAUSACION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[valores_abono_factura]));		 
	 $this -> assign("VALORESNOTA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[valores_abono_nota]));		 
	 $this -> assign("FECHAINGRESO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[ingreso_abono_factura]));		 
	 $this -> assign("ESTADO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_abono_factura]));
	 $this -> assign("MOTIVONOTA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[motivo_nota]));

	 /***********************
	     Anulacion Registro
	 ***********************/
	 
	 $this -> assign("FECHALOG",$this -> objectsHtml -> GetobjectHtml($this -> fields[anul_abono_factura]));	   
	 $this -> assign("OBSERVACIONES",$this -> objectsHtml -> GetobjectHtml($this -> fields[desc_anul_abono_factura]));	   	 


	 /***********************
	     Reversar Registro
	 ***********************/
	 
	 $this -> assign("FECHALOGREV",$this -> objectsHtml -> GetobjectHtml($this -> fields[rever_abono_factura]));	   
	 $this -> assign("OBSERVACIONESREV",$this -> objectsHtml -> GetobjectHtml($this -> fields[desc_rever_abono_factura]));	   	 

	
     if($this -> Guardar){
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   $this -> assign("REPORTAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[reportar]));
	   $this -> assign("REPORTARVP",$this -> objectsHtml -> GetobjectHtml($this -> fields[reportarvp]));
	   
	  
	 }
	 if($this -> Actualizar){
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
 	   $this -> assign("CONTABILIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[contabilizar]));
	   $this -> assign("REVERSAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[reversar]));

	 }
	  
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	   
	 if($this -> Anular)
	   $this -> assign("ANULAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));	   

	 if($this -> Imprimir)
	   $this -> assign("IMPRIMIR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	   

    }


    public function SetTiposPago($TiposPago){
	  $this -> fields[cuenta_tipo_pago_id]['options'] = $TiposPago;
      $this -> assign("PAGO",$this -> objectsHtml -> GetobjectHtml($this -> fields[cuenta_tipo_pago_id]));
    }

    public function setFactura($abono_factura_id){
	    $this -> fields[abono_factura_id]['value'] = $abono_factura_id;
      $this -> assign("ABONOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[abono_factura_id]));	

   }

    public function SetDocumento($IdDocumento){
	  $this -> fields[tipo_documento_id]['options'] = $IdDocumento;
      $this -> assign("DOCID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_documento_id]));
    }

    public function setDocumentorev($IdDocumento){
	  $this -> fields[rever_documento_id]['options'] = $IdDocumento;
      $this -> assign("REVDOCID",$this -> objectsHtml -> GetobjectHtml($this -> fields[rever_documento_id]));
    }

   public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALESID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   }


   public function setUsuarioId($usuario,$oficina){
	 $this -> fields[oficina_id]['value'] = $oficina;
     $this -> assign("OFICINAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	  
	 $this -> fields[oficina_anul]['value'] = $oficina;
     $this -> assign("OFICINAANUL",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_anul]));	  

	 $this -> fields[usuario_id]['value'] = $usuario;
     $this -> assign("USUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));	  
	 $this -> fields[anul_usuario_id]['value'] = $usuario;
     $this -> assign("ANULUSUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[anul_usuario_id]));	  
	 $this -> fields[rever_usuario_id]['value'] = $usuario;
     $this -> assign("REVERUSUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[rever_usuario_id]));	  
	 
   }   

    public function SetGridPago($Attributes,$Titles,$Cols,$Query){
    require_once("../../../framework/clases/grid/JqGridClass.php");
	  
     $TableGrid = new JqGrid();
 	   $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $head = "'<head>".
	 
     $TableGrid -> GetJqGridJs()." ".
    
     $TableGrid -> GetJqGridCss()."
    
     </head>";
     
     $body = "<body>".$TableGrid -> RenderJqGrid()."</body>";
    
     return "<html>".$head." ".$body."</html>";
    }
     
    public function RenderMain(){
      $this ->RenderLayout('pago.tpl');
    }

}

?>