<?php
require_once("../../../framework/clases/ControlerClass.php");
final class DetallesEdades extends Controler{

  public function __construct(){
	parent::__construct(3);
  }
  
  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesEdadesLayoutClass.php");
    require_once("DetallesEdadesModelClass.php");
		
	$Layout                 = new DetallesEdadesLayout();
    $Model                  = new DetallesEdadesModel();	
    $tipo 					= $_REQUEST['tipo'];
	$oficina_id				= $_REQUEST['oficina_id'];
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_tenedor				= $_REQUEST['si_tenedor'];
	$tenedor_id				= $_REQUEST['tenedor_id'];	
    $si_vehiculo			= $_REQUEST['si_vehiculo'];
	$vehiculo_id			= $_REQUEST['vehiculo_id'];	
	$all_oficina			= $_REQUEST['all_oficina'];
	$download			= $_REQUEST['download'];
	
    $Layout -> setIncludes();
	
	if($tipo=='MC' && $si_vehiculo=='ALL' && $si_tenedor=='ALL'){
		$Layout -> setReporteMC1($Model -> getReporteMC1($oficina_id,$desde,$hasta,$this -> getConex()));

  }elseif($tipo=='DU' && $si_vehiculo=='ALL' && $si_tenedor=='ALL'){
		$Layout -> setReporteDU1($Model -> getReporteDU1($oficina_id,$desde,$hasta,$this -> getConex()));
  }
	
	elseif($tipo=='MC' && $si_vehiculo=='ALL' && $si_tenedor==1)
		$Layout -> setReporteMC2($Model -> getReporteMC2($oficina_id,$desde,$hasta,$tenedor_id,$this -> getConex()));
	elseif($tipo=='DU' && $si_vehiculo=='ALL' && $si_tenedor==1)
		$Layout -> setReporteDU2($Model -> getReporteDU2($oficina_id,$desde,$hasta,$tenedor_id,$this -> getConex()));
	
	elseif($tipo=='MC' && $si_vehiculo==1 && $si_tenedor=='ALL')
		$Layout -> setReporteMC3($Model -> getReporteMC3($oficina_id,$desde,$hasta,$vehiculo_id, $this -> getConex()));
	elseif($tipo=='DU' && $si_vehiculo==1 && $si_tenedor=='ALL')
		$Layout -> setReporteDU3($Model -> getReporteDU3($oficina_id,$desde,$hasta,$vehiculo_id, $this -> getConex()));
	
	elseif($tipo=='MC' && $si_vehiculo==1 && $si_tenedor==1)
		$Layout -> setReporteMC4($Model -> getReporteMC4($oficina_id,$desde,$hasta,$vehiculo_id,$tenedor_id,$this -> getConex()));
	elseif($tipo=='DU' && $si_vehiculo==1 && $si_tenedor==1)
		$Layout -> setReporteDU4($Model -> getReporteDU4($oficina_id,$desde,$hasta,$vehiculo_id,$tenedor_id,$this -> getConex()));
		
	elseif($tipo=='MC,DU' && $si_vehiculo=='ALL' && $si_tenedor=='ALL')
		$Layout -> setReporteALL1($Model -> getReporteALL1($oficina_id,$desde,$hasta,$this -> getConex()));
	elseif($tipo=='MC,DU' && $si_vehiculo=='ALL' && $si_tenedor==1)
		$Layout -> setReporteALL2($Model -> getReporteALL2($oficina_id,$desde,$hasta,$tenedor_id,$this -> getConex()));
	elseif($tipo=='MC,DU' && $si_vehiculo==1 && $si_tenedor=='ALL')
		$Layout -> setReporteALL3($Model -> getReporteALL3($oficina_id,$desde,$hasta,$vehiculo_id,$this -> getConex()));
	elseif($tipo=='MC,DU' && $si_vehiculo==1 && $si_tenedor==1)
		$Layout -> setReporteALL4($Model -> getReporteALL4($oficina_id,$desde,$hasta,$vehiculo_id,$tenedor_id,$this -> getConex()));
	
	
		
	if($download == 'true'){
	    $Layout -> exportToExcel('detallesEdades.tpl'); 		
	}else{	
		  $Layout -> RenderMain();
	  }
  }
}

$DetallesEdades = new DetallesEdades();

?>