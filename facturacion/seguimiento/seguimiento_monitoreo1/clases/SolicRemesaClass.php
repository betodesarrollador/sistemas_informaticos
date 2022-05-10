<?php

require_once("../../../framework/clases/ControlerClass.php");

final class SolicRemesa extends Controler{

  public function __construct(){
  
	$this -> SetCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
   	
	require_once("SolicRemesaLayoutClass.php");
    require_once("SolicRemesaModelClass.php");
	
	$Layout = new SolicRemesaLayout();
    $Model  = new SolicRemesaModel();
    $trafico_id 	= $_REQUEST['trafico_id'];
	$detalle_seg_id = $_REQUEST['detalle_seg_id'];

	
    $Layout -> setIncludes();
    $Layout -> SetSolicRemesa($Model -> getSolicRemesa($trafico_id,$detalle_seg_id,$this -> getConex()));
	$Layout -> SetCampos($this -> Campos);
    $Layout -> RenderMain();
    
  }

  protected function onclickSave(){
  
    require_once("SolicRemesaModelClass.php");
	
    $Model = new SolicRemesaModel();
	
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


  protected function SetCampos(){
		
	//botones
	$this -> Campos[adicionar] = array(
		name	=>'adicionar',
		id		=>'adicionar',
		type	=>'button',
		value=>'ADICIONAR'
	);
	
		
	$this -> SetVarsValidate($this -> Campos);
  }

}

$SolicRemesa = new SolicRemesa();

?>