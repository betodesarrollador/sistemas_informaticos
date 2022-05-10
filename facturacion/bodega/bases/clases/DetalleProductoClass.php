<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleProducto extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
    
    $this -> noCache();
    
    require_once("DetalleProductoLayoutClass.php");
    require_once("DetalleProductoModelClass.php");
	
    $Layout = new DetalleProductoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleProductoModel();
	
    $Layout -> setIncludes();

    $Layout -> setDetallesSalarios($Model -> getDetallesSalarios($this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  

 
  
  protected function onclickSaveCosto(){
  
    require_once("DetalleProductoModelClass.php");
	
    $Model = new DetalleProductoModel();

    $return = $Model -> SaveCosto($this -> Campos,$this -> getConex());
	
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

  protected function onclickUpdateCosto(){
  
    require_once("DetalleProductoModelClass.php");
	
    $Model = new DetalleProductoModel();
    $Model -> UpdateCosto($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }

  protected function onclickSaveVenta(){
  
    require_once("DetalleProductoModelClass.php");
	
    $Model = new DetalleProductoModel();

    $return = $Model -> SaveVenta($this -> Campos,$this -> getConex());
	
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

  protected function onclickUpdateVenta(){
  
    require_once("DetalleProductoModelClass.php");
	
    $Model = new DetalleProductoModel();
    $Model -> UpdateVenta($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
  
//CAMPOS
  protected function setCampos(){


	$this -> Campos[detalle_precios_id] = array(
		name	=>'detalle_precios_id',
		id      =>'detalle_precios_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('   wms_detalle_precios       '),
			type	=>array('primary_key'))
	);

	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id      =>'fecha',
		type	=>'text',
		datatype=>array(
			type	=>'date',
			length	=>'11'),
		transaction=>array(
			table	=>array('   wms_detalle_precios       '),
			type	=>array('column'))
	);
	


	$this -> Campos[valor] = array(
		name	=>'valor',
		id      =>'valor',
		required=>'no',
		datatype=>array(type=>'numeric'),
		transaction=>array(
			table	=>array('   wms_detalle_precios       '),
			type	=>array('column'))
	);
	
	

	$this -> Campos[producto_id] = array(
		name	=>'producto_id',
		id      =>'producto_id',
		type	=>'select',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('   wms_detalle_precios       '),
			type	=>array('column'))
	);	
	
			
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}

$DetalleProducto = new DetalleProducto();

?>