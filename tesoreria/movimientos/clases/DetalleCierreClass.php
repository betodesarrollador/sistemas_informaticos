<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleCierre extends Controler{

  public function __construct(){  
  	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("DetalleCierreLayoutClass.php");
	require_once("DetalleCierreModelClass.php");
	
	$Layout = new DetalleCierreLayout($this -> getTitleTab(),$this -> getTitleForm());
	$Model  = new DetalleCierreModel();
	
    $Layout -> setIncludes();
	
    $Layout -> setDetallesManifiesto($Model -> getDetallesManifiesto($this -> getConex()));
	
	$Layout -> RenderMain();
    
  }  
	  
  protected function deleteDetalleManifiesto(){
  
    require_once("DetalleCierreModelClass.php");
	
    $Model = new DetalleCierreModel();
	
    $Model -> deleteDetalleManifiesto($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        print 'true';
	  }	 

  }

	
	
	
}

$DetalleCierre = new DetalleCierre();

?>