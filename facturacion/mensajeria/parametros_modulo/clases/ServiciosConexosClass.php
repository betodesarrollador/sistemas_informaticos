<?php

require_once("../../../framework/clases/ControlerClass.php");

final class ServiciosConexos extends Controler{

  public function __construct(){
  
	$this -> setCampos();
	parent::__construct(3);
    
  }


  public function Main(){
	   
    $this -> noCache();
    
	require_once("ServiciosConexosLayoutClass.php");
	require_once("ServiciosConexosModelClass.php");
	
	$Layout   = new ServiciosConexosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ServiciosConexosModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));

    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'ServiciosConexos',
	  title		=>'Servicios Conexos',
	  sortname	=>'servi_conex',
	  width		=>'auto',
	  height	=>'250'
	);
	$Cols = array(
	  array(name=>'servi_conex',index=>'servi_conex',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'agencia',	index=>'agencia',		sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'ctaingreso',	index=>'ctaingreso',	sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'ctacxc',		index=>'ctacxc',		sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'ctacosto',	index=>'ctacosto',		sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'ctacxp',		index=>'ctacxp',		sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'estado',		index=>'estado',		sorttype=>'text',	width=>'50',	align=>'center')
	);
    $Titles = array('SERVICIO RECURSO',
					'AGENCIA',
					'CUENTA INGRESO',
					'CUENTA X COBRAR',
					'CUENTA COSTO',
					'CUENTA X PAGAR',
					'ESTADO'
	);
	$Layout -> SetGridServiciosConexos($Attributes,$Titles,$Cols,$Model -> getQueryServiciosConexosGrid());
	
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"servicio_conexo",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

  protected function onclickSave(){
    require_once("ServiciosConexosModelClass.php");
    $Model = new ServiciosConexosModel();
    $Model -> Save($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se ingreso correctamente la alerta');
    }	
  }

  protected function onclickUpdate(){
    require_once("ServiciosConexosModelClass.php");
	$Model = new ServiciosConexosModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente la alerta');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("ServiciosConexosModelClass.php");
    $Model = new ServiciosConexosModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la alerta');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
    require_once("ServiciosConexosModelClass.php");
    $Model = new ServiciosConexosModel();
	$Data  = $Model -> selectServiciosConexos($this -> getConex());
    $this -> getArrayJSON($Data);
  }
  
  protected function onchangeSetOptionList(){
    require_once("../../../framework/clases/ListaDependiente.php");
	$list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>'nombre',concat=>''),$this -> Campos);
	$list -> getList();
  }  



  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[servi_conex_id] = array(
		name	=>'servi_conex_id',
		id		=>'servi_conex_id',
		type	=>'hidden',
    	datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('servicio_conexo'),
			type	=>array('primary_key'))
	);
	
	$this->Campos[empresa_id] = array(
		name	=>'empresa_id',
		id		=>'empresa_id',
		type	=>'select',
		options=> array(),
        setoptionslist => array(childId=>'oficina_id'),
		required=>'yes',
		datatype=>array(
			type	=>'integer')
	);
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		options  => array(),
		required=>'yes',
    	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('servicio_conexo'),
			type	=>array('column'))
	);
	
	$this -> Campos[servi_conex] = array(
		name	=>'servi_conex',
		id		=>'servi_conex',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'alpha_upper',
			length	=>'30'),
		transaction=>array(
			table	=>array('servicio_conexo'),
			type	=>array('column'))
	);
	
	$this -> Campos[puc_ingreso] = array(
		name	=>'puc_ingreso',
		id		=>'puc_ingreso',
		type	=>'text',
		suggest=>array(
			name	=>'cuentas_movimiento',
			setId	=>'puc_ingreso_hidden',
			form    =>'0'
			)
	);
	
	$this -> Campos[puc_ingreso_id] = array(
		name	=>'puc_ingreso_id',
		id		=>'puc_ingreso_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('servicio_conexo'),
			type	=>array('column'))
	);
	
	$this -> Campos[puc_cxc] = array(
		name	=>'puc_cxc',
		id		=>'puc_cxc',
		type	=>'text',
		suggest=>array(
			name	=>'cuentas_movimiento',
			setId	=>'puc_cxc_hidden',
			form    =>'0'
			)
	);
	
	$this -> Campos[puc_cxc_id] = array(
		name	=>'puc_cxc_id',
		id		=>'puc_cxc_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('servicio_conexo'),
			type	=>array('column'))
	);
	
	$this -> Campos[puc_costo] = array(
		name	=>'puc_costo',
		id		=>'puc_costo',
		type	=>'text',
		suggest=>array(
			name	=>'cuentas_movimiento',
			setId	=>'puc_costo_hidden',
			form    =>'0'
			)
	);
	
	$this -> Campos[puc_costo_id] = array(
		name	=>'puc_costo_id',
		id		=>'puc_costo_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('servicio_conexo'),
			type	=>array('column'))
	);
	
	$this -> Campos[puc_cxp] = array(
		name	=>'puc_cxp',
		id		=>'puc_cxp',
		type	=>'text',
		suggest=>array(
			name	=>'cuentas_movimiento',
			setId	=>'puc_cxp_hidden',
			form    =>'0'
			)
	);
	
	$this -> Campos[puc_cxp_id] = array(
		name	=>'puc_cxp_id',
		id		=>'puc_cxp_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('servicio_conexo'),
			type	=>array('column'))
	);
	
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		options => array(
				array(value=>'A',text=>'Activo'),
				array(value=>'I',text=>'Inactivo')),
		required=>'yes',
    	datatype=>array(
			type	=>'alpha'),
		transaction=>array(
			table	=>array('servicio_conexo'),
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
			onsuccess=>'ServiciosConexosOnSaveUpdate')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'ServiciosConexosOnSaveUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'ServiciosConexosOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'ServiciosConexosOnReset()'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		value	=>'',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'busca_servicio_conexo',
			setId	=>'servi_conex_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$ServiciosConexos = new ServiciosConexos();

?>