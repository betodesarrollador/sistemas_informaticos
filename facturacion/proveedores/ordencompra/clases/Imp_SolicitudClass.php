<?php

final class Imp_Solicitud{

  private $Conex;
  
  public function __construct($Conex){
    
    $this -> Conex = $Conex;
  
  }

  public function printOut(){
    	
      require_once("Imp_SolicitudLayoutClass.php");
      require_once("Imp_SolicitudModelClass.php");
		
      $Layout = new Imp_SolicitudLayout();
      $Model  = new Imp_SolicitudModel();		
	
      $Layout -> setIncludes();
	
      $Layout -> setSolicitud($Model -> getSolicitud($this -> Conex));	
	  $Layout -> setitemSolicitud($Model -> getitemSolicitud($this -> Conex));	
	  $Layout -> setliqSolicitud($Model -> getliqSolicitud($this -> Conex));
	  
	  $Layout -> set_num_itemSolicitud($Model -> get_num_itemSolicitud($this -> Conex));	
	  $Layout -> set_num_liqSolicitud($Model -> get_num_liqSolicitud($this -> Conex));

	  $Layout -> set_val_itemSolicitud($Model -> get_val_itemSolicitud($this -> Conex));	
	  $Layout -> set_val_liqSolicitud($Model -> get_val_liqSolicitud($this -> Conex));
	  
	  $Layout -> set_tot_pucCompra($Model -> get_tot_pucCompra($this -> Conex));
	  $Layout -> set_pucCompra($Model -> get_pucCompra($this -> Conex));

      $Layout -> RenderMain();
    
  }
	
}

new Imp_Solicitud();

?>