<?php

final class Imp_HV_Conductor{

  private $Conex;

  public function __construct(){
         
  }

  public function printOut($Conex){  
  	
      require_once("Imp_HV_ConductorLayoutClass.php");
      require_once("Imp_HV_ConductorModelClass.php");
		
      $Layout = new Imp_HV_ConductorLayout();
      $Model  = new Imp_HV_ConductorModel();		
	
      $Layout -> setIncludes();
	
      $Layout -> setConductor($Model -> getConductor($this -> Conex));	
	  
      $Layout -> RenderMain();	  
    
  }
  
	
}

new Imp_HV_Conductor();

?>