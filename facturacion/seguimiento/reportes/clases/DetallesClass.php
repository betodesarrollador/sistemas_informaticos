<?php

ini_set("memory_limit","2048M");

require_once("../../../framework/clases/ControlerClass.php");


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
	$tipo_nov				= $_REQUEST['tipo_nov'];
	$tipo_doc				= $_REQUEST['tipo_doc'];
	$oficina_id				= $_REQUEST['oficina_id'];
	$desde					= $_REQUEST['desde']!='NULL' ? $_REQUEST['desde'] : '0000-00-00';
	$hasta					= $_REQUEST['hasta']!='NULL' ? $_REQUEST['hasta'] : date('Y-m-d');
	$desde_h				= $_REQUEST['desde_h']!='NULL' ? $_REQUEST['desde_h'] : '00:00:00';
	$hasta_h				= $_REQUEST['hasta_h']!='NULL' ? $_REQUEST['hasta_h'] : '24:00:00';
	$si_cliente				= $_REQUEST['si_cliente'];
	$cliente_id				= $_REQUEST['cliente_id'];	
	$cliente				= $_REQUEST['cliente'];	
	$si_placa				= $_REQUEST['si_placa'];
	$placa_id				= $_REQUEST['placa_id'];	
	$placa					= $_REQUEST['placa'];	
	$all_oficina			= $_REQUEST['all_oficina'];
	$opciones_conductor		= $_REQUEST['opciones_conductor'];
	$conductor				= $_REQUEST['conductor'];
	$conductor_id			= $_REQUEST['conductor_id'];
	$solouno				= $_REQUEST['solouno'];
	
	
	if($opciones_conductor=='T') $consul_cond=''; else  $consul_cond=' AND conductor_id='.$conductor_id.' ';
	$LIMITE='';
	  
	
    $Layout -> setIncludes();
	if($solouno=='1'){
    	$Layout -> setReporteUlt($Model -> getReporteUlt($tipo,$tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex()));	
		$data = $Model -> getReporteUlt($tipo,$tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex());
		
  	}elseif($tipo=='ALL' && $tipo_nov=='NULL' && $si_cliente==1 && $si_placa==1){
    	$Layout -> setReporte1($Model -> getReporte1($oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex()));	
		$data = $Model -> getReporte1($oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex());
	
	}elseif($tipo=='ALL' && $tipo_nov>0 && $si_cliente==1 && $si_placa==1){
		$Layout -> setReporte2($Model -> getReporte2($tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex()));
		$data = $Model -> getReporte2($tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex());
	
	}elseif($tipo!='ALL' && $tipo_nov=='NULL' && $si_cliente==1 && $si_placa==1){
		$Layout -> setReporte3($Model -> getReporte3($tipo,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex()));
		$data = $Model -> getReporte3($tipo,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex());
	
	}elseif($tipo!='ALL' && $tipo_nov>0 && $si_cliente==1 && $si_placa==1){
		$Layout -> setReporte4($Model -> getReporte4($tipo,$tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex()));
		$data = $Model -> getReporte4($tipo,$tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex());
	
	}elseif($tipo=='ALL' && $tipo_nov=='NULL' && $si_cliente=='ALL' && $si_placa==1){
    	$Layout -> setReporte5($Model -> getReporte5($oficina_id,$desde,$hasta,$desde_h,$hasta_h,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex()));	
		$data = $Model -> getReporte5($oficina_id,$desde,$hasta,$desde_h,$hasta_h,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex());
	
	}elseif($tipo=='ALL' && $tipo_nov>0 && $si_cliente=='ALL' && $si_placa==1){
		$Layout -> setReporte6($Model -> getReporte6($tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex()));
		$data = $Model -> getReporte6($tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex());
	
	}elseif($tipo!='ALL' && $tipo_nov=='NULL' && $si_cliente=='ALL' && $si_placa==1){
		$Layout -> setReporte7($Model -> getReporte7($tipo,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex()));
		$data = $Model -> getReporte7($tipo,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex());
	
	}elseif($tipo!='ALL' && $tipo_nov>0 && $si_cliente=='ALL' && $si_placa==1){
		$Layout -> setReporte8($Model -> getReporte8($tipo,$tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex()));
		$data = $Model -> getReporte8($tipo,$tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex());
		
	}elseif($tipo=='ALL' && $tipo_nov=='NULL' && $si_cliente==1 && $si_placa=='ALL'){ 
    	$Layout -> setReporte9($Model -> getReporte9($oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex()));	
    	$data = $Model -> getReporte9($oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex());
		
	}elseif($tipo=='ALL' && $tipo_nov>0 && $si_cliente==1 && $si_placa=='ALL'){ 
		$Layout -> setReporte10($Model -> getReporte10($tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex()));
	    $data = $Model -> getReporte10($tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex());
		
	}elseif($tipo!='ALL' && $tipo_nov=='NULL' && $si_cliente==1 && $si_placa=='ALL'){ 
		$Layout -> setReporte11($Model -> getReporte11($tipo,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex()));
		$data = $Model -> getReporte11($tipo,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex());
		
    }elseif($tipo!='ALL' && $tipo_nov>0 && $si_cliente==1 && $si_placa=='ALL'){
		$Layout -> setReporte12($Model -> getReporte12($tipo,$tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex()));
    	$data = $Model -> getReporte12($tipo,$tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex());
		
	}elseif($tipo=='ALL' && $tipo_nov=='NULL' && $si_cliente=='ALL' && $si_placa=='ALL' ){
    	$Layout -> setReporte13($Model -> getReporte13($oficina_id,$desde,$hasta,$desde_h,$hasta_h,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex()));
		$data = $Model -> getReporte13($oficina_id,$desde,$hasta,$desde_h,$hasta_h,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex());
		
    }elseif($tipo=='ALL' && $tipo_nov>0 && $si_cliente=='ALL' && $si_placa=='ALL' ){
		$Layout -> setReporte14($Model -> getReporte14($tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex()));
    	$data = $Model -> getReporte14($tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex());
	
	}elseif($tipo!='ALL' && $tipo_nov=='NULL' && $si_cliente=='ALL' && $si_placa=='ALL' ){
		$Layout -> setReporte15($Model -> getReporte15($tipo,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex()));
		$data = $Model -> getReporte15($tipo,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex());
    
	}elseif($tipo!='ALL' && $tipo_nov>0 && $si_cliente=='ALL' && $si_placa=='ALL'  ){
		$Layout -> setReporte16($Model -> getReporte16($tipo,$tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex()));
		$data = $Model -> getReporte16($tipo,$tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$tipo_doc,$consul_cond,$LIMITE,$this -> getConex());
	
	}

    $download = $this -> requestData('download');
	$csv = $this -> requestData('csv');

    if($download == 'true'){
	    $Layout -> exportToExcel('detalles.tpl'); 
	}elseif($csv == 'true'){
		$ruta  = $this -> arrayToExcel("Personalizado","Personalizado",$data,null,"string");
		$this -> ForceDownload($ruta);
		
		
	}else{	
		  $Layout -> RenderMain();
	  }
    
  }
}

new Detalles();

?>