<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DirectoriosApoyo extends Controler{

  public function __construct(){
//  print "<pre>";print_r($_REQUEST);print "</pre>";exit();
	$this -> setCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    
	require_once("DirectoriosApoyoLayoutClass.php");
	require_once("DirectoriosApoyoModelClass.php");
	
	$Layout   = new DirectoriosApoyoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new DirectoriosApoyoModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar	($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar	($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar	($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> SetTipoApoyo($Model -> GetTipoApoyo($this -> getConex()));
    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'DirectoriosApoyo',
	  title		=>'Directorio de apoyo',
	  sortname	=>'apoyo_id',
	  width		=>'auto',
	  height	=>250
	  
	);
	$Cols = array(
	  array(name=>'apoyo_id',		index=>'apoyo_id',		sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'tipo_apoyo',		index=>'tipo_apoyo',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'ubicacion',		index=>'ubicacion',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'apoyo',			index=>'apoyo',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'contacto_apoyo',	index=>'contacto_apoyo',sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'tel_apoyo',		index=>'tel_apoyo',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'cel_apoyo',		index=>'cel_apoyo',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'dir_apoyo',		index=>'dir_apoyo',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'placa_apoyo',	index=>'placa_apoyo',	sorttype=>'text',	width=>'100',	align=>'center')
	  
	);
    $Titles = array('ID','TIPO DE APOYO','UBICACION','NOMBRE','CONTACTO','TELEFONO','MOVIL','DIRECCION','PLACA');
	
	$Layout -> SetGridDirectoriosApoyo($Attributes,$Titles,$Cols,$Model -> getQueryDirectoriosApoyoGrid());
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"apoyo",$this ->Campos);
    $this -> getArrayJSON($Data -> GetData());
  }

  protected function onclickSave(){
    require_once("DirectoriosApoyoModelClass.php");
    $Model = new DirectoriosApoyoModel();
    $Model -> Save($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se ingreso correctamente el apoyo');
    }
  }

  protected function onclickUpdate(){
    require_once("DirectoriosApoyoModelClass.php");
	$Model = new DirectoriosApoyoModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente el apoyo');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("DirectoriosApoyoModelClass.php");
    $Model = new DirectoriosApoyoModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el apoyo');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
  	require_once("DirectoriosApoyoModelClass.php");
    $Model = new DirectoriosApoyoModel();
    $ApoyoId = $_REQUEST['apoyo_id'];
    $Data =  $Model -> selectDirectoriosApoyo($ApoyoId,$this -> getConex());
    $this -> getArrayJSON($Data);
  }



  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[ubicacion_id] = array(
		name	=>'ubicacion_id',
		id		=>'ubicacion_id_hidden',
		type	=>'hidden',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('apoyo'),
			type	=>array('column'))
	);
	
	$this -> Campos[ubicacion] = array(
		name	=>'ubicacion',
		id		=>'ubicacion',
		type	=>'text',
		suggest=>array(
			name	=>'ubicacion',
			setId	=>'ubicacion_id_hidden')
	);

	$this -> Campos[tipo_apoyo_id] = array(
		name	=>'tipo_apoyo_id',
		id		=>'tipo_apoyo_id',
		type	=>'select',
		options	=>null,
		required=>'yes',
    	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('apoyo'),
			type	=>array('column'))
	);

	$this -> Campos[apoyo] = array(
		name	=>'apoyo',
		id		=>'apoyo',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('apoyo'),
			type	=>array('column'))
	);

	$this -> Campos[identificacion_apoyo] = array(
		name	=>'identificacion_apoyo',
		id		=>'identificacion_apoyo',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'50'),
		transaction=>array(
			table	=>array('apoyo'),
			type	=>array('column'))
	);

	$this -> Campos[apoyo_id] = array(
		name	=>'apoyo_id',
		id		=>'apoyo_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('apoyo'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[tel_apoyo] = array(
		name	=>'tel_apoyo',
		id		=>'tel_apoyo',
		type	=>'text',
		required=>'yes',
		value	=>'',
    	datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('apoyo'),
			type	=>array('column'))
	);
	
	$this -> Campos[dir_apoyo] = array(
		name	=>'dir_apoyo',
		id		=>'dir_apoyo',
		type	=>'text',
		required=>'no',
		value	=>'',
    	datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('apoyo'),
			type	=>array('column'))
	);

	$this -> Campos[placa_apoyo] = array(
		name	=>'placa_apoyo',
		id		=>'placa_apoyo',
		type	=>'text',
		required=>'no',
		value	=>'',
    	datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('apoyo'),
			type	=>array('column'))
	);

	$this -> Campos[cel_apoyo] = array(
		name	=>'cel_apoyo',
		id		=>'cel_apoyo',
		type	=>'text',
		required=>'no',
		value	=>'',
    	datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('apoyo'),
			type	=>array('column'))
	);

	$this -> Campos[cor_apoyo] = array(
		name	=>'cor_apoyo',
		id		=>'cor_apoyo',
		type	=>'text',
		required=>'no',
		value	=>'',
    	datatype=>array(
			type	=>'email',
			length	=>'250'),
		transaction=>array(
			table	=>array('apoyo'),
			type	=>array('column'))
	);

	$this -> Campos[contacto_apoyo] = array(
		name	=>'contacto_apoyo',
		id		=>'contacto_apoyo',
		type	=>'text',
		required=>'yes',
		value	=>'',
    	datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('apoyo'),
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
			onsuccess=>'DirectoriosApoyoOnSaveUpdate')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		'disabled'=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'DirectoriosApoyoOnSaveUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		'disabled'=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'DirectoriosApoyoOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick =>'directoriosApoyoOnclear(this.form)'
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
			name	=>'directorio_apoyo',
			setId	=>'apoyo_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$DirectoriosApoyo = new DirectoriosApoyo();

?>