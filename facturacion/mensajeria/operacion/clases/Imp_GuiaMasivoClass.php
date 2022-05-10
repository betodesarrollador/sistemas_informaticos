<?php

final class Imp_GuiaMasivo{

  private $Conex;
  private $oficina_id;
  private $usuario;
  
  public function __construct($oficina_id,$Conex,$usuario){  
    $this -> Conex      = $Conex;
	$this -> oficina_id = $oficina_id;
	$this -> usuario    = $usuario;  
  }

  public function printOut($usuario){    	
      require_once("Imp_GuiaMasivoLayoutClass.php");
      require_once("Imp_GuiaMasivoModelClass.php");
		
      $Layout = new Imp_GuiaMasivoLayout();
      $Model  = new Imp_GuiaMasivoModel();		
		
      $Layout -> setGuiaMasivo($Model -> getGuiaMasivo($this -> oficina_id,$this -> Conex,$this -> usuario));	  
      $Layout -> RenderMain();    
  }	
}

new Imp_GuiaMasivo();

?>