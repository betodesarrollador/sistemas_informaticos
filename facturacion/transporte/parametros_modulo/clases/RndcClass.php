<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Rndc extends Controler{

  public function __construct(){  
    parent::__construct(3);    
  }


  public function Main(){
	   
    $this -> noCache();
    
    require_once("RndcLayoutClass.php");
    require_once("RndcModelClass.php");
	
    $Layout   = new RndcLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new RndcModel();
    
    $Model -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout->setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	$Layout -> setActivo($Model -> getActivo($this -> getConex()));
	
	//LISTA MENU

	
	$Layout -> RenderMain();
    
  }


  protected function onclickUpdate(){
    require_once("RndcModelClass.php");
	$Model = new RndcModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente ');
	}
  }
	  
  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[rndc_id] = array(
		name	=>'rndc_id',
		id		=>'rndc_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('rndc'),
			type	=>array('primary_key'))
	);
	  
	$this->Campos[activo_envio] = array(
		name	=>'activo_envio',
		id		=>'activo_envio',
		type	=>'select',
		required=>'yes',
		options=> array(),
		//tabindex	=>'1',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('rndc'),
			type	=>array('column'))
	);

	$this->Campos[activo_impresion] = array(
		name	=>'activo_impresion',
		id		=>'activo_impresion',
		type	=>'select',
		required=>'yes',
		options=> array(),
		//tabindex	=>'1',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('rndc'),
			type	=>array('column'))
	);

	
	//botones
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'RndcOnSaveUpdate')
	);
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$Rndc = new Rndc();

?>