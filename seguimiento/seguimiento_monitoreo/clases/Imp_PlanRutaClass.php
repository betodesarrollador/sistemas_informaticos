<?php


final class Imp_PlanRuta{

  private $Conex;
  
  public function __construct(){
    
     
  
  }


  public function printOut($Conex){  


	require_once("Imp_PlanRutaLayoutClass.php");
    require_once("Imp_PlanRutaModelClass.php");
		
	$Layout = new Imp_PlanRutaLayout();
    $Model  = new Imp_PlanRutaModel();		
	
    $Layout -> setIncludes();
	
	$Layout -> setTrafico($Model -> getTrafico($this -> Conex));
	$Layout -> setDetalles($Model -> getDetalles($this -> Conex));
	
	$Layout -> RenderMain();
    
  }
	
}

new Imp_PlanRuta();
?>