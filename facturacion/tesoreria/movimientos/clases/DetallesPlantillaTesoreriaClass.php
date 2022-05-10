<?php
require_once("../../../framework/clases/ControlerClass.php");

final class DetallesPlantillaTesoreria extends Controler{

  public function __construct(){  
	parent::__construct(3);    
  }

  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesPlantillaTesoreriaLayoutClass.php");
    require_once("DetallesPlantillaTesoreriaModelClass.php");
		
	$Layout                 = new DetallesPlantillaTesoreriaLayout();
    $Model                  = new DetallesPlantillaTesoreriaModel();	
    $plantilla_tesoreria_id 	= $_REQUEST['plantilla_tesoreria_id'];
	
	$empresa_id 			= $this -> getEmpresaId(); 
	$oficina_id 			= $this -> getOficinaId();	
	
    $Layout -> setIncludes();
    $Layout -> setImputacionesContables($Model -> getImputacionesContables($plantilla_tesoreria_id,$empresa_id,$oficina_id,$this -> getConex()));	
    $Layout -> setTipo($Model -> getTipo($plantilla_tesoreria_id,$this -> getConex()));			
	$Layout -> RenderMain();    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),$this ->Campos);
    $this -> getArrayJSON($Data -> GetData());
  }

  protected function onclickSave(){  
    require_once("DetallesPlantillaTesoreriaModelClass.php");
    $Model = new DetallesPlantillaTesoreriaModel();
    $return = $Model -> Save($this -> getUsuarioId(),$this -> getEmpresaId(),$this -> getOficinaId(),$this -> Campos,$this -> getConex());
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
    require_once("DetallesPlantillaTesoreriaModelClass.php");
    $Model = new DetallesPlantillaTesoreriaModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	
  }

  protected function onclickUpdates(){
    require_once("DetallesPlantillaTesoreriaModelClass.php");
    $Model = new DetallesPlantillaTesoreriaModel();
    $Model -> Updates($this -> getEmpresaId(),$this -> getOficinaId(),$this -> Campos,$this -> getConex());
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	
  }

 protected function onclickDelete(){  
    require_once("DetallesPlantillaTesoreriaModelClass.php");	
    $Model = new DetallesPlantillaTesoreriaModel();
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 
  }

  protected function getRequieresCuenta(){
    require_once("DetallesPlantillaTesoreriaModelClass.php");	
    $Model                 		 = new DetallesPlantillaTesoreriaModel();
    $puc_id                		 = $_REQUEST['puc_id'];
    $plantilla_tesoreria_id 	 = $_REQUEST['plantilla_tesoreria_id'];	
	$data 						 = $Model -> selectCuentaPuc($puc_id,$plantilla_tesoreria_id,$this -> getConex());	
	$this -> getArrayJSON($data);		  
  }
  
  protected function getvalorCalculadoBase(){	  
    require_once("DetallesPlantillaTesoreriaModelClass.php");	
    $Model = new DetallesPlantillaTesoreriaModel();	
    $puc_id                 		= $_REQUEST['puc_id'];
    $plantilla_tesoreria_id 		= $_REQUEST['plantilla_tesoreria_id'];
    $base_plantilla_tesoreria		= $_REQUEST['base_plantilla_tesoreria'];	
	$data							= $Model -> selectImpuesto($puc_id,$base_plantilla_tesoreria,$plantilla_tesoreria_id,$this -> getConex());	
	print json_encode($data);	  
  }
}

new DetallesPlantillaTesoreria();

?>