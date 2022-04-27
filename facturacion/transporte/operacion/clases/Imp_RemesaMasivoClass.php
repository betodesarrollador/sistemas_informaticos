<?php

final class Imp_RemesaMasivo{

  private $Conex;
  private $oficina_id;
  private $usuario;
  
  public function __construct($oficina_id,$Conex,$usuario){
  
    $this -> Conex      = $Conex;
	$this -> oficina_id = $oficina_id;
	$this -> usuario    = $usuario;
  
  }

  public function printOut($usuario){
    	
      require_once("Imp_RemesaMasivoLayoutClass.php");
      require_once("Imp_RemesaMasivoModelClass.php");
		
      $Layout = new Imp_RemesaMasivoLayout();
      $Model  = new Imp_RemesaMasivoModel();		
		
      $Layout -> setRemesasMasivo($Model -> getRemesasMasivo($this -> oficina_id,$this -> Conex,$this -> usuario));	  
      $Layout -> RenderMain();
    
  }
	
}

new Imp_RemesaMasivo();

?>