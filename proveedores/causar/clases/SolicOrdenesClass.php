<?php

require_once("../../../framework/clases/ControlerClass.php");

final class SolicOrdenes extends Controler{

  public function __construct(){
  
	$this -> SetCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
   	
	require_once("SolicOrdenesLayoutClass.php");
    require_once("SolicOrdenesModelClass.php");
	
	$Layout = new SolicOrdenesLayout();
    $Model  = new SolicOrdenesModel();
    $proveedor_id 	= $_REQUEST['proveedor_id'];
	
    $Layout -> setIncludes();
    $Layout -> SetSolicOrdenes($Model -> getSolicOrdenes($proveedor_id,$this -> getConex()));
	$Layout -> SetCampos($this -> Campos);
    $Layout -> RenderMain();
    
  }
  

  protected function SetCampos(){
		
	//botones
	$this -> Campos[adicionar] = array(
		name	=>'adicionar',
		id		=>'adicionar',
		type	=>'button',
		value=>'ADICIONAR'
	);
	
		
	$this -> SetVarsValidate($this -> Campos);
  }

}

$SolicOrdenes = new SolicOrdenes();

?>