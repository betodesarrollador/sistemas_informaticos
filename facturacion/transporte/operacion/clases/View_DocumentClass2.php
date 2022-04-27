<?php

final class View_Document{

  private $Conex;
  
  public function __construct($Conex){
    
    $this -> Conex = $Conex;
  
  }

  public function printOut(){
    	
      require_once("View_DocumentLayoutClass2.php");
      require_once("View_DocumentModelClass2.php");
		
      $Layout = new View_DocumentLayout();
      $Model  = new View_DocumentModel();		
	
      $Layout -> setIncludes();
	  	
	  $liquidacion_despacho_id = $_REQUEST['liquidacion_despacho_id'];
	
      $Layout -> setEncabezado($Model -> getEncabezado($liquidacion_despacho_id,$this -> Conex));	
	  $Layout -> setimputaciones($Model -> getimputaciones($liquidacion_despacho_id,$this -> Conex));	
	  $Layout -> setTotal($Model -> getTotal($liquidacion_despacho_id,$this -> Conex));	
	  $Layout -> setTotales($Model -> getTotales($liquidacion_despacho_id,$this -> Conex));	

      $Layout -> RenderMain();
  }
}

?>