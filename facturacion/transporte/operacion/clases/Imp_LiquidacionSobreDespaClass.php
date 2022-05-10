<?php

final class Imp_LiquidacionSobreDespa{

  private $Conex;
  
  public function __construct($Conex){
    
    $this -> Conex = $Conex;
  
  }

  public function printOut(){
    	
      require_once("Imp_LiquidacionSobreDespaLayoutClass.php");
      require_once("Imp_LiquidacionSobreDespaModelClass.php");
		
      $Layout = new Imp_LiquidacionSobreDespaLayout();
      $Model  = new Imp_LiquidacionSobreDespaModel();		
	
      $Layout -> setIncludes();
	  	
	  $liquidacion_despacho_sobre_id = $_REQUEST['liquidacion_despacho_sobre_id'];
	
      $Layout -> setEncabezado($Model -> getEncabezado($liquidacion_despacho_sobre_id,$this -> Conex));	
	  $Layout -> setimputaciones($Model -> getimputaciones($liquidacion_despacho_sobre_id,$this -> Conex));	
	  $Layout -> setTotal($Model -> getTotal($liquidacion_despacho_sobre_id,$this -> Conex));	

      $Layout -> RenderMain();
  }
}

?>