<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_HV_VehiculoLayout extends View{

   private $fields;

   
   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../transporte/bases/css/Imp_HV_Vehiculo.css");
	 
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css","print");
     $this -> TplInclude -> IncludeCss("../../../transporte/bases/css/Imp_HV_Vehiculo.css","print");	 
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 
   }
  
   
   public function setVehiculo($vehiculo){

	 $this -> assign("DATOSVEHICULO",$vehiculo[0]);
	 
   }
  
   
   public function setTenedor($tenedor){
   
	 $this -> assign("DATOSTENEDOR", $tenedor[0]);
	 
   }
  
   
   public function setPropietario($propietario){
   
	 $this -> assign("DATOSPROPIETARIO", $propietario[0]);
	 
   }


   public function RenderMain(){

      //$this -> exportToPdf('Imp_HV_Vehiculo.tpl');

      $this -> RenderLayout('Imp_HV_Vehiculo.tpl');

   }


}

?>