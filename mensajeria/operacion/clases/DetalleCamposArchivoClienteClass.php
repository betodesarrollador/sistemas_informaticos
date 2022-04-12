<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleCamposArchivoCliente extends Controler{

  public function __construct(){
	parent::__construct(3);
  }


  public function Main(){
  
    $this -> noCache();
    
    require_once("DetalleCamposArchivoClienteLayoutClass.php");
    require_once("DetalleCamposArchivoClienteModelClass.php");
	
    $Layout = new DetalleCamposArchivoClienteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleCamposArchivoClienteModel();

    $cliente_id = $_REQUEST['cliente_id'];
    
    $Layout -> setIncludes();
    $Layout -> setCamposSolicitud($Model -> getCamposSolicitud($this -> getConex()));	
    $Layout -> setDetallesCamposArchivoCliente($Model -> getDetallesCamposArchivoCliente($cliente_id,$this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  

  protected function onclickSave(){
  
    require_once("DetalleCamposArchivoClienteModelClass.php");
	
    $Model = new DetalleCamposArchivoClienteModel();
	
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
  
    require_once("DetalleCamposArchivoClienteModelClass.php");
	
    $Model = new DetalleCamposArchivoClienteModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("DetalleCamposArchivoClienteModelClass.php");
	
    $Model = new DetalleCamposArchivoClienteModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }
  
	
}

$DetalleCamposArchivoCliente = new DetalleCamposArchivoCliente();

?>