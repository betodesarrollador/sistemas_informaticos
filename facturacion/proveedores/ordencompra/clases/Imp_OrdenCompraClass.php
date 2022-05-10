<?php

final class Imp_OrdenCompra{

  private $Conex;
  
  public function __construct(){
    
     
  
  }

  public function printOut($Conex){  
    	
      require_once("Imp_OrdenCompraLayoutClass.php");
      require_once("Imp_OrdenCompraModelClass.php");
		
      $Layout = new Imp_OrdenCompraLayout();
      $Model  = new Imp_OrdenCompraModel();		
	
      $Layout -> setIncludes();
	
      $Layout -> setOrdenCompra($Model -> getOrdenCompra($this -> Conex));	
	  $Layout -> setitemOrdenCompra($Model -> getitemOrdenCompra($this -> Conex));	
	  $Layout -> setliqOrdenCompra($Model -> getliqOrdenCompra($this -> Conex));
	  
	  $Layout -> set_num_itemOrdenCompra($Model -> get_num_itemOrdenCompra($this -> Conex));	
	  $Layout -> set_num_liqOrdenCompra($Model -> get_num_liqOrdenCompra($this -> Conex));

	  $Layout -> set_val_itemOrdenCompra($Model -> get_val_itemOrdenCompra($this -> Conex));	
	  $Layout -> set_val_liqOrdenCompra($Model -> get_val_liqOrdenCompra($this -> Conex));
	  
	  $Layout -> set_tot_pucCompra($Model -> get_tot_pucCompra($this -> Conex));
	  $Layout -> set_pucCompra($Model -> get_pucCompra($this -> Conex));

      $Layout -> RenderMain();
    
  }
	
}

new Imp_OrdenCompra();

?>