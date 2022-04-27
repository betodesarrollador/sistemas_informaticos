<?php

final class Imp_Reenvio{

  private $Conex;
  private $oficina_id;
  private $usuario;
  
  public function __construct($Conex){
  
    $this -> Conex      = $Conex;
  
  }

  public function printOut(){
    	
      require_once("Imp_ReenvioLayoutClass.php");
      require_once("Imp_ReenvioModelClass.php");
		
      $Layout = new Imp_ReenvioLayout();
      $Model  = new Imp_ReenvioModel();		
	
	
      $Layout -> setReenvio($Model -> getReenvio($this -> oficina_id,$this -> Conex,$this -> usuario),$this -> usuario);	  
	  $Layout -> setDetalle($Model -> getDetalle($this -> oficina_id,$this -> Conex,$this -> usuario),$this -> usuario);	  
      $Layout -> RenderMain();
	      
  }
	
}

new Imp_Reenvio();

?>