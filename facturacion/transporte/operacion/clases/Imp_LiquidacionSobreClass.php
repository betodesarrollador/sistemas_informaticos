<?php

final class Imp_LiquidacionSobre{

  private $Conex;
  
  public function __construct($Conex){
    
    $this -> Conex = $Conex;
  
  }

  public function printOut(){
    	
      require_once("Imp_LiquidacionSobreLayoutClass.php");
      require_once("Imp_LiquidacionSobreModelClass.php");
		
      $Layout = new Imp_LiquidacionSobreLayout();
      $Model  = new Imp_LiquidacionSobreModel();		
	
      $Layout -> setIncludes();
	  	
	  $liquidacion_despacho_sobre_id = $_REQUEST['liquidacion_despacho_sobre_id'];
	
      $Layout -> setEncabezado($Model -> getEncabezado($liquidacion_despacho_sobre_id,$this -> Conex));	
	  $Layout -> setimputaciones($Model -> getimputaciones($liquidacion_despacho_sobre_id,$this -> Conex));	
	  $Layout -> setTotal($Model -> getTotal($liquidacion_despacho_sobre_id,$this -> Conex));	

      $Layout -> RenderMain();
  }
}

?>