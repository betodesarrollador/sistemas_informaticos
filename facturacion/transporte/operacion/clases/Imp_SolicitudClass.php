<?php

final class Imp_Solicitud{

  private $Conex;
  
  public function __construct($Conex){
    
    $this -> Conex = $Conex;
  
  }

  public function printOut(){
	  
	
    	
      require_once("Imp_SolicitudLayoutClass.php");
      require_once("Imp_SolicitudModelClass.php");
		
      $Layout = new Imp_SolicitudLayout();
      $Model  = new Imp_SolicitudModel();		
	
      $Layout -> setIncludes();
	
      $Layout -> setOrdenCargue($Model -> getOrdenCargue($this -> Conex));	
      $Layout -> RenderMain();
    
  }
	
}

new Imp_Solicitud();

?>