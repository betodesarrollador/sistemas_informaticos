<?php

final class Imp_AutorizaPago{

  private $Conex;
  
  public function __construct($Conex){
    
    $this -> Conex = $Conex;
  
  }

  public function printOut(){
    	
      require_once("Imp_AutorizaPagoLayoutClass.php");
      require_once("Imp_AutorizaPagoModelClass.php");
		
      $Layout = new Imp_AutorizaPagoLayout();
      $Model  = new Imp_AutorizaPagoModel();		
	
      $Layout -> setIncludes();
	
      $Layout -> setOrdenCompra($Model -> getOrdenCompra($this -> Conex));	

      $Layout -> RenderMain();
    
  }
	
}

new Imp_AutorizaPago();

?>