<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Detalles extends Controler{

  public function __construct(){
  
	parent::__construct(3);
    
  }


  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesLayoutClass.php");
    require_once("DetallesModelClass.php");
		
	$Layout                 = new DetallesLayout();
    $Model                  = new DetallesModel();	
    $tipo_bien_servicio_id = $_REQUEST['tipo_bien_servicio_id'];
	
    $Layout -> setIncludes();
    $Layout -> setDetalles($Model -> getDetalles($tipo_bien_servicio_id,$this -> getConex()));	
		
	$Layout -> RenderMain();
    
  }
  
   protected function getRequieresCuenta(){

    require_once("DetallesModelClass.php");
	
    $Model                  = new DetallesModel();
    $puc_id                 = $_REQUEST['puc_id'];
    
	$data = $Model -> selectCuentaPuc($puc_id,$this -> getConex());
	
	$this -> getArrayJSON($data);
		  
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),$this ->Campos);
    echo json_encode($Data -> GetData());
  }

  protected function onclickSave(){
  
    require_once("DetallesModelClass.php");
	
    $Model = new DetallesModel();
	
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
    require_once("DetallesModelClass.php");
    $Model = new DetallesModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	

  }
	  
  protected function onclickDelete(){
  
    require_once("DetallesModelClass.php");
	
    $Model = new DetallesModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }

}

$Detalles = new Detalles();

?>