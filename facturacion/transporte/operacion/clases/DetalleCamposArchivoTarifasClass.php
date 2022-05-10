<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleCamposArchivoTarifas extends Controler{

  public function __construct(){
	parent::__construct(3);
  }


  public function Main(){
  
    $this -> noCache();
    
    require_once("DetalleCamposArchivoTarifasLayoutClass.php");
    require_once("DetalleCamposArchivoTarifasModelClass.php");
	
    $Layout = new DetalleCamposArchivoTarifasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleCamposArchivoTarifasModel();

    $cliente_id = $_REQUEST['cliente_id'];
    
    $Layout -> setIncludes();
    $Layout -> setCamposSolicitud($Model -> getCamposSolicitud($this -> getConex()));	
    $Layout -> setDetallesCamposArchivoTarifas($Model -> getDetallesCamposArchivoTarifas($cliente_id,$this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  

  protected function onclickSave(){
  
    require_once("DetalleCamposArchivoTarifasModelClass.php");
	
    $Model = new DetalleCamposArchivoTarifasModel();
	
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
  
    require_once("DetalleCamposArchivoTarifasModelClass.php");
	
    $Model = new DetalleCamposArchivoTarifasModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("DetalleCamposArchivoTarifasModelClass.php");
	
    $Model = new DetalleCamposArchivoTarifasModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }
  
	
}

$DetalleCamposArchivoTarifas = new DetalleCamposArchivoTarifas();

?>