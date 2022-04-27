<?php

require_once("../../framework/clases/ControlerClass.php");
final class Detalles extends Controler{

  public function __construct(){
	parent::__construct(3);
  }


  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesLayoutClass.php");
    require_once("DetallesModelClass.php");
		
	$Layout                 = new DetallesLayout();
    $Model                  = new DetallesModel();	
    $tipo 					= $_REQUEST['tipo'];
	$oficina_id				= $_REQUEST['oficina_id'];
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_cliente				= $_REQUEST['si_cliente'];
	$cliente_id				= $_REQUEST['cliente_id'];	
	$all_oficina			= $_REQUEST['all_oficina'];
	$saldos			= $_REQUEST['saldos'];
	if($saldos=='S'){
		$saldos=" AND ab.fecha BETWEEN '".$desde."'  AND  '".$hasta."' ";
	}else{
		$saldos='';
	}
	
	
    $Layout -> setIncludes();
	if($tipo=='FP' && $si_cliente==1)
    	$Layout -> setReporteVF1($Model -> getReporteVF1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$this -> getConex()));
	elseif($tipo=='VF' && $si_cliente=='ALL')
    	$Layout -> setReporteVF_ALL($Model -> getReporteVF_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex()));	
		

	 $download = $this -> requestData('download');
	
	if($download == 'true'){
	    $Layout -> exportToExcel('detalles.tpl'); 		
	}else{	
		  $Layout -> RenderMain();
	  }
    
  }
}

$Detalles = new Detalles();

?>