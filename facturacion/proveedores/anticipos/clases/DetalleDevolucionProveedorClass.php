<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleDevolucionProveedor extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("DetalleDevolucionProveedorLayoutClass.php");
    require_once("DetalleDevolucionProveedorModelClass.php");
	
    $Layout = new DetalleDevolucionProveedorLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleDevolucionProveedorModel();
	
    $Layout -> setIncludes();
	
	$proveedor_id        = $_REQUEST['proveedor_id'];
	
	if(is_numeric($proveedor_id)){
	  $Layout -> setDataPlaca($Model -> getDataplaca($proveedor_id,$this -> getConex()));
	  $Layout -> setRegDataPlaca($Model -> getRegDataplaca($proveedor_id,$this -> getConex()));	  
      $Layout -> setAnticiposPlaca($Model -> getAnticiposPlaca($proveedor_id,$this -> getConex()));		
	  $Layout -> setFormasPago($Model -> getFormasPago($this -> getConex()));	
	  $Layout -> setTipoDoc($Model -> getTipoDoc($this -> getConex()));	
	  $Layout -> setAnticiposPlacaCruce($Model -> getAnticiposPlacaCruce($proveedor_id,$this -> getConex()));	
	  $Layout -> setTiposAnticipo($Model -> getTiposAnticipo($this -> getConex()));	
    }

	
    $Layout -> RenderMain();
    
  }
  

  protected function onclickSave(){
  
    require_once("DetalleDevolucionProveedorModelClass.php");
	
    $Model = new DetalleDevolucionProveedorModel();
	
    $return = $Model -> Save($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
         exit(json_encode($return));
	  }	

  }

  protected function onclickUpdate(){
  
    require_once("DetalleDevolucionProveedorModelClass.php");
	
    $Model = new DetalleDevolucionProveedorModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("DetalleDevolucionProveedorModelClass.php");
	
    $Model = new DetalleDevolucionProveedorModel();
	
    $Model -> Delete($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
         exit("Devolucion Eliminada Exitosamente");
	  }	 

  }

  protected function onclickAnular(){
  
    require_once("DetalleDevolucionProveedorModelClass.php");
	
    $Model = new DetalleDevolucionProveedorModel();
	
    $Model -> Anular($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("Devolucion Anulada Exitosamente");
	  }	 

  }

  protected function setCuentasFormaPago(){
  
    require_once("DetalleDevolucionProveedorModelClass.php");
    require_once("DetalleDevolucionProveedorLayoutClass.php");	
	
    $Model         = new DetalleDevolucionProveedorModel();	
    $Layout        = new DetalleDevolucionProveedorLayout($this -> getTitleTab(),$this -> getTitleForm());	
	$forma_pago_id = $_REQUEST['forma_pago_id'];
    $cuentas       = $Model -> selectCuentasFormasPago($forma_pago_id,$this -> getConex());
	
	if(count($cuentas) > 0){
	  
	  $field['cuenta_tipo_pago_id'] = array(
	    name     => 'cuenta_tipo_pago',
		id       => 'cuenta_tipo_pago_id',
		type     => 'select',
		datatype => array( type => 'integer'),
		options  => $cuentas
	  );
	  
	  
	 print $Layout -> getObjectHtml($field['cuenta_tipo_pago_id']);
	  
	}else{
	    exit("No se han definido cuentas para esta forma de pago!!!");
	  }
  
  }
  
//CAMPOS
  protected function setCampos(){

  }

}

$DetalleDevolucionProveedor = new DetalleDevolucionProveedor();
?>