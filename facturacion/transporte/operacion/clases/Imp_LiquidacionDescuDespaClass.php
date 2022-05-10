<?php

final class Imp_LiquidacionDescuDespa{

  private $Conex;
  
  public function __construct($Conex){
    
    $this -> Conex = $Conex;
  
  }

  public function printOut(){
    	
      require_once("Imp_LiquidacionDescuDespaLayoutClass.php");
      require_once("Imp_LiquidacionDescuDespaModelClass.php");
		
      $Layout = new Imp_LiquidacionDescuDespaLayout();
      $Model  = new Imp_LiquidacionDescuDespaModel();		
	
      $Layout -> setIncludes();
	  	
	  $liquidacion_despacho_descu_id = $_REQUEST['liquidacion_despacho_descu_id'];
	
      $Layout -> setEncabezado($Model -> getEncabezado($liquidacion_despacho_descu_id,$this -> Conex));	
	  $Layout -> setimputaciones($Model -> getimputaciones($liquidacion_despacho_descu_id,$this -> Conex));	
	  $Layout -> setTotal($Model -> getTotal($liquidacion_despacho_descu_id,$this -> Conex));	

      $Layout -> RenderMain();
  }
}

?>