<?php

require_once("../../../framework/clases/ControlerClass.php");

final class TipoServicio extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("TipoServicioLayoutClass.php");
	require_once("TipoServicioModelClass.php");
	
	$Layout   = new TipoServicioLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new TipoServicioModel();

	$oficina_id = $this -> getOficinaId();	
	
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU	
   	$Layout -> SetFuente($Model -> GetFuente($this -> getConex()));
	$Layout -> SetDocumento($Model -> GetDocumento($this -> getConex()));
	$Layout -> SetAgencia($Model -> GetAgencia($oficina_id,$this -> getConex()));
	
	$Layout -> RenderMain();
  
  }
  
  protected function showGrid(){
	  
	require_once("TipoServicioLayoutClass.php");
	require_once("TipoServicioModelClass.php");
	
	$Layout   = new TipoServicioLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new TipoServicioModel();
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'tiposervicio',
		title		=>'Listado de Tipos de Servicios',
		sortname	=>'tipo_bien_servicio_factura_id',
		width		=>'auto',
		height	=>'250'
	  );
  
	  $Cols = array(
	  
		array(name=>'tipo_bien_servicio_factura_id',	index=>'tipo_bien_servicio_factura_id',	sorttype=>'int',	width=>'70',	align=>'center'),
		array(name=>'nombre_bien_servicio_factura',	index=>'nombre_bien_servicio_factura',	sorttype=>'text',	width=>'250',	align=>'left'),
		  array(name=>'fuente_servicio',				index=>'fuente_servicio',				sorttype=>'text',	width=>'230',	align=>'left'),
		array(name=>'documento',						index=>'documento',						sorttype=>'text',	width=>'180',	align=>'left'),
		array(name=>'estado',							index=>'estado',						sorttype=>'text',	width=>'70',	align=>'left')
	  );
		
	  $Titles = array('CODIGO',
					  'BIEN/SERVICIO',
					  'FUENTE',
					  'DOCUMENTO',
					  'ESTADO'
	  );
	  
	 $html =  $Layout -> SetGridTipoServicio($Attributes,$Titles,$Cols,$Model -> GetQueryTipoServicioGrid());
	 
	 print $html;
	  
  }
  

  protected function onclickValidateRow(){
	require_once("TipoServicioModelClass.php");
    $Model = new TipoServicioModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

	require_once("TipoServicioModelClass.php");
	$Model = new TipoServicioModel();
	$agencia = $_REQUEST['agencia'];
	$return = $Model -> Save($agencia,$this -> Campos,$this -> getConex());
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
 
  	require_once("TipoServicioModelClass.php");
    $Model = new TipoServicioModel();

	$agencia = $_REQUEST['agencia'];
    $Model -> Update($agencia,$this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente El Tipo de Servicio');
	  }
	
	
  }


  protected function onclickDelete(){

  	require_once("TipoServicioModelClass.php");
    $Model = new TipoServicioModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('no se puede borrar El Tipo de Servicio');
	}else{
	    exit('Se borro exitosamente El Tipo de Servicio');
	  }
	
  }

  protected function getAgencias(){
	  
  	require_once("TipoServicioModelClass.php");
    $Model = new TipoServicioModel();
	$tipo_bien_servicio_factura_id = $_REQUEST['tipo_bien_servicio_factura_id'];
	$data = $Model -> getAgencias($tipo_bien_servicio_factura_id,$this -> getConex());
	print json_encode($data);  
	  
  }


//BUSQUEDA
  protected function onclickFind(){
	
	require_once("TipoServicioModelClass.php");
    $Model = new TipoServicioModel();
	
    $Data                 			= array();
	$tipo_bien_servicio_factura_id	= $_REQUEST['tipo_bien_servicio_factura_id'];
	 
	if(is_numeric($tipo_bien_servicio_factura_id)){
	  
	  $Data  = $Model -> selectDatosTipoServicioId($tipo_bien_servicio_factura_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Tarifas Proveedor
	********************/
	
	$this -> Campos[tipo_bien_servicio_factura_id] = array(
		name	=>'tipo_bien_servicio_factura_id',
		id		=>'tipo_bien_servicio_factura_id',
		type	=>'text',
		Boostrap=>'si',
		readonly=>'yes',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('tipo_bien_servicio_factura'),
			type	=>array('primary_key'))
	);
	
	  

	$this -> Campos[nombre_bien_servicio_factura] = array(
		name	=>'nombre_bien_servicio_factura',
		id		=>'nombre_bien_servicio_factura',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'150'),
		transaction=>array(
			table	=>array('tipo_bien_servicio_factura'),
			type	=>array('column'))
	);
	

	$this -> Campos[fuente_facturacion_cod] = array(
		name	=>'fuente_facturacion_cod',
		id		=>'fuente_facturacion_cod',
		type	=>'select',
		Boostrap=>'si',
		options	=>null,
		required=>'yes',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'2'),
		transaction=>array(
			table	=>array('tipo_bien_servicio_factura'),
			type	=>array('column'))
	);
	$this -> Campos[tipo_documento_id] = array(
		name	=>'tipo_documento_id',
		id		=>'tipo_documento_id',
		type	=>'select',
		Boostrap=>'si',
		options	=>null,
		required=>'yes',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'2'),
		transaction=>array(
			table	=>array('tipo_bien_servicio_factura'),
			type	=>array('column'))
	);
	$this -> Campos[tipo_documento_dev_id] = array(
		name	=>'tipo_documento_dev_id',
		id		=>'tipo_documento_dev_id',
		type	=>'select',
		Boostrap=>'si',
		options	=>null,
		//required=>'yes',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'2'),
		transaction=>array(
			table	=>array('tipo_bien_servicio_factura'),
			type	=>array('column'))
	);
	$this -> Campos[agencia] = array(
		name	=>'agencia',
		id		=>'agencia',
		type	=>'select',
		Boostrap=>'si',
		multiple=>'yes',
		required=>'yes',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11')
	);
	
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		Boostrap=>'si',
		options	 =>array(array(value => 'B',text => 'BLOQUEADO'),array(value => 'D', text => 'DISPONIBLE')),
		required=>'yes',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('tipo_bien_servicio_factura'),
			type	=>array('column'))
	);

	$this -> Campos[reporta_cartera] = array(
		name	=>'reporta_cartera',
		id		=>'reporta_cartera',
		type	=>'select',
		options	=>array ( 0 => array ( 'value' => '1', 'text' => 'SI' ), 1 => array ( 'value' => '0', 'text' => 'NO' )),
		required=>'yes',
		Boostrap=>'si',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('tipo_bien_servicio_factura'),
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
			onsuccess=>'TipoServicioOnDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'TipoServicioOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap=>'si',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'tiposerviciofactura',
			setId	=>'tipo_bien_servicio_factura_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$tipo_bien_servicio_factura_id = new TipoServicio();

?>