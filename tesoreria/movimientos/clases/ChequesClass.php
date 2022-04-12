<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Cheques extends Controler{

  public function __construct(){
  
	$this -> SetCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
   	
	require_once("ChequesLayoutClass.php");
    require_once("ChequesModelClass.php");
	
	$Layout = new ChequesLayout();
    $Model  = new ChequesModel();
    $oficina_id 	= $_REQUEST['oficina_id'];
	
    $Layout -> setIncludes();
    $Layout -> SetCheques($Model -> getCheques($oficina_id,$this -> getConex()));
	$Layout -> SetCampos($this -> Campos);
    $Layout -> RenderMain();
    
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

$Cheques = new Cheques();

?>