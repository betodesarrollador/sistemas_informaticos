<?php

final class Imp_LiquidacionGuias{

  private $Conex;
  
  public function __construct($Conex){
    
    $this -> Conex = $Conex;
  
  }

  public function printOut(){
    	
      require_once("Imp_LiquidacionGuiasLayoutClass.php");
      require_once("Imp_LiquidacionGuiasModelClass.php");
		
      $Layout = new Imp_LiquidacionGuiasLayout();
      $Model  = new Imp_LiquidacionGuiasModel();		
	
      $Layout -> setIncludes();
	  	
	  $liquidacion_guias_cliente_id = $_REQUEST['liquidacion_guias_cliente_id'];
	
      $Layout -> setEncabezado($Model -> getEncabezado($liquidacion_guias_cliente_id,$this -> Conex));	
	  $Layout -> setimputaciones($Model -> getimputaciones($liquidacion_guias_cliente_id,$this -> Conex));	
	  $Layout -> setTotal($Model -> getTotal($liquidacion_guias_cliente_id,$this -> Conex));	

      $Layout -> RenderMain();
  }
}

?>