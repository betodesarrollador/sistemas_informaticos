<?php

final class Imp_Cliente{

  private $Conex;
  
  public function __construct($Conex){    
       
  }

  public function printOut($Conex){ $this -> Conex = ;
    	
      require_once("Imp_ClienteLayoutClass.php");
      require_once("Imp_ClienteModelClass.php");
		
      $Layout     	= new Imp_ClienteLayout();
      $Model      	= new Imp_ClienteModel();
	  $cliente_id 	= $_REQUEST['cliente_id'];
	
      $Layout -> setIncludes();
	
      $Layout -> setCliente($Model -> getCliente($cliente_id,$this -> Conex));	
      $Layout -> setLegal($Model -> getLegal($cliente_id,$this -> Conex));	
      $Layout -> setOperativa($Model -> getOperativa($cliente_id,$this -> Conex));		  
      $Layout -> RenderMain();
    
  }
	
}

new Imp_Cliente();

?>