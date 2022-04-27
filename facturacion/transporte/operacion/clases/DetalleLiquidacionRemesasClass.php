<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleLiquidacionRemesas extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
    
    $this -> noCache();
    
    require_once("DetalleLiquidacionRemesasLayoutClass.php");
    require_once("DetalleLiquidacionRemesasModelClass.php");
	
    $Layout = new DetalleLiquidacionRemesasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleLiquidacionRemesasModel();
	
    $Layout -> setIncludes();
	
    $Layout -> setDetallesDespacho($Model -> getDetallesDespacho($this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  
  protected function onclickUpdate(){
    
    require_once("DetalleLiquidacionRemesasModelClass.php");
	
    $Model = new DetalleLiquidacionRemesasModel();
	
    $remesa_id      = $this -> requestData('remesa_id');
    $valor_facturar = $this -> requestData('valor_facturar');
	
    $Model -> Update($remesa_id,$valor_facturar,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	
}

new DetalleLiquidacionRemesas();

?>