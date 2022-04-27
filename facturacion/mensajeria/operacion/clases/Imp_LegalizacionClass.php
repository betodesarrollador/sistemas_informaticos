<?php

final class Imp_Legalizacion{

  private $Conex;
  
  public function __construct($Conex){
    
    $this -> Conex = $Conex;
  
  }

  public function printOut(){
    	
      require_once("Imp_LegalizacionLayoutClass.php");
      require_once("Imp_LegalizacionModelClass.php");
		
      $Layout = new Imp_LegalizacionLayout();
      $Model  = new Imp_LegalizacionModel();		
	
      $Layout -> setIncludes();
	
	  $encabezado_registro_id = $_REQUEST['encabezado_registro_id'];
	
      $Layout -> setEncabezado($Model -> getEncabezado($encabezado_registro_id,$this -> Conex));	
	  $Layout -> setimputaciones($Model -> getimputaciones($encabezado_registro_id,$this -> Conex));	
	  $Layout -> setTotal($Model -> getTotal($encabezado_registro_id,$this -> Conex));	
	  $Layout -> setTotales($Model -> getTotales($encabezado_registro_id,$this -> Conex));	

      $Layout -> RenderMain();
  }
}
new Imp_Legalizacion();

?>