<?php

require_once("../../../framework/clases/ControlerClass.php");

final class RangoGuia extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }

  public function Main(){
	   
    $this -> noCache();
    
    require_once("RangoGuiaLayoutClass.php");
    require_once("RangoGuiaModelClass.php");
	
    $Layout   = new RangoGuiaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new RangoGuiaModel();
    
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
	  id		=>'RangoGuia',
	  title		=>'Rango Manifiestos',
	  sortname	=>'empresa',
	  width		=>'auto',
	  height	=>'250'
	);
		
	$Cols = array(
	  array(name=>'empresa',				index=>'empresa',				sorttype=>'text',	width=>'255',	align=>'center'),
	  array(name=>'oficina',				index=>'oficina',				sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'prefijo',				index=>'prefijo',				sorttype=>'text',	width=>'80',	align=>'center'),	  
	  array(name=>'fecha_rango_guia',		index=>'fecha_rango_guia',		sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'rango_guia_ini',			index=>'rango_guia_ini',		sorttype=>'text',	width=>'90',	align=>'center'),
	  array(name=>'rango_guia_fin',			index=>'rango_guia_fin',		sorttype=>'text',	width=>'90',	align=>'center'),
	  array(name=>'total_rango_guia',		index=>'total_rango_guia',		sorttype=>'text',	width=>'110',	align=>'center'),
	  array(name=>'utilizado_rango_guia',	index=>'utilizado_rango_guia',	sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'saldo_rango_guia',		index=>'saldo_rango_guia',		sorttype=>'text',	width=>'60',	align=>'center'),
	  array(name=>'estado',					index=>'estado',				sorttype=>'text',	width=>'50',	align=>'center')
	);
    $Titles = array('EMPRESA',
					'OFICINA',
					'PREFIJO',
					'FECHA',
					'RANGO INICIO',
					'RANGO FINAL',
					'TOTAL ASIGNADO',
					'UTILIZADOS',
					'SALDO',
					'ESTADO'
	);
	
	$Layout -> SetGridRangoGuia($Attributes,$Titles,$Cols,$Model -> getQueryRangoGuiaGrid());
	
	$Layout -> RenderMain();    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"rango_guia",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

  protected function onclickSave(){
    require_once("RangoGuiaModelClass.php");
    $Model = new RangoGuiaModel();
    $Model -> Save($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se ingreso correctamente la alerta');
    }	
  }

  protected function onclickUpdate(){
    require_once("RangoGuiaModelClass.php");
	$Model = new RangoGuiaModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente la alerta');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("RangoGuiaModelClass.php");
    $Model = new RangoGuiaModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la alerta');
	}
  }

/*se busca el consecutivo disponible para los rangos de manifiesto*/
  protected function setDisponibleRes(){
    require_once("RangoGuiaModelClass.php");
    $Model = new RangoGuiaModel();
	$Data  = $Model -> getDisponibleRes($this -> getConex());
	$this -> getArrayJSON($Data);
  }
  
/*se valida que no exista un rango activo para la agencia*/
  protected function validaAgencia(){
    require_once("RangoGuiaModelClass.php");
    $Model = new RangoGuiaModel();
	$rango_guia_id  = $Model -> validaAgencia($this -> getConex());
	print $rango_guia_id;
  }

//BUSQUEDA
  protected function onclickFind(){
    require_once("RangoGuiaModelClass.php");
    $Model = new RangoGuiaModel();
	$Data  = $Model -> selectRangoGuia($this -> getConex());
	$this -> getArrayJSON($Data);
  }
  
  protected function onchangeSetOptionList(){
    require_once("../../../framework/clases/ListaDependiente.php");
	$list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>'nombre',concat=>''),$this -> Campos);
	$list -> getList();
  }  

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[rango_guia_id] = array(
		name	=>'rango_guia_id',
		id		=>'rango_guia_id',
		type	=>'hidden',
    	datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('rango_guia'),
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
			table	=>array('rango_guia'),
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
			table	=>array('rango_guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[prefijo] = array(
		name	=>'prefijo',
		id		=>'prefijo',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'alpha'),
		transaction=>array(
			table	=>array('rango_guia'),
			type	=>array('column'))
	);	
	
	
	$this -> Campos[fecha_rango_guia] = array(
		name	=>'fecha_rango_guia',
		id		=>'fecha_rango_guia',
		type	=>'text',
		value	=>date("Y-m-d"),
		required=>'yes',
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('rango_guia'),
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
			table	=>array('rango_guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[total_rango_guia] = array(
		name	=>'total_rango_guia',
		id		=>'total_rango_guia',
		type	=>'text',
		value	=>'0',
		required=>'yes',
		size	=>'6',
    	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('rango_guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[rango_guia_ini] = array(
		name	=>'rango_guia_ini',
		id		=>'rango_guia_ini',
		type	=>'text',
		value	=>'0',
		required=>'yes',
		readonly=>'readonly',
		size	=>'6',
    	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('rango_guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[rango_guia_fin] = array(
		name	=>'rango_guia_fin',
		id		=>'rango_guia_fin',
		type	=>'text',
		value	=>'0',
		required=>'yes',
		readonly=>'readonly',
		size	=>'6',
    	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('rango_guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[utilizado_rango_guia] = array(
		name	=>'utilizado_rango_guia',
		id		=>'utilizado_rango_guia',
		type	=>'text',
		value	=>'0',
		required=>'yes',
		size	=>'6',
    	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('rango_guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[saldo_rango_guia] = array(
		name	=>'saldo_rango_guia',
		id		=>'saldo_rango_guia',
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
			table	=>array('rango_guia'),
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
			onsuccess=>'RangoGuiaOnSaveUpdate')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'RangoGuiaOnSaveUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'RangoGuiaOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'RangoGuiaOnReset()'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'busca_rango_guia',
			setId	=>'rango_guia_id',
			onclick	=>'setDataFormWithResponse')
	);	
	
	$this -> SetVarsValidate($this -> Campos);
  }
}

$RangoGuia = new RangoGuia();

?>