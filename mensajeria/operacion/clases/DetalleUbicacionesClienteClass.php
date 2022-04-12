<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleUbicacionesCliente extends Controler{

  public function __construct(){
	parent::__construct(3);
  }


  public function Main(){
      
    $this -> noCache();
    
    require_once("DetalleUbicacionesClienteLayoutClass.php");
    require_once("DetalleUbicacionesClienteModelClass.php");
	
    $Layout = new DetalleUbicacionesClienteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleUbicacionesClienteModel();

    $cliente_id = $_REQUEST['cliente_id'];
    
    $Layout -> setIncludes();
    $Layout -> setUbicacionesSolicitud($Model -> getUbicacionesSolicitud($this -> getConex()));	
    $Layout -> setDetallesUbicacionesCliente($Model -> getDetallesUbicacionesArchivoCliente($cliente_id,$this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  

  protected function onclickSave(){
  
    require_once("DetalleUbicacionesClienteModelClass.php");
	
    $Model = new DetalleUbicacionesClienteModel();
	
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
  
    require_once("DetalleUbicacionesClienteModelClass.php");
	
    $Model = new DetalleUbicacionesClienteModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("DetalleUbicacionesClienteModelClass.php");
	
    $Model = new DetalleUbicacionesClienteModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }
  
	
}

$DetalleUbicacionesCliente = new DetalleUbicacionesCliente();

?>