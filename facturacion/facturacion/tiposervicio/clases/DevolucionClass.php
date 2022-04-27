<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Devolucion extends Controler{

  public function __construct(){
  
	parent::__construct(3);
    
  }


  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DevolucionLayoutClass.php");
    require_once("DevolucionModelClass.php");
		
	$Layout                 = new DevolucionLayout();
    $Model                  = new DevolucionModel();	
    $tipo_bien_servicio_factura_id = $_REQUEST['tipo_bien_servicio_factura_id'];
	
    $Layout -> setIncludes();
    $Layout -> setDevolucion($Model -> getDevolucion($tipo_bien_servicio_factura_id,$this -> getConex()));	
		
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),$this ->Campos);
    echo json_encode($Data -> GetData());
  }

  protected function onclickSave(){
  
    require_once("DevolucionModelClass.php");
	
    $Model = new DevolucionModel();
	
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
    require_once("DevolucionModelClass.php");
    $Model = new DevolucionModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	

  }
	  
  protected function onclickDelete(){
  
    require_once("DevolucionModelClass.php");
	
    $Model = new DevolucionModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }


    protected function onclickActivar(){
   
     require_once("DevolucionModelClass.php");
   
     $Model = new DevolucionModel();
   
     $Model -> activar($this -> Campos,$this -> getConex());
   
   if(strlen(trim($Model -> GetError())) > 0){
     exit("Error : ".$Model -> GetError());
   }else{
         exit("true");
     }	 
  
   }

}

$Devolucion = new Devolucion();

?>