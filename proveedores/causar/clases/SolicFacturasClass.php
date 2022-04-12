<?php

require_once("../../../framework/clases/ControlerClass.php");

final class SolicFacturas extends Controler{

  public function __construct(){
  
	$this -> SetCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
   	
	require_once("SolicFacturasLayoutClass.php");
    require_once("SolicFacturasModelClass.php");
	
	$Layout = new SolicFacturasLayout();
    $Model  = new SolicFacturasModel();
    $proveedor_id 	= $_REQUEST['proveedor_id'];
	
    $Layout -> setIncludes();
    $Layout -> SetSolicFacturas($Model -> getSolicFacturas($proveedor_id,$this -> getConex()));
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

$SolicFacturas = new SolicFacturas();

?>