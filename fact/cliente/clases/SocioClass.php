<?php
require_once("../../../framework/clases/ControlerClass.php");
final class Socio extends Controler{

  public function __construct(){
  
	parent::__construct(3);
    
  }

  public function Main(){
	    
    $this -> noCache();
    	
	require_once("SocioLayoutClass.php");
    require_once("SocioModelClass.php");
		
	$Layout                 = new SocioLayout();
    $Model                  = new SocioModel();	
    $tercero_id 			= $_REQUEST['tercero_id'];
	$empresa_id 			= $this -> getEmpresaId(); 
	$oficina_id 			= $this -> getOficinaId();	

    $Layout -> setIncludes();
    $Layout -> setSocios($Model -> getSocios($tercero_id,$empresa_id,$oficina_id,$this -> getConex()));	
	$Layout -> RenderMain();
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),$this ->Campos);
    print json_encode($Data -> GetData());
  }

  protected function onclickSave(){
  
    require_once("SocioModelClass.php");
    $Model = new SocioModel();
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

    require_once("SocioModelClass.php");
    $Model = new SocioModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	}	

  }
  protected function onclickDelete(){
  
    require_once("SocioModelClass.php");
	
    $Model = new SocioModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }
  

}

$Socio = new Socio();

?>