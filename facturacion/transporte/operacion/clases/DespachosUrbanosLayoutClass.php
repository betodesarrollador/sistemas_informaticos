<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DespachosUrbanosLayout extends View{

   private $fields;
   
   public function setGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function setActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }
   
   public function setAnular($Permiso){
   	 $this -> Anular = $Permiso;
   }      
   
   public function setBorrar($Permiso){
   	 $this -> Borrar = $Permiso;
   }
   
   public function setLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function setImprimir($Permiso){
     $this -> Imprimir = $Permiso;
   }
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("DespachosUrbanosClass.php","DespachosUrbanosForm","DespachosUrbanosForm");
	 $Form2 = new Form("DespachosUrbanosClass.php","DespachosUrbanosLiquidacionForm","DespachosUrbanosLiquidacionForm");	 
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("../../../transporte/operacion/css/Manifiestos.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../transporte/operacion/js/DespachosUrbanos.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 
     $this -> assign("CSSSYSTEM",		$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",		$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",			$Form1 -> FormBegin());
     $this -> assign("FORM1END",		$Form1 -> FormEnd());
     $this -> assign("FORM2",			$Form2 -> FormBegin());
     $this -> assign("FORM2END",		$Form2 -> FormEnd());	 
     $this -> assign("BUSQUEDA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));	 
     $this -> assign("MANIFIESTOID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[despachos_urbanos_id]));
     $this -> assign("UPDATEMANIFIESTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[updateManifiesto]));	 	 
     $this -> assign("FECHASTATIC",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_static]));	 	 
     $this -> assign("EMPRESAIDSTATIC",	$this -> objectsHtml -> GetobjectHtml($this -> fields[empresa_id_static]));	 	 
     $this -> assign("OFICINAIDSTATIC",	$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id_static]));	 
     $this -> assign("OFICINAID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	 
     $this -> assign("EMPRESAID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[empresa_id]));	 	 
     $this -> assign("MANIFIESTO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[despacho]));
     $this -> assign("SERVICIOTRANSPORTE",	$this -> objectsHtml -> GetobjectHtml($this -> fields[servicio_transporte_id]));
     $this -> assign("FECHAMANIFIESTO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_du]));
     $this -> assign("FECHAENTREGA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_entrega_mcia_du]));	 
     $this -> assign("HORAENTREGA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[hora_entrega]));	 	 	 
     $this -> assign("ORIGEN",			$this -> objectsHtml -> GetobjectHtml($this -> fields[origen]));
     $this -> assign("ORIGENID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[origen_id]));
     $this -> assign("ORIGENDIVIPOLA",  $this -> objectsHtml -> GetobjectHtml($this -> fields[origen_divipola]));	 
     $this -> assign("DESTINO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[destino]));
     $this -> assign("DESTINOID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[destino_id]));	
     $this -> assign("DESTINODIVIPOLA", $this -> objectsHtml -> GetobjectHtml($this -> fields[destino_divipola]));		 	 
     $this -> assign("MODALIDAD",		$this -> objectsHtml -> GetobjectHtml($this -> fields[modalidad]));	 	       
     $this -> assign("CARGUEPAGADOPOR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[cargue_pagado_por]));	 
     $this -> assign("DESCARGUEPAGADOPOR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[descargue_pagado_por]));	          
     $this -> assign("TITULARID",$this -> objectsHtml -> GetobjectHtml($this -> fields[titular_despacho_id]));	 
     $this -> assign("TITULAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[titular_despacho]));	 
     $this -> assign("NUMEROIDENTIFICACIONTITULAR",$this->objectsHtml->GetobjectHtml($this-> fields[numero_identificacion_titular_despacho])); 
     $this -> assign("DIRECCIONTITULAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[direccion_titular_despacho]));	 
     $this -> assign("TELEFONOTITULAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[telefono_titular_despacho]));	      
     $this -> assign("CIUDADTITULAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[ciudad_titular_despacho]));	      
     $this -> assign("CIUDADTITULARDIVIPOLA",$this -> objectsHtml -> GetobjectHtml($this -> fields[ciudad_titular_despacho_divipola]));     
     $this -> assign("PLACAVEHICULO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[placa]));
     $this -> assign("PLACAVEHICULOID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[placa_id]));	 
     $this -> assign("PROPIO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[propio]));	 	 
     $this -> assign("REMOLQUE",	$this -> objectsHtml -> GetobjectHtml($this -> fields[remolque]));	 	 	 	 
     $this -> assign("MARCAVEHICULO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[marca]));
     $this -> assign("LINEAVEHICULO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[linea]));	 	 
     $this -> assign("MODELOVEHICULO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[modelo]));
     $this -> assign("MODELOREPOTENCIADOVEHICULO",$this -> objectsHtml -> GetobjectHtml($this -> fields[modelo_repotenciado]));
     $this -> assign("SERIEVEHICULO",	           $this -> objectsHtml -> GetobjectHtml($this -> fields[serie]));	 
     $this -> assign("COLORVEHICULO",		   $this -> objectsHtml -> GetobjectHtml($this -> fields[color]));
     $this -> assign("CARROCERIAVEHICULO",	   $this -> objectsHtml -> GetobjectHtml($this -> fields[carroceria]));
     $this -> assign("REGISTRONALCARGAVEHICULO",  $this -> objectsHtml -> GetobjectHtml($this -> fields[registro_nacional_carga]));
     $this -> assign("CONFIGURACIONVEHICULO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[configuracion]));
     $this -> assign("PESOVACIOVEHICULO",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[peso_vacio])); 	 	 	 	 	
     $this -> assign("NUMEROSOATVEHICULO",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[numero_soat]));
     $this -> assign("ASEGURADORASOATVEHICULO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre_aseguradora]));
     $this -> assign("VENCIMIENTOSOATVEHICULO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[vencimiento_soat]));    
     $this -> assign("PLACAREMOLQUE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[placa_remolque]));
     $this -> assign("PLACAREMOLQUEID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[placa_remolque_id]));	 
	 
     $this -> assign("PROPIETARIOREMOLQUE",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[propietario_remolque]));	 
     $this -> assign("TIPOIDENTIFICACIONPROPIETARIOREMOLQUE",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_identificacion_propietario_remolque_codigo]));	 
     $this -> assign("DOCIDENTIFICACIONPROPIETARIOREMOLQUE",$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_identificacion_propietario_remolque]));	 		 
	 
	 
     $this -> assign("CONDUCTORID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[conductor_id]));
     $this -> assign("NUMEROIDENTIFICACION",$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_identificacion]));
     $this -> assign("NOMBRECONDUCTOR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));	 
     $this -> assign("DIRECCIONCONDUCTOR",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[direccion_conductor]));
	 
     $this -> assign("LICENCIACONDUCTOR",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[numero_licencia_cond]));	 
	 
	 
     $this -> assign("CATEGORIALICENCIACONDUCTOR",	  $this -> objectsHtml -> GetobjectHtml($this -> fields[categoria_licencia_conductor]));	 	 
     $this -> assign("TELEFONOCONDUCTOR",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[telefono_conductor]));     
	 $this -> assign("CIUDADCONDUCTOR",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[ciudad_conductor]));	 	 	 	 	 	     $this -> assign("PROPIETARIO",		              $this -> objectsHtml -> GetobjectHtml($this -> fields[propietario]));
     $this -> assign("TIPOIDENTIFICACIONPROPIETARIO",  $this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_identificacion_propietario_codigo]));	
     $this -> assign("DOCIDENTIFICACIONPROPIETARIO",  $this -> objectsHtml -> GetobjectHtml($this -> fields[numero_identificacion_propietario]));
     $this -> assign("DIRECCIONPROPIETARIO",		  $this -> objectsHtml -> GetobjectHtml($this -> fields[direccion_propietario]));
     $this -> assign("TELEFONOPROPIETARIO",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[telefono_propietario]));
     $this -> assign("CIUDADPROPIETARIO",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[ciudad_propietario]));	 	 	 	 	 	     $this -> assign("TENEDOR",		                  $this -> objectsHtml -> GetobjectHtml($this -> fields[tenedor]));
     $this -> assign("TENEDORID",		              $this -> objectsHtml -> GetobjectHtml($this -> fields[tenedor_id]));	 	 
     $this -> assign("TIPOIDENTIFICACIONTENEDOR",      $this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_identificacion_tenedor_codigo]));	 
     $this -> assign("DOCIDENTIFICACIONTENEDOR",      $this -> objectsHtml -> GetobjectHtml($this -> fields[numero_identificacion_tenedor]));
     $this -> assign("DIRECCIONTENEDOR",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[direccion_tenedor]));
     $this -> assign("TELEFONOTENEDOR",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[telefono_tenedor]));
     $this -> assign("CIUDADTENEDOR",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[ciudad_tenedor]));	 	 	 	 
     $this -> assign("OBSERVACIONES",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[observaciones]));	     
	 $this -> assign("CLIENTE",		                  $this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));	 	 	 	 	 
     $this -> assign("CLIENTEID",		              $this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));	 	 	 	 	 	 
     $this -> assign("DTAID",		                  $this -> objectsHtml -> GetobjectHtml($this -> fields[dta_id]));	 	 	 	 
     $this -> assign("NUMEROFORMULARIO",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[numero_formulario]));	 	 	 	 	 
     $this -> assign("IMAGENFORMULARIO",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[imagen_formulario]));		 	 	 	 
     $this -> assign("FECHACONSIGNACION",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_consignacion]));	 	 	 	 	 	 	 
     $this -> assign("FECHAENTREGADTA",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_entrega_dta]));	 	 	 	 	 	 	 	 
     $this -> assign("NUMEROCONTENEDORDTA",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[numero_contenedor_dta]));	 
     $this -> assign("NAVIERA",		                  $this -> objectsHtml -> GetobjectHtml($this -> fields[naviera]));	 	 
	 
	 
     $this -> assign("TARA",		                  $this -> objectsHtml -> GetobjectHtml($this -> fields[tara]));	 	 
     $this -> assign("TIPO",		                  $this -> objectsHtml -> GetobjectHtml($this -> fields[tipo]));	 	 	 
     $this -> assign("FOTOPOSTERIOR",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[foto_posterior]));	 	 	 	 	 	 	 	 	 	 	 	 
     $this -> assign("FOTOANTERIOR",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[foto_anterior]));	 	 	 	 	 	 	 	 	 	 	 	 	 
     $this -> assign("FOTOLATERALDERECHA",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[foto_lateral_derecha]));	  
     $this -> assign("FOTOLATERALIZQUIERDA",		  $this -> objectsHtml -> GetobjectHtml($this -> fields[foto_lateral_izquierda]));	  
     $this -> assign("NUMEROPRECINTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_precinto]));	 	 	 	 	 	 	 	 	 	 	 	 	 		
     $this -> assign("FOTOPRECINTO",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[foto_precinto]));	 	 	 	 	 	 	 	 	 	 	 	 	 		
     $this -> assign("FOTOPRECINTONORMAL",		       $this -> objectsHtml -> GetobjectHtml($this -> fields[foto_precinto_normal]));	 	 	 	 	     $this -> assign("FOTOAMARRES",		       $this -> objectsHtml -> GetobjectHtml($this -> fields[foto_amarres]));	 	 	 	 	 	 	 	 	 	 	 	 	 			 

     $this -> assign("CLIENTE",		                  $this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));	 	 	 	 	 	 		
     $this -> assign("NUMEROIDENTIFICACIONCLIENTE",	  $this -> objectsHtml -> GetobjectHtml($this -> fields[numero_identificacion_cliente]));	 	 	 	 $this -> assign("CODIGO",	                      $this -> objectsHtml -> GetobjectHtml($this -> fields[codigo]));	 	 	 	 	 	 	 	 	 	 $this -> assign("PRODUCTO",	                  $this -> objectsHtml -> GetobjectHtml($this -> fields[producto]));	 	 	 	 	 	 	 	
     $this -> assign("PRODUCTOID",	                  $this -> objectsHtml -> GetobjectHtml($this -> fields[producto_id]));	 	 	 	 	 	 	 
     $this -> assign("PESO",	                      $this -> objectsHtml -> GetobjectHtml($this -> fields[peso]));	 	 	 	 	 	 	 	  		
     $this -> assign("RESPONSABLEDIAN",	              $this -> objectsHtml -> GetobjectHtml($this -> fields[responsable_dian]));	     
	 $this -> assign("RESPONSABLEEMPRESA",	          $this -> objectsHtml -> GetobjectHtml($this -> fields[responsable_empresa]));	 	 
	 $this -> assign("OBSERVACIONESDTA",	          $this -> objectsHtml -> GetobjectHtml($this -> fields[observaciones_dta]));	 	 
	 $this -> assign("ESTADO",	                      $this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));	 	 	 	 	 	 	 	 
     $this -> assign("VALORFLETE",		              $this -> objectsHtml -> GetobjectHtml($this -> fields[valor_flete]));	 	 	 	 
     $this -> assign("NETOPAGAR",		              $this -> objectsHtml -> GetobjectHtml($this -> fields[valor_neto_pagar]));	 	 	 	 
     $this -> assign("SALDOPAGAR",		              $this -> objectsHtml -> GetobjectHtml($this -> fields[saldo_por_pagar]));	 	 	 	 
	 $this -> assign("FECHAPAGOSALDO",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_pago_saldo]));	 	 	 	 	 	 	 $this -> assign("LUGARPAGOSALDO",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[lugar_pago_saldo]));	 	 	 	 	 		 	 $this -> assign("ESTADODTA",		              $this -> objectsHtml -> GetobjectHtml($this -> fields[estado_dta]));	 
     $this -> assign("OBSERVANULACION",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[observacion_anulacion]));
	 $this -> assign("IDMOBILE",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[id_mobile]));	  	 	 	 	 	 	 	 	 	 	 	 		 	 	  	 	 	 	 	 	 	 	 	 	 	 		 	 
	 	 
     if($this -> Guardar)
	   $this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar){
     $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
     $this -> assign("CAUSAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[causar]));
   }
     if($this -> Anular)
	   $this -> assign("ANULAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	   
	 if($this -> Imprimir)	   
   	   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	   
	   
   	   $this -> assign("MANIFESTAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[manifestar]));
   	   $this -> assign("SELECCIONARREMESAS",$this -> objectsHtml -> GetobjectHtml($this -> fields[importRemesas]));	  
	   
       $this -> assign("USUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));	  
   	   $this -> assign("USUARIOREGISTRA",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_registra]));	  
   	   $this -> assign("USUARIONUMID",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_registra_numero_identificacion]));	  	  	   	   
	   
	    
	   
	   
   }
   
//LISTA MENU
   
   public function setDescuentos($descuentos){
	 $this -> assign("DESCUENTOS",$descuentos);   
   }
   
   public function setImpuestos($impuestos){
	 $this -> assign("IMPUESTOS",$impuestos);      
   }
   
    public function setImpuestosica($impuestos){
	 $this -> assign("IMPUESTOS1",$impuestos);      
   }
   
   public function setLugaresPagoSaldo($lugaresSaldo){
     $this -> fields[oficina_pago_saldo_id][options] = $lugaresSaldo;
	 $this -> assign("LUGARESSALDO",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_pago_saldo_id]));   
   }
   
   public function setFormasPago($formas_pago){
	 $this -> assign("FORMASPAGO",$formas_pago);   
   }
   
   public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALANULACIONID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   }   
   
//// GRID ////
   public function SetGridDespachosUrbanos($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDDESPACHOS",$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('DespachosUrbanos.tpl');
	 
   }


}


?>