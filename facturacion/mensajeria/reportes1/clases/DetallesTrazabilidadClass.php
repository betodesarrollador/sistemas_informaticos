<?php
require_once("../../../framework/clases/ControlerClass.php");

final class DetallesTrazabilidad extends Controler{

  public function __construct(){
	parent::__construct(3);
  }
  
  public function Main(){
	    
    $this -> noCache();

	require_once("DetallesTrazabilidadLayoutClass.php");
    require_once("DetallesTrazabilidadModelClass.php");

	$Layout                 = new DetallesTrazabilidadLayout();
    $Model                  = new DetallesTrazabilidadModel();	
    $oficina_id				= $_REQUEST['oficina_id'];
	$estado_id				= $_REQUEST['estado_id'];
	$trazabilidad_id		= $_REQUEST['trazabilidad_id'];
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_cliente				= $_REQUEST['si_cliente'];
	$cliente_id				= $_REQUEST['cliente_id'];		
	$all_oficina			= $_REQUEST['all_oficina'];
	$all_estado 			= $_REQUEST['all_estado'];
	$all_trazabilidad 		= $_REQUEST['all_trazabilidad'];
	
    $Layout -> setIncludes();

    if($all_estado == 'SI'){
	  $estado = str_replace(',',"','",$estado_id);
	}else{	 
	   $estado = str_replace(',',"','",$estado_id);
	 }

	if($all_trazabilidad == 'SI'){
	  $trazabilidad = str_replace(',',"','",$trazabilidad_id);
	}else{	 
	   $trazabilidad = str_replace(',',"','",$trazabilidad_id);
	 }	
	 
	if($estado_id=='MC' && $si_cliente=='ALL' && $all_trazabilidad == 'SI')
		$Layout -> setReporte1($Model -> getReporte1($oficina_id,$desde,$hasta,$this -> getConex()));			
	elseif($estado_id=='DU' && $si_cliente=='ALL' && $all_trazabilidad == 'SI')
     	$Layout -> setReporte2($Model -> getReporte2($oficina_id,$desde,$hasta,$this -> getConex()));
	elseif($all_estado=='SI' && $si_cliente=='ALL' && $all_trazabilidad == 'SI')
		$Layout -> setReporte3($Model -> getReporte3($oficina_id,$desde,$hasta,$this -> getConex()));	
	elseif($estado_id=='MC' && $si_cliente==1 && $all_trazabilidad == 'SI')
     	$Layout -> setReporte4($Model -> getReporte4($oficina_id,$desde,$hasta,$cliente_id,$this -> getConex()));		
	elseif($estado_id=='DU' && $si_cliente==1 && $all_trazabilidad == 'SI')
     	$Layout -> setReporte5($Model -> getReporte5($oficina_id,$desde,$hasta,$cliente_id,$this -> getConex()));	
		
	elseif($all_estado=='SI' && $si_cliente==1 && $all_trazabilidad == 'SI')
     	$Layout -> setReporte6($Model -> getReporte6($oficina_id,$desde,$hasta,$cliente_id,$this -> getConex()));		
		
	$Layout -> RenderMain();    
  }
}

$DetallesTrazabilidad = new DetallesTrazabilidad();

?>