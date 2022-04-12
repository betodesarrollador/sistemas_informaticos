<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleRemesas extends Controler{

  public function __construct(){
  	parent::__construct(3);    
  }


  public function Main(){  
  
    $this -> noCache();
    
    require_once("DetalleRemesasLayoutClass.php");
    require_once("DetalleRemesasModelClass.php");
	
    $Layout = new DetalleRemesasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleRemesasModel();
	
    $Layout -> setIncludes($this -> Campos);
		
    $Layout -> SetNaturaleza	   ($Model -> GetNaturaleza   ($this -> getConex()));
    $Layout -> SetTipoEmpaque	   ($Model -> GetTipoEmpaque  ($this -> getConex()));
    $Layout -> SetUnidadMedida     ($Model -> getUnidades($this -> getConex()));
	
    $Layout -> setDetallesRemesas($Model -> getDetallesRemesas($this -> getConex()));
	
    $Layout -> RenderMain();
    
  }  

  protected function onclickSave(){
    
    require_once("DetalleRemesasModelClass.php");
	
    $Model = new DetalleRemesasModel();
	
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
  
    require_once("DetalleRemesasModelClass.php");
	
    $Model = new DetalleRemesasModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
    
    require_once("DetalleRemesasModelClass.php");
	
    $Model = new DetalleRemesasModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }


//CAMPOS
  protected function setCampos(){

	$this -> Campos[detalle_remesa_id] = array(
		name	=>'detalle_remesa_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('detalle_remesa'),
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
			table	=>array('detalle_remesa'),
			type	=>array('column'))
	);
	/*
	$this -> Campos[referencia_producto] = array(
		name	=>'referencia_producto',
		type	=>'text',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('detalle_remesa'),
			type	=>array('column'))
	);	*/
	
	$this -> Campos[descripcion_producto] = array(
		name	=>'descripcion_producto',
		type	=>'text',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('detalle_remesa'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[naturaleza_id] = array(
		name	=>'naturaleza_id',
		id  	=>'naturaleza_id',		
		type	=>'select',
		options => array(),		
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('detalle_remesa'),
  			type	=>array('column'))
	);	
	
	$this -> Campos[empaque_id] = array(
		name	=>'empaque_id',
		id   	=>'empaque_id',		
		type	=>'select',
		options => array(),		
		datatype=>array(type =>'integer'),
		transaction=>array(
			table	=>array('detalle_remesa'),
  			type	=>array('column'))
	);	
	
	$this -> Campos[medida_id] = array(
		name	=>'medida_id',
		id   	=>'medida_id',		
		type	=>'select',
		options => array(),
		datatype=>array(type =>'integer'),
		transaction=>array(
			table	=>array('detalle_remesa'),
  			type	=>array('column'))
	);		
		
	$this -> Campos[cantidad] = array(
		name	=>'cantidad',
		type	=>'text',
		datatype=>array(
			type	=>'numeric',
			length	=>'15'),
		transaction=>array(
			table	=>array('detalle_remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[peso] = array(
		name	=>'peso',
		type	=>'text',
		datatype=>array(
			type	=>'numeric',
			length	=>'15'),
		transaction=>array(
			table	=>array('detalle_remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[peso_volumen] = array(
		name	=>'peso_volumen',
		type	=>'text',
		datatype=>array(
			type	=>'numeric',
			length	=>'15'),
		transaction=>array(
			table	=>array('detalle_remesa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[valor_unidad] = array(
		name	=>'valor_unidad',
		type	=>'text',
		datatype=>array(
			type	=>'numeric',
			length	=>'15'),
		transaction=>array(
			table	=>array('detalle_remesa'),
			type	=>array('column'))
	);	
		
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}

$DetalleRemesas = new DetalleRemesas();

?>