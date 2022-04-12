<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetallesSolic extends Controler{

  public function __construct(){
  
	parent::__construct(3);
    
  }


  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesSolicLayoutClass.php");
    require_once("DetallesSolicModelClass.php");
		
	$Layout                 = new DetallesSolicLayout();
    $Model                  = new DetallesSolicModel();	
    $pre_orden_compra_id 		= $_REQUEST['pre_orden_compra_id'];
	
    $Layout -> setIncludes();
    $Layout -> setDetalles($Model -> getDetalles($pre_orden_compra_id,$this -> getConex()));	
		
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),$this ->Campos);
    $this -> getArrayJSON($Data -> GetData());
  }

  protected function onclickSave(){
  
    require_once("DetallesSolicModelClass.php");
	
    $Model = new DetallesSolicModel();
	
    $return = $Model -> Save($this -> getUsuarioId(),$this -> Campos,$this -> getConex());
	
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
    require_once("DetallesSolicModelClass.php");
    $Model = new DetallesSolicModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	

  }
	  
  protected function onclickDelete(){
  
    require_once("DetallesSolicModelClass.php");
	
    $Model = new DetallesSolicModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }

}

$DetallesSolic = new DetallesSolic();

?>