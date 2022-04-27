<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleCorreos extends Controler{

  public function __construct(){
  
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    	
	require_once("DetalleCorreosLayoutClass.php");
    require_once("DetalleCorreosModelClass.php");
		
	$Layout = new DetalleCorreosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleCorreosModel();	
	
    $Layout -> setIncludes();
    $Layout -> setDetallesCorreos($Model -> getDetallesCorreos($this -> getConex()));	
		
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"ruta",$this ->Campos);
    $this -> getArrayJSON($Data -> GetData());
  }

  protected function onclickSave(){
  
    require_once("DetalleCorreosModelClass.php");
	
    $Model = new DetalleCorreosModel();
	
	
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

    require_once("DetalleCorreosModelClass.php");
	
    $Model = new DetalleCorreosModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	

  }
	  
  protected function onclickDelete(){
  
    require_once("DetalleCorreosModelClass.php");
	
    $Model = new DetalleCorreosModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }


//BUSQUEDA

	
}

$DetalleCorreos = new DetalleCorreos();

?>