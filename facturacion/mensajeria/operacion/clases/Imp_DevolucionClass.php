<?php

final class Imp_Devolucion{

  private $Conex;
  private $oficina_id;
  private $usuario;
  
  public function __construct($Conex){
  
    $this -> Conex      = $Conex;
  
  }

  public function printOut(){
    	
      require_once("Imp_DevolucionLayoutClass.php");
      require_once("Imp_DevolucionModelClass.php");
		
      $Layout = new Imp_DevolucionLayout();
      $Model  = new Imp_DevolucionModel();		
	
	
      $Layout -> setDevolucion($Model -> getDevolucion($this -> oficina_id,$this -> Conex,$this -> usuario),$this -> usuario);	  
	  $Layout -> setDetalle($Model -> getDetalle($this -> oficina_id,$this -> Conex,$this -> usuario),$this -> usuario);	  
      $Layout -> RenderMain();
	      
  }
	
}

new Imp_Devolucion();

?>