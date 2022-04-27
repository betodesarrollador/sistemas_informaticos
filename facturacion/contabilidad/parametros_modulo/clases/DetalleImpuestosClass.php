<?php
require_once("../../../framework/clases/ControlerClass.php");
final class DetalleImpuestos extends Controler{
  public function __construct(){
	parent::__construct(3);
  }
  public function Main(){
  
    $this -> noCache();
    
    require_once("DetalleImpuestosLayoutClass.php");
    require_once("DetalleImpuestosModelClass.php");
	
    $Layout = new DetalleImpuestosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleImpuestosModel();
	
    $Layout -> setIncludes();
	
    $Layout -> setPeriodosContables($Model -> getPeriodosContables($this -> getConex()));		
    $Layout -> setDetallesImpuesto($Model -> getDetallesImpuesto($this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  
  protected function onclickSave(){
  
    require_once("DetalleImpuestosModelClass.php");
	
    $Model = new DetalleImpuestosModel();
	
    $return = $Model -> Save($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        if(is_numeric($return)){
		  exit("$return");
		}else{
		    exit('false');
		  }
	  }	
  }
  protected function onclickUpdate(){
  
    require_once("DetalleImpuestosModelClass.php");
	
    $Model = new DetalleImpuestosModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("DetalleImpuestosModelClass.php");
	
    $Model = new DetalleImpuestosModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 
  }
  
//CAMPOS
  protected function setCampos(){
	
	$this -> Campos[impuesto_periodo_contable_id] = array(
		name	=>'impuesto_periodo_contable_id',
		id      =>'impuesto_periodo_contable_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('impuesto_periodo_contable'),
			type	=>array('primary_key'))
	);
	$this -> Campos[impuesto_id] = array(
		name	=>'impuesto_id',
		id      =>'impuesto_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('impuesto_periodo_contable'),
			type	=>array('column'))
	);

	$this -> Campos[periodo_contable_id] = array(
		name	=>'periodo_contable_id',
		id		=>'periodo_contable_id',
		type	=>'select',
		options =>array(),
		required=>'yes',
		datatype=>array(type =>'integer'),
		transaction=>array(
			table	=>array('impuesto_periodo_contable'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[porcentaje] = array(
		name	=>'porcentaje',
		id      =>'porcentaje',
		type	=>'text',
		datatype=>array(type=>'numeric'),
		transaction=>array(
			table	=>array('impuesto_periodo_contable'),
			type	=>array('column'))
	);	
	
	$this -> Campos[formula] = array(
		name	=>'formula',
		id      =>'formula',
		type	=>'text',
		datatype=>array(type=>'numeric'),
		transaction=>array(
			table	=>array('impuesto_periodo_contable'),
			type	=>array('column'))
	);	
	
	$this -> Campos[monto] = array(
		name	=>'monto',
		id      =>'monto',
		type	=>'text',
		datatype=>array(type=>'numeric'),
		transaction=>array(
			table	=>array('impuesto_periodo_contable'),
			type	=>array('column'))
	);	
	
		
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}
$DetalleImpuestos = new DetalleImpuestos();
?>