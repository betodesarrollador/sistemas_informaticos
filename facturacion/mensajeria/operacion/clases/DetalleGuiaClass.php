<?php
require_once("../../../framework/clases/ControlerClass.php");

final class DetalleGuia extends Controler{

  public function __construct(){
  	parent::__construct(3);    
  }

  public function Main(){  
  
    $this -> noCache();
    
    require_once("DetalleGuiaLayoutClass.php");
    require_once("DetalleGuiaModelClass.php");
	
    $Layout = new DetalleGuiaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleGuiaModel();
	
    $Layout -> setIncludes($this -> Campos);
		
    $Layout -> setDetallesGuia     ($Model -> getDetallesGuia ($this -> getConex()));	
    $Layout -> RenderMain();    
  }  

  protected function onclickSave(){    
    require_once("DetalleGuiaModelClass.php");	
    $Model = new DetalleGuiaModel();	
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
    require_once("DetalleGuiaModelClass.php");	
    $Model = new DetalleGuiaModel();	
    $Model -> Update($this -> Campos,$this -> getConex());	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){    
    require_once("DetalleGuiaModelClass.php");	
    $Model = new DetalleGuiaModel();	
    $Model -> Delete($this -> Campos,$this -> getConex());	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 
  }
  
//CAMPOS
  protected function setCampos(){

	$this -> Campos[detalle_guia_id] = array(
		name	=>'detalle_guia_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('detalle_guia'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[detalle_ss_id] = array(
		name	=>'detalle_ss_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('detalle_guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[referencia_producto] = array(
		name	=>'referencia_producto',
		type	=>'text',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('detalle_guia'),
			type	=>array('column'))
	);	
	
	$this -> Campos[descripcion_producto] = array(
		name	=>'descripcion_producto',
		type	=>'text',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('detalle_guia'),
			type	=>array('column'))
	);	
		
	$this -> Campos[cantidad] = array(
		name	=>'cantidad',
		type	=>'text',
		datatype=>array(
			type	=>'numeric',
			length	=>'15'),
		transaction=>array(
			table	=>array('detalle_guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[peso] = array(
		name	=>'peso',
		type	=>'text',
		datatype=>array(
			type	=>'numeric',
			length	=>'15'),
		transaction=>array(
			table	=>array('detalle_guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[peso_volumen] = array(
		name	=>'peso_volumen',
		type	=>'text',
		datatype=>array(
			type	=>'numeric',
			length	=>'15'),
		transaction=>array(
			table	=>array('detalle_guia'),
			type	=>array('column'))
	);	
	
	$this -> Campos[valor] = array(
		name	=>'valor',
		type	=>'text',
		datatype=>array(
			type	=>'numeric',
			length	=>'15'),
		transaction=>array(
			table	=>array('detalle_guia'),
			type	=>array('column'))
	);	
		
	$this -> SetVarsValidate($this -> Campos);
  }	
}

$DetalleGuia = new DetalleGuia();

?>