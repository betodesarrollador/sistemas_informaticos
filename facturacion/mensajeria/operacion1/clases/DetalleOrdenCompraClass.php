<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleOrdenCompra extends Controler{

  public function __construct(){
  
	$this -> setCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    	
	require_once("DetalleOrdenCompraLayoutClass.php");
    require_once("DetalleOrdenCompraModelClass.php");
		
	$Layout = new DetalleOrdenCompraLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleOrdenCompraModel();	
	
    $Layout -> setIncludes();
    $Layout -> setDetalleOrdenCompra($Model -> getDetalleOrdenCompra($this -> getConex()));	
		
	$Layout -> RenderMain();
    
  }

  protected function onclickSave(){
    require_once("DetalleOrdenCompraModelClass.php");
    $Model = new DetalleOrdenCompraModel();
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
    require_once("DetalleOrdenCompraModelClass.php");
    $Model = new DetalleOrdenCompraModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
  
  protected function onclickDelete(){
    require_once("DetalleOrdenCompraModelClass.php");
    $Model = new DetalleOrdenCompraModel();
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
	$this -> Campos[detalle_ordenconexo_id] = array(
		name	=>'detalle_ordenconexo_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('detalle_ordenconexo'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[ordencompra_id] = array(
		name	=>'ordencompra_id',
		id		=>'ordencompra_id',
		type	=>'text',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('detalle_ordenconexo'),
			type	=>array('column'))
	);
		
	$this -> Campos[remesa_id] = array(
		name	=>'remesa_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('detalle_ordenconexo'),
			type	=>array('column'))
	);
		
	$this -> Campos[origen_id] = array(
		name	=>'origen_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('detalle_ordenconexo'),
			type	=>array('column'))
	);
		
	$this -> Campos[destino_id] = array(
		name	=>'destino_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('detalle_ordenconexo'),
			type	=>array('column'))
	);
		
	$this -> Campos[observaciones] = array(
		name	=>'observaciones',
		type	=>'text',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('detalle_ordenconexo'),
			type	=>array('column'))
	);
		
	$this -> Campos[costo_ordenconexo] = array(
		name	=>'costo_ordenconexo',
		type	=>'text',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('detalle_ordenconexo'),
			type	=>array('column'))
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}

$DetalleOrdenCompra = new DetalleOrdenCompra();

?>