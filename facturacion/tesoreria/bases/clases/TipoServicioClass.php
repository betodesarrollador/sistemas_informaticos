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
	$Layout -> SetDocumento($Model -> GetDocumento($this -> getConex()));
	$Layout -> SetAgencia($Model -> GetAgencia($oficina_id,$this -> getConex()));
	$Layout -> SetManual($Model -> GetManual($oficina_id,$this -> getConex()));
	

	//// GRID ////
	$Attributes = array(
	  id		=>'tiposervicio',
	  title		=>'Listado de Tipos de Servicios',
	  sortname	=>'tipo_bien_servicio_teso_id',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
	
	  array(name=>'tipo_bien_servicio_teso_id',	index=>'tipo_bien_servicio_teso_id',	sorttype=>'int',	width=>'70',	align=>'center'),
	  array(name=>'nombre_bien_servicio_teso',	index=>'nombre_bien_servicio_teso',		sorttype=>'text',	width=>'150',	align=>'left'),
	  array(name=>'documento',					index=>'documento',						sorttype=>'text',	width=>'250',	align=>'left'),	  
	  array(name=>'valor_manual',				index=>'valor_manual',					sorttype=>'text',	width=>'100',	align=>'left'),
	  array(name=>'cuentas_bien',				index=>'cuentas_bien',					sorttype=>'text',	width=>'180',	align=>'left')
	);
	  
    $Titles = array('CODIGO', 'BIEN/SERVICIO', 'DOCUMENTO', 'VALOR MANUAL', 'No DE CUENTAS');
	
	$Layout -> SetGridTipoServicio($Attributes,$Titles,$Cols,$Model -> GetQueryTipoServicioGrid());
	$Layout -> RenderMain();  
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
	$tipo_bien_servicio_teso_id = $_REQUEST['tipo_bien_servicio_teso_id'];
	$data = $Model -> getAgencias($tipo_bien_servicio_teso_id,$this -> getConex());
	print json_encode($data);  	  
  }

//BUSQUEDA
  protected function onclickFind(){
	
	require_once("TipoServicioModelClass.php");
    $Model = new TipoServicioModel();
	
    $Data                 = array();
	$tipo_bien_servicio_teso_id= $_REQUEST['tipo_bien_servicio_teso_id'];
	 
	if(is_numeric($tipo_bien_servicio_teso_id)){
	  
	  $Data  = $Model -> selectDatosTipoServicioId($tipo_bien_servicio_teso_id,$this -> getConex());	  
	} 
    echo json_encode($Data);	
  }

  protected function SetCampos(){  
    /********************
	  Campos Tarifas Proveedor
	********************/
	
	$this -> Campos[tipo_bien_servicio_teso_id] = array(
		name	=>'tipo_bien_servicio_teso_id',
		id		=>'tipo_bien_servicio_teso_id',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('tipo_bien_servicio_teso'),
			type	=>array('primary_key'))
	);

	$this -> Campos[nombre_bien_servicio_teso] = array(
		name	=>'nombre_bien_servicio_teso',
		id		=>'nombre_bien_servicio_teso',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'150'),
		transaction=>array(
			table	=>array('tipo_bien_servicio_teso'),
			type	=>array('column'))
	);	

	$this -> Campos[tipo_documento_id] = array(
		name	=>'tipo_documento_id',
		id		=>'tipo_documento_id',
		type	=>'select',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'2'),
		transaction=>array(
			table	=>array('tipo_bien_servicio_teso'),
			type	=>array('column'))
	);

	$this -> Campos[valor_manual] = array(
		name	=>'valor_manual',
		id		=>'valor_manual',
		type	=>'select',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('tipo_bien_servicio_teso'),
			type	=>array('column'))
	);

	$this -> Campos[maneja_cheque] = array(
		name	=>'maneja_cheque',
		id		=>'maneja_cheque',
		type	=>'select',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('tipo_bien_servicio_teso'),
			type	=>array('column'))
	);

	$this -> Campos[puc_manual] = array(
		name	=>'puc_manual',
		id		=>'puc_manual',
		type	=>'select',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('tipo_bien_servicio_teso'),
			type	=>array('column'))
	);
	
	$this -> Campos[tercero_manual] = array(
		name	=>'tercero_manual',
		id		=>'tercero_manual',
		type	=>'select',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('tipo_bien_servicio_teso'),
			type	=>array('column'))
	);	
	
	$this -> Campos[centro_manual] = array(
		name	=>'centro_manual',
		id		=>'centro_manual',
		type	=>'select',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('tipo_bien_servicio_teso'),
			type	=>array('column'))
	);		

	$this -> Campos[agencia] = array(
		name	=>'agencia',
		id		=>'agencia',
		type	=>'select',
		multiple=>'yes',
		required=>'yes',
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
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled'
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
  		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'TipoServicioOnDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'TipoServicioOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'tiposervicioteso',
			setId	=>'tipo_bien_servicio_teso_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$tipo_bien_servicio_teso_id = new TipoServicio();

?>