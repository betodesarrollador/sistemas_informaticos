<?php
require_once("../../../framework/clases/ControlerClass.php");
final class Factura extends Controler{
	
  public function __construct(){
	parent::__construct(3);
	
  }
  	
  public function Main(){
    $this -> noCache();
	  
	require_once("FacturaLayoutClass.php");
	require_once("FacturaModelClass.php");
	
	$Layout   = new FacturaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new FacturaModel();
	
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
	$Layout -> SetAnular	($Model -> getPermiso($this -> getActividadId(),ANULAR,$this -> getConex()));	
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	$Layout -> setImprimir	($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU	
   	$Layout -> SetFuente  ($Model -> GetFuente($this -> getConex()));
   	$Layout -> SetServiOs ($Model -> GetServiOs($this -> getConex()));
   	$Layout -> SetServiRm ($Model -> GetServiRm($this -> getConex()));	
	$Layout -> SetServiSt ($Model -> GetServiSt($this -> getConex()));	
   	$Layout -> SetFormaCom($Model -> GetFormaCom($this -> getConex()));
   	$Layout -> SetTipoFac ($Model -> GetTipoFac($this -> getConex()));	
	$Layout -> setUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
	$Layout -> setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));
	$Layout -> setReteica($Model -> getReteica($this -> getConex()));
	$factura_id = $_REQUEST['factura_id'];
		if($factura_id>0){
			$Layout -> setFactura($factura_id);
		}
	
	$Layout -> RenderMain();
  
  }
  
  protected function showGrid(){
	  
	require_once("FacturaLayoutClass.php");
	require_once("FacturaModelClass.php");
	
	$Layout   = new FacturaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new FacturaModel();
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'Factura',
		title		=>'Listado de Facturas',
		sortname	=>'fecha',
		sortorder	=>'desc',	
		width		=>'auto',
		rowList	=>'500,800,1000,2000,2500',
		height	=>'250'
	  );
	  $Cols = array(
	  
		array(name=>'consecutivo_factura',index=>'consecutivo_factura',		sorttype=>'int',	width=>'120',	align=>'left'),
		array(name=>'cliente',			index=>'cliente',					sorttype=>'text',	width=>'90',	align=>'left'),
		array(name=>'fecha',				index=>'fecha',						sorttype=>'date',	width=>'120',	align=>'left'),	 
		array(name=>'vencimiento',		index=>'vencimiento',				sorttype=>'date',	width=>'140',	align=>'left'),
		array(name=>'radicacion',		    index=>'radicacion',				sorttype=>'date',	width=>'140',	align=>'left'),
		array(name=>'valor',				index=>'valor',						sorttype=>'int',	width=>'140',	align=>'left'),
		array(name=>'fuente',				index=>'fuente',					sorttype=>'text',	width=>'140',	align=>'left'),
		array(name=>'tipo_servicio',		index=>'tipo_servicio',				sorttype=>'text',	width=>'140',	align=>'left'),
		array(name=>'estado_factura',		index=>'estado_factura',			sorttype=>'text',	width=>'120',	align=>'center')
	  );
		
	  $Titles = array('FACTURA No',
					  'CLIENTE',
					  'FECHA',
					  'VENCIMIENTO',
					  'RADICACION',
					  'VALOR',
					  'FUENTE',					
					  'TIPO SERVICIO',
					  'ESTADO'
	  );
	  
	 $html = $Layout -> SetGridFactura($Attributes,$Titles,$Cols,$Model -> GetQueryFacturaGrid());
	 
	 print $html;
	  
  }
  
  protected function onclickValidateRow(){
	require_once("FacturaModelClass.php");
    $Model = new FacturaModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  protected function setLeerCodigobar(){
	require_once("FacturaModelClass.php");
	$Model= new FacturaModel();
	$guia       = $_REQUEST['guia'];
	$cliente_id = $_REQUEST['cliente_id'];
	$Data = $Model -> setLeerCodigobar($guia,$cliente_id, $this -> getConex());
	if(count($Data)>1 && array_search('orden_servicio', array_column($Data, 'tipo')) !== false && count($Data)>1 && array_search('remesa', array_column($Data, 'tipo')) !== false){
	$oficina      = array();
	$consecutivo  = array();
	$tipo		  = array();
	$estado       = array();
	$codigo       = array();
	$oficina1     = array();
	$consecutivo1 = array();
	$tipo1        = array();
	$estado1      = array();
	$codigo1      = array();
	for ($i=0; $i < count($Data); $i++) { 
		if($Data[$i][estado]=='LQ' || $Data[$i][estado]=='L'){
			array_push($oficina,    $Data[$i]['oficina']);
			array_push($consecutivo,$Data[$i]['consecutivo']);
			array_push($tipo,       $Data[$i]['tipo']);
			array_push($estado,     $Data[$i]['estado']);
			array_push($codigo,     $Data[$i]['guia']);
		}else{
			array_push($oficina1,    $Data[$i]['oficina']);
			array_push($consecutivo1,$Data[$i]['consecutivo']);
			array_push($tipo1,       $Data[$i]['tipo']);
			array_push($estado1,     $Data[$i]['estado']);
			array_push($codigo1,     $Data[$i]['guia']);
			
		}
	}
	
	if(count($consecutivo)==1){# Retorna la remesa o la orden de servicio que se encuentre con estado 'LQ' ó 'L'
		$Data = $tipo[0] == 'remesa' ? $consecutivo[0]."-RM," : $consecutivo[0] . "-OS,";
		$this -> getArrayJSON($Data);
	}else if(count($consecutivo)>1){# Retorna una remesa y una orden de servicio con igual consecutivo y con estado 'LQ' ó 'L'
		$array[0]['consecutivo'] = $consecutivo;
		
		$array[0]['oficina']     = $oficina;
		$array[0]['tipo']	     = $tipo;
		
		$array[0]['guia']	     = $codigo;
		$this->getArrayJSON($array);
		
	}else if(count($consecutivo1)>1){ # Retorna una remesa y una orden de servicio con igual consecutivo y con estado DIFERENTE a 'LQ' ó 'L'
		$estado1 = array_unique($estado1); #eliminar repetidos
		for ($i=0; $i < count($estado1); $i++) { 
			$estados .= $estado1[$i].',';
		}
		exit("La orden de servicio o remesa presenta el siguiente estado : ".substr($estados, 0, -1));
	}else if(count($consecutivo1)==1){ # Retorna la remesa o la orden de servicio que se encuentre con estado DIFERENTE a 'LQ' ó 'L'
		exit("La orden de servicio o remesa presenta el siguiente estado : " . $estado1[0]);
		
	}
	}else if($Data[0][consecutivo]>0){
		if($Data[0][estado]=='LQ' || $Data[0][estado]=='L'){ # Retorna la remesa o la orden de servicio que se encuentre con estado  'LQ' ó 'L'
		$Data = $Data[0][tipo] == 'remesa' ? $Data[0][consecutivo]."-RM," : $Data[0][consecutivo] . "-OS,";
		$this -> getArrayJSON($Data);
			
		}else{
			$estado = $Data[0][estado];
			if($Data[0][tipo] == 'remesa'){
				exit('No se puede agregar la remesa '.$guia.' por que se encuentra en estado '.$estado);
			}else{
				exit('No se puede agregar la orden de servicio '.$guia.' por que se encuentra en estado '.$estado);
			}
		}
		
		
	}else{
		exit('El codigo '.$guia.' no existe');	
	}
	
}

protected function buscarFecha(){

	require_once("FacturaModelClass.php");

	 $Model = new FacturaModel();

	 $cliente_id = $_REQUEST['cliente_id'];

	 $fecha_inicio = $_REQUEST['fecha_inicio'];

	 if($data = $Model -> getFechavencimiento($fecha_inicio,$cliente_id,$this -> getConex())){

 $this -> getArrayJSON($data); 

	 }

	 else exit('false');

}
  
  protected function onclickSave(){
	require_once("FacturaModelClass.php");
	$Model = new FacturaModel();
	$empresa_id 	= $this -> getEmpresaId(); 
	$oficina_id 	= $this -> getOficinaId();	
	$return = $Model -> Save($empresa_id,$oficina_id,$this -> Campos,$this -> getConex());
	if(strlen(trim($Model -> GetError())) > 0){
		//exit("Error : ".$Model -> GetError());
		$this -> getArrayJSON(array(factura_id=>0,error=>$Model -> GetError()));
	}elseif(is_array($return)){
	   $this -> getArrayJSON($return); 
	}else{
		//exit($return);
		$this -> getArrayJSON(array(factura_id=>0,error=>$return));
	}
  }
  protected function onclickUpdate(){
 
  	require_once("FacturaModelClass.php");
	$Model = new FacturaModel();
	$empresa_id 	= $this -> getEmpresaId(); 
	$oficina_id 	= $this -> getOficinaId();
    $resultado = $Model -> Update($empresa_id,$oficina_id,$this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	   echo json_encode('Ocurrio una inconsistencia');
	}elseif(is_string($resultado)){
		echo json_encode($resultado);
	}else{
	   echo json_encode('Se actualizo correctamente la Factura');
	  }
	
  }
  protected function onclickCancellation(){
  
  	require_once("FacturaModelClass.php");
	
    $Model = new FacturaModel();
	
	$Model -> cancellation($this -> getConex());
	
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit('true');
	}
	
  }
//BUSQUEDA
  protected function onclickFind(){
	
	require_once("FacturaModelClass.php");
    $Model = new FacturaModel();
	
    $Data       = array();
	$factura_id = $_REQUEST['factura_id'];
	 
	if(is_numeric($factura_id)){
	  
	  $Data  = $Model -> selectDatosFacturaId($factura_id,$this -> getConex());
	  
	} 
	if($Data[0]['oficina_id']!=$this -> getOficinaId()) exit('Esta Factura fue Realizada por la oficina  '.$Data[0]['oficina'].'</br> Por favor consultela por la oficina de Creacion');
   $this -> getArrayJSON($Data);  
	
  }
  protected function onclickPrint(){
	$factura_id = $_REQUEST['factura_id'];
  
    if($_REQUEST['tipo']=='PDF'){
		require_once("Imp_FacturaPDFClass.php");
		$print = new Imp_FacturaPDF();
		$print -> printOut($this -> getConex()); 
	}else{
    	require_once("Imp_FacturaClass.php");
		$print = new Imp_Factura();
		$print -> printOut($factura_id,$this -> getConex());
	}
  
  }
  protected function setDataCliente(){
    require_once("FacturaModelClass.php");
    $Model = new FacturaModel();    
    $cliente_id = $_REQUEST['cliente_id'];
    $data = $Model -> getDataCliente($cliente_id,$this -> getConex());
    $this -> getArrayJSON($data);  
  }
   protected function setDataClienteOpe(){
    require_once("FacturaModelClass.php");
    $Model 	= new FacturaModel();   
	 
    $sede_id 	= $_REQUEST['sede_id'];
	$cliente_id = $_REQUEST['cliente_id'];
	
    $data = $Model -> getDataClienteOpe($sede_id,$cliente_id,$this -> getConex());
    $this -> getArrayJSON($data);  
  }
  
  protected function setDataFactura(){
    require_once("FacturaModelClass.php");
    $Model = new FacturaModel();    
    $factura_id = $_REQUEST['factura_id'];
    $data = $Model -> getDataFactura($factura_id,$this -> getConex());
    $this -> getArrayJSON($data);  
  }
  protected function setSolicitud(){
  
	require_once("FacturaModelClass.php");
    $Model     = new FacturaModel();
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
  
	require_once("FacturaModelClass.php");
	$Model     = new FacturaModel();
	
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
  
	require_once("FacturaModelClass.php");
	$Model     = new FacturaModel();
	
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
	  
  	require_once("FacturaModelClass.php");
    $Model           = new FacturaModel();
	$tipo_bien_servicio_factura_id 	 = $_REQUEST['tipo_bien_servicio_factura_id'];	
	$numero = $Model -> getComprobarTercero($tipo_bien_servicio_factura_id,$this -> getConex());
	exit("$numero");
	  
  } 
  
  protected function getEstadoEncabezadoRegistro($Conex=''){
	  
  	require_once("FacturaModelClass.php");
    $Model           = new FacturaModel();
	$factura_id 	 = $_REQUEST['factura_id'];	
	$Estado = $Model -> selectEstadoEncabezadoRegistro($factura_id,$this -> getConex());
	exit("$Estado");
	  
  } 
  protected function getTotalDebitoCredito(){
	  
  	require_once("FacturaModelClass.php");
    $Model = new FacturaModel();
	$factura_id = $_REQUEST['factura_id'];
	$data = $Model -> getTotalDebitoCredito($factura_id,$this -> getConex());
	print json_encode($data);  
	
	  
  }

  protected function updateDetalleFactura(){
	  
  	require_once("FacturaModelClass.php");
	$Model = new FacturaModel();
	
	$factura_id = $_REQUEST['factura_id'];
	$id = $_REQUEST['id'];

	$data = $Model -> updateDetalleFac($factura_id,$id,$this -> getConex());

	    if($data==true){
			exit("true");
		}else{
			exit("Error : ".$Model -> GetError());
		}
	  
  }

  protected function getContabilizar(){
	
  	require_once("FacturaModelClass.php");
    $Model = new FacturaModel();
	$factura_id 	= $_REQUEST['factura_id'];
	$fecha 			= $_REQUEST['fecha'];
	$empresa_id = $this -> getEmpresaId(); 
	$oficina_id = $this -> getOficinaId();	
	$usuario_id = $this -> getUsuarioId();		
	
	
    $mesContable     = $Model -> mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha,$this -> getConex());
    $periodoContable = $Model -> PeriodoContableEstaHabilitado($this -> getConex());
	
    if($mesContable && $periodoContable){
		$return=$Model -> getContabilizarReg($factura_id,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$this -> getConex());
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
  protected function getreContabilizar(){ 
  	require_once("FacturaModelClass.php");
    $Model = new FacturaModel();
	$factura_id 	= $_REQUEST['factura_id'];
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
  	require_once("FacturaModelClass.php");
    $Model = new FacturaModel();
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
  	require_once("FacturaModelClass.php");
	$Model = new FacturaModel();
	
	$tokens=$Model -> getTokens($this -> getConex());

	require_once("ProcesarVP.php");
    $FacturaElec = new FacturaElectronica();	
    
  	
	$factura_id 	= $_REQUEST['factura_id'];
	$data_fac=$Model -> getDataFactura_total($factura_id,$this -> getConex());
	$deta_fac=$Model -> getDataFactura_detalle($factura_id,$this -> getConex());
	$deta_obli=$Model -> getDataFactura_Obligaciones($factura_id,$this -> getConex());
	
	$deta_puc=$Model -> getDataFactura_puc($factura_id,$this -> getConex());
	$deta_puc_con=$Model -> getDataFactura_puc_con($factura_id,$this -> getConex());
	if($data_fac[0]['reportada']==1){ exit("La Factura ".$data_fac[0]['consecutivo_factura'].", previamente ya fue enviada."); }
	if($tokens[0]['tokenenterprise']=='' || $tokens[0]['tokenenterprise']== NULL || $tokens[0]['tokenautorizacion']=='' || $tokens[0]['tokenautorizacion']== NULL){ exit("No se han parametrizado correctamente los tokens, por favor realice este proceso en el formulario Parametros Facturacion Electronica"); }
	
	$resultado = $FacturaElec -> sendFactura(4,'FT',$tokens,$data_fac,$deta_fac,$deta_puc,'','',$deta_obli,$deta_puc_con);
	
	if(trim($resultado["codigo"])==200 || trim($resultado["codigo"])==201){
		$Model -> setMensajeFactura($factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$resultado["cufe"],$resultado["xml"],$this -> getConex());
		//inicio bloque factura anexo representacion grafica
		require_once("Imp_FacturaAdjuntoClass.php");		
		$print = new Imp_FacturaAdjunto($this -> getConex());
		$print -> printOutPDF($data_fac[0]['consecutivo_factura'].'_'.$data_fac[0]['factura_id']);	
		$resultado = $FacturaElec -> sendFactura(11,'FT',$tokens,$data_fac,$deta_fac,$deta_puc,'','',$deta_obli,$deta_puc_con);		
		//fin bloque factura anexo representacion grafica
		
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
   protected function onclickEnviarMail(){
	require_once("../../../framework/clases/MailClass.php");
  	require_once("FacturaLayoutClass.php");
	require_once("FacturaModelClass.php");
	
	$mes= array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	$Layout   = new FacturaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model = new FacturaModel();
	$factura_id 	= $_REQUEST['factura_id'];
	$data=$Model -> selectDatosFacturaId($factura_id,$this -> getConex());
	$tokens=$Model -> getTokens($this -> getConex());
	$dataEmpresa=$Model -> selectEmpresa($this -> getEmpresaId(),$this -> getConex());
	// $data[0]['cliente_email']='alexander_tafur1999@hotmail.com';
	if($data[0]['cliente_email']!='' && $data[0]['cliente_email']!='NULL' && $data[0]['factura_id']>0){
		require_once("Imp_FacturaAdjuntoClass.php");		
		$print = new Imp_FacturaAdjunto(); 
		$print -> printOutPDF($data[0]['consecutivo_factura'].'_'.$data[0]['factura_id'],$this -> getConex());	
		$adjunto = $data[0]['adjunto'];
		$adjunto_nombre = str_replace("../../../archivos/facturacion/adjuntos/","",$adjunto);
		$fecha = $data[0]['fecha'];
		$fechafin= explode('-',$fecha);
		
		$mensaje_texto='Estimado Cliente '.$data[0]['cliente'].',<br><br>
		
						Adjuntamos factura del mes '.$mes[intval($fechafin[1])].' de '.$fechafin[0].', con Numero  '.$data[0]['prefijo'].'-'.$data[0]['consecutivo_factura'].', quedamos atentos a cualquier inquietud.<br><br>
						Por favor no responder a este correo, cualquier inquietud enviar correo a <a href="mailto:'.$dataEmpresa[0]['email'].'">'.$dataEmpresa[0]['email'].'</a><br><br>
						
						Cordialmente,<br><br>
						
						FACTURACION '.$dataEmpresa[0]['nombre'];
						$enviar_mail=new Mail();	
			
						$correo2 = $data[0]['correo_sede']!='' ? $data[0]['correo_sede'] : $data[0]['correo2'];
					
						$array_correos = array('0' => trim($tokens[0]['correo']), 
											   '1' => $correo2,
											   '2' => trim($data[0]['cliente_email']));
						
						$errores = '';
						
						//Valida XML
						
						$consecutivo_factura = $data[0]['consecutivo_factura'];
						$prefijo             = $data[0]['prefijo'];
						$xml                 = "../../../archivos/facturacion/xml/".$prefijo.$consecutivo_factura.'.xml';
						$pdf                 = '../../../archivos/facturacion/facturas/'.$data[0]['consecutivo_factura'].'_'.$data[0]['factura_id'].'.pdf';
						
						$path 				 = "../../../archivos/facturacion/zip";
						if (!is_dir($path)) {
							mkdir($path, 0777, true);
						}
						
						if (!file_exists($xml)) {// Crea en .xml en caso de que no exista
							
							require_once("ProcesarVP.php");
							
							$FacturaElec = new FacturaElectronica();	
							
							$data_fac       = $Model -> getDataFactura_total($factura_id,$this -> getConex());
							$deta_fac       = $Model -> getDataFactura_detalle($factura_id,$this -> getConex());
							$deta_obli      = $Model -> getDataFactura_Obligaciones($factura_id,$this -> getConex());
							$deta_puc       = $Model -> getDataFactura_puc($factura_id,$this -> getConex());
							
							$resultado = $FacturaElec -> sendFactura(3,'FT',$tokens,$data_fac,$deta_fac,$deta_puc);
							
							if($resultado["codigo"]==117){
								$Model -> setMensajeNOFactura($factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$this -> getConex());
							
								exit($resultado["resultado"]."-".$resultado["mensaje"]);
								
							}else if($resultado["codigo"]==115){
								
								$Model -> setMensajeNOFactura($factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$this -> getConex());
								
								exit("El n&uacute;mero consecutivo de la factura ya se encuentra registrada en el sistema");
								
							}else if(trim($resultado["codigo"])!=200 && trim($resultado["codigo"])!=201){
								
								print_r(var_export($resultado,true));
								
								$Model -> setMensajeNOFactura($factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$this -> getConex());
								exit();
							}
							
						} 
						
						//Crea el .zip que contiene el .pdf y .xml
						
						$zip 			  = new ZipArchive();
						$nombreArchivoZip = $path. "/".$data[0]['consecutivo_factura'].'_'.$data[0]['factura_id'].'.zip';

						$opened = $zip->open($nombreArchivoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE);

						if (!$opened) {
							exit("Error abriendo ZIP en $nombreArchivoZip");
						}
						
						$zip->addFile($pdf, basename($pdf));
						$zip->addFile($xml, basename($xml));
						
						
						$resultado = $zip->close();
						
						if (!$resultado) {
							exit("Error creando archivo .ZIP");
						} 
			
						
						
						//se envia correo con el .zip y .pdf
													  
						for ($i=0; $i < count($array_correos); $i++) { 
							
							//$array_correos[$i] = 'johandarioalarcon@hotmail.com';
							
							if($array_correos[$i] != ''){
															
								// $mail_subject = 'Se ha generado la factura '.$data[0]['prefijo'].''.$data[0]['consecutivo_factura'];
								
								// $mensaje_exitoso=$enviar_mail->sendMail($array_correos[$i],$mail_subject,$mensaje_texto,$pdf,$data[0]['consecutivo_factura'].'_'.$data[0]['factura_id'].'.pdf');
								
								/* $mensaje_exitoso=$enviar_mail->sendMail('johandarioalarcon@hotmail.com',$mail_subject,$mensaje_texto,$pdf,$data[0]['consecutivo_factura'].'_'.$data[0]['factura_id'].'.pdf',$adjunto,$adjunto_nombre); */
								
								// if(!$mensaje_exitoso) 	$errores = $errores."<br> Correo ".$array_correos[$i]." No pudo ser Enviado";
								
								$mail_subject = 'Se ha generado el xml y pdf de la factura '.$data[0]['prefijo'].''.$data[0]['consecutivo_factura'];
								
								$mensaje_exitoso=$enviar_mail->sendMail($array_correos[$i],$mail_subject,$mensaje_texto,$nombreArchivoZip,$data[0]['consecutivo_factura'].'_'.$data[0]['factura_id'].'.zip');
								
								if(!$mensaje_exitoso) 	$errores = $errores."<br> Correo ".$array_correos[$i]." No pudo ser Enviado"; 
							}
						}
					
						//$mensaje_exitoso=$enviar_mail->sendMail('johnatanleyva@gmail.com','Se ha generado la factura '.$data[0]['prefijo'].''.$data[0]['consecutivo_factura'],$mensaje_texto,'../../../archivos/facturacion/facturas/'.$data[0]['consecutivo_factura'].'_'.$data[0]['factura_id'].'.pdf',$data[0]['consecutivo_factura'].'_'.$data[0]['factura_id'].'.pdf');
					
						if(strlen($errores)>0){ 
							
							exit('Errores : '.$errores);
							
						}else{
							
							exit('Correo Enviado Satisfactoriamente');
							
						}
					
					
					}elseif($data[0]['cliente_email']=='' && $data[0]['factura_id']>0){
						
						exit('El cliente no tiene Email configurado');	
				
					}else{
						
						exit('No existe Factura');
							
					}
				 
				  }

  protected function uploadFileAutomaticallyANTESPARAELADJUNTO(){
  
    require_once("FacturaModelClass.php");
    $Model         = new FacturaModel();
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
  protected function uploadFileAutomatically(){
  
    require_once("FacturaModelClass.php");
    $Model         = new FacturaModel();
	$this -> upload_max_filesize("2048M");
        
    
    $archivoPOST     = $_FILES['excel_cargar'];
    $rutaAlmacenar   = "../../../archivos/facturacion/factura/";
    
    $dir_file        = $this -> moveUploadedFile($archivoPOST,$rutaAlmacenar,"excelFactura");    
	$fileContent 	 = $this -> excelToArray($dir_file);
	$arrayInsert 	 = array();

	for($i = 1; $i <count($fileContent); $i++){
		array_push($arrayInsert, trim($fileContent[$i][0]));
	}
	
	
	$remesas = implode(",",$arrayInsert);
	
	return $this -> getArrayJSON($arrayInsert);
    
    
  }

  protected function getArrayInsert($dir_file){
  
    $fileContent = $this -> excelToArray($dir_file);
    $keys        = $fileContent[0];
    $arrayInsert = array();
    
    for($i = 1; $i <= count($fileContent); $i++){
    
      foreach($keys as $llave => $valor){
        $arrayInsert[$i][$valor] = $fileContent[$i][$llave];
      }
      
    }
        
    return array_values($arrayInsert); 
  
  }
  protected function SetCampos(){
  
    /********************
	  Campos Factura
	********************/
	
	$this -> Campos[factura_id] = array(
		name	=>'factura_id',
		id		=>'factura_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('primary_key'))
	);
	$this -> Campos[consecutivo_factura] = array(
		name	=>'consecutivo_factura',
		id		=>'consecutivo_factura',
		type	=>'text',
		Boostrap =>'si',
		/* disabled=>'yes',				
		readonly=>'yes' */
	);
	$this -> Campos[fuente_facturacion_cod] = array(
		name	=>'fuente_facturacion_cod',
		id		=>'fuente_facturacion_cod',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		required=>'yes',
		onchange	=>'Facturatipo()',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'2'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
		
	);
	$this -> Campos[tipo_bien_servicio_factura_os] = array(
		name	=>'tipo_bien_servicio_factura_os',
		id		=>'tipo_bien_servicio_factura_os',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		required=>'yes',
		onchange	=>'ComprobarTercero(this.value)',
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
		
	);
	$this -> Campos[tipo_bien_servicio_factura_rm] = array(
		name	=>'tipo_bien_servicio_factura_rm',
		id		=>'tipo_bien_servicio_factura_rm',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		required=>'yes',
		onchange	=>'ComprobarTercero(this.value)',
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
		
	);
	$this -> Campos[tipo_bien_servicio_factura_st] = array(
		name	=>'tipo_bien_servicio_factura_st',
		id		=>'tipo_bien_servicio_factura_st',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		required=>'yes',
		onchange	=>'ComprobarTercero(this.value)',
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
		
	);
	$this -> Campos[cliente] = array(
		name	=>'cliente',
		id		=>'cliente',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		size	=>83,
		suggest=>array(
			name	=>'cliente',
			setId	=>'cliente_hidden',
			onclick => 'setDataCliente')
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
	$this -> Campos[cliente_nit] = array(
		name	=>'cliente_nit',
		id		=>'cliente_nit',
		type	=>'text',
		Boostrap =>'si',
		readonly=>'yes',
		disabled=>'yes',				
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'20')
	);
	$this -> Campos[cliente_direccion] = array(
		name	=>'cliente_direccion',
		id		=>'cliente_direccion',
		type	=>'text',
		Boostrap =>'si',
		readonly=>'yes',
		disabled=>'yes',				
	 	datatype=>array(
			type	=>'text',
			length	=>'200')
	);
	$this -> Campos[cliente_ciudad] = array(
		name	=>'cliente_ciudad',
		id		=>'cliente_ciudad',
		type	=>'text',
		Boostrap =>'si',
		readonly=>'yes',
		disabled=>'yes',				
	 	datatype=>array(
			type	=>'text',
			length	=>'200')
	);
	$this -> Campos[cliente_tele] = array(
		name	=>'cliente_tele',
		id		=>'cliente_tele',
		type	=>'text',
		Boostrap =>'si',
		readonly=>'yes',
		disabled=>'yes',				
	 	datatype=>array(
			type	=>'integer',
			length	=>'20')
	);
	$this -> Campos[cliente_email] = array(
		name	=>'cliente_email',
		id		=>'cliente_email',
		type	=>'text',
		Boostrap =>'si',
		readonly=>'yes',
		disabled=>'yes',				
	 	datatype=>array(
			type	=>'integer',
			length	=>'20')
	);
	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id		=>'fecha',
		type	=>'text',
		Boostrap =>'si',
		value	=>date("Y-m-d"),
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
	);
	$this -> Campos[vencimiento] = array(
		name	=>'vencimiento',
		id		=>'vencimiento',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
	);
	
	$this -> Campos[radicacion] = array(
		name	=>'radicacion',
		id		=>'radicacion',
		type	=>'text',
		Boostrap =>'si',
	 	datatype=>array(
			type	=>'date',
			length	=>'10'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
	);
	$this -> Campos[forma_compra_venta_id] = array(
		name	=>'forma_compra_venta_id',
		id		=>'forma_compra_venta_id',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
		
	);
	$this -> Campos[tipo_factura_id] = array(
		name	=>'tipo_factura_id',
		id		=>'tipo_factura_id',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
		
	);
	$this -> Campos[concepto_item] = array(
		name	=>'concepto_item',
		id		=>'concepto_item',
		type	=>'hidden',	
	 	datatype=>array(
			type	=>'text',
			length	=>'350'),
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
		readonly=>'yes',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'350'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
		
	);
	$this -> Campos[observacion] = array(
		name	=>'observacion',
		id		=>'observacion',
		type	=>'text',
		Boostrap =>'si',
		size	=>83,
	 	datatype=>array(
			type	=>'text',
			length	=>'950'),
		transaction=>array(
			table	=>array('factura'),
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
	
	$this -> Campos[sedes] = array(
		name	=>'sedes',
		id		=>'sedes',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		//required=>'yes',
		onchange	=>'cambioSedes()',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'2'),
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
	
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		Boostrap =>'si',
		disabled=>'yes',
		options => array(array(value => 'A', text => 'EDICION'),array(value => 'I', text => 'ANULADA'),array(value => 'C', text => 'CONTABILIZADA')),
		selected=>'A',		
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
		
	);
	$this -> Campos[numero_pagos] = array(
		name	=>'numero_pagos',
		id		=>'numero_pagos',
		type	=>'hidden',
		value	=>'',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11')
	);
	
	$this -> Campos[tipo_impre] = array(
		name	=>'tipo_impre',
		id		=>'tipo_impre',
		type	=>'hidden',
		value	=>'F'
	);
	
	$this -> Campos[adjunto] = array(
		name	  =>'adjunto',
		id	  =>'adjunto',
		type	  =>'file',
                title     =>'Carga Adjunto'
              
	);
	/* CAmpos nuevos para adicionar remesas por numero o por archivo excel */
	$this -> Campos[numeros_agregar] = array(
		name	=>'numeros_agregar',
		id		=>'numeros_agregar',
		type	=>'textarea',
		value	=>'',
		rows	=>'4',
		//required=>'yes',
    	datatype=>array(
			type	=>'text')
	);
	$this -> Campos[codigo_barras] = array(
		name	=>'codigo_barras',
		id		=>'codigo_barras',
		type	=>'text',
		Boostrap =>'si',
		//required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'350')
		
	);
	$this -> Campos[excel_cargar] = array(
		name	  =>'excel_cargar',
		id	  =>'excel_cargar',
		type	  =>'upload',
				title     =>'Carga por archivo',
				parameters=>'factura_id',
                beforesend=>'validaCargaExcel',
                onsuccess =>'cargarExcel'
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
		value	=>'Enviar Factura Electr&oacute;nica',
		tabindex=>'16',
		onclick =>'OnclickReportarVP()'
	);		
   	$this -> Campos[reportar] = array(
		name	=>'reportar',
		id		=>'reportar',
		type	=>'button',
		disabled=>'yes',
		value	=>'Enviar Factura Electronica',
		tabindex=>'16',
		onclick =>'OnclickReportar()'
	);		
    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'print',
	disabled=>'disabled',
    value   =>'Imprimir',
	id_prin => 'factura_id',
	displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion Factura formato',
      width       => '800',
      height      => '600'
	));
	
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
		value	=>'Enviar Email',
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
			name	=>'factura',
			setId	=>'factura_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}
}
$factura_id = new Factura();
?>