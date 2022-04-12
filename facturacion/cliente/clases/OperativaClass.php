<?php
require_once("../../../framework/clases/ControlerClass.php");
final class Operativa extends Controler{

  public function __construct(){
  
	parent::__construct(3);
    
  }

  public function Main(){
	    
    $this -> noCache();
    	
	require_once("OperativaLayoutClass.php");
    require_once("OperativaModelClass.php");
		
	$Layout                 = new OperativaLayout();
    $Model                  = new OperativaModel();	
    $tercero_id 			= $_REQUEST['tercero_id'];
	$empresa_id 			= $this -> getEmpresaId(); 
	$oficina_id 			= $this -> getOficinaId();	

    $Layout -> setIncludes();
    $Layout -> setOper($Model -> getOper($tercero_id,$empresa_id,$oficina_id,$this -> getConex()));	
	$Layout -> RenderMain();
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),$this ->Campos);
    print json_encode($Data -> GetData());
  }

  protected function onclickSave(){
  
    require_once("OperativaModelClass.php");
    $Model = new OperativaModel();
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

    require_once("OperativaModelClass.php");
    $Model = new OperativaModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	}	

  }
  protected function onclickDelete(){
  
    require_once("OperativaModelClass.php");
	
    $Model = new OperativaModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }
  

}

$Operativa = new Operativa();

?>