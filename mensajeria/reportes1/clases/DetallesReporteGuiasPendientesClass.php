<?php
require_once("../../../framework/clases/ControlerClass.php");
final class DetallesReporteGuiasPendientes extends Controler{

  public function __construct(){
	parent::__construct(3);
  }
  
  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesReporteGuiasPendientesLayoutClass.php");
    require_once("DetallesReporteGuiasPendientesModelClass.php");
		
	$Layout                 		= new DetallesReporteGuiasPendientesLayout();
    $Model                  		= new DetallesReporteGuiasPendientesModel();	
	$desde							= $_REQUEST['desde'];
	$hasta							= $_REQUEST['hasta'];

	$oficina_id				= $_REQUEST['oficina_id'];
	$all_oficina			= $_REQUEST['all_oficina'];

    if ($all_oficina=='' || $all_oficina=='NULL' || $all_oficina==NULL || $all_oficina=='SI'){
    	$consulta_oficina="";
    }
    else $consulta_oficina=" AND g.oficina_id IN (".$oficina_id.") ";

	$Layout -> setReporte1($Model -> getReporte1($desde,$hasta,$consulta_oficina,$this -> getConex()));
	$Layout -> RenderMain();    
  }


  protected function generateFile(){
  
    require_once("DetallesReporteGuiasPendientesModelClass.php");
	
    $Model     = new DetallesReporteGuiasPendientesModel();	

	$desde							= $_REQUEST['desde'];
	$hasta							= $_REQUEST['hasta'];
	$oficina_id				= $_REQUEST['oficina_id'];
	$all_oficina			= $_REQUEST['all_oficina'];


    if ($all_oficina=='' || $all_oficina=='NULL' || $all_oficina==NULL || $all_oficina=='SI'){
    	$consulta_oficina="";
    }
    else $consulta_oficina=" AND g.oficina_id IN (".$oficina_id.") ";

	$data  = $Model -> getReporte1($desde,$hasta,$consulta_oficina,$this -> getConex());
		
    $ruta  = $this -> arrayToExcel("ReporGuias","Reporte Guias",$data,null);

    if($_REQUEST['download'] == 'SI'){
      $this -> ForceDownload($ruta);
	}else{
       print json_encode(array(ruta => $ruta, errores => $data[0]['validaciones']));
    }
}

  
  protected function generateFileFormato(){
  
	require_once("DetallesReporteGuiasPendientesLayoutClass.php");
    require_once("DetallesReporteGuiasPendientesModelClass.php");
		
	$Layout                 = new DetallesReporteGuiasPendientesLayout();
    $Model                  = new DetallesReporteGuiasPendientesModel();

	$desde							= $_REQUEST['desde'];
	$hasta							= $_REQUEST['hasta'];
	$oficina_id				= $_REQUEST['oficina_id'];
	$all_oficina			= $_REQUEST['all_oficina'];
	
    if ($all_oficina=='' || $all_oficina=='NULL' || $all_oficina==NULL || $all_oficina=='SI'){
    	$consulta_oficina="";
    }
    else $consulta_oficina=" AND g.oficina_id IN (".$oficina_id.") ";

	$Layout -> setReporte1($Model -> getReporte1($desde,$hasta,$consulta_oficina,$this -> getConex()));	
	if($_REQUEST['download'] == 'SI'){
		$Layout -> exportToExcel('DetallesReporteGuiasPendientesExc.tpl');
	}
  }

  protected function generateFileFormato1(){
  
	require_once("DetallesReporteGuiasPendientesLayoutClass.php");
    require_once("DetallesReporteGuiasPendientesModelClass.php");
		
	$Layout                 = new DetallesReporteGuiasPendientesLayout();
    $Model                  = new DetallesReporteGuiasPendientesModel();

	$desde							= $_REQUEST['desde'];
	$hasta							= $_REQUEST['hasta'];
	$oficina_id				= $_REQUEST['oficina_id'];
	$all_oficina			= $_REQUEST['all_oficina'];

	$Layout -> assign("desde",            $_REQUEST['desde']);
	$Layout -> assign("hasta",            $_REQUEST['hasta']);

    if ($all_oficina=='' || $all_oficina=='NULL' || $all_oficina==NULL || $all_oficina=='SI'){
    	$consulta_oficina="";
    }
    else $consulta_oficina=" AND g.oficina_id IN (".$oficina_id.") ";

	$Layout -> setReporte1($Model -> getReporte1($desde,$hasta,$consulta_oficina,$this -> getConex()));	
	if($_REQUEST['download'] == 'SI'){
		$Layout -> exportToExcel('DetallesReporteGuiasPendientesExc1.tpl');
	}
  }



}

$DetallesReporteGuiasPendientes = new DetallesReporteGuiasPendientes();

?>