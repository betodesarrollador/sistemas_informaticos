<?php

require_once("../../../framework/clases/ControlerClass.php");

final class NotaCredito extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("NotaCreditoLayoutClass.php");
	require_once("NotaCreditoModelClass.php");
	
	$Layout   = new NotaCreditoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new NotaCreditoModel();
	
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
	$Layout -> SetAnular	($Model -> getPermiso($this -> getActividadId(),ANULAR,$this -> getConex()));	
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU
   	$Layout -> SetTipoDoc($Model -> GetFormaCom($this -> getConex()));
	$Layout -> setUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
	$Layout -> setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));
	$Layout -> SetServi ($Model -> GetServi($this -> getConex()));

	$factura_id = $_REQUEST['factura_id'];

		if($factura_id>0){
			$Layout -> setFactura($factura_id);
		}


	
	$Layout -> RenderMain();
  
  }
  
  protected function showGrid(){
	  
	require_once("NotaCreditoLayoutClass.php");
	require_once("NotaCreditoModelClass.php");
	
	$Layout   = new NotaCreditoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new NotaCreditoModel();
	
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'pago',
		title		=>'Listado de Pagos',
		sortname	=>'fecha',
		sortorder =>'desc',
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
	  
	 $html = $Layout -> SetGridFactura($Attributes,$Titles,$Cols,$Model -> GetQueryFacturaGrid());
	 
	 print $html;
	  
  }

  protected function onclickValidateRow(){
	require_once("NotaCreditoModelClass.php");
    $Model = new NotaCreditoModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){
	   
    require_once("SubtotalModelClass.php");
    $Model = new SubtotalModel();

	 $remesas = $_REQUEST['remesas'];
	 $ordenes = $_REQUEST['ordenes'];
	 $previsual = 0;

	 if(($remesas == '' || $remesas == 'NULL') && ($ordenes == '' || $ordenes == 'NULL')){
		$aplica_total_factura = 1;
	 }else{
		 $aplica_total_factura = 0;
	 }

	 $valores_abono_actura = $_REQUEST['valor_nota']."=";
        
        $return = $Model->previsual(0,$valores_abono_actura,$aplica_total_factura,$previsual,$remesas,$ordenes,$this->getEmpresaId(),$this->getOficinaId(),$this->getUsuarioId(),$this->getConex());
		
		if(strlen(trim($Model -> GetError())) > 0){
			exit($Model -> GetError());
		}elseif(is_array($return)){
		   $this -> getArrayJSON($return); 
		}else{
			$this -> getArrayJSON(array(array(factura_id=>0,error=>$return)));

		}
  }

  protected function onclickUpdate(){
 
  	 require_once("SubtotalModelClass.php");
     $Model = new SubtotalModel();

	 $remesas = $_REQUEST['remesas'];
	 $ordenes = $_REQUEST['ordenes'];

	 $previsual = 0;
     
	 if(($remesas == '' || $remesas == 'NULL') && ($ordenes == '' || $ordenes == 'NULL')){
		$aplica_total_factura = 1;
	 }else{
		
		 $aplica_total_factura = 0;
	 }

	 $valores_abono_actura = $_REQUEST['valor_nota']."=";
     
     $Model -> previsual(1,$valores_abono_actura,$aplica_total_factura,$previsual,$remesas,$ordenes,$this->getEmpresaId(),$this->getOficinaId(),$this->getUsuarioId(),$this->getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente la Nota Credito');
	  }
	
  }

  protected function onclickCancellation(){
  
  	require_once("NotaCreditoModelClass.php");
	
    $Model = new NotaCreditoModel();
	
	$Model -> cancellation($this -> getConex());
	
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit('true');
	}
	
  }

//BUSQUEDA
  protected function onclickFind(){
	
	require_once("NotaCreditoModelClass.php");
    $Model = new NotaCreditoModel();
	
    $Data       = array();
	$abono_factura_id = $_REQUEST['abono_factura_id'];
	 
	if(is_numeric($abono_factura_id)){
	  
	  $Data  = $Model -> selectDatosNotaId($abono_factura_id,$this -> getConex());
	  
	} 
	if($Data[0]['oficina_id']!=$this -> getOficinaId()) exit('Esta Factura fue Realizada por la oficina  '.$Data[0]['oficina'].'</br> Por favor consultela por la oficina de Creacion');
   $this -> getArrayJSON($Data);  
	
  }

   protected function onclickPrint(){
  
    require_once("Imp_DocumentoClass.php");

    $print = new Imp_Documento();

    $print -> printOut($this -> getConex());
  
   }

  protected function setDataFactura(){
    require_once("NotaCreditoModelClass.php");
    $Model = new NotaCreditoModel();    
	$factura_id = $_REQUEST['factura_id'];
	
    $data = $Model -> getDataFactura($factura_id,$this -> getConex());
    $this -> getArrayJSON($data);  

  }

   protected function setDataClienteOpe(){

    require_once("NotaCreditoModelClass.php");
    $Model 	= new NotaCreditoModel();   
	 
    $sede_id 	= $_REQUEST['sede_id'];
	$cliente_id = $_REQUEST['cliente_id'];
	
    $data = $Model -> getDataClienteOpe($sede_id,$cliente_id,$this -> getConex());
    $this -> getArrayJSON($data);  

  }
  
  protected function setDataNota(){

    require_once("NotaCreditoModelClass.php");
    $Model = new NotaCreditoModel();    
    $factura_id = $_REQUEST['factura_id'];
    $data = $Model -> getDataNota($factura_id,$this -> getConex());
    $this -> getArrayJSON($data);  

  }

  protected function setSolicitud(){
  
	require_once("NotaCreditoModelClass.php");
    $Model     = new NotaCreditoModel();
    $detalle_id = $_REQUEST['detalle_id'];
	$fuente_facturacion_cod = $_REQUEST['fuente_facturacion_cod'];
	$return = $Model -> SelectSolicitud($detalle_id,$fuente_facturacion_cod,$this -> getConex());
	
	if(count($return) > 0){
		print json_encode($return);

	}else{
	    exit('false');
	  }
  
  }

  protected function setValidaIca(){
  
	require_once("NotaCreditoModelClass.php");
	$Model     = new NotaCreditoModel();
	
    $consecutivo_rem = $_REQUEST['consecutivo_rem'];
	$tipo_bien_servicio_factura_rm = $_REQUEST['tipo_bien_servicio_factura_rm'];

	$return = $Model -> ValidaIca($consecutivo_rem,$tipo_bien_servicio_factura_rm,$this -> getConex());
	
	if($return > 0){
		echo json_encode($return);
	}else{
	    exit('false');
	}
  
  }

  protected function setValidaDist(){
  
	require_once("NotaCreditoModelClass.php");
	$Model     = new NotaCreditoModel();
	
    $consecutivo_rem = $_REQUEST['consecutivo_rem'];
	$tipo_bien_servicio_factura_rm = $_REQUEST['tipo_bien_servicio_factura_rm'];

	$return = $Model -> ValidaDist($consecutivo_rem,$tipo_bien_servicio_factura_rm,$this -> getConex());
	
	if($return > 0){
		echo json_encode($return);
	}else{
	    exit('false');
	}
  
  }

  protected function ComprobarTercero($Conex){
	  
  	require_once("NotaCreditoModelClass.php");
    $Model           = new NotaCreditoModel();
	$tipo_bien_servicio_factura_id 	 = $_REQUEST['tipo_bien_servicio_factura_id'];	
	$numero = $Model -> getComprobarTercero($tipo_bien_servicio_factura_id,$this -> getConex());
	exit("$numero");
	  
  } 

  
 protected function getEstadoEncabezadoRegistro($Conex=''){
	  
    require_once("NotaCreditoModelClass.php");
    $Model = new NotaCreditoModel();
	$abono_factura_id = $_REQUEST['abono_factura_id'];	
	$Estado = $Model -> selectEstadoEncabezadoRegistro($abono_factura_id,$this -> getConex());
	exit("$Estado");
	  
  } 

  protected function getTotalDebitoCredito(){
	  
    require_once("NotaCreditoModelClass.php");
    $Model = new NotaCreditoModel();
	$abono_factura_id = $_REQUEST['abono_factura_id'];
	$data = $Model -> getTotalDebitoCredito($abono_factura_id,$this -> getConex());
	print json_encode($data);  
	  
  }

  protected function getContabilizar(){
	
  	require_once("NotaCreditoModelClass.php");
    $Model = new NotaCreditoModel();
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

  protected function getreContabilizar(){ 

  	require_once("NotaCreditoModelClass.php");
    $Model = new NotaCreditoModel();
	$factura_id 	= 8082;
	$fecha 			= $_REQUEST['fecha'];
	$empresa_id = $this -> getEmpresaId(); 
	$oficina_id = $this -> getOficinaId();	
	$usuario_id = $this -> getUsuarioId();		

	$return=$Model -> getreContabilizarReg($factura_id,$empresa_id,$oficina_id,$usuario_id,$this -> getConex());
	if($return==true){
		exit("true");
	}else{
		exit("Error : ".$Model -> GetError());
	}	

	 
  }
 //validacion posterior 
  protected function OnclickReportar(){

  	require_once("NotaCreditoModelClass.php");
    $Model = new NotaCreditoModel();
	require_once("procesar.php");
    $FacturaElec = new FacturaElectronica();	
  	

	$factura_id 	= $_REQUEST['factura_id'];
	$data_fac=$Model -> getDataFactura_total($factura_id,$this -> getConex());
	$deta_fac=$Model -> getDataFactura_detalle($factura_id,$this -> getConex());
	$deta_puc=$Model -> getDataFactura_puc($factura_id,$this -> getConex());
	if($data_fac[0]['reportada']==1){ exit("La Factura ".$data_fac[0]['consecutivo_factura'].", previamente ya fue enviada."); }
	$resultado = $FacturaElec -> sendFactura(4,$data_fac,$deta_fac,$deta_puc);
	
	if(trim($resultado["codigo"])==200 || trim($resultado["codigo"])==201){
		$Model -> setMensajeFactura($factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$resultado["cufe"],$resultado["xml"],$this -> getConex());
		exit("La factura electr&oacute;nica ha sido generada satisfactoriamente!!! <br>En breves momentos llegara la factura al correo del cliente");
	}else{
		if($resultado["codigo"]==117){
			$Model -> setMensajeNOFactura($factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$this -> getConex());
			//exit("La fecha u hora de emisi&oacute;n de la factura no debe ser mayor a la fecha del sistema: ". $data_fac[0]['fecha']." ".date("H:i:s").'-'.$resultado["resultado"].'-'.$resultado["mensaje"]);
			exit($resultado["resultado"]."-".$resultado["mensaje"]);
			
		}else if($resultado["codigo"]==115){
			$Model -> setMensajeNOFactura($factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$this -> getConex());
			exit("El n&uacute;mero consecutivo de la factura ya se encuentra registrada en el sistema");
			
		}else{
			print_r(var_export($resultado,true));
			$Model -> setMensajeNOFactura($factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$this -> getConex());
			exit();
		}
	}
	 
  }

 //validacion previa test
  protected function OnclickReportarVP(){

  	require_once("../../factura/clases/FacturaModelClass.php");
    $Model = new FacturaModel();
	
  	require_once("NotaCreditoModelClass.php");
	$Modelpago = new NotaCreditoModel();
	
	$tokens=$Modelpago -> getTokens($this -> getConex());

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
	$deta_obli=$Model -> getDataFactura_Obligaciones($factura_id,$this -> getConex());

	if($data_abo[0]['nota_credito']==0){exit("El documento Actual no es una Nota Crédito, no se puede reportar."); }
	if($data_fac[0]['reportada']==0){exit("La Factura ".$data_fac[0]['consecutivo_factura'].", no se ha reportado previamente."); }
	if($tokens[0]['tokenenterprise']=='' || $tokens[0]['tokenenterprise']== NULL || $tokens[0]['tokenautorizacion']=='' || $tokens[0]['tokenautorizacion']== NULL){ exit("No se han parametrizado correctamente los tokens, por favor realice este proceso en el formulario Parametros Facturacion Electronica"); }
	
	$resultado = $FacturaElec -> sendFactura(8,'NC',$tokens,$data_fac,$deta_fac,$deta_puc,$data_abo,$deta_abo_puc,$deta_obli,$deta_puc_con);
	
	if($resultado["codigo"]==200  || $resultado["codigo"]==201){
		$Modelpago -> setMensajeAbono($abono_factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$resultado["cufe"],$resultado["xml"],$this -> getConex());

        //inicio bloque factura anexo representacion grafica
		require_once("Imp_DocumentoClass.php");		
		$print = new Imp_Documento();
		$print -> printOut($this -> getConex(),$data_abo[0]['encabezado_registro_id'],$data_abo[0]['numero_soporte'].'_'.$data_abo[0]['abono_factura_id']);	
		$resultado = $FacturaElec -> sendFactura(11,'NC',$tokens,$data_fac,$deta_fac,$deta_puc,$data_abo,$deta_abo_puc,'',$deta_puc_con);		
		//fin bloque factura anexo representacion grafica

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


   protected function onclickEnviarMail(){
	require_once("../../../framework/clases/MailClass.php");
  	require_once("NotaCreditoLayoutClass.php");
	require_once("NotaCreditoModelClass.php");
	
	$mes= array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	$Layout   = new NotaCreditoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model = new NotaCreditoModel();
	$abono_factura_id 	= $_REQUEST['abono_factura_id'];

	$data=$Model -> selectDatosPagoId($abono_factura_id,$this -> getConex());
	$dataEmpresa=$Model -> selectEmpresa($this -> getEmpresaId(),$this -> getConex());
	//$data[0]['cliente_email']='johnatanleyva@gmail.com';
	if($data[0]['cliente_email']!='' && $data[0]['cliente_email']!='NULL' && $data[0]['abono_factura_id']>0){
		require_once("Imp_DocumentoClass.php");		
		$print = new Imp_Documento(); 
		
		$print -> printOut($this -> getConex(),$data[0]['encabezado_registro_id'],$data[0]['numero_soporte'].'_'.$data[0]['abono_factura_id']);	
		$adjunto = $data[0]['adjunto'];
		$adjunto_nombre = str_replace("../../../archivos/facturacion/adjuntos/","",$adjunto);

		$fecha = $data[0]['fecha'];
		$fechafin= explode('-',$fecha);
		
		$mensaje_texto='Estimado Cliente '.$data[0]['cliente'].',<br><br>
		
						Adjuntamos Nota Crédito referente a la factura del mes '.$mes[intval($fechafin[1])].' de '.$fechafin[0].', con Numero  '.$data[0]['prefijo'].'-'.$data[0]['consecutivo_factura'].', quedamos atentos a cualquier inquietud.<br><br>
						Por favor no responder a este correo, cualquier inquietud enviar correo a <a href="mailto:'.$dataEmpresa[0]['email'].'">'.$dataEmpresa[0]['email'].'</a><br><br>
						
						Cordialmente,<br><br>
						
						FACTURACION '.$dataEmpresa[0]['nombre'];
		$enviar_mail=new Mail();	//$data[0]['cliente_email']	
		$mensaje_exitoso=$enviar_mail->sendMail(trim($dataEmpresa[0]['email']),'Se ha generado la nota credito referente a la factura '.$data[0]['prefijo'].'-'.$data[0]['consecutivo_factura'],$mensaje_texto,'../../../archivos/facturacion/notas/'.$data[0]['numero_soporte'].'_'.$data[0]['abono_factura_id'].'.pdf',$data[0]['numero_soporte'].'_'.$data[0]['abono_factura_id'].'.pdf',$adjunto,$adjunto_nombre);

		$mensaje_exitoso=$enviar_mail->sendMail(trim($data[0]['cliente_email']),'Se ha generado la nota credito referente a la factura '.$data[0]['prefijo'].'-'.$data[0]['consecutivo_factura'],$mensaje_texto,'../../../archivos/facturacion/notas/'.$data[0]['numero_soporte'].'_'.$data[0]['abono_factura_id'].'.pdf',$data[0]['numero_soporte'].'_'.$data[0]['abono_factura_id'].'.pdf');
		if($mensaje_exitoso){ 
			exit('Correo Enviado Satisfactoriamente');
			
		}else{
			exit('Correo No pudo ser Enviado');
			
		}
	}elseif($data[0]['cliente_email']=='' && $data[0]['factura_id']>0){
		exit('El cliente no tiene Email configurado');	
	
	}else{
		exit('No existe Factura');	
	}
	 
  }

  protected function uploadFileAutomatically(){
  
    require_once("NotaCreditoModelClass.php");

    $Model         = new NotaCreditoModel();
	$factura_id  = $_REQUEST['factura_id'];
	$consecutivo_factura  = $_REQUEST['consecutivo_factura'];	
    $ruta          = "../../../archivos/facturacion/adjuntos/";
    $archivo       = $_FILES['adjunto'];
    $nombreArchivo = "adjunto_factura_".$consecutivo_factura;    
    $dir_file      = $this -> moveUploadedFile($archivo,$ruta,$nombreArchivo);

    
    $Model -> seAdjunto($factura_id,$dir_file,$this -> getConex());      
		

	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit('true');
	}


  }

  protected function SetCampos(){
  
    /********************
	  Campos Factura
	********************/
	
	$this -> Campos[consecutivo_factura] = array(
		name	=>'consecutivo_factura',
		id		=>'consecutivo_factura',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		suggest=>array(
			name	=>'factura_contabilizada',
			setId	=>'factura_hidden',
			onclick => 'setDataFactura')
	);

	$this -> Campos[factura_id] = array(
		name	=>'factura_id',
		id		=>'factura_hidden',
		type	=>'hidden',	
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('abono_factura'),
			type	=>array('column'))
	);

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

	$this -> Campos[cliente] = array(
		name	=>'cliente',
		id		=>'cliente',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		disabled=>'yes',
		size	=>83
	);

	$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id		=>'cliente_hidden',
		type	=>'hidden',	
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
	);

	$this -> Campos[numero_documento] = array(
		name	=>'numero_documento',
		id		=>'numero_documento',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		disabled=>'yes',
		size	=>83
	);

	$this -> Campos[encabezado_registro_id] = array(
		name	=>'encabezado_registro_id',
		id		=>'encabezado_registro_hidden',
		type	=>'hidden',	
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
	);
	
	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id		=>'fecha',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		disabled=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'10'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
	);
	
	$this -> Campos[fecha_nota] = array(
		name	=>'fecha_nota',
		id		=>'fecha_nota',
		type	=>'text',
		required=>'yes',
		Boostrap =>'si',
	 	datatype=>array(
			type	=>'date',
			length	=>'10'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
	);

	$this -> Campos[tipo_de_documento_id] = array(
		name	=>'tipo_de_documento_id',
		id		=>'tipo_de_documento_id',
		type	=>'select',
		Boostrap =>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
		
	);

	$this -> Campos[concepto] = array(
		name	=>'concepto',
		id		=>'concepto',
		type	=>'text',
		Boostrap =>'si',
		size	=>81,
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'350'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
	);

	$this -> Campos[motivo_nota] = array(
		name	=>'motivo_nota',
		id		=>'motivo_nota',
		type	=>'select',
		Boostrap=>'si',
		required=>'yes',
		options => array(array(value => '1', text => 'DEVOLUCION PARCIAL'),array(value => '2', text => 'ANULACION FACTURA'),array(value => '3', text => 'REBAJA TOTAL'),array(value => '4', text => 'DESCUENTO TOTAL'),array(value => '5', text => 'OTROS')),
	 	datatype=>array(
			type	=>'integer',
			length	=>'1'),
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
			table	=>array('factura'),
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
			table	=>array('factura'),
			type	=>array('column'))
	);

	$this -> Campos[ingreso_factura] = array(
		name	=>'ingreso_factura',
		id		=>'ingreso_factura',
		type	=>'hidden',
		value	=>date("Y-m-d h:i:s"),
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'20'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
	);
	
	$this -> Campos[valor] = array(
		name	=>'valor',
		id		=>'valor',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		readonly=>'yes',
		disabled=>'yes',				
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
		
	);

	$this -> Campos[valor_nota] = array(
		name	=>'valor_nota',
		id		=>'valor_nota',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		disabled=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
		
	);
	
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		Boostrap =>'si',
		disabled=>'yes',
		options => array(array(value => 'A', text => 'EDICION'),array(value => 'C', text => 'CONTABILIZADA')),
		selected=>'A',		
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
		
	);
	
	$this -> Campos[adjunto] = array(
		name	  =>'adjunto',
		id	  =>'adjunto',
		type	  =>'upload',
                title     =>'Carga Adjunto',
                parameters=>'factura_id',
                beforesend=>'validaSeleccionFactura',
                onsuccess =>'onSendFile'
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
			table	=>array('factura'),
			type	=>array('column'))
	);		

	$this -> Campos[anul_oficina_id] = array(
		name	=>'anul_oficina_id',
		id		=>'anul_oficina_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11')
	);

	$this -> Campos[anul_factura] = array(
		name	=>'anul_factura',
		id		=>'anul_factura',
		type	=>'text',
		Boostrap =>'si',
		size    =>'17',
        value   =>date("Y-m-d H:m"),
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
	);	
	
	$this -> Campos[causal_anulacion_id] = array(
		name	=>'causal_anulacion_id',
		id		=>'causal_anulacion_id',
		type	=>'select',
		Boostrap =>'si',
		//required=>'yes',
		options	=>array(),
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
	);		
	
	
	$this -> Campos[desc_anul_factura] = array(
		name	=>'desc_anul_factura',
		id		=>'desc_anul_factura',
		type	=>'textarea',
		value	=>'',
		//required=>'yes',
    	datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
	);
	
	/**********************************
	 campos div ica 
	************************************/

	$this -> Campos[impuesto] = array(
		name	=>'impuesto',
		id		=>'impuesto',
		type	=>'select',
		Boostrap =>'si',
		Boostrap =>'si',
		//required=>'yes',
		options	=>array(),
		datatype=>array(
			type	=>'integer')
	);
	
	$this -> Campos[impuesto_id] = array(
		name	=>'impuesto_id',
		id		=>'impuesto_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11')
	);

	$this -> Campos[remesas] = array(
		name	=>'remesas',
		id		=>'remesas',
		type	=>'hidden',
		value	=>''
	);

	$this -> Campos[ordenes] = array(
		name	=>'ordenes',
		id		=>'ordenes',
		type	=>'hidden',
		value	=>''
	);

	$this -> Campos[tipo_bien_servicio_factura] = array(
		name	=>'tipo_bien_servicio_factura',
		id		=>'tipo_bien_servicio_factura',
		type	=>'select',
		disabled=>'yes',
		Boostrap =>'si',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'20')
	);

	$this->Campos[consecutivo_contable] = array(
            name => 'consecutivo_contable',
            id => 'consecutivo_contable',
            Boostrap => 'si',
            type => 'text',
            disabled => 'yes',
            datatype => array(
                type => 'integer',
                length => '20')
        );
	

	 	  
	/**********************************
 	             Botones
	**********************************/
	
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar'
		//tabindex=>'19'
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled'
		//tabindex=>'20'
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
		//tabindex=>'22',
		onclick	=>'FacturaOnReset(this.form)'
	);
	 
   	$this -> Campos[contabilizar] = array(
		name	=>'contabilizar',
		id		=>'contabilizar',
		type	=>'button',
		value	=>'Contabilizar',
		tabindex=>'16',
		onclick =>'OnclickContabilizar()'
	);		

   	$this -> Campos[recontabilizar] = array(
		name	=>'recontabilizar',
		id		=>'recontabilizar',
		type	=>'button',
		value	=>'reasignacion',
		tabindex=>'16',
		onclick =>'OnclickReContabilizar()'
	);		

   	$this -> Campos[reportarvp] = array(
		name	=>'reportarvp',
		id		=>'reportarvp',
		type	=>'button',
		Clase   =>'btn btn-success',
		//disabled=>'yes',
		value	=>'Enviar Nota Credito',
		tabindex=>'16',
		onclick =>'OnclickReportarVP()'
	);		

   	$this -> Campos[reportar] = array(
		name	=>'reportar',
		id		=>'reportar',
		type	=>'button',
		disabled=>'yes',
		value	=>'Enviar Factura de Venta',
		tabindex=>'16',
		onclick =>'OnclickReportar()'
	);		

    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'print',
	disabled=>'disabled',
    value   =>'Imprimir',
	id_prin => 'encabezado_registro_hidden',
	displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion Documento Contable',
      width       => '800',
      height      => '600'
    )

    );
	
	$this -> Campos[imprimir_pdf] = array(
		name   =>'imprimir_pdf',
		id   =>'imprimir_pdf',
		type   =>'button',
		disabled=>'disabled',
		value   =>'Imprimir PDF',
		onclick =>'beforePdf();'
		);
	
	$this -> Campos[imprimir1] = array(
    name   =>'imprimir1',
    id   =>'imprimir1',
    type   =>'print',
	disabled=>'disabled',
    value   =>'Imprimir sin formato',
	id_prin =>'factura_id',
	displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion Factura sin formato',
      width       => '800',
      height      => '600'
    ));

	$this -> Campos[envio_factura] = array(
		name	=>'envio_factura',
		id		=>'envio_factura',
		type	=>'button',
		Clase   =>'btn btn-info',
		value	=>'Envio Mail',
		tabindex=>'14',
		onclick =>'onclickEnviarMail(this.form)'
	);
	
	$this -> Campos[confirmar] = array(
			name	=>'confirmar',
			id		=>'confirmar',
			type	=>'button',
			value	=>'Confirmar',
		);

   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap =>'si',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'nota_credito',
			setId	=>'abono_factura_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$factura_id = new NotaCredito();

?>