<?php

require_once("../../../framework/clases/ControlerClass.php");

final class CorregirTercero extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("CorregirTerceroLayoutClass.php");
	require_once("CorregirTerceroModelClass.php"); 
	
	$Layout   = new CorregirTerceroLayout($this -> getTitleTab(),$this -> getTitleForm()); 
    $Model    = new CorregirTerceroModel(); 

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId()); 
	
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex())); 
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex())); 
	
    $Layout -> SetCampos($this -> Campos);
		
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("CorregirTerceroModelClass.php");
    $Model = new CorregirTerceroModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }

  protected function onclickUpdate(){
 
  	require_once("CorregirTerceroModelClass.php");
    $Model = new CorregirTerceroModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Tercero');
	  }
	
  }


  

  protected function SetCampos(){
  
    /********************
	  Campos CorregirTercero
	********************/
	
	$this -> Campos[tercero_id] = array(
		name	=>'tercero_id',
		id		=>'tercero_id',
		type	=>'hidden',
		datatype=>array(type=>'integer')
	);
	
	$this -> Campos[tercero] = array(
		name	=>'tercero',
		id		=>'tercero',
		type	=>'text',
		required=>'yes',
		suggest=>array(
			name	=>'tercero',
			setId	=>'tercero_id')
	);
	
		$this -> Campos[tercero_id1] = array(
		name	=>'tercero_id1',
		id		=>'tercero_id1',
		type	=>'hidden',
		datatype=>array(type=>'integer')
	);
	
	$this -> Campos[tercero1] = array(
		name	=>'tercero1',
		id		=>'tercero1',
		type	=>'text',
		required=>'yes',
		suggest=>array(
			name	=>'tercero',
			setId	=>'tercero_id1')
	);

	 	  
	/**********************************
 	             Botones
	**********************************/
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar'
	);
	 
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'CorregirTerceroOnReset()'
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$corregirtercero_id = new CorregirTercero();

?>