<?php

require_once("../../../framework/clases/ViewClass.php");

final class FacturaLayout extends View{

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
   public function setImprimir($Permiso){
     $this -> Imprimir = $Permiso;
   }
   
   
   public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("FacturaClass.php","FacturaForm","FacturaForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	   $this -> TplInclude -> IncludeCss("../../../facturacion/factura/css/factura.css");
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
     $this -> TplInclude -> IncludeJs("../../../facturacion/factura/js/factura.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	   $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("FACTURAID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[factura_id]));
     $this -> assign("NUMSOPORTE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[consecutivo_factura]));
	   $this -> assign("CLIENTE",				$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));
     $this -> assign("CLIENTEID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));	 	 	 	 
    $this -> assign("CLIENTENIT",			$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_nit]));	
    $this -> assign("CLIENTEDIREC",		$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_direccion]));	 
    $this -> assign("CLIENTETELE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_tele]));	
    $this -> assign("CLIENTEEMAIL",			$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_email]));	
    $this -> assign("CLIENTECIUDAD",		$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_ciudad]));		 
    $this -> assign("FECHAFACPRO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha]));		 	 
    $this -> assign("VENCEFACPRO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[vencimiento]));		 	 	 
    $this -> assign("VALOR",				$this -> objectsHtml -> GetobjectHtml($this -> fields[valor]));	
    $this -> assign("FECHAINGRESO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[ingreso_factura]));		 
    $this -> assign("ESTADO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));		 	 
    $this -> assign("CONCEPTO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[concepto]));		 
    $this -> assign("CONCEPTOITEM",		$this -> objectsHtml -> GetobjectHtml($this -> fields[concepto_item]));	
    $this -> assign("OBSERVACION",			$this -> objectsHtml -> GetobjectHtml($this -> fields[observacion]));	
    $this -> assign("NPAGOS",				$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_pagos]));		
    $this -> assign("TIMPRE",				$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_impre]));	
    $this -> assign("RADICFAC",			$this -> objectsHtml -> GetobjectHtml($this -> fields[radicacion]));
    
    $this -> assign("SEDES",				$this -> objectsHtml -> GetobjectHtml($this -> fields[sedes]));
    $this -> assign("IMPUESTOID",				$this -> objectsHtml -> GetobjectHtml($this -> fields[impuesto_id]));

    $this -> assign("ADJUNTO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[adjunto]));
    
    $this -> assign("AGREGARNUMEROS",				$this -> objectsHtml -> GetobjectHtml($this -> fields[numeros_agregar]));
    $this -> assign("CODIGODEBARRAS",				$this -> objectsHtml -> GetobjectHtml($this -> fields[codigo_barras]));
    $this -> assign("EXCELAGREGAR",				$this -> objectsHtml -> GetobjectHtml($this -> fields[excel_cargar]));


	 /***********************
	     Anulacion Registro
	 ***********************/
	 
	 $this -> assign("FECHALOG",$this -> objectsHtml -> GetobjectHtml($this -> fields[anul_factura]));	   
	 $this -> assign("OBSERVACIONES",$this -> objectsHtml -> GetobjectHtml($this -> fields[desc_anul_factura]));	   	 


	
     if($this -> Guardar){
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   $this -> assign("REPORTAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[reportar]));
	   $this -> assign("REPORTARVP",$this -> objectsHtml -> GetobjectHtml($this -> fields[reportarvp]));

	 }
	 if($this -> Actualizar){
	   	$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
 	   	$this -> assign("CONTABILIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[contabilizar]));
	    $this -> assign("RECONTABILIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[recontabilizar]));
      $this -> assign("ENVIOFACTURA",$this -> objectsHtml -> GetobjectHtml($this -> fields[envio_factura]));
      $this	->	assign("SELECCIONAR",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[confirmar]));

	 }
	  
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	   
	 if($this -> Anular)
	   $this -> assign("ANULAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));	   
	   
	 if($this -> Imprimir)	   
   	   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
     $this -> assign("IMPRIMIR1",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir1]));
     $this -> assign("PDF",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir_pdf]));	 	 
	   
	   
    }
	


    public function SetFuente($IdFuente){
	  $this -> fields[fuente_facturacion_cod]['options'] = $IdFuente;
      $this -> assign("FUENTEID",$this -> objectsHtml -> GetobjectHtml($this -> fields[fuente_facturacion_cod]));
    }

    public function SetServiOs($IdServiOs){
	  $this -> fields[tipo_bien_servicio_factura_os]['options'] = $IdServiOs;
      $this -> assign("SERV_OS",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_bien_servicio_factura_os]));
    }

    public function SetServiRm($IdServiRm){
	  $this -> fields[tipo_bien_servicio_factura_rm]['options'] = $IdServiRm;
      $this -> assign("SERV_RM",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_bien_servicio_factura_rm]));
    }

    public function SetServiSt($IdServist){
	  $this -> fields[tipo_bien_servicio_factura_st]['options'] = $IdServist;
      $this -> assign("SERV_ST",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_bien_servicio_factura_st]));
    }

    public function SetFormaCom($IdFormaCom){
	  $this -> fields[forma_compra_venta_id]['options'] = $IdFormaCom;
      $this -> assign("FORMACOM",$this -> objectsHtml -> GetobjectHtml($this -> fields[forma_compra_venta_id]));
    }

    public function SetTipoFac($IdTipoFac){
	  $this -> fields[tipo_factura_id]['options'] = $IdTipoFac;
      $this -> assign("TIPOFAC",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_factura_id]));
    }

   public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALESID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   }

   public function setReteica($impuesto){
	   $this -> fields[impuesto]['options'] = $impuesto;
     $this -> assign("RETEICA",$this -> objectsHtml -> GetobjectHtml($this -> fields[impuesto]));	  	   
   }

    public function setFactura($factura_id){
	    $this -> fields[factura_id]['value'] = $factura_id;
      $this -> assign("FACTURAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[factura_id]));	  	   
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

    public function SetGridFactura($Attributes,$Titles,$Cols,$Query){
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
      $this ->RenderLayout('Factura.tpl');
    }

}

?>