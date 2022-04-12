<?php
require_once("../../../../framework/clases/ControlerClass.php");
final class Parametros extends Controler{
	
  public function __construct(){
	parent::__construct(3);
	
  }
  	
  public function Main(){
    $this -> noCache();
	  
	require_once("ParametrosLayoutClass.php");
	require_once("ParametrosModelClass.php");
	
	$Layout   = new ParametrosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ParametrosModel();
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU
	 $Layout -> setFormaPago($Model -> getFormasPago($this -> getConex()));		
	
	//// GRID ////
	$Attributes = array(
	  id		=>'parametros',
	  title		=>'Listado de Parametros',
	  sortname	=>'cuenta_tipo_pago_id',
	  width		=>'auto',
	  height	=>'250'
	);
	$Cols = array(
	
	  array(name=>'cuenta_tipo_pago_id',	index=>'cuenta_tipo_pago_id',	sorttype=>'int',	width=>'100',	align=>'center'),
	  array(name=>'forma',					index=>'forma',					sorttype=>'text',	width=>'170',	align=>'left'),
	  array(name=>'puc',					index=>'puc',					sorttype=>'text',	width=>'320',	align=>'left'),
	  array(name=>'cuenta_tipo_pago_natu',	index=>'cuenta_tipo_pago_natu',	sorttype=>'text',	width=>'100',	align=>'left')	  
	);
	  
    $Titles = array('ID',
					'FORMA DE PAGO',
					'CUENTA PUC',
					'NATURALEZA'
	);
	
	$Layout -> SetGridParametros($Attributes,$Titles,$Cols,$Model -> GetQueryParametrosGrid());
	$Layout -> RenderMain();
  
  }
  protected function onclickValidateRow(){
	require_once("ParametrosModelClass.php");
    $Model = new ParametrosModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  
  protected function onclickSave(){
  	require_once("ParametrosModelClass.php");
    $Model = new ParametrosModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente una nueva Configuracion');
	}
	
  }
  protected function onclickUpdate(){
 
  	require_once("ParametrosModelClass.php");
    $Model = new ParametrosModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente la Configuracion');
	  }
	
  }

  protected function onclickDelete(){
  	require_once("ParametrosModelClass.php");
    $Model = new ParametrosModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('no se puede borrar la Configuracion');
	}else{
	    exit('Se borro exitosamente la Configuracion');
	  }
	
  }

//BUSQUEDA
  protected function onclickFind(){
	
	require_once("ParametrosModelClass.php");
    $Model = new ParametrosModel();
	
    $Data                  = array();
	$cuenta_tipo_pago_id   = $_REQUEST['cuenta_tipo_pago_id'];
	 
	if(is_numeric($cuenta_tipo_pago_id)){
	  
	  $Data  = $Model -> selectDatosParametrosId($cuenta_tipo_pago_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  
  protected function SetCampos(){
  
    /********************
	  Campos Tarifas Proveedor
	********************/
	
	$this -> Campos[cuenta_tipo_pago_id] = array(
		name	=>'cuenta_tipo_pago_id',
		id		=>'cuenta_tipo_pago_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('cuenta_tipo_pago'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[forma_pago_id] = array(
		name	=>'forma_pago_id',
		id		=>'forma_pago_id',
		type	=>'select',
		options	=>null,
		required=>'yes',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('cuenta_tipo_pago'),
			type	=>array('column'))
	);
	
	$this -> Campos[puc] = array(
		name	=>'puc',
		id		=>'puc',
		type	=>'text',
		size    =>'50',
		tabindex=>'10',
		suggest=>array(
			name	=>'cuentas_movimiento',
			setId	=>'puc_hidden',
			form    =>'0'
			)		
	);		
	  
	$this -> Campos[puc_id] = array(
		name	=>'puc_id',
		id		=>'puc_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('cuenta_tipo_pago'),
			type	=>array('column'))
	);	
	 
	$this -> Campos[cuenta_tipo_pago_natu] = array(
		name	=>'cuenta_tipo_pago_natu',
		id		=>'cuenta_tipo_pago_natu',
		type	=>'select',
		options	=>array(array(value=>'D',text=>'Debito'),array(value=>'C',text=>'Credito')),
		required=>'yes',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('cuenta_tipo_pago'),
			type	=>array('column'))
	);
	 	  
	/**********************************
 	             Botones
	**********************************/
	
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		//tabindex=>'19'
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
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
			onsuccess=>'ParametrosOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'ParametrosOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'parametroscuenta',
			setId	=>'cuenta_tipo_pago_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}
}
$parametros_factura_id = new Parametros();
?>