<?php

require_once("../../../framework/clases/ViewClass.php");

final class GuiaReenvioLayout extends View{

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
   
   public function setAnular($Permiso){
   	 $this -> Anular = $Permiso;
   }     
   
   public function setLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function setImprimir($Permiso){
     $this -> Imprimir = $Permiso;
   }
   
   public function setCampos($campos){
     
	 require_once("../../../framework/clases/FormClass.php");	 
	 $Form1 = new Form("GuiaReenvioClass.php","GuiaReenvioForm","GuiaReenvioForm");	 
	
	 $this -> fields = $campos;	 
     
	 $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/velotax/mensajeria/operacion/css/GuiaReenvio.css");	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/mensajeria/operacion/js/GuiaReenvio.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funcionesDetalle.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");	 
	 
     $this -> assign("CSSSYSTEM",	   		  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			  $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				  $Form1 -> FormBegin());
     $this -> assign("FORM1END",			  $Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			  $this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("OFICINAID",			  $this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	 
     $this -> assign("OFICINAIDSTATIC",		  $this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id_static]));
	 $this -> assign("TIPOIDENTIFICACIONID",  $this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_identificacion_id]));
//     $this -> assign("CLIENTE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));
//     $this -> assign("CLIENTEID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));     
	 
	 // ----- INFORMACION GENERAL ----- //
   $this -> assign("GUIAIDPADRE",       $this -> objectsHtml -> GetobjectHtml($this -> fields[guia_id_padre]));
   $this -> assign("NUMEROGUIAPADRE",       $this -> objectsHtml -> GetobjectHtml($this -> fields[numero_guia_padre]));
	 $this -> assign("ID",               $this -> objectsHtml -> GetobjectHtml($this -> fields[guia_id]));	 
	 $this -> assign("TIPOSERVICIOID",	   	$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_servicio_mensajeria_id]));
	 // $this -> assign("TIPOENVIOID",		   	$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_envio_id]));
	 $this -> assign("ESTADOMENSAJERIAID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_mensajeria_id]));	
     $this -> assign("NUMEROGUIA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_guia]));	 
     $this -> assign("FECHA",			   	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha]));
     $this -> assign("FECHAGUIA",		   	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_guia]));
     // $this -> assign("PLANILLA",   		   	$this -> objectsHtml -> GetobjectHtml($this -> fields[planilla]));
     // $this -> assign("SOLICITUDSERVICIO",  	$this -> objectsHtml -> GetobjectHtml($this -> fields[solicitud_id]));	 
     $this -> assign("FORMAPAGO",    	   	$this -> objectsHtml -> GetobjectHtml($this -> fields[forma_pago_mensajeria_id]));
     $this -> assign("CLASESERVICIOID",    	$this -> objectsHtml -> GetobjectHtml($this -> fields[clase_servicio_mensajeria_id]));	 
     // $this -> assign("SOLICITUDID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[solicitud_id]));
	 
	 // ----- PRODUCTOS ----- //		 
     //$this -> assign("PRODUCTOID",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[producto_id]));
     $this -> assign("DESCRIPCIONPRODUCTO",   $this -> objectsHtml -> GetobjectHtml($this -> fields[descripcion_producto]));
     $this -> assign("CANTIDAD",    $this -> objectsHtml -> GetobjectHtml($this -> fields[cantidad]));
     $this -> assign("PESONETO",    $this -> objectsHtml -> GetobjectHtml($this -> fields[peso]));
     $this -> assign("VALORDECLARADO",  $this -> objectsHtml -> GetobjectHtml($this -> fields[valor]));  
     $this -> assign("LARGO",     $this -> objectsHtml -> GetobjectHtml($this -> fields[largo]));
     $this -> assign("ANCHO",     $this -> objectsHtml -> GetobjectHtml($this -> fields[ancho]));
     $this -> assign("ALTO",      $this -> objectsHtml -> GetobjectHtml($this -> fields[alto]));
   $this -> assign("PESOVOLUMEN",   $this -> objectsHtml -> GetobjectHtml($this -> fields[peso_volumen]));
   $this -> assign("GUIACLIENTE",   $this -> objectsHtml -> GetobjectHtml($this -> fields[guia_cliente]));
     $this -> assign("OBSERVACIONES", $this -> objectsHtml -> GetobjectHtml($this -> fields[observaciones])); 
	 
	 // ----- DATOS ENVIO ----- //
	 // ----- DATOS REMITENTE -----//
     $this -> assign("ORIGEN",							$this -> objectsHtml -> GetobjectHtml($this -> fields[origen]));
     $this -> assign("ORIGENID",						$this -> objectsHtml -> GetobjectHtml($this -> fields[origen_id]));	 
   //  $this -> assign("TIPOIDENTIFICACIONREMITENTEID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_identificacion_remitente_id]));
	 $this -> assign("DOCUMENTOREMITENTE",				$this -> objectsHtml -> GetobjectHtml($this -> fields[doc_remitente]));
     $this -> assign("REMITENTE",						$this -> objectsHtml -> GetobjectHtml($this -> fields[remitente]));
     $this -> assign("REMITENTEID",						$this -> objectsHtml -> GetobjectHtml($this -> fields[remitente_id]));
     $this -> assign("DIRECCIONREMITENTE",				$this -> objectsHtml -> GetobjectHtml($this -> fields[direccion_remitente]));
     $this -> assign("TELEFONOREMITENTE",				$this -> objectsHtml -> GetobjectHtml($this -> fields[telefono_remitente]));
     // $this -> assign("CORREOREMITENTE",					$this -> objectsHtml -> GetobjectHtml($this -> fields[correo_remitente]));
	 
	 // ----- DATOS DESTINATARIO ----- //
     $this -> assign("DESTINO",								$this -> objectsHtml -> GetobjectHtml($this -> fields[destino]));
     $this -> assign("DESTINOID",							$this -> objectsHtml -> GetobjectHtml($this -> fields[destino_id]));	 
    // $this -> assign("TIPOIDENTIFICACIONDESTINATARIOID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_identificacion_destinatario_id]));
	 $this -> assign("DOCUMENTODESTINATARIO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[doc_destinatario]));
     $this -> assign("DESTINATARIO",						$this -> objectsHtml -> GetobjectHtml($this -> fields[destinatario]));
     $this -> assign("DESTINATARIOID",						$this -> objectsHtml -> GetobjectHtml($this -> fields[destinatario_id]));	 
     $this -> assign("DIRECCIONDESTINATARIO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[direccion_destinatario]));
     $this -> assign("TELEFONODESTINATARIO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[telefono_destinatario]));
     // $this -> assign("CORREODESTINATARIO",					$this -> objectsHtml -> GetobjectHtml($this -> fields[correo_destinatario]));
     $this -> assign("RECIBE",								$this -> objectsHtml -> GetobjectHtml($this -> fields[quienrecibe]));
	 
	 // ----- COSTOS ENVIO ----- //
     $this -> assign("COSTOMANEJO",	    		$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_manejo]));
     $this -> assign("VFLETE",	        		$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_flete]));	 
     $this -> assign("VSEGURO",	        		$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_seguro]));	 
     $this -> assign("VOTROS",	    			$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_otros]));	 	 	 	 
     $this -> assign("VTOTAL",	    			$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_total]));	 
	 
	 // ----- OBSERVACIONES ----- //
	 // $this -> assign("OBSERVACIONES2",		   $this -> objectsHtml -> GetobjectHtml($this -> fields[observaciones2]));
 	 // $this -> assign("MOTIVODEVOLUCIONID",	   $this -> objectsHtml -> GetobjectHtml($this -> fields[motivo_devolucion_id]));
	 // $this -> assign("FECHAENTREGA",		   $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_entrega]));

     $this -> assign("FORMATO",	                $this -> objectsHtml -> GetobjectHtml($this -> fields[formato]));
	 $this -> assign("ESTADO",	                $this -> objectsHtml -> GetobjectHtml($this -> fields[estado_mensajeria_id]));	
     // $this -> assign("OBSERVANULACION",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[observacion_anulacion]));	
	 
	 $this -> assign("RANGODESDE",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[rango_desde]));		 
	 $this -> assign("RANGOHASTA",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[rango_hasta]));		 	 
	 $this -> assign("ORDENSERVICIO",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[orden_servicio]));		 	 
	 $this -> assign("FECHAGUIACREA",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_guia_crea]));		 	 

///////////////////////////////////////////////////////////
	 
     if($this -> Guardar)
	   $this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
     if($this -> Anular)
	   $this -> assign("ANULAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));	   
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));

     if($this -> Imprimir){	   
	   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
	   $this -> assign("PRINTOUT",$this -> objectsHtml -> GetobjectHtml($this -> fields[print_out]));	   
	   $this -> assign("PRINTCANCEL",$this -> objectsHtml -> GetobjectHtml($this -> fields[print_cancel]));	   	   	   
	 }	   
   }

//LISTA MENU  
   /*public function  setProductos($productos){
     $this -> fields[producto_id][options] = $productos;
	 $this -> assign("PRODUCTOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[producto_id]));
   }*/
   
 /*  public function setRangoDesde($rangoDesde){
	 $this -> fields[rango_desde]['options'] = $rangoDesde;
     $this -> assign("RANGODESDE",$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_desde]));    
   }*/
   
   public function setRangoHasta($rangoHasta){
	 $this -> fields[rango_hasta]['options'] = $rangoHasta;
     $this -> assign("RANGOHASTA",$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_hasta]));    
   }   

/*   public function SetTipoEnvio($TipoEnvio){
	 $this -> fields[tipo_envio_id]['options'] = $TipoEnvio;
	 $this -> assign("TIPOENVIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_envio_id]));
   }*/
   
   public function SetClaseServicio($ClaseServicio){
	 $this -> fields[clase_servicio_mensajeria_id]['options'] = $ClaseServicio;
	 $this -> assign("CLASESERVICIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[clase_servicio_mensajeria_id]));
   }   
  
   public function SetTipoServicio($TipoServicio){
	 $this -> fields[tipo_servicio_mensajeria_id]['options'] = $TipoServicio;
	 $this -> assign("TIPOSERVICIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_servicio_mensajeria_id]));
   }

   public function SetTipoMedida($medida){
	 $this -> fields[medida_id]['options'] = $medida;
	 $this -> assign("MEDIDAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[medida_id]));
   }

   public function SetEstadoMensajeria($EstadoMensajeria){
	 $this -> fields[estado_mensajeria_id]['options'] = $EstadoMensajeria;
	 $this -> assign("ESTADOMENSAJERIAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_mensajeria_id]));
   }   
   
   public function SetFormaPago($FormaPago){
	 $this -> fields[forma_pago_mensajeria_id]['options'] = $FormaPago;
	 $this -> assign("FORMAPAGOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[forma_pago_mensajeria_id]));
   }      
   
  //  public function SetMotivoDevolucion($MotivoDevolucion){
	 // $this -> fields[motivo_devolucion_id]['options'] = $MotivoDevolucion;
	 // $this -> assign("MOTIVODEVOLUCIONID",$this -> objectsHtml -> GetobjectHtml($this -> fields[motivo_devolucion_id]));
  //  }  
   
   public function SetTipoIdentificacion($TipoIdentificacion){
	 $this -> fields[tipo_identificacion_id]['options'] = $TipoIdentificacion;
	 $this -> assign("TIPOIDENTIFICACIONID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_identificacion_id]));
   }  

   public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALANULACIONID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   }   
////////////////////////////////////////

//// GRID ////
  public function SetGridGuiaReenvioOficinas($Attributes,$Titles,$Cols,$Query,$SubAttributes,$SubTitles,$SubCols,$SubQuery){  
  
	require_once("../../../framework/clases/grid/JqGridClass.php");
	
	$TableGrid = new JqGrid();		
	$TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query,$SubAttributes,$SubTitles,$SubCols,$SubQuery);	
	
    $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
    $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");	
    $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
	
    $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());	
    $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());	
	$this -> assign("GRIDGUIA",		$TableGrid -> RenderJqGrid());
	$this -> assign("TABLEGRIDCSS",	$TableGrid -> GetJqGridCss());
	$this -> assign("TABLEGRIDJS",	$TableGrid -> GetJqGridJs());   	
  }
////////////////////////////////////////

   public function RenderMain(){
		$this -> RenderLayout('GuiaReenvio.tpl');
   }
}

?>