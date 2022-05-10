<?php
require_once("../../../framework/clases/ControlerClass.php");
final class DetallesGuiaToRE extends Controler{

  public function __construct(){
	parent::__construct(3);
  }
  
  protected function onclickSave(){  
    require_once("DetallesGuiaToREModelClass.php");
    $Model = new DetallesGuiaToREModel();	
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
    	
	require_once("DetallesGuiaToRELayoutClass.php");
    require_once("DetallesGuiaToREModelClass.php");
		
	$Layout                 = new DetallesGuiaToRELayout();
    $Model                  = new DetallesGuiaToREModel();	
	$destino_id				= $_REQUEST['destino_id'];
	$destino				= $_REQUEST['destino'];
	$departamento_id		= $_REQUEST['departamento_id'];
	$departamento    		= $_REQUEST['departamento'];
	$fecha					= $_REQUEST['fecha_guia'];
	$cliente_id				= $_REQUEST['cliente_id'];
	$cliente    			= $_REQUEST['cliente'];
	
	if($cliente_id>0){
		$cliente_consul=" AND r.cliente_id=".$cliente_id." ";
	}else{
		$cliente_consul="";
	}

	if($departamento_id>0){
		$depa_consul=" AND r.destino_id IN (SELECT ubicacion_id FROM ubicacion WHERE ubi_ubicacion_id =".$departamento_id.") ";
	}else{
		$depa_consul="";
	}

	if($destino_id>0){
		$desti_consul=" AND r.destino_id =".$destino_id." ";
	}else{
		$desti_consul="";
	}

	if($fecha!='' && $fecha!='NULL' && $fecha!='null' && $fecha!=NULL){
		$fecha=" AND r.fecha_guia ='".$fecha."' ";
	}else{
		$fecha="";
	}

	$Layout -> setFiltro1($Model -> getFiltro1($fecha,$depa_consul,$cliente_consul,$desti_consul, $this -> getOficinaId() ,$this -> getConex()));
    $Layout -> setIncludes();
	
	$Layout -> RenderMain();    
  }
}

$DetallesGuiaToRE = new DetallesGuiaToRE();

?>