<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleDespachosUrbanos extends Controler{

  public function __construct(){  
  	parent::__construct(3);    
  }


  public function Main(){
  
    $this -> noCache();
    
	require_once("DetalleDespachosUrbanosLayoutClass.php");
	require_once("DetalleDespachosUrbanosModelClass.php");
	
	$Layout = new DetalleDespachosUrbanosLayout($this -> getTitleTab(),$this -> getTitleForm());
	$Model  = new DetalleDespachosUrbanosModel();
	
    $Layout -> setIncludes();
	
    $Layout -> setDetallesDespacho($Model -> getDetallesDespacho($this -> getConex()));
	
	$Layout -> RenderMain();
    
  }
  
	  
  protected function deleteDetalleDespacho(){
  
    require_once("DetalleDespachosUrbanosModelClass.php");
	
    $Model = new DetalleDespachosUrbanosModel();
	
    $Model -> deleteDetalleDespacho($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        print 'true';
	  }	 

  }
	
}

$DetalleDespachosUrbanos = new DetalleDespachosUrbanos();

?>