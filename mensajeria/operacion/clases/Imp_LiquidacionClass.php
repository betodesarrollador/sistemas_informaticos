<?php

final class Imp_Liquidacion{

  private $Conex;
  
  public function __construct($Conex){
    
    $this -> Conex = $Conex;
  
  }

  public function printOut(){
    	
      require_once("Imp_LiquidacionLayoutClass.php");
      require_once("Imp_LiquidacionModelClass.php");
		
      $Layout = new Imp_LiquidacionLayout();
      $Model  = new Imp_LiquidacionModel();		
	
      $Layout -> setIncludes();
	  	
	  $liquidacion_despacho_id = $_REQUEST['liquidacion_despacho_id'];
	
      $Layout -> setEncabezado($Model -> getEncabezado($liquidacion_despacho_id,$this -> Conex));	
	  $Layout -> setimputaciones($Model -> getimputaciones($liquidacion_despacho_id,$this -> Conex));	
	  $Layout -> setTotal($Model -> getTotal($liquidacion_despacho_id,$this -> Conex));	

      $Layout -> RenderMain();
  }
}

?>