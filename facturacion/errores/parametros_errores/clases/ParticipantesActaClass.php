<?php
require_once("../../../framework/clases/ControlerClass.php");
final class ParticipantesActa extends Controler{
  public function __construct(){
	parent::__construct(3);
  }
  public function Main(){
    
    $this -> noCache();
    
    require_once("ParticipantesActaLayoutClass.php");
    require_once("ParticipantesActaModelClass.php");
	
    $Layout = new ParticipantesActaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new ParticipantesActaModel();
	
    $Layout -> setIncludes();
    $Layout -> setTercerosActa($Model -> getTercerosActa($this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  
  protected function onclickSave(){
  
    require_once("ParticipantesActaModelClass.php");
	
    $Model = new ParticipantesActaModel();
	
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
  
    require_once("ParticipantesActaModelClass.php");
	
    $Model = new ParticipantesActaModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("ParticipantesActaModelClass.php");
	
    $Model = new ParticipantesActaModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 
  }
  
//CAMPOS
  protected function setCampos(){
	
	$this -> Campos[participantes_actas_id] = array(
		name	=>'participantes_actas_id',
		id      =>'participantes_actas_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('participantes_actas'),
			type	=>array('primary_key'))
	);
	$this -> Campos[acta_id] = array(
		name	=>'acta_id',
		id      =>'acta_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('participantes_actas'),
			type	=>array('column'))
	);

	$this -> Campos[tipo_participante] = array(
		name	=>'tipo_participante',
		id      =>'tipo_participante',
		type	=>'select',
		options =>array(array(value => 'P', text => 'PROVEEDOR'), array(value => 'C', text => 'CLIENTE')),selected=>'P',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('participantes_actas'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[participante] = array(
		name	=>'participante',
		id      =>'participante',
		type	=>'text',
		datatype=>array(type=>'textarea'),
		transaction=>array(
			table	=>array('participantes_actas'),
			type	=>array('column'))
	);	
	
	
		
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}
$ParticipantesActa = new ParticipantesActa();
?>