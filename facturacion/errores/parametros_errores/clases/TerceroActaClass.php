<?php
require_once("../../../framework/clases/ControlerClass.php");
final class TerceroActa extends Controler{
  public function __construct(){
	parent::__construct(3);
  }
  public function Main(){
    
    $this -> noCache();
    
    require_once("TerceroActaLayoutClass.php");
    require_once("TerceroActaModelClass.php");
	
    $Layout = new TerceroActaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new TerceroActaModel();

	$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setIncludes();
    $Layout -> setTercerosActa($Model -> getTercerosActa($this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  
  protected function onclickSave(){
  
    require_once("TerceroActaModelClass.php");
	
    $Model = new TerceroActaModel();
	
    $return = $Model -> Save($this -> Campos,$this -> getConex(),$this -> getUsuarioId());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        if(is_numeric($return)){
		  exit("$return");
		}else{
		    exit('false');
		  }
	  }	
  }
  protected function onclickUpdate(){
  
    require_once("TerceroActaModelClass.php");
	
    $Model = new TerceroActaModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("TerceroActaModelClass.php");
	
    $Model = new TerceroActaModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 
  }
  
//CAMPOS
  protected function setCampos(){
	
	$this -> Campos[acuerdo_id] = array(
		name	=>'acuerdo_id',
		id      =>'acuerdo_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('acuerdos_compromisos'),
			type	=>array('primary_key'))
	);
	$this -> Campos[acta_id] = array(
		name	=>'acta_id',
		id      =>'acta_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('acuerdos_compromisos'),
			type	=>array('column'))
	);

	$this -> Campos[prioridad] = array(
		name	=>'prioridad',
		id      =>'prioridad',
		type	=>'select',
		options =>array(array(value => '1', text => 'ALTA'), array(value => '2', text => 'MEDIA'), array(value => '3', text => 'BAJA')),selected=>'1',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('acuerdos_compromisos'),
			type	=>array('column'))
	);

	/* $this -> Campos[tercero_id] = array(
		name	=>'tercero_id',
		id		=>'tercero_id',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(type =>'integer'),
		transaction=>array(
			table	=>array('acuerdos_compromisos'),
			type	=>array('column'))
	); */
	
	
	$this -> Campos[compromiso] = array(
		name	=>'compromiso',
		id      =>'compromiso',
		type	=>'text',
		datatype=>array(type=>'textarea'),
		transaction=>array(
			table	=>array('acuerdos_compromisos'),
			type	=>array('column'))
	);	
	
	
		
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}
$TerceroActa = new TerceroActa();
?>