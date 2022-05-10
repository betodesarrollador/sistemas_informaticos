<?php

final class Imp_OrdenSeguimiento{

  private $Conex;
  
  public function __construct(){
    
     
  
  }

  public function printOut($Conex){  
    	
      require_once("Imp_OrdenSeguimientoLayoutClass.php");
      require_once("Imp_OrdenSeguimientoModelClass.php");
		
      $Layout = new Imp_OrdenSeguimientoLayout();
      $Model  = new Imp_OrdenSeguimientoModel();		
	
      $Layout -> setIncludes();
	
      $Layout -> setOrdenSeguimiento($Model -> getOrdenSeguimiento($this -> Conex));	
	  $Layout -> setContactos($Model -> getContactos($this -> Conex));	
      $Layout -> RenderMain();
    
  }
	
}

new Imp_OrdenSeguimiento();

?>