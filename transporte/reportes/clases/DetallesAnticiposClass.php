<?php
require_once("../../../framework/clases/ControlerClass.php");
final class DetallesAnticipos extends Controler{

  public function __construct(){
	parent::__construct(3);
  }
  
  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesAnticiposLayoutClass.php");
    require_once("DetallesAnticiposModelClass.php");
		
	$Layout                 = new DetallesAnticiposLayout();
    $Model                  = new DetallesAnticiposModel();	
    $tipo 					= $_REQUEST['tipo'];
    $estado 				= $_REQUEST['estado'];	
	$oficina_id				= $_REQUEST['oficina_id'];
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_tenedor				= $_REQUEST['si_tenedor'];
	$tenedor_id				= $_REQUEST['tenedor_id'];	
    $si_vehiculo			= $_REQUEST['si_vehiculo'];
	$vehiculo_id			= $_REQUEST['vehiculo_id'];	
	$all_oficina			= $_REQUEST['all_oficina'];
	
	$download = $this -> requestData('download');
	
	$con_corte				= $_REQUEST['con_corte'];
	

	if($con_corte=="N"){
		$cons_cor = "";
		$cons_cor1 = "";
		
		
	}else{
		$cons_cor = "AND l.fecha BETWEEN '$desde' AND '$hasta'";
		$cons_cor1 = "AND af.fecha BETWEEN '$desde' AND '$hasta'";
		
	}
	
	
	
    $Layout -> setIncludes();
	
	if($estado=="P" || $estado=="CE"){//m.estado!='A' AND
		$estadomc = "AND  ((am.detalle_liquidacion_despacho_id IS NULL AND am.legalizacion_manifiesto_id IS NULL) OR  am.detalle_liquidacion_despacho_id NOT IN (SELECT dl.detalle_liquidacion_despacho_id FROM detalle_liquidacion_despacho dl, liquidacion_despacho l WHERE dl.detalle_liquidacion_despacho_id=am.detalle_liquidacion_despacho_id AND l.liquidacion_despacho_id=dl.liquidacion_despacho_id AND l.estado_liquidacion!='C')) ";
		
		$estadodu = "AND ((adu.detalle_liquidacion_despacho_id IS NULL AND adu.legalizacion_despacho_id IS NULL) OR  adu.detalle_liquidacion_despacho_id NOT IN (SELECT dl.detalle_liquidacion_despacho_id FROM detalle_liquidacion_despacho dl, liquidacion_despacho l WHERE dl.detalle_liquidacion_despacho_id=adu.detalle_liquidacion_despacho_id AND l.liquidacion_despacho_id=dl.liquidacion_despacho_id AND l.estado_liquidacion!='C'))";
		$estadoap = "AND ap.estado='P'";
	}else{
		$estadomc = "";
		$estadodu = "";
		$estadoap = "";
	}
	
	if($si_vehiculo=="ALL"){
		$cons_vehm = "";
		$cons_vehd = "";
		$cons_veha = "";
		
	}else{
		$cons_vehm = "AND m.placa_id = $vehiculo_id";
		$cons_vehd = "AND du.placa_id = $vehiculo_id";
		$cons_veha = "AND ap.placa_id = $vehiculo_id";
	}

	if($si_tenedor=="ALL"){
		$cons_tenm = "";
		$cons_tend = "";
		$cons_tena = "";
		
	}else{
		$cons_tenm = "AND m.tenedor_id = $tenedor_id";
		$cons_tend = "AND du.tenedor_id = $tenedor_id";
		$cons_tena = "AND ap.tenedor_id = $tenedor_id";
	}

	if($estado=='CE'){
		$Layout -> setReporteMCE1DUE1APE1($Model -> getReporteMCE1DUE1APE1($tipo,$oficina_id,$desde,$hasta,$estadomc,$estadodu,$estadoap,$cons_vehm,$cons_vehd,$cons_veha,$cons_tenm,$cons_tend,$cons_tena,$cons_cor,$cons_cor1,$this -> getConex()));
		
	}elseif($estado=='P'){
		$Layout -> setReporteMCE1DUE1APE1($Model -> getReporteMCE1DUE1APE1($tipo,$oficina_id,$desde,$hasta,$estadomc,$estadodu,$estadoap,$cons_vehm,$cons_vehd,$cons_veha,$cons_tenm,$cons_tend,$cons_tena,$cons_cor,$cons_cor1,$this -> getConex()));
		
	}elseif($estado=='ALL'){
		$Layout -> setReporteMCE1DUE1APE1($Model -> getReporteTOTAL($tipo,$oficina_id,$desde,$hasta,$estadomc,$estadodu,$estadoap,$cons_vehm,$cons_vehd,$cons_veha,$cons_tenm,$cons_tend,$cons_tena,$cons_cor,$cons_cor1,$this -> getConex()));
	}
		
		if($download == 'true'){
	    	$Layout -> exportToExcel('detallesAnticipos.tpl'); 		
		}else{	
		  $Layout -> RenderMain();
	 	}    
  }
}

$DetallesAnticipos = new DetallesAnticipos();

?>