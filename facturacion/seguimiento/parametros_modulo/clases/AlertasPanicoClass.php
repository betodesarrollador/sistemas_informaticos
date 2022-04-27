<?php

require_once("../../../framework/clases/ControlerClass.php");

final class AlertasPanico extends Controler{

  public function __construct(){
  
	$this -> setCampos();
	parent::__construct(3);
    
  }


  public function Main(){
	   
    $this -> noCache();
    
	require_once("AlertasPanicoLayoutClass.php");
	require_once("AlertasPanicoModelClass.php");
	
	$Layout   = new AlertasPanicoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new AlertasPanicoModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU

    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'AlertasPanico',
	  title		=>'Colores alerta de panico',
	  sortname	=>'alerta_id',
	  width		=>'auto',
	  height	=>250
	);
	$Cols = array(
	  array(name=>'alerta_id',			index=>'alerta_id',				sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'alerta_panico',		index=>'alerta_panico',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'color_alerta_panico',index=>'color_alerta_panico',	sorttype=>'text',	width=>'100',	align=>'center')
	);
    $Titles = array('ALERTA ID','ALERTA PANICO','COLOR');
	$Layout -> SetGridAlertasPanico($Attributes,$Titles,$Cols,$Model -> getQueryAlertasPanicoGrid());
	
	
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"alerta_panico",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

  protected function onclickSave(){
    require_once("AlertasPanicoModelClass.php");
    $Model = new AlertasPanicoModel();
    $Model -> Save($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se ingreso correctamente la alerta');
    }	
  }

  protected function onclickUpdate(){
    require_once("AlertasPanicoModelClass.php");
	$Model = new AlertasPanicoModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente la alerta');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("AlertasPanicoModelClass.php");
    $Model = new AlertasPanicoModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la alerta');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
    require_once("../../../framework/clases/FindRowClass.php");
    $Data1 = new FindRow($this -> getConex(),"alerta_panico",$this ->Campos);
    $this -> getArrayJSON($Data1 -> GetData());
  }



  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[alerta_id] = array(
		name	=>'alerta_id',
		id		=>'alerta_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('alerta_panico'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[alerta_panico] = array(
		name	=>'alerta_panico',
		id		=>'alerta_panico',
		type	=>'text',
		required=>'yes',
		value	=>'',
		tabindex=>'1',
    	datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('alerta_panico'),
			type	=>array('column'))
	);
	
	$this -> Campos[color_alerta_panico] = array(
		name	=>'color_alerta_panico',
		id		=>'color_alerta_panico',
		type	=>'text',
		value	=>'',
		required=>'yes',
		readonly=>'readonly',
		tabindex=>'2',
    	datatype=>array(
			type	=>'color',
			length	=>'10'),
		transaction=>array(
			table	=>array('alerta_panico'),
			type	=>array('column')));
	
	
	
	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'AlertasPanicoOnSaveUpdate')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		'disabled'=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'AlertasPanicoOnSaveUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		'disabled'=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'AlertasPanicoOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'AlertasPanicoOnReset()'
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
			name	=>'busqueda_alerta_panico',
			setId	=>'alerta_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$AlertasPanico = new AlertasPanico();

?>