<?php
require_once("../../../framework/clases/ControlerClass.php");
final class DetalleCertificados extends Controler{
  public function __construct(){
	parent::__construct(3);
  }
  public function Main(){
    
    $this -> noCache();
    
    require_once("DetalleCertificadosLayoutClass.php");
    require_once("DetalleCertificadosModelClass.php");
	
    $Layout = new DetalleCertificadosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleCertificadosModel();
	
    $Layout -> setIncludes();
    $Layout -> setDetallesCertificados($Model -> getDetallesCertificados($this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  
  protected function setCampos(){
  
	$this -> Campos[cuentas_certificado_id] = array(
		name	=>'cuentas_certificado_id',
		id	    =>'cuentas_certificado_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('cuentas_certificado'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[certificados_id] = array(
		name	=>'certificados_id',
		id	    =>'certificados_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('cuentas_certificado'),
			type	=>array('column'))
	);
	
	$this -> Campos[puc_id] = array(
		name	=>'puc_id',
		id	    =>'puc_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('cuentas_certificado'),
			type	=>array('column'))
	);		
		  	
	 
	$this -> SetVarsValidate($this -> Campos);
  }
  
  
  protected function onclickSave(){
  
    require_once("DetalleCertificadosModelClass.php");
	
    $Model = new DetalleCertificadosModel();
	
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
  
    require_once("DetalleCertificadosModelClass.php");
	
    $Model = new DetalleCertificadosModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("DetalleCertificadosModelClass.php");
	
    $Model = new DetalleCertificadosModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 
  }
  	
	
}
new DetalleCertificados();
?>