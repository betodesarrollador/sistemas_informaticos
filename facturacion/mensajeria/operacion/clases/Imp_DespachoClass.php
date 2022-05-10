<?php

final class Imp_Despacho{

  private $Conex;
  
  public function __construct($Conex){    
    $this -> Conex = $Conex;  
  }

  public function printOut(){
    	
      require_once("Imp_DespachoLayoutClass.php");
      require_once("Imp_DespachoModelClass.php");
		
      $Layout        		= new Imp_DespachoLayout();
      $Model         		= new Imp_DespachoModel();
	  $despachos_urbanos_id 	= $_REQUEST['despachos_urbanos_id'];
	
      $Layout -> setIncludes();
	
      $Layout -> setDespacho($Model -> getDespacho($despachos_urbanos_id,$this -> Conex));	
      $Layout -> setRemesas($Model -> getRemesas($despachos_urbanos_id,$this -> Conex));	
      $Layout -> setImpuestos($Model -> getImpuestos($despachos_urbanos_id,$this -> Conex));		  
      $Layout -> RenderMain();
    
  }
	
}

new Imp_Despacho();

?>