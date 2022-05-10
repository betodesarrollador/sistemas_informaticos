<?php

require_once("../../../framework/clases/ControlerClass.php");

final class RangoOrdenServicio extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }

  public function Main(){
	   
    $this -> noCache();
    
    require_once("RangoOrdenServicioLayoutClass.php");
    require_once("RangoOrdenServicioModelClass.php");
	
    $Layout   = new RangoOrdenServicioLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new RangoOrdenServicioModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	$Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));
	
	//LISTA MENU
	//// GRID ////
	$Attributes = array(
	  id		=>'RangoOrdenServicio',
	  title		=>'Rango Orden de Servicios',
	  sortname	=>'empresa',
	  width		=>'auto',
	  height	=>'250'
	);
		
	$Cols = array(
	  array(name=>'empresa',						index=>'empresa',						sorttype=>'text',	width=>'255',	align=>'center'),
	  array(name=>'oficina',						index=>'oficina',						sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'fecha_rango_orden_servicio',		index=>'fecha_rango_orden_servicio',	sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'rango_orden_servicio_ini',		index=>'rango_orden_servicio_ini',		sorttype=>'text',	width=>'90',	align=>'center'),
	  array(name=>'rango_orden_servicio_fin',		index=>'rango_orden_servicio_fin',		sorttype=>'text',	width=>'90',	align=>'center'),
	  array(name=>'total_rango_orden_servicio',		index=>'total_rango_orden_servicio',	sorttype=>'text',	width=>'110',	align=>'center'),
	  array(name=>'utilizado_rango_orden_servicio',	index=>'utilizado_rango_orden_servicio',sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'saldo_rango_orden_servicio',		index=>'saldo_rango_orden_servicio',	sorttype=>'text',	width=>'60',	align=>'center'),
	  array(name=>'estado',							index=>'estado',						sorttype=>'text',	width=>'50',	align=>'center')
	);
    $Titles = array('EMPRESA',
					'OFICINA',
					'FECHA',
					'RANGO INICIO',
					'RANGO FINAL',
					'TOTAL ASIGNADO',
					'UTILIZADOS',
					'SALDO',
					'ESTADO'
	);
	
	$Layout -> SetGridRangoOrdenServicio($Attributes,$Titles,$Cols,$Model -> getQueryRangoOrdenServicioGrid());
	
	$Layout -> RenderMain();    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"rango_orden_servicio",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

  protected function onclickSave(){
    require_once("RangoOrdenServicioModelClass.php");
    $Model = new RangoOrdenServicioModel();
    $Model -> Save($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se ingreso correctamente la alerta');
    }	
  }

  protected function onclickUpdate(){
    require_once("RangoOrdenServicioModelClass.php");
	$Model = new RangoOrdenServicioModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente la alerta');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("RangoOrdenServicioModelClass.php");
    $Model = new RangoOrdenServicioModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la alerta');
	}
  }

/*se busca el consecutivo disponible para los rangos de manifiesto*/
  protected function setDisponibleRes(){
    require_once("RangoOrdenServicioModelClass.php");
    $Model = new RangoOrdenServicioModel();
	$Data  = $Model -> getDisponibleRes($this -> getConex());
	$this -> getArrayJSON($Data);
  }
  
/*se valida que no exista un rango activo para la agencia*/
  protected function validaAgencia(){
    require_once("RangoOrdenServicioModelClass.php");
    $Model = new RangoOrdenServicioModel();
	$rango_orden_servicio_id  = $Model -> validaAgencia($this -> getConex());
	print $rango_orden_servicio_id;
  }

//BUSQUEDA
  protected function onclickFind(){
    require_once("RangoOrdenServicioModelClass.php");
    $Model = new RangoOrdenServicioModel();
	$Data  = $Model -> selectRangoOrdenServicio($this -> getConex());
	$this -> getArrayJSON($Data);
  }
  
  protected function onchangeSetOptionList(){
    require_once("../../../framework/clases/ListaDependiente.php");
	$list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>'nombre',concat=>''),$this -> Campos);
	$list -> getList();
  }  

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[rango_orden_servicio_id] = array(
		name	=>'rango_orden_servicio_id',
		id		=>'rango_orden_servicio_id',
		type	=>'hidden',
    	datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('rango_orden_servicio'),
			type	=>array('primary_key'))
	);
	
	$this->Campos[empresa_id] = array(
		name	=>'empresa_id',
		id		=>'empresa_id',
		type	=>'select',
		options=> array(),
        setoptionslist => array(childId=>'oficina_id',triggerOnchange=>'no'),
		required=>'yes',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('rango_orden_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		options  => array(),
		required=>'yes',
		onchange   =>'validaAgencia(this.value)',		
    	datatype=>array(type => 'integer'),
		transaction=>array(
			table	=>array('rango_orden_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[fecha_rango_orden_servicio] = array(
		name	=>'fecha_rango_orden_servicio',
		id		=>'fecha_rango_orden_servicio',
		type	=>'text',
		value	=>date("Y-m-d"),
		required=>'yes',
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('rango_orden_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[inicio_disponible_res] = array(
		name	=>'inicio_disponible_res',
		id		=>'inicio_disponible_res',
		type	=>'text',
		value	=>'0',
		required=>'yes',
		size	=>'6',
    	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('rango_orden_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[total_rango_orden_servicio] = array(
		name	=>'total_rango_orden_servicio',
		id		=>'total_rango_orden_servicio',
		type	=>'text',
		value	=>'0',
		required=>'yes',
		size	=>'6',
    	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('rango_orden_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[rango_orden_servicio_ini] = array(
		name	=>'rango_orden_servicio_ini',
		id		=>'rango_orden_servicio_ini',
		type	=>'text',
		value	=>'0',
		required=>'yes',
		readonly=>'readonly',
		size	=>'6',
    	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('rango_orden_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[rango_orden_servicio_fin] = array(
		name	=>'rango_orden_servicio_fin',
		id		=>'rango_orden_servicio_fin',
		type	=>'text',
		value	=>'0',
		required=>'yes',
		readonly=>'readonly',
		size	=>'6',
    	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('rango_orden_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[utilizado_rango_orden_servicio] = array(
		name	=>'utilizado_rango_orden_servicio',
		id		=>'utilizado_rango_orden_servicio',
		type	=>'text',
		value	=>'0',
		required=>'yes',
		size	=>'6',
    	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('rango_orden_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[saldo_rango_orden_servicio] = array(
		name	=>'saldo_rango_orden_servicio',
		id		=>'saldo_rango_orden_servicio',
		type	=>'text',
		value	=>'0',
		required=>'yes',
		readonly=>'readonly',
		size	=>'6',
    	datatype=>array(type=>'integer')
	);
	
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		options	=>array(array(value=>'A',text=>'ACTIVO',selected=>'A'),array(value=>'I',text=>'INACTIVO')),
		required=>'yes',
	 	datatype=>array(
			type	=>'alpha'),
		transaction=>array(
			table	=>array('rango_orden_servicio'),
			type	=>array('column'))
	);	
	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'RangoOrdenServicioOnSaveUpdate')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'RangoOrdenServicioOnSaveUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'RangoOrdenServicioOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'RangoOrdenServicioOnReset()'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'busca_rango_orden_servicio',
			setId	=>'rango_orden_servicio_id',
			onclick	=>'setDataFormWithResponse')
	);	
	
	$this -> SetVarsValidate($this -> Campos);
  }
}

$RangoOrdenServicio = new RangoOrdenServicio();

?>