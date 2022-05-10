<?php

final class Imp_DTA{

  private $Conex;
  private $empresa_id;
  
  public function __construct(){    
    $this -> Conex      = $Conex;  
	 
  }

  public function printOut($Conex,$empresa_id){   $this -> empresa_id = $empresa_id
    	
      require_once("Imp_DTALayoutClass.php");
      require_once("Imp_DTAModelClass.php");
		
      $Layout = new Imp_DTALayout();
      $Model  = new Imp_DTAModel();
	  $dta_id = $_REQUEST['dta_id'];
	  	
      $Layout -> setIncludes();	 
	  
      $Layout -> setDTA($Model -> getDTA($dta_id,$this -> empresa_id,$this -> Conex));	
      $Layout -> RenderMain();
    
  }
	
}


?>