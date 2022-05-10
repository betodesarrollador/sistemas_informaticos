<?php

require_once("../../../framework/clases/ControlerClass.php");

final class TerceroFormaPago extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
    
    $this -> noCache();
    
    require_once("TerceroFormaPagoLayoutClass.php");
    require_once("TerceroFormaPagoModelClass.php");
	
    $Layout = new TerceroFormaPagoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new TerceroFormaPagoModel();
	
    $Layout -> setIncludes();

    $Layout -> setTercerosFormaPago($Model -> getTercerosFormaPago($this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  

  protected function onclickSave(){
  
    require_once("TerceroFormaPagoModelClass.php");
	
    $Model = new TerceroFormaPagoModel();
	
    $return = $Model -> Save($this -> Campos,$this -> getConex());
	
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
  
    require_once("TerceroFormaPagoModelClass.php");
	
    $Model = new TerceroFormaPagoModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("TerceroFormaPagoModelClass.php");
	
    $Model = new TerceroFormaPagoModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }
  
//CAMPOS
  protected function setCampos(){

	
	$this -> Campos[forma_pago_tercero_id] = array(
		name	=>'forma_pago_tercero_id',
		id      =>'forma_pago_tercero_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('forma_pago_tercero'),
			type	=>array('primary_key'))
	);

	$this -> Campos[forma_pago_id] = array(
		name	=>'forma_pago_id',
		id      =>'forma_pago_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('forma_pago_tercero'),
			type	=>array('column'))
	);


	$this -> Campos[tercero_id] = array(
		name	=>'tercero_id',
		id		=>'tercero_id',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(type =>'integer'),
		transaction=>array(
			table	=>array('forma_pago_tercero'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[tercero] = array(
		name	=>'tercero',
		id      =>'tercero',
		type	=>'text',
		datatype=>array(type=>'text')
	);	
	
	
		
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}

$TerceroFormaPago = new TerceroFormaPago();

?>