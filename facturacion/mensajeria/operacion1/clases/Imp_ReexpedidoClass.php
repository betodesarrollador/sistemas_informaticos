<?php

final class Imp_Reexpedido{

  private $Conex;
  private $oficina_id;
  private $usuario;
  
  public function __construct($Conex){
  
    $this -> Conex      = $Conex;
  
  }

  public function printOut(){
    	
      require_once("Imp_ReexpedidoLayoutClass.php");
      require_once("Imp_ReexpedidoModelClass.php");
		
      $Layout = new Imp_ReexpedidoLayout();
      $Model  = new Imp_ReexpedidoModel();	
	  $reexpedido_id = $_REQUEST['reexpedido_id'];
	
	  $download=$_REQUEST[download];
      $Layout -> setReexpedido($Model -> getReexpedido($this -> oficina_id,$this -> Conex,$this -> usuario),$this -> usuario);	  
	  $Layout -> setDetalle($Model -> getDetalle($this -> oficina_id,$this -> Conex,$this -> usuario),$this -> usuario);
	  $Layout -> setDetalle1($Model -> getDetalle1($this -> oficina_id,$this -> Conex,$this -> usuario),$this -> usuario);	  	  
	  if($download=='SI'){
	      $Layout -> RenderExcel();
	  }else{
	      $Layout -> RenderMain();
	  }
	      
  }
	
}

new Imp_Reexpedido();

?>