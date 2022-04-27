<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Contactos extends Controler{

  public function __construct(){
  
	$this -> setCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    
	require_once("ContactosLayoutClass.php");
    require_once("ContactosModelClass.php");
		
	$Layout = new ContactosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new ContactosModel();	
	
    $Layout -> setIncludes();	
    $Layout -> setEstadosContacto($Model -> getEstadosContacto($this -> getConex()));		
    $Layout -> setContactos($Model -> getContactos($this -> getConex()));	
		
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"cliente",$this ->Campos);
    $this -> getArrayJSON($Data -> GetData());
  }

  protected function onclickSave(){
  
    require_once("ContactosModelClass.php");
	
    $Model = new ContactosModel();
	
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

    require_once("ContactosModelClass.php");
	
    $Model = new ContactosModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	

  }
	  
  protected function onclickDelete(){
  
    require_once("ContactosModelClass.php");
	
    $Model = new ContactosModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }


//BUSQUEDA




//FORMULARIO
  
  protected function setCampos(){
  
	$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id		=>'cliente_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('contacto'),
			type	=>array('column'))
	);
	
	$this -> Campos[contacto_id] = array(
		name	=>'contacto_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('contacto'),
			type	=>array('primary_key'))
	);
		
	$this -> Campos[nombre_contacto] = array(
		name	=>'nombre_contacto',
//		id		=>'nombre_contacto',
		type	=>'text',
		value	=>'',
//		tabindex=>'7',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('contacto'),
			type	=>array('column'))
	);
		
	$this -> Campos[cargo_contacto] = array(
		name	=>'cargo_contacto',
//		id		=>'cargo_contacto',
		type	=>'text',
		value	=>'',
//		tabindex=>'7',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'40'),
		transaction=>array(
			table	=>array('contacto'),
			type	=>array('column'))
	);
		
	$this -> Campos[dir_contacto] = array(
		name	=>'dir_contacto',
//		id		=>'dir_contacto',
		type	=>'text',
		value	=>'',
//		tabindex=>'7',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('contacto'),
			type	=>array('column'))
	);
		
	$this -> Campos[tel_contacto] = array(
		name	=>'tel_contacto',
//		id		=>'tel_contacto',
		type	=>'text',
		value	=>'',
//		tabindex=>'7',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('contacto'),
			type	=>array('column'))
	);
		
	$this -> Campos[cel_contacto] = array(
		name	=>'cel_contacto',
//		id		=>'cel_contacto',
		type	=>'text',
		value	=>'',
//		tabindex=>'7',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('contacto'),
			type	=>array('column'))
	);
		
	$this -> Campos[email_contacto] = array(
		name	=>'email_contacto',
//		id		=>'email_contacto',
		type	=>'text',
		value	=>'',
//		tabindex=>'7',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'40'),
		transaction=>array(
			table	=>array('contacto'),
			type	=>array('column'))
	);
	
	$this -> Campos[estado_contacto] = array(
		name	=>'estado_contacto',
		type	=>'text',
		tabindex=>'5'
	);
		
	$this -> Campos[estado_contacto_id] = array(
		name	=>'estado_contacto_id',
		type	=>'hidden',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('contacto'),
			type	=>array('column'))
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}

$Contactos = new Contactos();

?>