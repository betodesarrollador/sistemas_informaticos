<?php

require_once("../../../framework/clases/ControlerClass.php");
final class DetallesRemesas extends Controler{

  public function __construct(){
	parent::__construct(3);
  }
  
  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesRemesasLayoutClass.php");
    require_once("DetallesRemesasModelClass.php");
		
	$Layout                 = new DetallesRemesasLayout();
    $Model                  = new DetallesRemesasModel();	
	$oficina_id				= $_REQUEST['oficina_id'];
	$estado_id				= $_REQUEST['estado_id'];
	$clase_id				= $_REQUEST['clase_id'];	
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_cliente				= $_REQUEST['si_cliente'];
	$cliente_id				= $_REQUEST['cliente_id'];		
	$all_oficina			= $_REQUEST['all_oficina'];
	$all_estado 			= $_REQUEST['all_estado'];	
	$all_clase 			    = $_REQUEST['all_clase'];		
  
    $Layout -> setIncludes();
	if($all_estado == 'SI'){
	  $estado = str_replace(',',"','",$estado_id);
	}else{	 
	   $estado = str_replace(',',"','",$estado_id);
	}
	if($all_clase == 'SI'){
	  $clase = str_replace(',',"','",$clase_id);
	}else{	 
	   $clase = str_replace(',',"','",$clase_id);
	}	

	if($si_cliente=='ALL')	$consulta_cliente=""; else $consulta_cliente=" AND r.cliente_id =".$cliente_id;
	
	$Layout -> setReporte1($Model -> getReporte1($oficina_id,$estado,$desde,$hasta,$consulta_cliente,$clase,$this -> getConex()));			
		
	$Layout -> RenderMain();    
  }
}

$DetallesRemesas = new DetallesRemesas();

?>