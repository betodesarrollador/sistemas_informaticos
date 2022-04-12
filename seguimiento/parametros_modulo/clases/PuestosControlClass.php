<?php

require_once("../../../framework/clases/ControlerClass.php");

final class PuestosControl extends Controler{

  public function __construct(){
  
	$this -> setCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    
	require_once("PuestosControlLayoutClass.php");
	require_once("PuestosControlModelClass.php");
	
	$Layout   = new PuestosControlLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new PuestosControlModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
   	$Layout -> SetEstadoPuesto($Model -> GetEstadoPuesto($this -> getConex()));

    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'PuestosControl',
	  title		=>'puestos de control',
	  sortname	=>'puesto_control_id',
	  width		=>'auto',
	  height	=>'250'
	);
	$Cols = array(
	  array(name=>'puesto_control_id',			index=>'puesto_control_id',				sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'ubicacion',					index=>'ubicacion',						sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'puesto_control',				index=>'puesto_control',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'responsable_puesto_control',	index=>'responsable_puesto_control',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'direccion_puesto_control',	index=>'direccion_puesto_control',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'telefono_puesto_control',	index=>'telefono_puesto_control',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'telefono2_puesto_control',	index=>'telefono2_puesto_control',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'movil_puesto_control',		index=>'movil_puesto_control',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'movil2_puesto_control',		index=>'movil2_puesto_control',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'email_puesto_control',		index=>'email_puesto_control',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'estado_puesto_control',		index=>'estado_puesto_control',			sorttype=>'text',	width=>'100',	align=>'center')
	);
    $Titles = array('ID',
					'UBICACION',
					'PUESTO CONTROL',
					'RESPONSABLE',
					'DIRECCION',
					'TELEFONO',
					'TELEFONO2',
					'MOVIL',
					'MOVIL2',
					'EMAIL',
					'ESTADO PUESTO CONTROL'
	);
	
	$Layout -> SetGridPuestosControl($Attributes,$Titles,$Cols,$Model -> getQueryPuestosControlGrid());
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"puesto_control",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

  protected function onclickSave(){
    require_once("PuestosControlModelClass.php");
    $Model = new PuestosControlModel();
    $Model -> Save($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se ingreso correctamente el puesto de control');
    }	
  }

  protected function onclickUpdate(){
    require_once("PuestosControlModelClass.php");
	$Model = new PuestosControlModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente el puesto de control');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("PuestosControlModelClass.php");
    $Model = new PuestosControlModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el puesto de control');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
  	require_once("PuestosControlModelClass.php");
    $Model    = new PuestosControlModel();
    $PuestoId = $_REQUEST['puesto_control_id'];
    $Data     =  $Model -> selectPuestoControl($PuestoId,$this -> getConex());
    $this -> getArrayJSON($Data);
  }



  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[puesto_control_id] = array(
		name	=>'puesto_control_id',
		id		=>'puesto_control_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('puesto_control'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[ubicacion] = array(
		name	=>'ubicacion',
		id		=>'ubicacion',
		type	=>'text',
		tabindex=>'2',
		suggest=>array(
			name	=>'ubicacion',
			setId	=>'ubicacion_id')
	);
		
	$this -> Campos[ubicacion_id] = array(
		name	=>'ubicacion_id',
		id		=>'ubicacion_id',
		type	=>'hidden',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('puesto_control'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[puesto_control] = array(
		name	=>'puesto_control',
		id		=>'puesto_control',
		type	=>'text',
		required=>'yes',
		value	=>'',
		tabindex=>'3',
    	datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('puesto_control'),
			type	=>array('column'))
	);
	
	$this -> Campos[responsable_puesto_control] = array(
		name	=>'responsable_puesto_control',
		id		=>'responsable_puesto_control',
		type	=>'text',
		value	=>'',
		tabindex=>'4',
    	datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('puesto_control'),
			type	=>array('column'))
	);
	
	$this -> Campos[direccion_puesto_control] = array(
		name	=>'direccion_puesto_control',
		id		=>'direccion_puesto_control',
		type	=>'text',
		value	=>'',
		tabindex=>'5',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('puesto_control'),
			type	=>array('column'))
	);
	
	$this -> Campos[telefono_puesto_control] = array(
		name	=>'telefono_puesto_control',
		id		=>'telefono_puesto_control',
		type	=>'text',
		value	=>'',
		tabindex=>'6',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('puesto_control'),
			type	=>array('column'))
	);
	
	$this -> Campos[telefono2_puesto_control] = array(
		name	=>'telefono2_puesto_control',
		id		=>'telefono2_puesto_control',
		type	=>'text',
		value	=>'',
		tabindex=>'7',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('puesto_control'),
			type	=>array('column'))
	);
	
	$this -> Campos[movil_puesto_control] = array(
		name	=>'movil_puesto_control',
		id		=>'movil_puesto_control',
		type	=>'text',
		value	=>'',
		tabindex=>'8',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('puesto_control'),
			type	=>array('column'))
	);
	
	$this -> Campos[movil2_puesto_control] = array(
		name	=>'movil2_puesto_control',
		id		=>'movil2_puesto_control',
		type	=>'text',
		value	=>'',
		tabindex=>'9',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('puesto_control'),
			type	=>array('column'))
	);
	
	$this -> Campos[email_puesto_control] = array(
		name	=>'email_puesto_control',
		id		=>'email_puesto_control',
		type	=>'text',
		value	=>'',
		tabindex=>'10',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('puesto_control'),
			type	=>array('column'))
	);
	
	$this -> Campos[estado_puesto_control] = array(
		name	=>'estado_puesto_control',
		id		=>'estado_puesto_control',
		type	=>'select',
		options	=>null,
//		selected=>'0',
		required=>'yes',
		tabindex=>'11',
    	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('puesto_control'),
			type	=>array('column'))
	);
	
	
	
	
	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		disabled=>'disabled'
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'PuestosControlOnSaveUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'PuestosControlOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		disabled=>'disabled',
		onclick	=>'PuestosControlOnReset()'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		value	=>'',
		size	=>'85',
		tabindex=>'1',
		suggest=>array(
			name	=>'busqueda_puesto_control',
			setId	=>'puesto_control_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$PuestosControl = new PuestosControl();

?>