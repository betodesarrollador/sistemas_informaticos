<?php


final class Imp_HV_Vehiculo{

  private $Conex;

  public function __construct(){
     
  }


  public function printOut($Conex){  
      	
	require_once("Imp_HV_VehiculoLayoutClass.php");
    require_once("Imp_HV_VehiculoModelClass.php");
		
	$Layout = new Imp_HV_VehiculoLayout();
    $Model  = new Imp_HV_VehiculoModel();		
	
    $Layout -> setIncludes();
	
	$Layout -> setVehiculo    ($Model -> getVehiculo($this -> Conex));
	$Layout -> setTenedor     ($Model -> getTenedor($this -> Conex));
	$Layout -> setPropietario ($Model -> getPropietario($this -> Conex));
	
	$Layout -> RenderMain();
    
  }
	
}

$Imp_HV_Vehiculo = new Imp_HV_Vehiculo();
?>