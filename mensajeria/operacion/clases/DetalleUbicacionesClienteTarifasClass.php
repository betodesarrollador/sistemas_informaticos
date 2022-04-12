<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleUbicacionesClienteTarifas extends Controler{

  public function __construct(){
	parent::__construct(3);
  }


  public function Main(){
      
    $this -> noCache();
    
    require_once("DetalleUbicacionesClienteTarifasLayoutClass.php");
    require_once("DetalleUbicacionesClienteTarifasModelClass.php");
	
    $Layout = new DetalleUbicacionesClienteTarifasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleUbicacionesClienteTarifasModel();

    $cliente_id = $_REQUEST['cliente_id'];

    $Layout -> setIncludes();
    $Layout -> setUbicacionesSolicitud($Model -> getUbicacionesSolicitud($this -> getConex()));	
    $Layout -> setDetallesUbicacionesClienteTarifas($Model -> getDetallesUbicacionesArchivoCliente($cliente_id,$this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  

  protected function onclickSave(){
  
    require_once("DetalleUbicacionesClienteTarifasModelClass.php");
	
    $Model = new DetalleUbicacionesClienteTarifasModel();
	
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
  
    require_once("DetalleUbicacionesClienteTarifasModelClass.php");
	
    $Model = new DetalleUbicacionesClienteTarifasModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("DetalleUbicacionesClienteTarifasModelClass.php");
	
    $Model = new DetalleUbicacionesClienteTarifasModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }
  
	
}

$DetalleUbicacionesClienteTarifas = new DetalleUbicacionesClienteTarifas();

?>