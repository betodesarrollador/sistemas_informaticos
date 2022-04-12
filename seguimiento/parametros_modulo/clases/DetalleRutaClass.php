<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleRuta extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }


  public function Main(){
  
    $this -> noCache();
    	
	require_once("DetalleRutaLayoutClass.php");
    require_once("DetalleRutaModelClass.php");
		
	$Layout = new DetalleRutaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleRutaModel();	
	
    $Layout -> setIncludes();
    $Layout -> setDetallesRuta($Model -> getDetallesRuta($this -> getConex()));	
		
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"ruta",$this ->Campos);
    $this -> getArrayJSON($Data -> GetData());
  }

  protected function onclickSave(){
  
    require_once("DetalleRutaModelClass.php");
	
    $Model = new DetalleRutaModel();
	
	
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

    require_once("DetalleRutaModelClass.php");
	
    $Model = new DetalleRutaModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	

  }
	  
  protected function onclickDelete(){
  
    require_once("DetalleRutaModelClass.php");
	
    $Model = new DetalleRutaModel();
	
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
  
	$this -> Campos[ruta_id] = array(
		name	=>'ruta_id',
		id		=>'ruta_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('detalle_ruta'),
			type	=>array('column'))
	);
	
	$this -> Campos[detalle_ruta_id] = array(
		name	=>'detalle_ruta_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('detalle_ruta'),
			type	=>array('primary_key'))
	);

	$this -> Campos[orden_det_ruta] = array(
		name	=>'orden_det_ruta',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('detalle_ruta'),
			type	=>array('column'))
	);
	
	$this -> Campos[ubicacion] = array(
		name	=>'ubicacion',
		type	=>'text',
		tabindex=>'5',
		suggest=>array(
			name	=>'ubicacion_punto',
			setId	=>'ubicacion_id')
	);

	$this -> Campos[ubicacion_id] = array(
		name	=>'ubicacion_id',
		type	=>'hidden',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('detalle_ruta'),
			type	=>array('column'))
	);

	$this -> Campos[punto_referencia_id] = array(
		name	=>'punto_referencia_id',
		type	=>'hidden',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('detalle_ruta'),
			type	=>array('column'))
	);
		
	$this -> Campos[distancia_det_ruta] = array(
		name	=>'distancia_det_ruta',
		type	=>'text',
		value	=>'',
		tabindex=>'6',
	    datatype=>array(
			type	=>'numeric',
			length	=>'18'),
		transaction=>array(
			table	=>array('detalle_ruta'),
			type	=>array('column'))
	);
	
	$this -> Campos[tiempo_det_ruta] = array(
		name	=>'tiempo_det_ruta',
		type	=>'text',
		value	=>'',
		tabindex=>'7',
	    datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('detalle_ruta'),
			type	=>array('column'))
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}

$DetalleRuta = new DetalleRuta();

?>