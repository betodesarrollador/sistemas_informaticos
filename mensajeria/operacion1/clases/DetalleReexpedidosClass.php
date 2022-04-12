<?php
require_once("../../../framework/clases/ControlerClass.php");

final class DetalleReexpedidos extends Controler{

  public function __construct(){  
  	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("DetalleReexpedidosLayoutClass.php");
	require_once("DetalleReexpedidosModelClass.php");
	
	$Layout = new DetalleReexpedidosLayout($this -> getTitleTab(),$this -> getTitleForm());
	$Model  = new DetalleReexpedidosModel();
	
    $Layout -> setIncludes();	
    $Layout -> setDetallesReexpedido($Model -> getDetallesReexpedido($this -> getConex()));	
	$Layout -> RenderMain();
    
  }  
  
	  
  protected function deleteDetalleReexpedido(){  
  
    require_once("DetalleReexpedidosModelClass.php");	
    $Model = new DetalleReexpedidosModel();	
    $Model -> deleteDetalleReexpedido($this -> Campos,$this -> getConex());	
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        print 'true';
	  }	 
   }	
   
  protected function setCampos(){
  
  	$this -> Campos[doc_prov_rxp] = array(
		name	=>'doc_prov_rxp',
		id      =>'doc_prov_rxp',
		type	=>'text',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);		

	$this -> Campos[valor_prov_rxp] = array(
		name	=>'valor_prov_rxp',
		id		=>'valor_prov_rxp',
		type	=>'text',
		required=>'yes',
		datatype=>array(type =>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	
  $this -> SetVarsValidate($this -> Campos);
  
  }   
   
}

$DetalleReexpedidos = new DetalleReexpedidos();

?>