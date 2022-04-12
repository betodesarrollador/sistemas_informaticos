<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Detalles extends Controler{

  public function __construct(){  
	parent::__construct(3);    
  }

  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesCausacionLayoutClass.php");
    require_once("DetallesCausacionModelClass.php");
		
	$Layout                 = new DetallesLayout();
    $Model                  = new DetallesModel();	
    $factura_proveedor_id 	= $_REQUEST['factura_proveedor_id'];
	
	$empresa_id 			= $this -> getEmpresaId(); 
	$oficina_id 			= $this -> getOficinaId();	
	
    $Layout -> setIncludes();
    $Layout -> setImputacionesContables($Model -> getImputacionesContables($factura_proveedor_id,$empresa_id,$oficina_id,$this -> getConex()));	
    $Layout -> setTipo($Model -> getTipo($factura_proveedor_id,$this -> getConex()));	
		
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),$this ->Campos);
    $this -> getArrayJSON($Data -> GetData());
  }

  protected function onclickSave(){
  
    require_once("DetallesCausacionModelClass.php");
    $Model = new DetallesModel();
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

    require_once("DetallesCausacionModelClass.php");
    $Model = new DetallesModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	
  }

  protected function onclickUpdates(){

    require_once("DetallesCausacionModelClass.php");
    $Model = new DetallesModel();
    $Model -> Updates($this -> getEmpresaId(),$this -> getOficinaId(),$this -> Campos,$this -> getConex());
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	
  }

  protected function getRequieresCuenta(){

    require_once("DetallesCausacionModelClass.php");
	
    $Model                  = new DetallesModel();
    $puc_id                 = $_REQUEST['puc_id'];
    $factura_proveedor_id 	= $_REQUEST['factura_proveedor_id'];
	
	$data = $Model -> selectCuentaPuc($puc_id,$factura_proveedor_id,$this -> getConex());
	
	$this -> getArrayJSON($data);
		  
  }
  
  protected function getvalorCalculadoBase(){
	  
    require_once("DetallesCausacionModelClass.php");
	
    $Model = new DetallesModel();
	
    $puc_id                 	= $_REQUEST['puc_id'];
    $factura_proveedor_id 		= $_REQUEST['factura_proveedor_id'];
    $base_factura_proveedor		= $_REQUEST['base_factura_proveedor'];
	
	$data = $Model -> selectImpuesto($puc_id,$base_factura_proveedor,$factura_proveedor_id,$this -> getConex());
	
	print json_encode($data);
	  
  }

}

new Detalles();

?>