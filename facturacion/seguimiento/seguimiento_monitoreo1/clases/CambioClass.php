<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Cambio extends Controler{

  public function __construct(){
  
	$this -> SetCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
   	
	require_once("CambioLayoutClass.php");
    require_once("CambioModelClass.php");
	
	$Layout = new CambioLayout();
    $Model  = new CambioModel();
    $trafico_id 	= $_REQUEST['trafico_id'];

	
    $Layout -> setIncludes();
	$Layout -> SetCampos($this -> Campos);
	$Layout -> SetRutas($Model -> getRutas($trafico_id,$this -> getConex()));
	$Layout -> SetOrden($Model -> getOrden($trafico_id,$this -> getConex()));
    $Layout -> RenderMain();
    
  }

  protected function SetCampos(){

	$this -> Campos[ruta_id] = array(
		name	=>'ruta_id',
		id		=>'ruta_id',
		type	=>'select',
		options	=>array(),
		required=>'yes',
		onchange	=>'Rutatipo()',
    	datatype=>array(
			type	=>'integer',
			length	=>'18')
	);	

	$this -> Campos[ordenar] = array(
		name	=>'ordenar',
		id		=>'ordenar',
		type	=>'select',
		options	=>array(),
		required=>'yes',
		onchange	=>'Rutatipo()',
    	datatype=>array(
			type	=>'alphanum',
			length	=>'4')
	);	

	//botones
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value=>'ACTUALIZAR'
	);
	
		
	$this -> SetVarsValidate($this -> Campos);
  }

}

$Cambio = new Cambio();

?>