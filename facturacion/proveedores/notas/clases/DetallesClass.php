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
		
	$Layout                 	= new DetallesLayout();
    $Model                  	= new DetallesModel();	
    $abono_factura_proveedor_id = $_REQUEST['abono_factura_proveedor_id'];
	$estado_abono_factura 		= $_REQUEST['estado_abono_factura'];
	
	$empresa_id 				= $this -> getEmpresaId();
	$oficina_id 				= $this -> getOficinaId();	
	
    $Layout -> setIncludes();
    $Layout -> setImputacionesContables($Model -> getImputacionesContables($abono_factura_proveedor_id,$empresa_id,$oficina_id,$this -> getConex()));	
		
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),$this ->Campos);
    print json_encode($Data -> GetData());
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
	  
  protected function getRequieresCuenta(){

    require_once("DetallesModelClass.php");
	
    $Model                  	= new DetallesModel();
    $puc_id                 	= $_REQUEST['puc_id'];
    $abono_factura_proveedor_id = $_REQUEST['abono_factura_proveedor_id'];
	
	$data = $Model -> selectCuentaPuc($puc_id,$abono_factura_proveedor_id,$this -> getConex());
	
	print json_encode($data);
		  
  }
  
  protected function getvalorCalculadoBase(){
	  
    require_once("DetallesModelClass.php");
	
    $Model = new DetallesModel();
	
    $puc_id                 = $_REQUEST['puc_id'];
    $abono_factura_proveedor_id 		= $_REQUEST['abono_factura_proveedor_id'];
    $base_abono		= $_REQUEST['base_abono_factura'];
	
	$empresa_id 				= $this -> getEmpresaId();
	$oficina_id 				= $this -> getOficinaId();	
	
	
	$data = $Model -> selectImpuesto($puc_id,$base_abono,$abono_factura_proveedor_id,$oficina_id,$empresa_id,$this -> getConex());
	
	print json_encode($data);
	  
  }

}

$Detalles = new Detalles();

?>