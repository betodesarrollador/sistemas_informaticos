<?php

final class Imp_Contratos{

  private $Conex;
  private $empresa_id;

  public function __construct(){
      
	  
  }

  public function printOut($empresa_id,$Conex){    
  	
      require_once("Imp_ContratosLayoutClass.php");
      require_once("Imp_ContratosModelClass.php");
		
      $Layout = new Imp_ContratosLayout();
      $Model  = new Imp_ContratosModel();		
	
      $Layout -> setIncludes();
	
      $Layout -> setcontrato($Model -> getcontrato($this -> getEmpresaId,$this -> Conex));
	  
      $Layout -> RenderMain();	  
    
  }   
  
	
}

new Imp_Contratos();

?>