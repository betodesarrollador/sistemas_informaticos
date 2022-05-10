<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleSolicitudLotes extends Controler{

  public function __construct(){
  
	$this -> setCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    	
	require_once("DetalleSolicitudLotesLayoutClass.php");
    require_once("DetalleSolicitudLotesModelClass.php");
		
	$Layout = new DetalleSolicitudLotesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleSolicitudLotesModel();	
	
    $Layout -> setIncludes();
    $Layout -> setDetalleSolicitudLotes	($Model -> getDetalleSolicitudLotes($this -> getConex()));	
    $Layout -> setAutoSugerente			($Model -> getAutoSugerente($this -> getConex()));	
		
	$Layout -> RenderMain();
    
  }

  protected function onclickSave(){
    require_once("DetalleSolicitudLotesModelClass.php");
    $Model = new DetalleSolicitudLotesModel();
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
    require_once("DetalleSolicitudLotesModelClass.php");
    $Model = new DetalleSolicitudLotesModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
  
  protected function onclickDelete(){
    require_once("DetalleSolicitudLotesModelClass.php");
    $Model = new DetalleSolicitudLotesModel();
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
	$this -> Campos[relacion_archivo_det_solicitud_id] = array(
		name	=>'relacion_archivo_det_solicitud_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('relacion_archivo_detalle_solicitud'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[campo_archivo_solicitud_id] = array(
		name	=>'campo_archivo_solicitud_id',
		id		=>'campo_archivo_solicitud_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('relacion_archivo_detalle_solicitud'),
			type	=>array('column'))
	);
		
	$this -> Campos[valor_foranea_id] = array(
		name	=>'valor_foranea_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'text',
			length	=>'30'),
		transaction=>array(
			table	=>array('relacion_archivo_detalle_solicitud'),
			type	=>array('column'))
	);
		
	$this -> Campos[valor_foranea] = array(
		name	=>'valor_foranea',
		type	=>'hidden',
		datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('relacion_archivo_detalle_solicitud'),
			type	=>array('column'))
	);
		
	$this -> Campos[valor_archivo] = array(
		name	=>'valor_archivo',
		type	=>'hidden',
		datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('relacion_archivo_detalle_solicitud'),
			type	=>array('column'))
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}

$DetalleSolicitudLotes = new DetalleSolicitudLotes();

?>