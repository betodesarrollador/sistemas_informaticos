<?php

require_once("../../../framework/clases/ControlerClass.php");

final class InterfazAnticipos extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }
  
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){  
  
	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'date')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'date')
	);	
	
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("InterfazAnticiposLayoutClass.php");
    require_once("InterfazAnticiposModelClass.php");
	
    $Layout   = new InterfazAnticiposLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new InterfazAnticiposModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setCampos($this -> Campos);	
	
	//LISTA MENU 
	
	$Layout -> RenderMain();
    
  }
   
  protected function generateFile(){
  
    require_once("InterfazAnticiposModelClass.php");
	
    $Model     = new InterfazAnticiposModel();	
	$desde     = $_REQUEST['desde'];
	$hasta     = $_REQUEST['hasta'];
	
	$data  = $Model -> selectAnticiposRangoFecha($desde,$hasta,$this -> getConex());   
	
    $ruta  = $this -> arrayToExcel("interfazAnticipos","Interfaz Anticipos",$data);
	
    $this -> ForceDownload($ruta);
	  
  }
	
}

$InterfazAnticipos = new InterfazAnticipos();

?>