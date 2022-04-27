<?php

final class Imp_Factura{

  private $Conex;
  
  public function __construct($Conex){
    
    $this -> Conex = $Conex;
  
  }

  public function printOut(){
    	
      require_once("Imp_FacturaLayoutClass.php");
      require_once("Imp_FacturaModelClass.php");
		
      $Layout = new Imp_FacturaLayout();
      $Model  = new Imp_FacturaModel();		
	
      $Layout -> setIncludes();
	
      $Layout -> setFactura($Model -> getFactura($this -> Conex));	
	  $Layout -> setitemFactura($Model -> getitemFactura($this -> Conex));	
	  $Layout -> set_pucFactura($Model -> get_pucFactura($this -> Conex));
	  $Layout -> set_valor_letras($Model -> get_valor_letras($this -> Conex));
	  $Layout -> set_valor_letras_deta($Model -> get_valor_detalles($this -> Conex));
	  $Layout -> setImputacionesContables($Model -> getImputacionesContables($this -> Conex));	
	  

      $Layout -> RenderMain();
    
  }
	
}

new Imp_Factura();

?>