<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleUnidadesVolumenCliente extends Controler{

  public function __construct(){
	parent::__construct(3);
  }


  public function Main(){
  
    $this -> noCache();
    
    require_once("DetalleUnidadesVolumenLayoutClass.php");
    require_once("DetalleUnidadesVolumenModelClass.php");
	
    $Layout = new DetalleUnidadesVolumenClienteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleUnidadesVolumenClienteModel();

    $cliente_id = $_REQUEST['cliente_id'];
    
    $Layout -> setIncludes();
    $Layout -> setCamposSolicitud($Model -> getCamposSolicitud($this -> getConex()));	
    $Layout -> setDetallesCamposArchivoCliente($Model -> getDetallesCamposArchivoCliente($cliente_id,$this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  

  protected function onclickSave(){
  
    require_once("DetalleUnidadesVolumenModelClass.php");
	
    $Model = new DetalleUnidadesVolumenClienteModel();
	
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
  
    require_once("DetalleUnidadesVolumenModelClass.php");
	
    $Model = new DetalleUnidadesVolumenClienteModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("DetalleUnidadesVolumenModelClass.php");
	
    $Model = new DetalleUnidadesVolumenClienteModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }
  
	
}

$DetalleUnidadesVolumenCliente = new DetalleUnidadesVolumenCliente();

?>