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


	//// GRID ////
	$Attributes = array(
	  id		=>'pago',
	  title		=>'Listado de Pagos',
	  sortname	=>'fecha',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
	  array(name=>'fecha',						index=>'fecha',						sorttype=>'date',	width=>'100',	align=>'left'),
	  array(name=>'ingreso_abono_factura',		index=>'ingreso_abono_factura',		sorttype=>'date',	width=>'120',	align=>'left'),
	  array(name=>'tipo_doc',					index=>'tipo_doc',					sorttype=>'text',	width=>'120',	align=>'left'),
	  array(name=>'num_ref',					index=>'num_ref',					sorttype=>'text',	width=>'90',	align=>'left'),	 
	  array(name=>'proveedor',					index=>'proveedor',					sorttype=>'text',	width=>'140',	align=>'left'),
	  array(name=>'forma_pago',					index=>'forma_pago',				sorttype=>'text',	width=>'140',	align=>'left'),
	  array(name=>'concepto_abono_factura',		index=>'concepto_abono_factura',	sorttype=>'text',	width=>'200',	align=>'left'),
	  array(name=>'valor_abono_factura',		index=>'valor_abono_factura',		sorttype=>'text',	width=>'100',	align=>'center', format => 'currency'),
	  array(name=>'estado_abono_factura',		index=>'estado_abono_factura',		sorttype=>'text',	width=>'100',	align=>'left')	  
	);
	  
    $Titles = array('FECHA PAGO',
					'FECHA INGRESO',
					'DOCUMENTO',
					'No',
					'PROVEEDOR',
					'FORMA PAGO',					
					'CONCEPTO',
					'VALOR',
					'ESTADO'
	);
	
	$Layout -> SetGridPago($Attributes,$Titles,$Cols,$Model -> GetQueryPagoGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("PagoModelClass.php");
    $Model = new PagoModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

	require_once("PagoModelClass.php");
	$Model = new PagoModel();
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
	$abono_factura_proveedor_id = $_REQUEST['abono_factura_proveedor_id'];
	 
	if(is_numeric($abono_factura_proveedor_id)){
	  
	  $Data  = $Model -> selectDatosPagoId($abono_factura_proveedor_id,$this -> getConex());
	  
	} 
	if($Data[0]['oficina_id']!=$this -> getOficinaId()) exit('Este registro fue Realizado por la oficina  '.$Data[0]['oficina'].'</br> Por favor consultelo por la oficina de Creacion');
    $this -> getArrayJSON($Data);
	
  }

  protected function setDataProveedor(){

    require_once("PagoModelClass.php");
    $Model = new PagoModel();    
    $proveedor_id = $_REQUEST['proveedor_id'];
    $data = $Model -> getDataProveedor($proveedor_id,$this -> getConex());
    $this -> getArrayJSON($data);

  }
  protected function setDataFactura(){

    require_once("PagoModelClass.php");
    $Model = new PagoModel();    
    $abono_factura_proveedor_id = $_REQUEST['abono_factura_proveedor_id'];
    $data = $Model -> getDataFactura($abono_factura_proveedor_id,$this -> getConex());
    $this -> getArrayJSON($data);

  }
  
  protected function setSolicitud(){
  
	require_once("PagoModelClass.php");
    $Model     = new PagoModel();
    $factura_proveedor_id = $_REQUEST['factura_proveedor_id'];
	$return = $Model -> SelectSolicitud($factura_proveedor_id,$this -> getConex());
	
	if(count($return) > 0){
	  $this -> getArrayJSON($return);	
	}else{
	    exit('false');
	  }
  
  }
  
  protected function getEstadoEncabezadoRegistro($Conex=''){
	  
  	require_once("PagoModelClass.php");
    $Model           = new PagoModel();
	$abono_factura_proveedor_id = $_REQUEST['abono_factura_proveedor_id'];	
	$Estado = $Model -> selectEstadoEncabezadoRegistro($abono_factura_proveedor_id,$this -> getConex());
	exit("$Estado");
	  
  } 

  protected function getTotalDebitoCredito(){
	  
  	require_once("PagoModelClass.php");
    $Model = new PagoModel();
	$abono_factura_proveedor_id = $_REQUEST['abono_factura_proveedor_id'];
	$data = $Model -> getTotalDebitoCredito($abono_factura_proveedor_id,$this -> getConex());
	print json_encode($data);  
	  
  }
  protected function getContabilizar(){
	
  	require_once("PagoModelClass.php");
    $Model = new PagoModel();
	$abono_factura_proveedor_id	= $_REQUEST['abono_factura_proveedor_id'];
	$ingreso_abono_factura 		= $_REQUEST['ingreso_abono_factura'];
	$empresa_id = $this -> getEmpresaId();  
	$oficina_id = $this -> getOficinaId();	
	$usuario_id = $this -> getUsuarioId();


	$return=$Model -> getContabilizarReg($abono_factura_proveedor_id,$empresa_id,$oficina_id,$usuario_id,$this -> getConex());
	if($return==true){
		exit("true");
	}else{
		exit("Error : ".$Model -> GetError());
	}	
		
  }

  	protected function OnclickEnviar(){
	  
		require_once("PagoModelClass.php");
		$Model = new PagoModel();
		require_once("../../../framework/clases/MailClass.php"); 
		$abono_factura_proveedor_id = $_REQUEST['abono_factura_proveedor_id'];
		$data = $Model -> selectDatosPagoId($abono_factura_proveedor_id,$this -> getConex());
	    $data1 = $Model -> selectDatosAbonos($abono_factura_proveedor_id,$this -> getConex());
	  	$correo = $data[0]['proveedor_email'];
	    //$correo ='johnatanleyva@gmail.com';
	  	$valor_tot_pago = $data[0]['valor_abono_factura'];
		$concepto_abono_factura = $data[0]['concepto_abono_factura'];
	  	$nombre_empresa = $this -> getEmpresaNombre();
	  	$sigla_empresa = $this -> getEmpresaSigla();		  
		  
		$enviar_mail =new Mail();	
		$mail_subject='Informe de Pago '.$sigla_empresa;
		$mensaje	 = '';
	  	$mensaje1	 = '';
		$mensaje	.='Cordial Saludo <br><br> Se ha generado un pago por concepto de: '.$concepto_abono_factura.' Por un valor total de '.number_format($valor_tot_pago,0,',','.').'<br><br><br>';
	  	if(count($data1)>0){	
			$mensaje	.='<div align="center">';
				$mensaje	.='<table width="100%" border="1" cellspacing="0">';
				$mensaje	.='<tr><td><strong>FECHA CAUSACION</strong></td><td><strong>CONCEPTO</strong></td><td><strong>VALOR ABONADO</strong></td></tr>';
				for($j=0;$j<count($data1);$j++){
					$mensaje	.='<tr><td>'.$data1[$j]['fecha_factura_proveedor'].'</td><td>'.$data1[$j]['concepto_factura_proveedor'].'</td><td align="right">$'.number_format($data1[$j]['rel_valor_abono_factura'],0,',','.').'</td></tr>';	
					$data2 = $Model -> selectItemsAbono($data1[$j]['factura_proveedor_id'],$this -> getConex());
					
					$mensaje1	.= '<div align="center" style="border: 1px solid #000; margin:30px 0 30px 0; padding: 10px;"><br>Documento '.$data1[$j]['consecutivo'].'<br><br>Fecha: '.$data1[$j]['fecha_factura_proveedor'].'<br><br>';
						$mensaje1	.='<table width="90%" border="1" cellspacing="0">';
						for($i=0;$i<count($data2);$i++){
							$mensaje1	 .= '<tr><td>'.$data2[$i]['desc_factura_proveedor'].'</td><td>'.number_format($data2[$i]['deb_item_factura_proveedor'],0,',','.').'</td><td>'.number_format($data2[$i]['cre_item_factura_proveedor'],0,',','.').'</td></tr>';
						}
						$mensaje1	.='</table>';
					$mensaje1	.='</div>';
			
					
				}
				$mensaje	.='</table>';
			$mensaje	.='</div>';
			
  		}
	  
		$mensaje	.=$mensaje1.'<br><br> '.$nombre_empresa.'';

		if(strlen($correo)>0){
			$retorno = $enviar_mail->sendMail(trim($correo),$mail_subject,$mensaje);	
			//$retorno = $enviar_mail->sendMail(trim('johnatanleyva@gmail.com'),$mail_subject,$mensaje);	
			if($retorno==true){
				echo 'Correo Enviado Satisfactoriamente a la cuenta: '.$correo;
			}else{
				echo 'Correo no fue  Enviado  a la cuenta: '.$correo.'.<br> Por favor revise si esta Correcta la cuenta de correo!';
			}
		}else{
			echo 'El Tercero No tiene correo Configurado';
			exit();
		}

	  
	  
  }
    

  protected function SetCampos(){
  
    /********************
	  Campos causar
	********************/
	
	$this -> Campos[abono_factura_proveedor_id] = array(
		name	=>'abono_factura_proveedor_id',
		id		=>'abono_factura_proveedor_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('abono_factura_proveedor'),
			type	=>array('primary_key'))
	);

	$this -> Campos[encabezado_registro_id] = array(
		name	=>'encabezado_registro_id',
		id		=>'encabezado_registro_id',
		type	=>'hidden',
		transaction=>array(
			table	=>array('abono_factura_proveedor'),
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


	$this -> Campos[proveedor_id] = array(
		name	=>'proveedor_id',
		id		=>'proveedor_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);
	  
	$this -> Campos[proveedor] = array(
		name	=>'proveedor',
		id		=>'proveedor',
		type	=>'text',
		Boostrap=>'si',
		size	=>45,
		suggest=>array(
			name	=>'proveedor',
			setId	=>'proveedor_hidden',
			onclick => 'setDataProveedor')
	);


	$this -> Campos[proveedor_nit] = array(
		name	=>'proveedor_nit',
		id		=>'proveedor_nit',
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
			table	=>array('abono_factura_proveedor'),
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
			table	=>array('abono_factura_proveedor'),
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
			table	=>array('abono_factura_proveedor'),
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
			table	=>array('abono_factura_proveedor'),
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
			table	=>array('abono_factura_proveedor'),
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
			table	=>array('abono_factura_proveedor'),
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
			table	=>array('abono_factura_proveedor'),
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
			table	=>array('abono_factura_proveedor'),
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
			table	=>array('abono_factura_proveedor'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[estado_abono_factura] = array(
		name	=>'estado_abono_factura',
		id		=>'estado_abono_factura',
		type	=>'select',
		Boostrap=>'si',
		disabled=>'yes',
		options => array(array(value => 'A', text => 'EDICION'),array(value => 'I', text => 'ANULADO'),array(value => 'C', text => 'CONTABILIZADO')),
		selected=>'A',		
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('abono_factura_proveedor'),
			type	=>array('column'))
		
	);
	
	$this -> Campos[observaciones] = array(
		name	=>'observaciones',
		id		=>'observaciones',
		type	=>'textarea',
		value	=>'',
    	datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('abono_factura_proveedor'),
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
			table	=>array('abono_factura_proveedor'),
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
			table	=>array('abono_factura_proveedor'),
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
			table	=>array('abono_factura_proveedor'),
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
			table	=>array('abono_factura_proveedor'),
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
			table	=>array('abono_factura_proveedor'),
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
			table	=>array('abono_factura_proveedor'),
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
			table	=>array('abono_factura_proveedor'),
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
			table	=>array('abono_factura_proveedor'),
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

   	$this -> Campos[enviar] = array(
		name	=>'enviar',
		id		=>'enviar',
		type	=>'button',
		value	=>'Enviar Mail',
		//disabled=>'yes',
		onclick =>'OnclickEnviar(this.form)'
	);		
      
    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'print',
	disabled=>'disabled',
    value   =>'Imprimir',
	id_prin =>'encabezado_registro_id',
	displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion Documento Contable',
      width       => '800',
      height      => '600'
    )

    );

   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap=>'si',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'pago',
			setId	=>'abono_factura_proveedor_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$abono_factura_proveedor_id  = new Pago();

?>