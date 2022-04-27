<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Solicitud extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("SolicitudLayoutClass.php");
	require_once("SolicitudModelClass.php");
	
	$Layout   = new SolicitudLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new SolicitudModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	$Layout -> SetAnular	($Model -> getPermiso($this -> getActividadId(),ANULAR,$this -> getConex()));	
	$Layout -> SetLiquidar  ($Model -> getPermiso($this -> getActividadId(),LIQUIDAR,$this -> getConex()));	
	$Layout -> setImprimir	($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));

	$Layout -> SetCampos($this -> Campos);
	//LISTA MENU	
   	//$Layout -> SetTiposPago($Model -> GetTipoPago($this -> getConex()));
    $Layout -> setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));
	$Layout -> setCentroCosto($Model -> getCentroCosto($this -> getConex()));
	$Layout -> setUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	


		
	$Layout	->	setDepartamento		($Model	->	selectDepartamento		($this	->	getConex()));
	$Layout	->	setUnidadNegocio	($Model	->	selectUnidadNegocio		($this	->	getConex()));
	$Layout ->  setOficina     		($Model ->  selectOficina			($this -> getConex()));
	/**/
	//// GRID ////
	$Attributes = array(
	  id		=>'ordencompra',
	  title		=>'Listado de Solicitudes de Compra',
	  sortname	=>'fecha_pre_orden_compra',
	  sortorder	=>'desc',
	  width		=>'auto',
	  height	=>'250',
	  rowList	=>'500,800,1000,2000,2500',
	  rowNum	=>'100'
	);

	$Cols = array(
	
	  array(name=>'pre_orden_compra_id',		index=>'pre_orden_compra_id',		sorttype=>'int',	width=>'80',	align=>'center'),
	  array(name=>'oficina',				index=>'oficina',				sorttype=>'int',	width=>'80',	align=>'center'),	  
	  array(name=>'fecha_pre_orden_compra',		index=>'fecha_pre_orden_compra',	sorttype=>'text',	width=>'90',	align=>'center'),
	  array(name=>'proveedor_nombre',		index=>'proveedor_nombre',		sorttype=>'text',	width=>'220',	align=>'center'),
	  array(name=>'proveedor_tele',			index=>'proveedor_tele',		sorttype=>'int',	width=>'80',	align=>'center'),	  	  
	  array(name=>'proveedor_ciudad',		index=>'proveedor_ciudad',		sorttype=>'text',	width=>'100',	align=>'center'),	
  	  array(name=>'estado',					index=>'estado',				sorttype=>'text',	width=>'60',	align=>'center'),
	  array(name=>'centro_de_costo',		index=>'centro_de_costo',		sorttype=>'text',	width=>'60',	align=>'center')
	);
	  
    $Titles = array('ORDEN No',
					'OFICINA',
					'FECHA',
					'PROVEEDOR',
					'TELEFONO',
					'CIUDAD',
					'ESTADO',
					'CENTRO DE COSTO'
	);
	

	$Layout -> SetGridSolicitud($Attributes,$Titles,$Cols,$Model -> GetQuerySolicitudGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("SolicitudModelClass.php");
    $Model = new SolicitudModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }

  protected function onclickLiquidar(){
  
	$empresa_id 	= $this -> getEmpresaId(); 
	$oficina_id 	= $this -> getOficinaId();	
  
  	require_once("SolicitudModelClass.php");
    $Model = new SolicitudModel();
	$Model -> liquidar($empresa_id,$oficina_id,$this -> getConex());
	
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit('true');
	}
	
  }

  protected function Checkconfig($Conex){
	  
  	require_once("SolicitudModelClass.php");
    $Model           = new SolicitudModel();
	$pre_orden_compra_id = $_REQUEST['pre_orden_compra_id'];	
	$empresa_id 	= $this -> getEmpresaId(); 
	$oficina_id 	= $this -> getOficinaId();	
	
	$Estado = $Model -> Checkconfig($pre_orden_compra_id,$empresa_id,$oficina_id,$this -> getConex());
	exit("$Estado");
	  
  } 

	protected function setArea1(){

		require_once("SolicitudLayoutClass.php");
		require_once("SolicitudModelClass.php");
		
		$Layout = new SolicitudLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model  = new SolicitudModel();
				
		$orden_id   = $_REQUEST['orden_id'];
		$area_id   = $_REQUEST['area_id'];
		
		$areas  = $Model -> getArea1($orden_id,$this -> getConex());
			
		if(!count($areas) > 0){
		  $areas = array();
		}
		
			$field = 	array(
			name	 =>'area_id',
			id		 =>'area_id',
			type	 =>'select',
			options  => $areas,		
			selected =>$area_id,
			required => 'yes',
			//disabled=>'yes',
			//onchange=>'validar_consecutivo()',
			datatype => array(
				type	=>'alphanum'
			 ),
			transaction=>array(
				table	=>array('orden_servicio'),
				type	=>array('column'))		 
		 );	
		 
		 print $Layout -> getObjectHtml($field);

   }
	protected function setArea(){

		require_once("SolicitudLayoutClass.php");
		require_once("SolicitudModelClass.php");
		
		$Layout = new SolicitudLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model  = new SolicitudModel();
			
		$departamento_id   = $_REQUEST['departamento_id'];
		
		$areas  = $Model -> getArea($departamento_id,$this -> getConex());
			
		if(!count($areas) > 0){
		  $areas = array();
		}
		
			$field = 	array(
			name	 =>'area_id',
			id		 =>'area_id',
			type	 =>'select',
			options  => $areas,		
			selected =>'NULL',
			required => 'yes',
			//onchange=>'validar_consecutivo()',
			datatype => array(
				type	=>'alphanum'
			 ),
			transaction=>array(
				table	=>array('orden_servicio'),
				type	=>array('column'))		 
		 );	
		 
		 print $Layout -> getObjectHtml($field);

   }





  protected function onclickSave(){

	require_once("SolicitudModelClass.php");
	$Model = new SolicitudModel();

	$return = $Model -> Save($this -> Campos,$this -> getConex());
	if(strlen(trim($Model -> GetError())) > 0){
		exit("Error : ".$Model -> GetError());
	}else{
		if(is_array($return)){
			$this -> getArrayJSON($return);
	  	}else{
	  		exit('false');
		}
	}
  }

  protected function onclickUpdate(){
 
  	require_once("SolicitudModelClass.php");
    $Model = new SolicitudModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente la Solicitud de Compra');
	  }
	
  }


  protected function onclickDelete(){

  	require_once("SolicitudModelClass.php");
    $Model = new SolicitudModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('no se puede borrar la Tarifa');
	}else{
	    exit('Se borro exitosamente la Tarifa');
	  }
	
  }

  protected function getTotal(){
	  
  	require_once("SolicitudModelClass.php");
    $Model = new SolicitudModel();
	$pre_orden_compra_id = $_REQUEST['pre_orden_compra_id'];
	$data = $Model -> getTotal($pre_orden_compra_id,$this -> getConex());
	$this -> getArrayJSON($data);  
	  
  }

  protected function onclickCancellation(){
  
  	require_once("SolicitudModelClass.php");
	
    $Model = new SolicitudModel();
	
	$Model -> cancellation($this -> getConex());
	
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit('true');
	}
	
  }


//BUSQUEDA
  protected function onclickFind(){
	
	require_once("SolicitudModelClass.php");
    $Model = new SolicitudModel();
	
    $Data               = array();
	$pre_orden_compra_id	= $_REQUEST['pre_orden_compra_id'];
	 
	if(is_numeric($pre_orden_compra_id)){
	  
	  $Data  = $Model -> selectDatosSolicitudId($pre_orden_compra_id,$this -> getConex());
	  
	} 
    $this -> getArrayJSON($Data);
	
  }

  protected function onclickPrint(){
  
    require_once("Imp_SolicitudClass.php");

    $print = new Imp_Solicitud($this -> getConex());

    $print -> printOut();
  
  }

  protected function setDataProveedor(){

    require_once("SolicitudModelClass.php");
    $Model = new SolicitudModel();    
    $proveedor_id = $_REQUEST['proveedor_id'];
    $data = $Model -> getDataProveedor($proveedor_id,$this -> getConex());
    $this -> getArrayJSON($data);

  }
  
  protected function getEstadoEncabezadoRegistro($Conex=''){
	  
  	require_once("SolicitudModelClass.php");
	
    $Model           = new SolicitudModel();
	$pre_orden_compra_id = $_REQUEST['pre_orden_compra_id'];	
	
	$Estado = $Model -> selectEstadoEncabezadoRegistro($pre_orden_compra_id,$this -> getConex());
	
	exit("$Estado");
	  
  } 


  protected function getItemliquida($Conex){
	  
  	require_once("SolicitudModelClass.php");
	
    $Model           = new SolicitudModel();
	$pre_orden_compra_id = $_REQUEST['pre_orden_compra_id'];	
	
	$totali = $Model -> selectItemliquida($pre_orden_compra_id,$this -> getConex());
	
	exit("$totali");
	  
  } 


  protected function SetCampos(){
  
    /********************
	  Campos Tarifas Proveedor
	********************/
	
	$this -> Campos[pre_orden_compra_id] = array(
		name	=>'pre_orden_compra_id',
		id		=>'pre_orden_compra_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('pre_orden_compra'),
			type	=>array('primary_key'))
	);

	$this -> Campos[consecutivo] = array(
		name	=>'consecutivo',
		id		=>'consecutivo',
		type	=>'text',
		Boostrap=>'si',
		readonly=>'yes',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('pre_orden_compra'),
			type	=>array('primary_key'))
	);

	$this -> Campos[fecha_pre_orden_compra] = array(
		name	=>'fecha_pre_orden_compra',
		id		=>'fecha_pre_orden_compra',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10'),
		transaction=>array(
			table	=>array('pre_orden_compra'),
			type	=>array('column'))
	);
	$this -> Campos[centro_de_costo_id] = array(
		name	=>'centro_de_costo_id',
		id		=>'centro_de_costo_id',
		type	=>'select',
		Boostrap=>'si',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('pre_orden_compra'),
			type	=>array('column'))
	);


	$this -> Campos[proveedor_id] = array(
		name	=>'proveedor_id',
		id		=>'proveedor_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('pre_orden_compra'),
			type	=>array('column'))
	);

	$this -> Campos[proveedor] = array(
		name	=>'proveedor',
		id		=>'proveedor',
		type	=>'text',
		Boostrap=>'si',
		suggest=>array(
			name	=>'proveedor',
			setId	=>'proveedor_hidden',
			onclick => 'setDataProveedor')
	);
			
	$this -> Campos[proveedor_tele] = array(
		name	=>'proveedor_tele',
		id		=>'proveedor_tele',
		type	=>'text',
		Boostrap=>'si',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'200')
	);
	$this -> Campos[proveedor_direccion] = array(
		name	=>'proveedor_direccion',
		id		=>'proveedor_direccion',
		type	=>'text',
		Boostrap=>'si',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'200')
	);
	$this -> Campos[proveedor_ciudad] = array(
		name	=>'proveedor_ciudad',
		id		=>'proveedor_ciudad',
		type	=>'text',
		Boostrap=>'si',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'200')
	);
	$this -> Campos[proveedor_contacto] = array(
		name	=>'proveedor_contacto',
		id		=>'proveedor_contacto',
		type	=>'text',
		Boostrap=>'si',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'200')
	);
	$this -> Campos[proveedor_correo] = array(
		name	=>'proveedor_correo',
		id		=>'proveedor_correo',
		type	=>'text',
		Boostrap=>'si',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'200')
	);

	
	
	
	$this -> Campos[observ_pre_orden_compra] = array(
		name	=>'observ_pre_orden_compra',
		id		=>'observ_pre_orden_compra',
		type	=>'text',
		Boostrap=>'si',
		size	=>89,
	 	//tabindex=>'11',
		datatype=>array(
			type	=>'text',
			length	=>'200'),
		transaction=>array(
			table	=>array('pre_orden_compra'),
			type	=>array('column'))
	);
	
	$this -> Campos[forma_compra_venta_id] = array(
		name	=>'forma_compra_venta_id',
		id		=>'forma_compra_venta_id',
		type	=>'select',
		Boostrap=>'si',
		options	=>null,
		required=>'yes',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('pre_orden_compra'),
			type	=>array('column'))
	);
	
	$this -> Campos[estado_pre_orden_compra] = array(
		name	=>'estado_pre_orden_compra',
		id		=>'estado_pre_orden_compra',
		type	=>'select',
		Boostrap=>'si',
		disabled=>'yes',
		options => array(array(value => 'A', text => 'ACTIVO'),array(value => 'L', text => 'LIQUIDADA'),array(value => 'I', text => 'ANULADA'),array(value => 'C', text => 'CAUSADA')),
		selected=>'A',		
		datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('pre_orden_compra'),
			type	=>array('column'))
	);
	
	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id		=>'usuario_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('pre_orden_compra'),
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
			table	=>array('pre_orden_compra'),
			type	=>array('column'))
	);
	$this -> Campos[ingreso_pre_orden_compra] = array(
		name	=>'ingreso_pre_orden_compra',
		id		=>'ingreso_pre_orden_compra',
		type	=>'hidden',
		value	=>date("Y-m-d h:i:s"),
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'20'),
		transaction=>array(
			table	=>array('pre_orden_compra'),
			type	=>array('column'))
	);
	
	/*****************************************
	        Campos Mantenimiento
	*****************************************/

	$this -> Campos[placa] = array(
		name	=>'placa',
		id		=>'placa',
		type	=>'text',
		Boostrap=>'si',
		size	=>'8',
		//required=>'yes',
		suggest=>array(
			name=>'vehiculo',
			setId=>'placa_hidden'
		),
		value	=>'',
		datatype=>array(
			type	=>'alphanum',
			length	=>'6')
	);
	
	
	$this -> Campos[placa_id] = array(
		name	=>'placa_id',
		id		=>'placa_hidden',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'integer',
			length	=>'8'),
		transaction=>array(
			table	=>array('pre_orden_compra'),
			type	=>array('column'))
	);
	
	$this -> Campos[kilometraje] = array(
		name	=>'kilometraje',
		id		=>'kilometraje',
		type	=>'text',
		Boostrap=>'si',
		required=>'no',
		datatype=>array(
			type	=>'integer',
			length	=>'8'),
		transaction=>array(
			table	=>array('pre_orden_compra'),
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
			table	=>array('pre_orden_compra'),
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

	$this -> Campos[anul_pre_orden_compra] = array(
		name	=>'anul_pre_orden_compra',
		id		=>'anul_pre_orden_compra',
		type	=>'text',
		Boostrap=>'si',
		size    =>'17',
        value   =>date("Y-m-d H:m"),
		readonly=>'yes',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('pre_orden_compra'),
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
			table	=>array('pre_orden_compra'),
			type	=>array('column'))
	);		
	
	
	$this -> Campos[desc_anul_pre_orden_compra] = array(
		name	=>'desc_anul_pre_orden_compra',
		id		=>'desc_anul_pre_orden_compra',
		type	=>'textarea',
		value	=>'',
		required=>'yes',
    	datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('pre_orden_compra'),
			type	=>array('column'))
	);	
	

	/**********************************
 	             Liquidacion
	**********************************/

	$this -> Campos[liq_usuario_id] = array(
		name	=>'liq_usuario_id',
		id		=>'liq_usuario_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('pre_orden_compra'),
			type	=>array('column'))
	);		

	$this -> Campos[fec_liq_pre_orden_compra] = array(
		name	=>'fec_liq_pre_orden_compra',
		id		=>'fec_liq_pre_orden_compra',
		type	=>'text',
		Boostrap=>'si',
		size    =>'17',
        value   =>date("Y-m-d H:m"),
		readonly=>'yes',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('pre_orden_compra'),
			type	=>array('column'))
	);	


	$this -> Campos[descrip_liq_pre_orden_compra] = array(
		name	=>'descrip_liq_pre_orden_compra',
		id		=>'descrip_liq_pre_orden_compra',
		type	=>'textarea',
		value	=>'',
    	datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('pre_orden_compra'),
			type	=>array('column'))
	);	

	 
	 //CAMPOS DE AREA DPTO UND NEGOCIO INICIO
	 			$this -> Campos[departamento_id] = array(
				name	=>'departamento_id',
				id		=>'departamento_id',
				type	=>'select',
				Boostrap=>'si',
				required=>'yes',
				onchange=>'setArea()',
				transaction=>array(
					table	=>array('pre_orden_compra'),
					type	=>array('column'))
			);

			

			$this -> Campos[unidad_negocio_id] = array(
				name	=>'unidad_negocio_id',
				id		=>'unidad_negocio_id',
				type	=>'select',
				Boostrap=>'si',
				required=>'yes',
				transaction=>array(
					table	=>array('pre_orden_compra'),
					type	=>array('column'))
			);

			$this -> Campos[area_id] = array(
				name	=>'area_id',
				id		=>'area_id',
				type	=>'select',
				required=>'yes',
				Boostrap=>'si',
				//onchange=>'validar_consecutivo()',
				options=> array(),
				transaction=>array(
					table	=>array('pre_orden_compra'),
					type	=>array('column'))
			);
		
		 $this -> Campos[sucursal_id] = array(
		name	=>'sucursal_id',
		id		=>'sucursal_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		selected=>$this -> getOficinaId(),
	    datatype=>array(
			type	=>'integer',
			length	=>'9'),
		transaction=>array(
			table	=>array('orden_servicio'),
			type	=>array('column'))
	);	
	
	 //CAMPOS DE AREA DPTO UND NEGOCIO FIN 
	 
	 	  
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
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
  		disabled=>'disabled',
		//tabindex=>'21',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'SolicitudOnDelete')
	);
   	$this -> Campos[anular] = array(
		name	=>'anular',
		id		=>'anular',
		type	=>'button',
		value	=>'Anular',
		tabindex=>'14',
		onclick =>'onclickCancellation(this.form)'
	);	

	$this -> Campos[liquidar] = array(
		name	=>'liquidar',
		id		=>'liquidar',
		type	=>'button',
		value	=>'Liquidar',
		onclick =>'onclickLiquidar(this.form)'
		//tabindex=>'19'
	);

	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'SolicitudOnReset()'
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
      title       => 'Impresion Solicitud de Compra',
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
			name	=>'preordencompra',
			setId	=>'pre_orden_compra_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$pre_orden_compra_id = new Solicitud();

?>