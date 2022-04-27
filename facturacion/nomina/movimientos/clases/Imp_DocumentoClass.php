<?php
final class Imp_Documento{
 private $Conex;
  private $empresa_id;
 public function __construct(){
      
	  
  }
 public function printOut($empresa_id,$Conex){    
  	
      require_once("Imp_DocumentoLayoutClass.php");
      require_once("Imp_DocumentoModelClass.php");
		
      $Layout = new Imp_DocumentoLayout();
      $Model  = new Imp_DocumentoModel();		
	
      $Layout -> setIncludes();
	
      $Layout -> setdocumento($Model -> getdocumento($this -> getEmpresaId,$this -> Conex));
	  
      $Layout -> RenderMain();	  
    
  }   
  
	
}

new Imp_Documento();

?>