<?php

final class Imp_OrdenCargue{

  private $Conex;
  
  public function __construct($Conex){
    
    $this -> Conex = $Conex;
  
  }

  public function printOut(){
    	
      require_once("Imp_OrdenCargueLayoutClass.php");
      require_once("Imp_OrdenCargueModelClass.php");
		
      $Layout = new Imp_OrdenCargueLayout();
      $Model  = new Imp_OrdenCargueModel();		
	
      $Layout -> setIncludes();
	
      $Layout -> setOrdenCargue($Model -> getOrdenCargue($this -> Conex));	
      $Layout -> RenderMain();
    
  }
	
}

new Imp_OrdenCargue();

?>