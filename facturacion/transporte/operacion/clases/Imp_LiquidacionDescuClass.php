<?php

final class Imp_LiquidacionDescu{

  private $Conex;
  
  public function __construct($Conex){
    
    $this -> Conex = $Conex;
  
  }

  public function printOut(){
    	
      require_once("Imp_LiquidacionDescuLayoutClass.php");
      require_once("Imp_LiquidacionDescuModelClass.php");
		
      $Layout = new Imp_LiquidacionDescuLayout();
      $Model  = new Imp_LiquidacionDescuModel();		
	
      $Layout -> setIncludes();
	  	
	  $liquidacion_despacho_descu_id = $_REQUEST['liquidacion_despacho_descu_id'];
	
      $Layout -> setEncabezado($Model -> getEncabezado($liquidacion_despacho_descu_id,$this -> Conex));	
	  $Layout -> setimputaciones($Model -> getimputaciones($liquidacion_despacho_descu_id,$this -> Conex));	
	  $Layout -> setTotal($Model -> getTotal($liquidacion_despacho_descu_id,$this -> Conex));	

      $Layout -> RenderMain();
  }
}

?>