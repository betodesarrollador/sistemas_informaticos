<?php

require_once("../../../framework/clases/ControlerClass.php");

final class SolicEdit extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
   	
	require_once("SolicEditLayoutClass.php");
    require_once("SolicEditModelClass.php");
	
	$Layout = new SolicEditLayout();
    $Model  = new SolicEditModel();
    $trafico_id 	= $_REQUEST['trafico_id'];
	$detalle_seg_id = $_REQUEST['detalle_seg_id'];

	
    $Layout -> setIncludes();
    $Layout -> SetSolicRemesa($Model -> getSolicRemesa($trafico_id,$detalle_seg_id,$this -> getConex()));
	$Layout -> SetCampos($this -> Campos);
    $Layout -> RenderMain();
    
  }

  protected function onclickSave(){
  
    require_once("SolicEditModelClass.php");
	
    $Model = new SolicEditModel();
	
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
  
    require_once("SolicEditModelClass.php");
	
    $Model = new SolicEditModel();
	
    $return = $Model -> Update($this -> Campos,$this -> getConex());
	
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
  protected function onclickDelete(){
  
    require_once("SolicEditModelClass.php");
	
    $Model = new SolicEditModel();
	
    $return = $Model -> Delete($this -> Campos,$this -> getConex());
	
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


  protected function SetCampos(){
		
	//botones
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value=>'ACTUALIZAR'
	);
	
		
	$this -> SetVarsValidate($this -> Campos);
  }

}

$SolicEdit = new SolicEdit();

?>