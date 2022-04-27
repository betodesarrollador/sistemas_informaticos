<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleManifiestos extends Controler{

  public function __construct(){  
  	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("DetalleManifiestosLayoutClass.php");
	require_once("DetalleManifiestosModelClass.php");
	
	$Layout = new DetalleManifiestosLayout($this -> getTitleTab(),$this -> getTitleForm());
	$Model  = new DetalleManifiestosModel();
	
    $Layout -> setIncludes();
	
    $Layout -> setDetallesManifiesto($Model -> getDetallesManifiesto($this -> getConex()));
	
	$Layout -> RenderMain();
    
  }  
	  
  protected function deleteDetalleManifiesto(){
  
    require_once("DetalleManifiestosModelClass.php");
	
    $Model = new DetalleManifiestosModel();
	
    $Model -> deleteDetalleManifiesto($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        print 'true';
	  }	 

  }

	
	
	
}

$DetalleManifiestos = new DetalleManifiestos();

?>