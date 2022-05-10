<?php

require_once("../../../framework/clases/ControlerClass.php");
final class DetallesHistorico extends Controler{

  public function __construct(){
	parent::__construct(3);
  }
  
  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesHistoricoLayoutClass.php");
    require_once("DetallesHistoricoModelClass.php");
		
	$Layout                 = new DetallesHistoricoLayout();
    $Model                  = new DetallesHistoricoModel();	
	$oficina_id				= $_REQUEST['oficina_id'];
	$estado_id				= $_REQUEST['estado_id'];
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_vehiculo			= $_REQUEST['si_vehiculo'];
	$vehiculo_id			= $_REQUEST['vehiculo_id'];			
	$si_conductor			= $_REQUEST['si_conductor'];
	$conductor_id			= $_REQUEST['conductor_id'];	
	$si_tenedor			    = $_REQUEST['si_tenedor'];
	$tenedor_id				= $_REQUEST['tenedor_id'];	
	$si_cliente				= $_REQUEST['si_cliente'];
	$cliente_id				= $_REQUEST['cliente_id'];		
	$all_oficina			= $_REQUEST['all_oficina'];
	
    $Layout -> setIncludes();
		
	if($si_cliente=='ALL' && $si_conductor=='ALL' && $si_vehiculo=='ALL' && $si_tenedor=='ALL') // REPORTE GENERAL
		$Layout -> setReporte1($Model -> getReporte1($oficina_id,$desde,$hasta,$this -> getConex()));	
	elseif($si_cliente==1 && $si_conductor=='ALL' && $si_vehiculo=='ALL' && $si_tenedor=='ALL') // REPORTE CLIENTE
		$Layout -> setReporte2($Model -> getReporte2($oficina_id,$desde,$hasta,$cliente_id,$this -> getConex()));	
	elseif($si_cliente=='ALL' && $si_conductor=='ALL' && $si_vehiculo=='ALL' && $si_tenedor==1) // REPORTE TENEDOR
		$Layout -> setReporte3($Model -> getReporte3($oficina_id,$desde,$hasta,$tenedor_id,$this -> getConex()));	
	elseif($si_cliente=='ALL' && $si_conductor==1 && $si_vehiculo=='ALL' && $si_tenedor=='ALL') // REPORTE CONDUCTOR
		$Layout -> setReporte4($Model -> getReporte4($oficina_id,$desde,$hasta,$conductor_id,$this -> getConex()));		
	elseif($si_cliente=='ALL' && $si_conductor=='ALL' && $si_vehiculo==1 && $si_tenedor=='ALL') // REPORTE VEHICULO
		$Layout -> setReporte5($Model -> getReporte5($oficina_id,$desde,$hasta,$vehiculo_id,$this -> getConex()));			
	elseif($si_cliente==1 && $si_conductor=='ALL' && $si_vehiculo==1 && $si_tenedor=='ALL') // REPORTE VEHICULO - CLIENTE 
		$Layout -> setReporte6($Model -> getReporte6($oficina_id,$desde,$hasta,$vehiculo_id,$cliente_id,$this -> getConex()));		
	elseif($si_cliente=='ALL' && $si_conductor==1 && $si_vehiculo==1 && $si_tenedor=='ALL') // REPORTE VEHICULO - CONDUCTOR 
		$Layout -> setReporte7($Model -> getReporte7($oficina_id,$desde,$hasta,$vehiculo_id,$conductor_id,$this -> getConex()));		
	elseif($si_cliente=='ALL' && $si_conductor=='ALL' && $si_vehiculo==1 && $si_tenedor==1) // REPORTE VEHICULO - TENEDOR 
		$Layout -> setReporte8($Model -> getReporte8($oficina_id,$desde,$hasta,$vehiculo_id,$tenedor_id,$this -> getConex()));	
	elseif($si_cliente=='ALL' && $si_conductor==1 && $si_vehiculo=='ALL' && $si_tenedor==1) // REPORTE CONDUCTOR - TENEDOR 
		$Layout -> setReporte9($Model -> getReporte9($oficina_id,$desde,$hasta,$conductor_id,$tenedor_id,$this -> getConex()));		
	elseif($si_cliente==1 && $si_conductor==1 && $si_vehiculo=='ALL' && $si_tenedor=='ALL') // REPORTE CONDUCTOR - CLIENTE 
		$Layout -> setReporte10($Model -> getReporte10($oficina_id,$desde,$hasta,$conductor_id,$cliente_id,$this -> getConex()));		
	elseif($si_cliente==1 && $si_conductor=='ALL' && $si_vehiculo=='ALL' && $si_tenedor==1) // REPORTE CLIENTE - TENEDOR 
		$Layout -> setReporte11($Model -> getReporte11($oficina_id,$desde,$hasta,$cliente_id,$tenedor_id,$this -> getConex()));			
	elseif($si_cliente==1 && $si_conductor==1 && $si_vehiculo==1 && $si_tenedor=='ALL') // REPORTE CONDUCTOR - VEHICULO - CLIENTE
		$Layout -> setReporte12($Model -> getReporte12($oficina_id,$desde,$hasta,$conductor_id,$vehiculo_id,$cliente_id,$this -> getConex()));		
	elseif($si_cliente=='ALL' && $si_conductor==1 && $si_vehiculo==1 && $si_tenedor==1) // REPORTE CONDUCTOR - VEHICULO - TENEDOR
		$Layout -> setReporte13($Model -> getReporte13($oficina_id,$desde,$hasta,$conductor_id,$vehiculo_id,$tenedor_id,$this -> getConex()));	
	elseif($si_cliente==1 && $si_conductor=='ALL' && $si_vehiculo==1 && $si_tenedor==1) // REPORTE CLIENTE - VEHICULO - TENEDOR
		$Layout -> setReporte14($Model -> getReporte14($oficina_id,$desde,$hasta,$cliente_id,$vehiculo_id,$tenedor_id,$this -> getConex()));	
	elseif($si_cliente==1 && $si_conductor==1 && $si_vehiculo=='ALL' && $si_tenedor==1) // REPORTE CONDUCTOR - CLIENTE - TENEDOR
		$Layout -> setReporte15($Model -> getReporte15($oficina_id,$desde,$hasta,$conductor_id,$cliente_id,$tenedor_id,$this -> getConex()));		
	elseif($si_cliente==1 && $si_conductor==1 && $si_vehiculo==1 && $si_tenedor==1) // REPORTE CONDUCTOR - CLIENTE - TENEDOR - VEHICULO
		$Layout -> setReporte16($Model -> getReporte16($oficina_id,$desde,$hasta,$conductor_id,$cliente_id,$tenedor_id,$vehiculo_id,$this -> getConex()));		
		
	$Layout -> RenderMain();    
  }
}

$DetallesHistorico = new DetallesHistorico();

?>