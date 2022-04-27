<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleDevolucioness extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("DetalleDevolucionessLayoutClass.php");
    require_once("DetalleDevolucionessModelClass.php");
	
    $Layout = new DetalleDevolucionessLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleDevolucionessModel();
	
    $Layout -> setIncludes();
	
	$manifiesto_id        = $_REQUEST['manifiesto_id'];
	$despachos_urbanos_id = $_REQUEST['despachos_urbanos_id'];
	
	if(is_numeric($manifiesto_id)){ 
		$Layout -> setDataManifiesto($Model -> getDataManifiesto($manifiesto_id,$this -> getConex()));
		$Layout -> setRegDataMan($Model -> getRegDataMan($manifiesto_id,$this -> getConex()));	
		$Layout -> setAnticipos($Model -> getAnticipos($manifiesto_id,$this -> getConex()));		
		$Layout -> setFormasPago($Model -> getFormasPago($this -> getConex()));
		$Layout -> setAnticiposCruce($Model -> getAnticiposCruce($manifiesto_id,$this -> getConex()));	
		$Layout -> assign("TIPOREG",'MC');
	}else{
	    $Layout -> setDataDespacho($Model -> getDataDespacho($despachos_urbanos_id,$this -> getConex()));	
	    $Layout -> setRegDataDes($Model -> getRegDataDes($despachos_urbanos_id,$this -> getConex()));	
        $Layout -> setAnticiposDespacho($Model -> getAnticiposDespacho($despachos_urbanos_id,$this -> getConex()));		
	    $Layout -> setFormasPago($Model -> getFormasPago($this -> getConex()));	
		$Layout -> setAnticiposDespachoCruce($Model -> getAnticiposDespachoCruce($despachos_urbanos_id,$this -> getConex()));	
		$Layout -> assign("TIPOREG",'DU');		
		
	}

	$Layout -> setTipoDoc($Model -> getTipoDoc($this -> getConex()));		
    $Layout -> RenderMain();
    
  }
  

  protected function onclickSave(){
  
    require_once("DetalleDevolucionessModelClass.php");
	
    $Model = new DetalleDevolucionessModel();
	
    $return = $Model -> Save($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
         exit(json_encode($return));
	  }	

  }

  protected function onclickUpdate(){
  
    require_once("DetalleDevolucionessModelClass.php");
	
    $Model = new DetalleDevolucionessModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("DetalleDevolucionessModelClass.php");
	
    $Model = new DetalleDevolucionessModel();
	
    $Model -> Delete($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
         exit("Devolucion Eliminada Exitosamente");
	  }	 

  }

  protected function onclickAnular(){
  
    require_once("DetalleDevolucionessModelClass.php");
	
    $Model = new DetalleDevolucionessModel();
	
    $Model -> Anular($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("Devolucion Anulada Exitosamente");
	  }	 

  }
  
  protected function setCuentasFormaPago(){
  
    require_once("DetalleDevolucionessModelClass.php");
    require_once("DetalleDevolucionessLayoutClass.php");	
	
    $Model         = new DetalleDevolucionessModel();	
    $Layout        = new DetalleDevolucionessLayout($this -> getTitleTab(),$this -> getTitleForm());	
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

$DetalleDevolucioness = new DetalleDevolucioness();
?>