<?php
require_once("../../../framework/clases/ControlerClass.php");
final class DetalleDocumento extends Controler{
  public function __construct(){
	parent::__construct(3);
  }
  public function Main(){
    
    $this -> noCache();
    
    require_once("DetalleDocumentoLayoutClass.php");
    require_once("DetalleDocumentoModelClass.php");
	
    $Layout = new DetalleDocumentoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleDocumentoModel();
	
    $Layout -> setIncludes();
    $Layout -> setOficinas($Model -> getOficinas($this -> getConex()));	
    $Layout -> setDetallesDocumento($Model -> getDetallesDocumento($this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  
  protected function onclickSave(){
  
    require_once("DetalleDocumentoModelClass.php");
	
    $Model = new DetalleDocumentoModel();
	
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
  
    require_once("DetalleDocumentoModelClass.php");
	
    $Model = new DetalleDocumentoModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("DetalleDocumentoModelClass.php");
	
    $Model = new DetalleDocumentoModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 
  }
  
//CAMPOS
  protected function setCampos(){
	
	$this -> Campos[consecutivo_documento_oficina_id] = array(
		name	=>'consecutivo_documento_oficina_id',
		id      =>'consecutivo_documento_oficina_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('consecutivo_documento_oficina'),
			type	=>array('primary_key'))
	);
	$this -> Campos[tipo_documento_id] = array(
		name	=>'tipo_documento_id',
		id      =>'tipo_documento_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('consecutivo_documento_oficina'),
			type	=>array('column'))
	);

	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id      =>'oficina_id',
		type	=>'select',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('consecutivo_documento_oficina'),
			type	=>array('column'))
	);	
	
	$this -> Campos[consecutivo] = array(
		name	=>'consecutivo',
		id      =>'consecutivo',
		type	=>'text',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('consecutivo_documento_oficina'),
			type	=>array('column'))
	);	
	
		
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}
$DetalleDocumento = new DetalleDocumento();
?>