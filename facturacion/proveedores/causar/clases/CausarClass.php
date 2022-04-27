<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Causar extends Controler{
	
	public function __construct(){

		parent::__construct(3);

	}

	public function Main(){

		$this -> noCache();

		require_once("CausarLayoutClass.php");
		require_once("CausarModelClass.php");

		$Layout   = new CausarLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new CausarModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

		$Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
		$Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
		$Layout -> SetAnular	($Model -> getPermiso($this -> getActividadId(),ANULAR,$this -> getConex()));	
		$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
		$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	

		$Layout -> SetCampos($this -> Campos);
	//LISTA MENU	
		$Layout -> SetFuente($Model -> GetFuente($this -> getConex()));
		$Layout -> SetServinn($Model -> GetServinn($this -> getConex()));	
		$Layout -> setUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
		$Layout -> setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));

		$factura_proveedor_id = $_REQUEST['factura_proveedor_id'];

		if($factura_proveedor_id>0){
			$Layout -> setFactura($factura_proveedor_id);
		}

	//// GRID ////
		$Attributes = array(
			id		=>'causar',
			title		=>'Listado de Causaciones',
			sortname	=>'consecutivo',
			sortorder =>'DESC',    
			width		=>'auto',
			height	=>'250'
		);

		$Cols = array(

			array(name=>'consecutivo',	            index=>'consecutivo',	            sorttype=>'int',	width=>'50',	align=>'left'),	
			array(name=>'ingreso_factura_proveedor',	index=>'ingreso_factura_proveedor',	sorttype=>'date',	width=>'120',	align=>'left'),
			array(name=>'orden_compra_id',			index=>'orden_compra_id',			sorttype=>'int',	width=>'90',	align=>'left'),
			array(name=>'codfactura_proveedor',		index=>'codfactura_proveedor',		sorttype=>'text',	width=>'120',	align=>'left'),	 
			array(name=>'num_ref',					index=>'num_ref',					sorttype=>'text',	width=>'140',	align=>'left'),	  
			array(name=>'proveedor',					index=>'proveedor',					sorttype=>'text',	width=>'140',	align=>'left'),
			array(name=>'fuente_nombre',				index=>'fuente_nombre',				sorttype=>'text',	width=>'140',	align=>'left'),
			array(name=>'tipo_documento',				index=>'tipo_documento',			sorttype=>'text',	width=>'80',	align=>'center'),
			array(name=>'tipo_servicio',				index=>'tipo_servicio',				sorttype=>'text',	width=>'140',	align=>'left'),
			array(name=>'fecha_factura_proveedor',	index=>'fecha_factura_proveedor',	sorttype=>'text',	width=>'120',	align=>'center'),
			array(name=>'vence_factura_proveedor',	index=>'vence_factura_proveedor',	sorttype=>'text',	width=>'120',	align=>'center'),
            array(name=>'equivalente',	             index=>'equivalente',	sorttype=>'text',	width=>'80',	align=>'center'),
			array(name=>'estado_factura_proveedor',	index=>'estado_factura_proveedor',	sorttype=>'text',	width=>'100',	align=>'left')	  
		);

		$Titles = array(
			'CAUSACION',
			'FECHA INGRESO',
			'ORDEN No',
			'CODIGO FACTURA',
			'DESPACHO/MANIFIESTO',
			'PROVEEDOR',
			'FUENTE',					
			'TIPO DOC',
			'TIPO SERVICIO',
			'FECHA FACTURA',
			'VENC. FACTURA',
            'EQUIVALENTE',
			'ESTADO'
		);

		$Layout -> SetGridCausar($Attributes,$Titles,$Cols,$Model -> GetQueryCausarGrid());
		$Layout -> RenderMain();

	}

	protected function onclickValidateRow(){
		require_once("CausarModelClass.php");
		$Model = new CausarModel();
		echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
	}


	protected function onclickSave(){

		require_once("CausarModelClass.php");
		$Model = new CausarModel();

		$archivoPOST     = $_FILES['archivo'];

		
		if($_REQUEST["archivo_checked_file"] == 'true'){
			$rutaAlmacenar   = "../../../archivos/proveedores/causar/";
			$dir_file        = $this -> moveUploadedFile($archivoPOST,$rutaAlmacenar,"archivoCausar");   
			$camposArchivo   = $this -> excelToArray($dir_file,'ALL');	
		}else{
			$camposArchivo = array();
		}

		$return = $Model -> Save($this -> Campos,$camposArchivo,$this -> getConex());

		



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

		require_once("CausarModelClass.php");
		$Model = new CausarModel();

		$Model -> Update($this -> Campos,$this -> getConex());

		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit('Se actualizo correctamente la Causacion');
		}

	}
	protected function setVencimiento($Conex=''){

		$dias 	 = $_REQUEST['dias'];
		$fecha 	 = $_REQUEST['fecha'];

		$retorno = date('Y-m-d', strtotime("$fecha + $dias day"));

		exit("$retorno");



	} 
	protected function onclickCancellation(){

		require_once("CausarModelClass.php");

		$Model = new CausarModel();

		$Model -> cancellation($this -> getConex());

		if(strlen($Model -> GetError()) > 0){
			exit('false');
		}else{
			exit('true');
		}

	}

	protected function onclickPrint(){

		require_once("Imp_DocumentoClass.php");

		$print = new Imp_Documento();

		$print -> printOut($this -> getConex());

	}

//BUSQUEDA
	protected function onclickFind(){

		require_once("CausarModelClass.php");
		$Model = new CausarModel();

		$Data                 = array();
		$factura_proveedor_id = $_REQUEST['factura_proveedor_id'];

		if(is_numeric($factura_proveedor_id)){

			$Data  = $Model -> selectDatosCausarId($factura_proveedor_id,$this -> getConex());

		} 
		$this -> getArrayJSON($Data);

	}

	protected function setDataProveedor(){

		require_once("CausarModelClass.php");
		$Model = new CausarModel();    
		$orden_compra_id = $_REQUEST['orden_compra_id'];
		$data = $Model -> getDataProveedor($orden_compra_id,$this -> getConex());
		$this -> getArrayJSON($data);

	}
	protected function setDataProveedorOrden(){

		require_once("CausarModelClass.php");
		$Model = new CausarModel();    
		$proveedor_id = $_REQUEST['proveedor_id'];
		$data = $Model -> getDataProveedorOrden($proveedor_id,$this -> getConex());
		$this -> getArrayJSON($data);

	}
	protected function setDataTerceManifiesto(){

		require_once("CausarModelClass.php");
		$Model = new CausarModel();    
		$liquidacion_despacho_id = $_REQUEST['liquidacion_despacho_id'];
		$data = $Model -> getDataTerceManifiesto($liquidacion_despacho_id,$this -> getConex());
		$this -> getArrayJSON($data);

	}
	protected function setDataTerceDespacho(){

		require_once("CausarModelClass.php");
		$Model = new CausarModel();    
		$liquidacion_despacho_id = $_REQUEST['liquidacion_despacho_id'];
		$data = $Model -> getDataTerceDespacho($liquidacion_despacho_id,$this -> getConex());
		$this -> getArrayJSON($data);

	}

	protected function setDataProveedornn(){

		require_once("CausarModelClass.php");
		$Model = new CausarModel();    
		$proveedor_id = $_REQUEST['proveedor_id'];
		$data = $Model -> getDataProveedornn($proveedor_id,$this -> getConex());
		$this -> getArrayJSON($data);

	}

	protected function setDataFactura(){

		require_once("CausarModelClass.php");
		$Model = new CausarModel();    
		$factura_proveedor_id = $_REQUEST['factura_proveedor_id'];
		$data = $Model -> getDataFactura($factura_proveedor_id,$this -> getConex());
		$this -> getArrayJSON($data);

	}

	protected function getEstadoEncabezadoRegistro($Conex=''){

		require_once("CausarModelClass.php");
		$Model           = new CausarModel();
		$factura_proveedor_id = $_REQUEST['factura_proveedor_id'];	
		$Estado = $Model -> selectEstadoEncabezadoRegistro($factura_proveedor_id,$this -> getConex());
		exit("$Estado");

	} 

	protected function getTotalDebitoCredito(){

		require_once("CausarModelClass.php");
		$Model = new CausarModel();
		$factura_proveedor_id = $_REQUEST['factura_proveedor_id'];
		$data = $Model -> getTotalDebitoCredito($factura_proveedor_id,$this -> getConex());
		print json_encode($data);  

	}
	protected function getContabilizar(){

		require_once("CausarModelClass.php");
		$Model = new CausarModel();
		$factura_proveedor_id 	 = $_REQUEST['factura_proveedor_id'];
		$fecha_factura_proveedor = $_REQUEST['fecha_factura_proveedor'];
		$empresa_id = $this -> getEmpresaId(); 
		$oficina_id = $this -> getOficinaId();	
		$usuario_id = $this -> getUsuarioId();		


		$mesContable     = $Model -> mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha_factura_proveedor,$this -> getConex());
		$periodoContable = $Model -> PeriodoContableEstaHabilitado($this -> getConex());

		if($mesContable && $periodoContable){
			$return=$Model -> getContabilizarReg($factura_proveedor_id,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$this -> getConex());
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


	protected function SetCampos(){

    /********************
	  Campos causar
	  ********************/

	  $this -> Campos[factura_proveedor_id] = array(
	  	name	=>'factura_proveedor_id',
	  	id		=>'factura_proveedor_id',
	  	type	=>'hidden',
	  	datatype=>array(
	  		type	=>'integer'),
	  	transaction=>array(
	  		table	=>array('factura_proveedor'),
	  		type	=>array('primary_key'))
	  );


	  $this -> Campos[numero_soporte] = array(
	  	name	=>'numero_soporte',
	  	id		=>'numero_soporte',
		type	=>'text',
		Boostrap=>'si',
	  	disabled=>'yes',		
	  	readonly=>'yes'
	  );

	  $this -> Campos[encabezado_registro_id] = array(
	  	name	=>'encabezado_registro_id',
	  	id		=>'encabezado_registro_id',
	  	type	=>'hidden'
	  );

	  $this -> Campos[fuente_servicio_cod] = array(
	  	name	=>'fuente_servicio_cod',
	  	id		=>'fuente_servicio_cod',
		type	=>'select',
		Boostrap=>'si',
	  	options	=>null,
	  	required=>'yes',
	  	onchange	=>'Causartipo()',
	  	datatype=>array(
	  		type	=>'alphanum',
	  		length	=>'2'),
	  	transaction=>array(
	  		table	=>array('factura_proveedor'),
	  		type	=>array('column'))

	  );

	  $this -> Campos[proveedorvacio] = array(
	  	name	=>'proveedorvacio',
	  	id		=>'proveedorvacio',
		  type	=>'text',
		  Boostrap=>'si',
	  	readonly=>'yes',
	  	suggest=>array(
	  		name	=>'ordencompraliquidadas')
	  );
	  
	  $this -> Campos[proveedor] = array(
	  	name	=>'proveedor',
	  	id		=>'proveedor',
		  type	=>'text',
		  Boostrap=>'si',
	  	required=>'yes',
	  	suggest=>array(
	  		name	=>'proveedor',
	  		setId	=>'proveedor_id',
	  		onclick => 'setDataProveedorOrden')
	  );

	  $this -> Campos[proveedormc] = array(
	  	name	=>'proveedormc',
	  	id		=>'proveedormc',
		  type	=>'text',
		  Boostrap=>'si',
	  	required=>'yes',
	  	suggest=>array(
	  		name	=>'manifiestoliquidados',
	  		setId	=>'liquidacion_despacho_hidden',
	  		onclick => 'setDataTerceManifiesto')
	  );

	  $this -> Campos[proveedordu] = array(
	  	name	=>'proveedordu',
	  	id		=>'proveedordu',
		  type	=>'text',
		  Boostrap=>'si',
	  	required=>'yes',
	  	suggest=>array(
	  		name	=>'despacholiquidados',
	  		setId	=>'liquidacion_despacho_hidden',
	  		onclick => 'setDataTerceDespacho')
	  );

	  $this -> Campos[proveedornn] = array(
	  	name	=>'proveedornn',
	  	id		=>'proveedornn',
		  type	=>'text',
		  Boostrap=>'si',
	  	required=>'yes',
	  	suggest=>array(
	  		name	=>'proveedor',
	  		setId	=>'proveedor_id',
	  		onclick => 'setDataProveedornn')
	  );
	  $this -> Campos[proveedor_id] = array(
	  	name	=>'proveedor_id',
	  	id		=>'proveedor_id',
	  	type	=>'hidden',	
	  	datatype=>array(
	  		type	=>'integer',
	  		length	=>'20'),
	  	transaction=>array(
	  		table	=>array('factura_proveedor'),
	  		type	=>array('column'))

	  );

	  $this -> Campos[tercero_id] = array(
	  	name	=>'tercero_id',
	  	id		=>'tercero_id',
	  	type	=>'hidden',	
	  	datatype=>array(
	  		type	=>'integer',
	  		length	=>'20')

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
	  $this -> Campos[orden_compra_id] = array(
	  	name	=>'orden_compra_id',
	  	id		=>'orden_compra_hidden',
	  	type	=>'hidden'
	  );
	  $this -> Campos[orden_compra] = array(
	  	name	=>'orden_compra',
	  	id		=>'orden_compra',
		  type	=>'text',
		  Boostrap=>'si',
	  	readonly=>'yes'
		//required=>'yes'
	  );
	  $this -> Campos[liquidacion_despacho_id] = array(
	  	name	=>'liquidacion_despacho_id',
	  	id		=>'liquidacion_despacho_hidden',
	  	type	=>'hidden',
	  	datatype=>array(
	  		type	=>'integer',
	  		length	=>'20'),
	  	transaction=>array(
	  		table	=>array('factura_proveedor'),
	  		type	=>array('column'))
	  );
	  $this -> Campos[manifiesto_id] = array(
	  	name	=>'manifiesto_id',
	  	id		=>'manifiesto_id',
		  type	=>'text',
		  Boostrap=>'si',
	  	readonly=>'yes',
	  	required=>'yes',
	  	datatype=>array(
	  		type	=>'integer',
	  		length	=>'20')
	  );
	  $this -> Campos[despacho_id] = array(
	  	name	=>'despacho_id',
	  	id		=>'despacho_id',
		  type	=>'text',
		  Boostrap=>'si',
	  	readonly=>'yes',
	  	required=>'yes',
	  	datatype=>array(
	  		type	=>'integer',
	  		length	=>'20')
	  );

	  $this -> Campos[idvacio] = array(
	  	name	=>'idvacio',
	  	id		=>'idvacio',
		  type	=>'text',
		  Boostrap=>'si',
	  	readonly=>'yes'
	  );

	  $this -> Campos[camp_vacio] = array(
	  	name	=>'camp_vacio',
	  	id		=>'camp_vacio',
		  type	=>'text',
		  Boostrap=>'si',
	  	readonly=>'yes'
	  );

	  $this -> Campos[codfactura_proveedor] = array(
	  	name	=>'codfactura_proveedor',
	  	id		=>'codfactura_proveedor',
		  type	=>'text',
		  Boostrap=>'si',
		//required=>'yes',
	  	datatype=>array(
	  		type	=>'alphanum',
	  		length	=>'20'),
	  	transaction=>array(
	  		table	=>array('factura_proveedor'),
	  		type	=>array('column'))

	  );
	  $this -> Campos[codfactura_proveedornn] = array(
	  	name	=>'codfactura_proveedornn',
	  	id		=>'codfactura_proveedornn',
		  type	=>'text',
		  Boostrap=>'si',
		//required=>'yes',
	  	datatype=>array(
	  		type	=>'alphanum',
	  		length	=>'20')
	  );

	  $this -> Campos[concepto_factura_proveedor] = array(
	  	name	=>'concepto_factura_proveedor',
	  	id		=>'concepto_factura_proveedor',
		  type	=>'text',
		  Boostrap=>'si',
	  	required=>'yes',
	  	size	=>95,
	  	datatype=>array(
	  		type	=>'text',
	  		length	=>'250'),
	  	transaction=>array(
	  		table	=>array('factura_proveedor'),
	  		type	=>array('column'))
	  );

	  $this -> Campos[tipo_bien_servicio_ord] = array(
	  	name	=>'tipo_bien_servicio_ord',
	  	id		=>'tipo_bien_servicio_ord',
	  	type	=>'hidden',
	  	datatype=>array(
	  		type	=>'alphanum',
	  		length	=>'2')
	  );

	  $this -> Campos[tipo_bien_servicio_id] = array(
	  	name	=>'tipo_bien_servicio_id',
	  	id		=>'tipo_bien_servicio_id',
	  	type	=>'hidden',
	  	required=>'no',
	  	datatype=>array(
	  		type	=>'integer',
	  		length	=>'2'),
	  	transaction=>array(
	  		table	=>array('factura_proveedor'),
	  		type	=>array('column'))		
	  );


	  $this -> Campos[tipo_bien_servicio_nn] = array(
	  	name	=>'tipo_bien_servicio_nn',
	  	id		=>'tipo_bien_servicio_nn',
		  type	=>'select',
		  Boostrap=>'si',
	  	options	=>null,
	  	required=>'yes',
	  	datatype=>array(
	  		type	=>'integer',
	  		length	=>'2')
	  );

	  $this -> Campos[fecha_factura_proveedor] = array(
	  	name	=>'fecha_factura_proveedor',
	  	id		=>'fecha_factura_proveedor',
		  type	=>'text',
		  Boostrap=>'si',
	  	required=>'yes',
	  	datatype=>array(
	  		type	=>'date',
	  		length	=>'10'),
	  	transaction=>array(
	  		table	=>array('factura_proveedor'),
	  		type	=>array('column'))
	  );
	  $this -> Campos[vence_factura_proveedor] = array(
	  	name	=>'vence_factura_proveedor',
	  	id		=>'vence_factura_proveedor',
		  type	=>'text',
		  Boostrap=>'si',
	  	readonly=>'yes',
	  	size => 10,
		/*required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10'),*/
			transaction=>array(
				table	=>array('factura_proveedor'),
				type	=>array('column'))
		);

	  $this -> Campos[dias_vencimiento] = array(
	  	name	=>'dias_vencimiento',
	  	id		=>'dias_vencimiento',
		  type	=>'text',
		  Boostrap=>'si',
	  	size =>2,
		//required=>'yes',
	  	datatype=>array(
	  		type	=>'integer',
	  		length	=>'20')

	  );

	  $this -> Campos[usuario_id] = array(
	  	name	=>'usuario_id',
	  	id		=>'usuario_id',
	  	type	=>'hidden',
	  	datatype=>array(
	  		type	=>'integer',
	  		length	=>'10'),
	  	transaction=>array(
	  		table	=>array('factura_proveedor'),
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
	  		table	=>array('factura_proveedor'),
	  		type	=>array('column'))
	  );

	  $this -> Campos[ingreso_factura_proveedor] = array(
	  	name	=>'ingreso_factura_proveedor',
	  	id		=>'ingreso_factura_proveedor',
	  	type	=>'hidden',
	  	value	=>date("Y-m-d h:i:s"),
	  	datatype=>array(
	  		type	=>'alphanum',
	  		length	=>'20'),
	  	transaction=>array(
	  		table	=>array('factura_proveedor'),
	  		type	=>array('column'))
	  );

	  $this -> Campos[valor] = array(
	  	name	=>'valor',
	  	id		=>'valor',
		  type	=>'text',
		  Boostrap=>'si',
	  	required=>'yes',
	  	readonly=>'yes',
	  	datatype=>array(
	  		type	=>'numeric',
	  		length	=>'20'),

	  );

	  $this -> Campos[valor_factura_proveedor] = array(
	  	name	=>'valor_factura_proveedor',
	  	id		=>'valor_factura_proveedor',
	  	type	=>'hidden',
		//required=>'yes',
	  	datatype=>array(
	  		type	=>'numeric',
	  		length	=>'20'),
	  	transaction=>array(
	  		table	=>array('factura_proveedor'),
	  		type	=>array('column'))

	  );

	  $this -> Campos[estado_factura_proveedor] = array(
	  	name	=>'estado_factura_proveedor',
	  	id		=>'estado_factura_proveedor',
	  	type	=>'hidden',
	  	value	=>'A',
	  	datatype=>array(
	  		type	=>'alphanum',
	  		length	=>'1'),
	  	transaction=>array(
	  		table	=>array('factura_proveedor'),
	  		type	=>array('column'))

	  );
	  $this -> Campos[estado] = array(
	  	name	=>'estado',
	  	id		=>'estado',
		  type	=>'select',
		  Boostrap=>'si',
	  	disabled=>'yes',
	  	options => array(array(value => 'A', text => 'EDICION'),array(value => 'I', text => 'ANULADO'),array(value => 'C', text => 'CONTABILIZADO')),
	  	selected=>'A',		
	  	datatype=>array(
	  		type	=>'alphanum',
	  		length	=>'1')
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

	  $this -> Campos[anticipos_cruzar] = array(
	  	name	=>'anticipos_cruzar',
	  	id		=>'anticipos_cruzar',
	  	type	=>'hidden',
	  	value	=>'',
	  	transaction=>array(
	  		table	=>array('factura_proveedor'),
	  		type	=>array('column'))

	  );

	  $this -> Campos[val_anticipos_cruzar] = array(
	  	name	=>'val_anticipos_cruzar',
	  	id		=>'val_anticipos_cruzar',
	  	type	=>'hidden',
	  	value	=>'',
	  	transaction=>array(
	  		table	=>array('factura_proveedor'),
	  		type	=>array('column'))

	  );
	  $this -> Campos[anticipos] = array(
	  	name	=>'anticipos',
	  	id		=>'anticipos',
		  type	=>'text',
		  Boostrap=>'si',
		//required=>'yes',

	  	datatype=>array(
	  		type	=>'text',
	  		length	=>'250')
	  );


	  $this -> Campos[factura_scan] = array(
	  	name	=>'factura_scan',
	  	id		=>'factura_scan',
	  	type	=>'file',
	  	value	=>'',
	  	path	=>'/rotterdan/imagenes/proveedores/facturas/',
	  	size	=>'70',
	  	datatype=>array(
	  		type	=>'file'),
	  	transaction=>array(
	  		table	=>array('factura_proveedor'),
	  		type	=>array('column')),
	  	namefile=>array(
	  		field	=>'yes',
	  		namefield=>'factura_proveedor_id',
	  		text	=>'_scanfact')
	  );	
	  
	$this -> Campos[equivalente] = array(
		name	=>'equivalente',
		id		=>'equivalente',
		type	=>'select',
		Boostrap=>'si',
		required=>'yes',
		options => array(array(value => '0', text => 'NO'),array(value => '1', text => 'SI')),
		datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('factura_proveedor'),
			type	=>array('column'))
		
	);

 	$this -> Campos[imp_doc_contable] = array(
		name	=>'imp_doc_contable',
		id		=>'imp_doc_contable',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'text',
			length	=>'5')
	);


	/*****************************************
	        Campos Anulacion Registro
	        *****************************************/


	        $this -> Campos[anul_usuario_id] = array(
	        	name	=>'anul_usuario_id',
	        	id		=>'anul_usuario_id',
	        	type	=>'hidden',
	        	datatype=>array(
	        		type	=>'integer')
	        );		

	        $this -> Campos[anul_oficina_id] = array(
	        	name	=>'anul_oficina_id',
	        	id		=>'anul_oficina_id',
	        	type	=>'hidden',
	        	datatype=>array(
	        		type	=>'integer',
	        		length	=>'11')
	        );

	        $this -> Campos[anul_factura_proveedor] = array(
	        	name	=>'anul_factura_proveedor',
	        	id		=>'anul_factura_proveedor',
				type	=>'text',
				Boostrap=>'si',
	        	size    =>'17',
	        	value   =>date("Y-m-d H:m"),
	        	readonly=>'yes',
	        	datatype=>array(
	        		type	=>'text')
	        );	

	        $this -> Campos[causal_anulacion_id] = array(
	        	name	=>'causal_anulacion_id',
	        	id		=>'causal_anulacion_id',
				type	=>'select',
				Boostrap=>'si',
	        	required=>'yes',
	        	options	=>array(),
	        	datatype=>array(
	        		type	=>'integer')
	        );		


	        $this -> Campos[desc_anul_factura_proveedor] = array(
	        	name	=>'desc_anul_factura_proveedor',
	        	id		=>'desc_anul_factura_proveedor',
	        	type	=>'textarea',
	        	value	=>'',
	        	required=>'yes',
	        	datatype=>array(
	        		type	=>'text')
	        );	

	        $this -> Campos[archivo]  = array(
	        	name	=>'archivo',
	        	id		=>'archivo',
	        	type	=>'file',
		//required=>'yes',
	        	title     =>'Carga de Archivos Clientes',

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
 	             	onclick	=>'CausarOnReset()'
 	             );

 	             $this -> Campos[contabilizar] = array(
 	             	name	=>'contabilizar',
 	             	id		=>'contabilizar',
 	             	type	=>'button',
 	             	value	=>'Contabilizar',
 	             	tabindex=>'16',
 	             	onclick =>'OnclickContabilizar()'
 	             );		

 	             $this -> Campos[imprimir] = array(
 	             	name   =>'imprimir',
 	             	id   =>'imprimir',
 	             	type   =>'print',
 	             	disabled=>'disabled',
 	             	value   =>'Imprimir',
 	             	displayoptions => array(
 	             		form        => 0,
 	             		beforeprint => 'beforePrint',
 	             		title       => 'Impresion Documento Contable',
 	             		width       => '800',
 	             		height      => '600'
 	             	));

 	             $this -> Campos[busqueda] = array(
 	             	name	=>'busqueda',
 	             	id		=>'busqueda',
					  type	=>'text',
					  Boostrap=>'si',
 	             	size	=>'85',
		//tabindex=>'1',
 	             	suggest=>array(
 	             		name	=>'causar',
 	             		setId	=>'factura_proveedor_id',
 	             		onclick	=>'setDataFormWithResponse')
 	             );

 	             $this -> SetVarsValidate($this -> Campos);
 	         }

 	     }

 	     $factura_proveedor_id = new Causar();

 	     ?>