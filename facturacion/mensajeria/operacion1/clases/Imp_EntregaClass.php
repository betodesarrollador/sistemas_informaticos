<?php

final class Imp_Entrega{

  private $Conex;
  private $oficina_id;
  private $usuario;
  
  public function __construct($Conex){
  
    $this -> Conex      = $Conex;
  
  }

  public function printOut(){
    	
      require_once("Imp_EntregaLayoutClass.php");
      require_once("Imp_EntregaModelClass.php");
		
      $Layout = new Imp_EntregaLayout();
      $Model  = new Imp_EntregaModel();		
	
	
      $Layout -> setEntrega($Model -> getEntrega($this -> oficina_id,$this -> Conex,$this -> usuario),$this -> usuario);	  
	    $Layout -> setDetalle($Model -> getDetalle($this -> oficina_id,$this -> Conex,$this -> usuario),$this -> usuario);	  
      $Layout -> RenderMain();
	      
  }
	
}

new Imp_Entrega();

?>