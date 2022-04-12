<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetallePuntos extends Controler{

  public function __construct(){  
	parent::__construct(3);    
  }


  public function Main(){
  
    $this -> noCache();
    	
	require_once("DetallePuntosLayoutClass.php");
    require_once("DetallePuntosModelClass.php");
		
	$Layout = new DetallePuntosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetallePuntosModel();	
    $Layout -> setIncludes();
    $Layout -> setDetallesPuntos	 ($Model -> getDetallesPuntos($this -> getConex()));
	$Layout -> ultimoPuntos	 		 ($Model -> getultimoPuntos($this -> getConex()));
	$Layout -> RenderMain();
    
  }


  protected function onclickSave(){
  
    require_once("DetallePuntosModelClass.php");
	
    $Model = new DetallePuntosModel();
	
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

	
}

$DetallePuntos = new DetallePuntos();

?>