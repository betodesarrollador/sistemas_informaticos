<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Productos extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("ProductosLayoutClass.php");
    require_once("ProductosModelClass.php");
	
    $Layout = new ProductosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new ProductosModel();
	
    $Layout -> setIncludes();
    $Layout -> setProductos($Model -> getProductos($this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  

  protected function onclickSave(){
  
    require_once("ProductosModelClass.php");
	
    $Model = new ProductosModel();
	
    $return = $Model -> Save($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
         print 'true';
	  }	

  }

  protected function onclickUpdate(){
  
    require_once("ProductosModelClass.php");
	
    $Model = new ProductosModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("ProductosModelClass.php");
	
    $Model = new ProductosModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }
  

//CAMPOS
  protected function setCampos(){
  
  
  }
	
	
	
}

$Productos = new Productos();

?>