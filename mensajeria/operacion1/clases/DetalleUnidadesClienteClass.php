<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleUnidadesCliente extends Controler{

  public function __construct(){
	parent::__construct(3);
  }


  public function Main(){
  
    $this -> noCache();
    
    require_once("DetalleUnidadesClienteLayoutClass.php");
    require_once("DetalleUnidadesClienteModelClass.php");
	
    $Layout = new DetalleUnidadesClienteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleUnidadesClienteModel();

    $cliente_id = $_REQUEST['cliente_id'];
    
    $Layout -> setIncludes();
    $Layout -> setCamposSolicitud($Model -> getCamposSolicitud($this -> getConex()));	
    $Layout -> setDetallesCamposArchivoCliente($Model -> getDetallesCamposArchivoCliente($cliente_id,$this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
    
	
}

$DetalleUnidadesCliente = new DetalleUnidadesCliente();

?>