<?php

require_once("../../../framework/clases/ControlerClass.php");

final class InterfazViajes extends Controler{

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
    
    require_once("InterfazViajesLayoutClass.php");
    require_once("InterfazViajesModelClass.php");
	
    $Layout   = new InterfazViajesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new InterfazViajesModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setCampos($this -> Campos);	
	
	//LISTA MENU 
	
	$Layout -> RenderMain();
    
  }
   
  protected function generateFile(){
  
    require_once("InterfazViajesModelClass.php");
	
    $Model     = new InterfazViajesModel();	
	$desde     = $_REQUEST['desde'];
	$hasta     = $_REQUEST['hasta'];
	
	$data  = $Model -> selectAnticiposRangoFecha($desde,$hasta,$this -> getConex());   
		
    $ruta  = $this -> arrayToExcel("InterfazViajes","Interfaz Viajes",$data[0]['interfaz']);
	
    $this -> ForceDownload($ruta);
	  
  }
	
}

$InterfazViajes = new InterfazViajes();

?>