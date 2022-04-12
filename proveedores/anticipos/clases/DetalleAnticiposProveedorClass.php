<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleAnticiposProveedor extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("DetalleAnticiposProveedorLayoutClass.php");
    require_once("DetalleAnticiposProveedorModelClass.php");
	
    $Layout = new DetalleAnticiposProveedorLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleAnticiposProveedorModel();
	
    $Layout -> setIncludes();
	
	//
	
	$proveedor_id        = $_REQUEST['proveedor_id'];
	
	if(is_numeric($proveedor_id)){
	  $Layout -> setDataPlaca($Model -> getDataplaca($proveedor_id,$this -> getConex()));
	  $Layout -> setRegDataPlaca($Model -> getRegDataplaca($proveedor_id,$this -> getConex()));	  
      $Layout -> setAnticiposProveedor($Model -> getAnticiposProveedor($proveedor_id,$this -> getConex()));		
	  $Layout -> setFormasPago($Model -> getFormasPago($this -> getConex()));	
	  $Layout -> setTiposAnticipo($Model -> getTiposAnticipo($this -> getConex()));	
	 //	 $Layout -> setAnular(1);	
    }

	
    $Layout -> RenderMain();
    
  }
  

  protected function onclickSave(){
  
    require_once("DetalleAnticiposProveedorModelClass.php");
	
    $Model = new DetalleAnticiposProveedorModel();
	
    $return = $Model -> Save($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
         exit(json_encode($return));
	  }	

  }

  protected function onclickUpdate(){
  
    require_once("DetalleAnticiposProveedorModelClass.php");
	
    $Model = new DetalleAnticiposProveedorModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("DetalleAnticiposProveedorModelClass.php");
	
    $Model = new DetalleAnticiposProveedorModel();
	
    $Model -> Delete($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
         exit("Anticipo Eliminado Exitosamente");
	  }	 

  }

  protected function onclickAnular(){
  
    require_once("DetalleAnticiposProveedorModelClass.php");
	
    $Model = new DetalleAnticiposProveedorModel();
	
    $Model -> Anular($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("Anticipo Anulado Exitosamente");
	  }	 

  }

  protected function setCuentasFormaPago(){
  
    require_once("DetalleAnticiposProveedorModelClass.php");
    require_once("DetalleAnticiposProveedorLayoutClass.php");	
	
    $Model         = new DetalleAnticiposProveedorModel();	
    $Layout        = new DetalleAnticiposProveedorLayout($this -> getTitleTab(),$this -> getTitleForm());	
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

$DetalleAnticiposProveedor = new DetalleAnticiposProveedor();
?>