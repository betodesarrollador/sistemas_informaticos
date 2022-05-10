<?php

require_once("../../../framework/clases/ControlerClass.php");
final class DetallesGuiaToMC extends Controler{

  public function __construct(){
	parent::__construct(3);
  }
  
  protected function onclickSave(){  
    require_once("DetallesGuiaToMCModelClass.php");
    $Model = new DetallesGuiaToMCModel();	
    $return = $Model -> Save($this -> Campos,$this -> getConex());	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        if(is_numeric($return)){
		  exit("$return");
		}
	  }	
  }    
  
  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesGuiaToMCLayoutClass.php");
    require_once("DetallesGuiaToMCModelClass.php");
		
	$Layout                 = new DetallesGuiaToMCLayout();
    $Model                  = new DetallesGuiaToMCModel();	
	$destino_id				= $_REQUEST['destino_id'];
	$destino				= $_REQUEST['destino'];
	$departamento_id		= $_REQUEST['departamento_id'];
	$departamento    		= $_REQUEST['departamento'];
	$fecha					= $_REQUEST['fecha_guia'];
	
    $Layout -> setIncludes();
	
   if($destino_id != 'NULL' && $destino != 'NULL' && $fecha == 'NULL' && $departamento == 'NULL' && $departamento_id == 'NULL')
		$Layout -> setFiltro1($Model -> getFiltro1($destino_id, $this -> getOficinaId() ,$this -> getConex()));
	  
	elseif($fecha != 'NULL' && $destino_id == 'NULL' && $destino == 'NULL' && $departamento == 'NULL' && $departamento_id == 'NULL')
		$Layout -> setFiltro2($Model -> getFiltro2($fecha, $this -> getOficinaId() ,$this -> getConex()));
	   
	elseif($departamento == 'NULL' && $departamento_id == 'NULL' && $destino == 'NULL' && $destino_id == 'NULL' && $fecha == 'NULL')
		$Layout -> setFiltro($Model -> getFiltro($this -> getOficinaId() ,$this -> getConex()));
		
   elseif($destino_id == 'NULL' && $destino == 'NULL' && $fecha == 'NULL' && $departamento != 'NULL' && $departamento_id != 'NULL')
		$Layout -> setFiltro3($Model -> getFiltro3($departamento_id, $this -> getOficinaId() ,$this -> getConex()));		
		
    else
		$Layout -> setFiltro($Model -> getFiltro($this -> getOficinaId() ,$this -> getConex()));

	$Layout -> RenderMain();    
  }
}

$DetallesGuiaToMC = new DetallesGuiaToMC();

?>