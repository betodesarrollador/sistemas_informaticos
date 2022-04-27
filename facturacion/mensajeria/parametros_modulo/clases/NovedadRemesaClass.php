<?php

require_once("../../../framework/clases/ControlerClass.php");

final class NovedadRemesa extends Controler{

  public function __construct(){
  
	$this -> setCampos();
	parent::__construct(3);
    
  }


  public function Main(){
	   
    $this -> noCache();
    
	require_once("NovedadRemesaLayoutClass.php");
	require_once("NovedadRemesaModelClass.php");
	
	$Layout   = new NovedadRemesaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new NovedadRemesaModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'NovedadRemesa',
	  title		=>'Novedades Remesas',
	  sortname	=>'novedad_rm',
	  width		=>'auto',
	  height	=>'250'
	);
	$Cols = array(
	  array(name=>'novedad_rm',	index=>'novedad_rm',sorttype=>'text',	width=>'200',	align=>'center'),
	  array(name=>'cliente',	index=>'cliente',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'estado',		index=>'estado',	sorttype=>'text',	width=>'150',	align=>'center')
	);
    $Titles = array('NOVEDAD',
					'VISIBLE CLIENTE',
					'ESTADO DE LA NOVEDAD'
	);
	$Layout -> SetGridNovedadRemesa($Attributes,$Titles,$Cols,$Model -> getQueryNovedadRemesaGrid());
	
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"novedad_remesa",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

  protected function onclickSave(){
    require_once("NovedadRemesaModelClass.php");
    $Model = new NovedadRemesaModel();
    $Model -> Save($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se ingreso correctamente la alerta');
    }	
  }

  protected function onclickUpdate(){
    require_once("NovedadRemesaModelClass.php");
	$Model = new NovedadRemesaModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente la alerta');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("NovedadRemesaModelClass.php");
    $Model = new NovedadRemesaModel();
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
    $Data = new FindRow($this -> getConex(),"novedad_remesa",$this ->Campos);
    $this -> getArrayJSON($Data -> GetData());
  }



  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[novedad_rm_id] = array(
		name	=>'novedad_rm_id',
		id		=>'novedad_rm_id',
		type	=>'hidden',
    	datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('novedad_remesa'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[novedad_rm] = array(
		name	=>'novedad_rm',
		id		=>'novedad_rm',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'alpha_upper',
			length	=>'50'),
		transaction=>array(
			table	=>array('novedad_remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[novedad_visible_cliente] = array(
		name	=>'novedad_visible_cliente',
		id		=>'novedad_visible_cliente',
		type	=>'select',
		options => array(
				array(value=>'1',text=>'SI'),
				array(value=>'0',text=>'NO')),
		required=>'yes',
    	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('novedad_remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		options => array(
				array(value=>'1',text=>'Activo'),
				array(value=>'0',text=>'Inactivo')),
		required=>'yes',
    	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('novedad_remesa'),
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
			onsuccess=>'NovedadRemesaOnSaveUpdate')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'NovedadRemesaOnSaveUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'NovedadRemesaOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'NovedadRemesaOnReset()'
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
			name	=>'busca_novedad_remesa',
			setId	=>'novedad_rm_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$NovedadRemesa = new NovedadRemesa();

?>