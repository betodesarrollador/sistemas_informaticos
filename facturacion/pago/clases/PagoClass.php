<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Pago extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("PagoLayoutClass.php");
	require_once("PagoModelClass.php");
	
	$Layout   = new PagoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new PagoModel();
	

	$empresa_id = $this -> getEmpresaId();
	$oficina_id = $this -> getOficinaId();	

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
	$Layout -> SetAnular	($Model -> getPermiso($this -> getActividadId(),ANULAR,$this -> getConex()));	
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU	
   	$Layout -> SetTiposPago($Model -> GetTipoPago($this -> getConex()));
	$Layout -> SetDocumento($Model -> GetDocumento($this -> getConex()));
	$Layout -> setUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
	$Layout -> setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));
	$Layout -> setDocumentorev($Model -> getDocumentorev($this -> getConex()));

	$abono_factura_id = $_REQUEST['abono_factura_id'];

	if ($abono_factura_id > 0) {
    $Layout->setFactura($abono_factura_id);
	}

	$Layout -> RenderMain();
  
  }
  
  protected function showGrid(){
	  
	require_once("PagoLayoutClass.php");
	require_once("PagoModelClass.php");
	
	$Layout   = new PagoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new PagoModel();
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'pago',
		title		=>'Listado de Pagos',
		sortname	=>'fecha',
		width		=>'auto',
		height	=>'250'
	  );
  
	  $Cols = array(
		array(name=>'fecha',						index=>'fecha',						sorttype=>'date',	width=>'120',	align=>'left'),
		array(name=>'ingreso_abono_factura',		index=>'ingreso_abono_factura',		sorttype=>'date',	width=>'120',	align=>'left'),
		array(name=>'tipo_doc',					index=>'tipo_doc',					sorttype=>'text',	width=>'120',	align=>'left'),
		array(name=>'num_ref',					index=>'num_ref',					sorttype=>'text',	width=>'90',	align=>'left'),	 
		array(name=>'cliente',					index=>'cliente',					sorttype=>'text',	width=>'140',	align=>'left'),
		array(name=>'forma_pago',					index=>'forma_pago',				sorttype=>'text',	width=>'140',	align=>'left'),
		array(name=>'concepto_abono_factura',		index=>'concepto_abono_factura',	sorttype=>'text',	width=>'200',	align=>'left'),
		array(name=>'valor_abono_factura',		index=>'valor_abono_factura',		sorttype=>'text',	width=>'100',	align=>'center', format => 'currency'),
		array(name=>'estado_abono_factura',		index=>'estado_abono_factura',		sorttype=>'text',	width=>'100',	align=>'left')	  
	  );
		
	  $Titles = array('FECHA PAGO',
					  'FECHA INGRESO',
					  'DOCUMENTO',
					  'No',
					  'CLIENTE',
					  'FORMA PAGO',					
					  'CONCEPTO',
					  'VALOR',
					  'ESTADO'
	  );
	  
	 $html = $Layout -> SetGridPago($Attributes,$Titles,$Cols,$Model -> GetQueryPagoGrid());
	 
	 print $html;
	  
  }

  protected function onclickValidateRow(){
	require_once("PagoModelClass.php");
    $Model = new PagoModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

	require_once("PagoModelClass.php");
	$Model = new PagoModel();
/* 	$tipo_documento_id = $_REQUEST['tipo_documento_id'];
	$motivo_nota = $_REQUEST['motivo_nota'];	
	$data_doc = $Model -> getDataDocumento($tipo_documento_id,$this -> getConex());
	if($data_doc[0]['nota_credito']==1 && ($motivo_nota=='NULL' || $motivo_nota=='') ){
		exit('Este documento esta configurado como Nota Credito.<br>  Por favor seleccione un Motivo Nota');	
	}  */
	$empresa_id = $this -> getEmpresaId();
	$return = $Model -> Save($empresa_id,$this -> Campos,$this -> getConex());
	if(strlen(trim($Model -> GetError())) > 0){
		exit("Error : ".$Model -> GetError());
	}else{
		if(is_numeric($return)){
			exit("$return");
	  	}else{
	  		exit('false');
		}
	}
  }

  protected function onclickUpdate(){
 
  	require_once("PagoModelClass.php");
    $Model = new PagoModel();
	$tipo_documento_id = $_REQUEST['tipo_documento_id'];
	$motivo_nota = $_REQUEST['motivo_nota'];	
	$data_doc = $Model -> getDataDocumento($tipo_documento_id,$this -> getConex());
	if($data_doc[0]['nota_credito']==1 && ($motivo_nota=='NULL' || $motivo_nota=='') ){
		exit('Este documento esta configurado como Nota Credito.<br>  Por favor seleccione un Motivo Nota');	
	}

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Pago');
	  }
	
  }

  protected function onclickCancellation(){
  
  	require_once("PagoModelClass.php");
    $Model = new PagoModel();
	$Model -> cancellation($this -> getConex());
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit('true');
	}
	
  }

  protected function OnclickReversar(){
  
  	require_once("PagoModelClass.php");
    $Model = new PagoModel();
	$empresa_id = $this -> getEmpresaId();  
	$oficina_id = $this -> getOficinaId();
	$usuario_id = $this -> getUsuarioId();
	$ingreso_abono_factura 	= $_REQUEST['rever_abono_factura'];

    $mesContable     = $Model -> mesContableEstaHabilitado($empresa_id,$oficina_id,$ingreso_abono_factura,$this -> getConex());
    $periodoContable = $Model -> PeriodoContableEstaHabilitado($this -> getConex());



	if($mesContable && $periodoContable){

		$return= $Model -> reversar($empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$this -> getConex());
		if($return==true){
			exit("true");
		}else{
			exit("Error : ".$Model -> GetError());
		}	
		
	}else{
			 
		if(!$mesContable && !$periodoContable){
			exit("No se permite Contabilizar en el periodo y mes seleccionado");
		}elseif(!$mesContable){
			exit("No se permite Contabilizar en el mes seleccionado");				 
		}else if(!$periodoContable){
			exit("No se permite Contabilizar en el periodo seleccionado");				   
		}
	}
  }
  protected function onclickPrint(){
  
    require_once("Imp_DocumentoClass.php");

    $print = new Imp_Documento();

    $print -> printOut($this -> getConex());
  
  }
  

//BUSQUEDA
  protected function onclickFind(){
	
	require_once("PagoModelClass.php");
    $Model = new PagoModel();
	
    $Data                	 	= array();
	$abono_factura_id = $_REQUEST['abono_factura_id'];
	 
	if(is_numeric($abono_factura_id)){
	  
	  $Data  = $Model -> selectDatosPagoId($abono_factura_id,$this -> getConex());
	  
	} 
	if($Data[0]['oficina_id']!=$this -> getOficinaId()) exit('Este Pago fue Realizado por la oficina  '.$Data[0]['oficina'].'</br> Por favor cons&uacute;ltelo por la oficina de Creaci&oacute;n.');
    $this -> getArrayJSON($Data);
	
  }

  protected function setDataCliente(){

    require_once("PagoModelClass.php");
    $Model = new PagoModel();    
    $cliente_id = $_REQUEST['cliente_id'];
    $data = $Model -> getDataCliente($cliente_id,$this -> getConex());
    $this -> getArrayJSON($data);

  }
  protected function setDataFactura(){

    require_once("PagoModelClass.php");
    $Model = new PagoModel();    
    $abono_factura_id = $_REQUEST['abono_factura_id'];
    $data = $Model -> getDataFactura($abono_factura_id,$this -> getConex());
    $this -> getArrayJSON($data);

  }
  
  protected function setSolicitud(){
  
	require_once("PagoModelClass.php");
    $Model     = new PagoModel();
    $factura_id = $_REQUEST['factura_id'];
    $nota_debito_id = $_REQUEST['nota_debito_id'];
	$return = $Model -> SelectSolicitud($factura_id,$nota_debito_id,$this -> getConex());
	
	if(count($return) > 0){
	  $this -> getArrayJSON($return);	
	}else{
	    exit('false');
	  }
  
  }
  
  protected function getEstadoEncabezadoRegistro($Conex=''){
	  
  	require_once("PagoModelClass.php");
    $Model           = new PagoModel();
	$abono_factura_id = $_REQUEST['abono_factura_id'];	
	$Estado = $Model -> selectEstadoEncabezadoRegistro($abono_factura_id,$this -> getConex());
	exit("$Estado");
	  
  } 

  protected function getTotalDebitoCredito(){
	  
  	require_once("PagoModelClass.php");
    $Model = new PagoModel();
	$abono_factura_id = $_REQUEST['abono_factura_id'];
	$data = $Model -> getTotalDebitoCredito($abono_factura_id,$this -> getConex());
	print json_encode($data);  
	  
  }
  protected function getContabilizar(){
	
  	require_once("PagoModelClass.php");
    $Model = new PagoModel();
	$abono_factura_id	= $_REQUEST['abono_factura_id'];
	$ingreso_abono_factura 		= $_REQUEST['ingreso_abono_factura'];
	$empresa_id = $this -> getEmpresaId();  
	$oficina_id = $this -> getOficinaId();	
	$usuario_id = $this -> getUsuarioId();

	$return=$Model -> getContabilizarReg($abono_factura_id,$empresa_id,$oficina_id,$usuario_id,$this -> getConex());
	if($return==true){
		exit("true");
	}else{
		exit("Error : ".$Model -> GetError());
	}	
		
  }

  protected function OnclickReportar(){

  	require_once("../../factura/clases/FacturaModelClass.php");
    $Model = new FacturaModel();
	
  	require_once("PagoModelClass.php");
    $Modelpago = new PagoModel();

	require_once("../../factura/clases/procesar.php");
    $FacturaElec = new FacturaElectronica();	
  	
	$abono_factura_id 	= $_REQUEST['abono_factura_id'];
	
	$data_facturas = $Modelpago -> selectFacturasAbonos($abono_factura_id,$this -> getConex());
	$data_abo = $Modelpago -> selectDatosPagoId($abono_factura_id,$this -> getConex());
	$deta_abo_puc = $Modelpago -> getDataAbono_puc($abono_factura_id,$this -> getConex());


	$factura_id 	= $data_facturas[0]['factura_id'];
	$data_fac=$Model -> getDataFactura_total($factura_id,$this -> getConex());
	$deta_fac=$Model -> getDataFactura_detalle($factura_id,$this -> getConex());
	$deta_puc=$Model -> getDataFactura_puc($factura_id,$this -> getConex());

	if($data_abo[0]['nota_credito']==0){exit("El documento Actual no es una Nota Cr�dito, no se puede reportar."); }
	if($data_fac[0]['reportada']==0){exit("La Factura ".$data_fac[0]['consecutivo_factura'].", no se ha reportado previamente."); }
	$resultado = $FacturaElec -> sendFactura(8,$data_fac,$deta_fac,$deta_puc,$data_abo,$deta_abo_pu);
	
	if($resultado["codigo"]==200  || $resultado["codigo"]==201){
		$Modelpago -> setMensajeAbono($abono_factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$resultado["cufe"],$resultado["xml"],$this -> getConex());
		exit("La Nota Credito ha sido ha sido generada satisfactoriamente!!! <br>En breves momentos llegara la Nota al correo del cliente");
	}else{
		if($resultado["codigo"]==117){
			$Modelpago -> setMensajeNOAbono($abono_factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$this -> getConex());
			exit("La fecha u hora de emisi&oacute;n de la factura no debe ser mayor a la fecha del sistema: ". $data_fac[0]['fecha']." ".date("H:i:s"));
			
		}else if($resultado["codigo"]==115){
			$Modelpago -> setMensajeNOAbono($abono_factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$this -> getConex());
			exit("El n&uacute;mero consecutivo ya se encuentra registrada en el sistema");
			
		}else{
			print_r(var_export($resultado,true));
			$Modelpago -> setMensajeNOAbono($abono_factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$this -> getConex());
			exit();
		}
	}
	 
  }


  protected function OnclickReportarVP(){

  	require_once("../../factura/clases/FacturaModelClass.php");
    $Model = new FacturaModel();
	
  	require_once("PagoModelClass.php");
	$Modelpago = new PagoModel();
	
	$tokens=$Modelpago -> getTokens($this -> getConex());
	
	if($tokens[0]['ambiente'] == 'P'){

		define("WSDL",$tokens[0]['wsdl']); 
		define("WSANEXO",$tokens[0]['wsanexo']);
		
	}elseif($tokens[0]['ambiente'] == 'D'){
       
		define("WSDL",$tokens[0]['wsdl_prueba']); 
		define("WSANEXO",$tokens[0]['wsanexo_prueba']);
		
	}else{
		exit("No existen Tokens, por favor verifique los tokens y las credenciales en la siguiente ruta: <b>Facturacion -> Parametros Modulo -> Parametros Facturacion Electronica</b>");
	}

	require_once("../../factura/clases/ProcesarVP.php");
    $FacturaElec = new FacturaElectronica();	
  	
	$abono_factura_id 	= $_REQUEST['abono_factura_id'];
	
	$data_facturas = $Modelpago -> selectFacturasAbonos($abono_factura_id,$this -> getConex());
	$data_abo = $Modelpago -> selectDatosPagoId($abono_factura_id,$this -> getConex());
	$deta_abo_puc = $Modelpago -> getDataAbono_puc($abono_factura_id,$this -> getConex());


	$factura_id 	= $data_facturas[0]['factura_id'];
	$data_fac=$Model -> getDataFactura_total($factura_id,$this -> getConex());
	$deta_fac=$Model -> getDataFactura_detalle($factura_id,$this -> getConex());
	$deta_puc=$Model -> getDataFactura_puc($factura_id,$this -> getConex());
	$deta_puc_con=$Model -> getDataFactura_puc_con($factura_id,$this -> getConex());

	if($data_abo[0]['nota_credito']==0){exit("El documento Actual no es una Nota Crédito, no se puede reportar."); }
	if($data_fac[0]['reportada']==0){exit("La Factura ".$data_fac[0]['consecutivo_factura'].", no se ha reportado previamente."); }
	if($tokens[0]['tokenenterprise']=='' || $tokens[0]['tokenenterprise']== NULL || $tokens[0]['tokenautorizacion']=='' || $tokens[0]['tokenautorizacion']== NULL){ exit("No se han parametrizado correctamente los tokens, por favor realice este proceso en el formulario Parametros Facturacion Electronica"); }
	
	$resultado = $FacturaElec -> sendFactura(8,$tokens,$data_fac,$deta_fac,$deta_puc,$data_abo,$deta_abo_pu,$deta_puc_con);
	
	if($resultado["codigo"]==200  || $resultado["codigo"]==201){
		$Modelpago -> setMensajeAbono($abono_factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$resultado["cufe"],$resultado["xml"],$this -> getConex());
		exit("La Nota Credito ha sido ha sido generada satisfactoriamente!!! <br>En breves momentos llegara la Nota al correo del cliente");
	}else{
		if($resultado["codigo"]==117){
			$Modelpago -> setMensajeNOAbono($abono_factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$this -> getConex());
			exit("La fecha u hora de emisi&oacute;n de la factura no debe ser mayor a la fecha del sistema: ". $data_fac[0]['fecha']." ".date("H:i:s"));
			
		}else if($resultado["codigo"]==115){
			$Modelpago -> setMensajeNOAbono($abono_factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$this -> getConex());
			exit("El n&uacute;mero consecutivo ya se encuentra registrada en el sistema");
			
		}else{
			print_r(var_export($resultado,true));
			$Modelpago -> setMensajeNOAbono($abono_factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$this -> getConex());
			exit();
		}
	}
	 
  }


  protected function SetCampos(){
  
    /********************
	  Campos causar
	********************/
	
	$this -> Campos[abono_factura_id] = array(
		name	=>'abono_factura_id',
		id		=>'abono_factura_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('primary_key'))
	);

	$this -> Campos[encabezado_registro_id] = array(
		name	=>'encabezado_registro_id',
		id		=>'encabezado_registro_id',
		type	=>'hidden',
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))

	);

	$this -> Campos[numero_soporte] = array(
		name	=>'numero_soporte',
		id		=>'numero_soporte',
		type	=>'text',
		Boostrap=>'si',
		disabled=>'yes',				
		readonly=>'yes'
	);


	$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id		=>'cliente_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);
	  
	$this -> Campos[cliente] = array(
		name	=>'cliente',
		id		=>'cliente',
		type	=>'text',
		Boostrap=>'si',
		size	=>45,
		suggest=>array(
			name	=>'cliente',
			setId	=>'cliente_hidden',
			onclick => 'setDataCliente')
	);


	$this -> Campos[cliente_nit] = array(
		name	=>'cliente_nit',
		id		=>'cliente_nit',
		type	=>'text',
		Boostrap=>'si',
		readonly=>'yes',
		disabled=>'yes',				
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'20')
	);
	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id		=>'fecha',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);

	$this -> Campos[num_cheque] = array(
		name	=>'num_cheque',
		id		=>'num_cheque',
		type	=>'text',
		Boostrap=>'si',
	 	datatype=>array(
			type	=>'text',
			length	=>'50')
	);

	$this -> Campos[valor_abono_factura] = array(
		name	=>'valor_abono_factura',
		id		=>'valor_abono_factura',
		type	=>'text',
		Boostrap=>'si',
		readonly=>'yes',
		disabled=>'yes',				
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20')
	);

	$this -> Campos[valor_abono_nota] = array(
		name	=>'valor_abono_nota',
		id		=>'valor_abono_nota',
		type	=>'text',
		Boostrap=>'si',
		readonly=>'yes',
		disabled=>'yes',				
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20')
	);

	$this -> Campos[valor_descu_factura] = array(
		name	=>'valor_descu_factura',
		id		=>'valor_descu_factura',
		type	=>'text',
		Boostrap=>'si',
		readonly=>'yes',
		disabled=>'yes',				
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20')
	);
	$this -> Campos[valor_mayor_factura] = array(
		name	=>'valor_mayor_factura',
		id		=>'valor_mayor_factura',
		type	=>'text',
		Boostrap=>'si',
		readonly=>'yes',
		disabled=>'yes',				
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20')
	);
	$this -> Campos[valor_neto_factura] = array(
		name	=>'valor_neto_factura',
		id		=>'valor_neto_factura',
		type	=>'text',
		Boostrap=>'si',
		readonly=>'yes',
		disabled=>'yes',				
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20')
	);
	
	$this -> Campos[observaciones] = array(
		name	=>'observaciones',
		id		=>'observaciones',
		type	=>'text',
		Boostrap=>'si',
		size    =>'80',
		datatype=>array(
			type	=>'text',
			length	=>'200')
	);

	$this -> Campos[cuenta_tipo_pago_id] = array(
		name	=>'cuenta_tipo_pago_id',
		id		=>'cuenta_tipo_pago_id',
		type	=>'select',
		Boostrap=>'si',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
		
	);
	$this -> Campos[tipo_documento_id] = array(
		name	=>'tipo_documento_id',
		id		=>'tipo_documento_id',
		type	=>'select',
		Boostrap=>'si',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
		
	);

	$this -> Campos[concepto_abono_factura] = array(
		name	=>'concepto_abono_factura',
		id		=>'concepto_abono_factura',
		type	=>'text',
		Boostrap=>'si',
		readonly=>'yes',
		required=>'yes',
		size    => '48',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column')),
		onclick =>'cargardiv()'
	);
	$this -> Campos[causaciones_abono_factura] = array(
		name	=>'causaciones_abono_factura',
		id		=>'causaciones_abono_factura',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
	);

	$this -> Campos[causaciones_abono_nota] = array(
		name	=>'causaciones_abono_nota',
		id		=>'causaciones_abono_nota',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
	);

	$this -> Campos[valores_abono_factura] = array(
		name	=>'valores_abono_factura',
		id		=>'valores_abono_factura',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
	);

	$this -> Campos[valores_abono_nota] = array(
		name	=>'valores_abono_nota',
		id		=>'valores_abono_nota',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
	);

	$this -> Campos[descuentos_items] = array(
		name	=>'descuentos_items',
		id		=>'descuentos_items',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
	);

	$this -> Campos[descuentos_items_nota] = array(
		name	=>'descuentos_items_nota',
		id		=>'descuentos_items_nota',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
	);

	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id		=>'usuario_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer',
			length	=>'10'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
	);
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
	);
	
	$this -> Campos[ingreso_abono_factura] = array(
		name	=>'ingreso_abono_factura',
		id		=>'ingreso_abono_factura',
		type	=>'hidden',
		value	=>date("Y-m-d h:i:s"),
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'20'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[estado_abono_factura] = array(
		name	=>'estado_abono_factura',
		id		=>'estado_abono_factura',
		type	=>'select',
		Boostrap=>'si',
		disabled=>'yes',
		options => array(array(value => 'A', text => 'EDICION'),array(value => 'I', text => 'ANULADA'),array(value => 'C', text => 'CONTABILIZADA')),
		selected=>'A',		
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
		
	);

	$this -> Campos[motivo_nota] = array(
		name	=>'motivo_nota',
		id		=>'motivo_nota',
		type	=>'select',
		Boostrap=>'si',
		//disabled=>'yes',
		options => array(array(value => '1', text => 'DEVOLUCION PARCIAL'),array(value => '2', text => 'ANULACION FACTURA'),array(value => '3', text => 'REBAJA TOTAL'),array(value => '4', text => 'DESCUENTO TOTAL'),array(value => '5', text => 'NULIDAD POR REQUISITOS'),array(value => '6', text => 'OTROS')),
	 	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
		
	);


	/*****************************************
	        Campos Anulacion Registro
	*****************************************/
	

	$this -> Campos[anul_usuario_id] = array(
		name	=>'anul_usuario_id',
		id		=>'anul_usuario_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
	);		

	$this -> Campos[anul_abono_factura] = array(
		name	=>'anul_abono_factura',
		id		=>'anul_abono_factura',
		type	=>'text',
		Boostrap=>'si',
		size    =>'17',
        value   =>date("Y-m-d H:m"),
		readonly=>'yes',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
	);	
	
	$this -> Campos[causal_anulacion_id] = array(
		name	=>'causal_anulacion_id',
		id		=>'causal_anulacion_id',
		type	=>'select',
		Boostrap=>'si',
		required=>'yes',
		options	=>array(),
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
	);		
	
	
	$this -> Campos[desc_anul_abono_factura] = array(
		name	=>'desc_anul_abono_factura',
		id		=>'desc_anul_abono_factura',
		type	=>'textarea',
		value	=>'',
		required=>'yes',
    	datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
	);	

	$this -> Campos[oficina_anul] = array(
		name	=>'oficina_anul',
		id		=>'oficina_anul',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11')
	);

	/*****************************************
	        Campos Reversar Registro
	*****************************************/
	

	$this -> Campos[rever_usuario_id] = array(
		name	=>'rever_usuario_id',
		id		=>'rever_usuario_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
	);		

	$this -> Campos[rever_documento_id] = array(
		name	=>'rever_documento_id',
		id		=>'rever_documento_id',
		type	=>'select',
		Boostrap=>'si',
		required=>'yes',
		options	=>array(),
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
	);		

	$this -> Campos[rever_abono_factura] = array(
		name	=>'rever_abono_factura',
		id		=>'rever_abono_factura',
		type	=>'text',
		Boostrap=>'si',
		size    =>'17',
        value   =>date("Y-m-d H:m"),
		readonly=>'yes',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
	);	
	
	$this -> Campos[desc_rever_abono_factura] = array(
		name	=>'desc_rever_abono_factura',
		id		=>'desc_rever_abono_factura',
		type	=>'textarea',
		value	=>'',
		required=>'yes',
    	datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
	);	

	/**********************************
 	             Botones
	**********************************/
	
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar'
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled'

	);
   	$this -> Campos[anular] = array(
		name	=>'anular',
		id		=>'anular',
		type	=>'button',
		value	=>'Anular',
		tabindex=>'14',
		onclick =>'onclickCancellation(this.form)'
	);	
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'PagoOnReset()'
	);
	 
   	$this -> Campos[contabilizar] = array(
		name	=>'contabilizar',
		id		=>'contabilizar',
		type	=>'button',
		value	=>'Contabilizar',
		onclick =>'OnclickContabilizar()'
	);		

   	$this -> Campos[reversar] = array(
		name	=>'reversar',
		id		=>'reversar',
		type	=>'button',
		value	=>'Reversar',
		onclick =>'OnclickReversar(this.form)'
	);		

    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'print',
	disabled=>'disabled',
    value   =>'Imprimir',
	id_prin => 'encabezado_registro_id',
	displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion Documento Contable',
      width       => '800',
      height      => '600'
    )

    );

   	$this -> Campos[reportar] = array(
		name	=>'reportar',
		id		=>'reportar',
		type	=>'button',
		//disabled=>'yes',
		value	=>'Enviar Nota Credito',
		tabindex=>'16',
		onclick =>'OnclickReportar()'
	);		

   	$this -> Campos[reportarvp] = array(
		name	=>'reportarvp',
		id		=>'reportarvp',
		type	=>'button',
		//disabled=>'yes',
		value	=>'Enviar Nota Credito',
		tabindex=>'16',
		onclick =>'OnclickReportarVP()'
	);		

   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap=>'si',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'pago_factura',
			setId	=>'abono_factura_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$abono_factura_id  = new Pago();

?>