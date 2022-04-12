<?php
final class Imp_Novedad{
 private $Conex;
  private $empresa_id;
 public function __construct(){
      
	  
  }
 public function printOut($empresa_id,$Conex){    
  	
      require_once("Imp_NovedadLayoutClass.php");
      require_once("Imp_NovedadModelClass.php");
		
      $Layout = new Imp_NovedadLayout();
      $Model  = new Imp_NovedadModel();		
	
      $Layout -> setIncludes();
	
      $Layout -> setNovedad($Model -> getdocumento($this -> getEmpresaId,$this -> Conex));
	  $Layout -> setDetallesNovedad($Model -> getDetallesNovedad($this -> Conex));
	  
      $Layout -> RenderMain();	  
    
  }   
  
	
}

new Imp_Novedad();

?>