<?php

require_once("../../../framework/clases/ControlerClass.php");

final class ParamDetImpresion extends Controler{

  public function __construct(){
  
	parent::__construct(3);
    
  }


  public function Main(){
	    
    $this -> noCache();
    	
	require_once("ParamDetImpresionLayoutClass.php");
    require_once("ParamDetImpresionModelClass.php");
		
	$Layout                 		= new ParamDetImpresionLayout();
    $Model                  		= new ParamDetImpresionModel();	
    $tipo_bien_servicio_factura_id 	= $_REQUEST['tipo_bien_servicio_factura_id'];
	
    $Layout -> setIncludes();
    $Layout -> setParamDetImpresion($Model -> getParamDetImpresion($tipo_bien_servicio_factura_id,$this -> getConex()));	
		
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),$this ->Campos);
    echo json_encode($Data -> GetData());
  }

  protected function onclickSave(){
  
    require_once("ParamDetImpresionModelClass.php");
	
    $Model = new ParamDetImpresionModel();
	
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
    require_once("ParamDetImpresionModelClass.php");
    $Model = new ParamDetImpresionModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	

  }
	  
  protected function onclickDelete(){
  
    require_once("ParamDetImpresionModelClass.php");
	
    $Model = new ParamDetImpresionModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }

  protected function onclickActivar(){
  
    require_once("ParamDetImpresionModelClass.php");
	
    $Model = new ParamDetImpresionModel();
	
    $Model -> activar($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }

}

$ParamDetImpresion = new ParamDetImpresion();

?>