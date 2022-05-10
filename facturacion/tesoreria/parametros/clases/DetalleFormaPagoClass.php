<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleFormaPago extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
    
    $this -> noCache();
    
    require_once("DetalleFormaPagoLayoutClass.php");
    require_once("DetalleFormaPagoModelClass.php");
	
    $Layout = new DetalleFormaPagoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleFormaPagoModel();
	
    $Layout -> setIncludes();

    $Layout -> setBancos($Model -> getBancos($this -> getConex()));	
    $Layout -> setOficinas($Model -> getOficinas($this -> getConex()));		
    $Layout -> setDetallesFormaPago($Model -> getDetallesFormaPago($this -> getConex()));
    $Layout -> RenderMain();
    
  } 

  protected function onclickSave(){  
    require_once("DetalleFormaPagoModelClass.php");	
    $Model = new DetalleFormaPagoModel();	
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
    require_once("DetalleFormaPagoModelClass.php");	
    $Model = new DetalleFormaPagoModel();
	$Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){  
    require_once("DetalleFormaPagoModelClass.php");	
    $Model = new DetalleFormaPagoModel();	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 
  }
  
//CAMPOS
  protected function setCampos(){
	
	$this -> Campos[cuenta_tipo_pago_id] = array(
		name	=>'cuenta_tipo_pago_id',
		id      =>'cuenta_tipo_pago_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('cuenta_tipo_pago'),
			type	=>array('primary_key'))
	);

	$this -> Campos[forma_pago_id] = array(
		name	=>'forma_pago_id',
		id      =>'forma_pago_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('cuenta_tipo_pago'),
			type	=>array('column'))
	);

	$this -> Campos[puc_id] = array(
		name	=>'puc_id',
		id		=>'puc_id',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(type =>'integer'),
		transaction=>array(
			table	=>array('cuenta_tipo_pago'),
			type	=>array('column'))
	);	
	
	$this -> Campos[puc] = array(
		name	=>'puc',
		id      =>'puc',
		type	=>'text',
		datatype=>array(type=>'text')
	);	
	
	$this -> Campos[banco_id] = array(
		name	=>'banco_id',
		id      =>'banco_id',
		type	=>'select',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('cuenta_tipo_pago'),
			type	=>array('column'))
	);	
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id      =>'oficina_id',
		type	=>'select',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('cuenta_tipo_pago'),
			type	=>array('column'))		
	);		
	
	$this -> Campos[cuenta_tipo_pago_natu] = array(
		name	=>'cuenta_tipo_pago_natu',
		id      =>'cuenta_tipo_pago_natu',
		type	=>'text',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('cuenta_tipo_pago'),
			type	=>array('column'))
	);	
		
	$this -> SetVarsValidate($this -> Campos);
  }	
	
}

$DetalleFormaPago = new DetalleFormaPago();

?>