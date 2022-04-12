<?php

final class Imp_OrdenSeguimiento{

  private $Conex;
  
  public function __construct($Conex){
    
    $this -> Conex = $Conex;
  
  }

  public function printOut(){
    	
      require_once("Imp_OrdenSeguimientoLayoutClass.php");
      require_once("Imp_OrdenSeguimientoModelClass.php");
		
      $Layout = new Imp_OrdenSeguimientoLayout();
      $Model  = new Imp_OrdenSeguimientoModel();		
	
      $Layout -> setIncludes();
	
	  $seguimiento_id = $_REQUEST['seguimiento_id'];
	
      $Layout -> setOrdenSeguimiento($Model -> getOrdenSeguimiento($this -> Conex));	
	  $Layout -> setContactos($Model -> getContactos($this -> Conex));	
      $Layout -> setImpuestos($Model -> getImpuestos($seguimiento_id,$this -> Conex));	  
      $Layout -> RenderMain();
    
  }
	
}

new Imp_OrdenSeguimiento();

?>