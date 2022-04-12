<?php
require_once("../../../framework/clases/ControlerClass.php");
final class DetalleActa extends Controler{
  public function __construct(){
	parent::__construct(3);
  }
  public function Main(){
    
    $this -> noCache();
    
    require_once("DetalleActaLayoutClass.php");
    require_once("DetalleActaModelClass.php");
	
    $Layout = new DetalleActaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleActaModel();
	
    $Layout -> setIncludes();
    // $Layout -> setBancos($Model -> getBancos($this -> getConex()));	
    $Layout -> setDetallesActa($Model -> getDetallesActa($this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  
  protected function onclickSave(){
  
    require_once("DetalleActaModelClass.php");
	
    $Model = new DetalleActaModel();
	
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
  
    require_once("DetalleActaModelClass.php");
	
    $Model = new DetalleActaModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("DetalleActaModelClass.php");
	
    $Model = new DetalleActaModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 
  }
  
//CAMPOS
  protected function setCampos(){
	
	$this -> Campos[tema_id] = array(
		name	=>'tema_id',
		id      =>'tema_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('temas_tratados'),
			type	=>array('primary_key'))
	);
	$this -> Campos[acta_id] = array(
		name	=>'acta_id',
		id      =>'acta_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('temas_tratados'),
			type	=>array('column'))
	);
	
	$this -> Campos[tema] = array(
		name	=>'tema',
		id      =>'tema',
		type	=>'text',
		datatype=>array(type=>'textarea'),
		transaction=>array(
			table	=>array('temas_tratados'),
			type	=>array('column'))
	);	

	/* $this -> Campos[puc_id] = array(
		name	=>'puc_id',
		id		=>'puc_id',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(type =>'integer'),
		transaction=>array(
			table	=>array('temas_tratados'),
			type	=>array('column'))
	); */
	
	/* $this -> Campos[banco_id] = array(
		name	=>'banco_id',
		id      =>'banco_id',
		type	=>'select',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('temas_tratados'),
			type	=>array('column'))
	); */	
	
	/* $this -> Campos[cuenta_tipo_pago_natu] = array(
		name	=>'cuenta_tipo_pago_natu',
		id      =>'cuenta_tipo_pago_natu',
		type	=>'text',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('temas_tratados'),
			type	=>array('column'))
	);	 */
	
		
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}
$DetalleActa = new DetalleActa();
?>