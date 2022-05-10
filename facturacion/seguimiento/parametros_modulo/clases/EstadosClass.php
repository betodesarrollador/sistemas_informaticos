<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Estados extends Controler{

  public function __construct(){
  
	$this -> setCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    
	require_once("EstadosLayoutClass.php");
	require_once("EstadosModelClass.php");
	
	$Layout   = new EstadosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new EstadosModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'Estados',
	  title		=>'Estados en el seguimiento',
	  sortname	=>'estado_segui_id',
	  width		=>'auto',
	  height	=>250
	);
	$Cols = array(
	  array(name=>'estado_segui_id',			index=>'estado_segui_id',				sorttype=>'text',	width=>'150',	align=>'center'),				  
	  array(name=>'estado_segui',				index=>'estado_segui',					sorttype=>'text',	width=>'250',	align=>'center')
	);
    $Titles = array('CODIGO',
					'NOMBRE'
	);
	
	$Layout -> SetGridEstados($Attributes,$Titles,$Cols,$Model -> getQueryEstadosGrid());
	
	
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"estado_seguimiento ",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

  protected function onclickSave(){
    require_once("EstadosModelClass.php");
    $Model = new EstadosModel();
    $Model -> Save($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se ingreso correctamente el Estado');
    }	
  }

  protected function onclickUpdate(){
    require_once("EstadosModelClass.php");
	$Model = new EstadosModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente el Estado');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("EstadosModelClass.php");
    $Model = new EstadosModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Estado');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
    require_once("../../../framework/clases/FindRowClass.php");
    $Data1 = new FindRow($this -> getConex(),"estado_seguimiento",$this ->Campos);
    $this -> getArrayJSON($Data1 -> GetData());
  }



  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[estado_segui_id] = array(
		name	=>'estado_segui_id',
		id		=>'estado_segui_id',
		type	=>'text',
		required=>'no',
		readonly=>'yes',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('estado_seguimiento'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[estado_segui] = array(
		name	=>'estado_segui',
		id		=>'estado_segui',
		type	=>'text',
		required=>'yes',
		value	=>'',
		tabindex=>'1',
    	datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('estado_seguimiento'),
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
			onsuccess=>'EstadosOnSaveUpdate')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		'disabled'=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'EstadosOnSaveUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		'disabled'=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'EstadosOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		type	=>'reset',
		name	=>'limpiar',
		id		=>'limpiar',
		value	=>'Limpiar',
		onclick	=>'EstadosOnReset()'
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
			name	=>'busqueda_estado_seguimiento',
			setId	=>'estado_segui_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$Estados = new Estados();

?>