<?php

final class View_Document{

  private $Conex;
  
  public function __construct(){
    
     
  
  }

  public function printOut($Conex){ $this -> Conex = $Conex;  
    require_once("View_DocumentLayoutClass.php");
    require_once("View_DocumentModelClass.php");
		
    $Layout = new View_DocumentLayout();
    $Model  = new View_DocumentModel();		
    
    $Layout -> setIncludes();
    
	  $encabezado_registro_id = $_REQUEST['encabezado_registro_id'];
    
    $Layout -> setEncabezado($Model -> getEncabezado($encabezado_registro_id,$this -> Conex));	
	  $Layout -> setimputaciones($Model -> getimputaciones($encabezado_registro_id,$this -> Conex));	
	  $Layout -> setTotal($Model -> getTotal($encabezado_registro_id,$this -> Conex));	
	  $Layout -> setTotales($Model -> getTotales($encabezado_registro_id,$this -> Conex));	
  

      $Layout -> RenderMain();
  }

  public function printOut1($encabezado_registro_id,$Conex){  
    	
      require_once("View_DocumentLayoutClass.php");
      require_once("View_DocumentModelClass.php");
		
      $Layout = new View_DocumentLayout();
      $Model  = new View_DocumentModel();		
	
      $Layout -> setIncludes();
	
	 // $encabezado_registro_id = $_REQUEST['encabezado_registro_id'];
	
      $Layout -> setEncabezado($Model -> getEncabezado($encabezado_registro_id,$this -> Conex));	
	  $Layout -> setimputaciones($Model -> getimputaciones($encabezado_registro_id,$this -> Conex));	
	  $Layout -> setTotal($Model -> getTotal($encabezado_registro_id,$this -> Conex));	
	  $Layout -> setTotales($Model -> getTotales($encabezado_registro_id,$this -> Conex));	

      $Layout -> RenderMain();
  }

}

?>