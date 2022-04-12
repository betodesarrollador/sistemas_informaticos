<?php
require_once("../../../framework/clases/ControlerClass.php");
final class DetallesReporteTotal extends Controler{

  public function __construct(){
	parent::__construct(3);
  }
  
  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesReporteTotalLayoutClass.php");
    require_once("DetallesReporteTotalModelClass.php");
		
	$Layout                 = new DetallesReporteTotalLayout();
    $Model                  = new DetallesReporteTotalModel();	
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$cliente_id				= $_REQUEST['cliente_id'];
	$si_cliente				= $_REQUEST['si_cliente'];

    $Layout -> setIncludes();

    if ($si_cliente=='' || $si_cliente=='NULL' || $si_cliente==NULL || $si_cliente=='ALL'){
    	$consulta_cliente="";
    }
    else $consulta_cliente=" AND c.cliente_id =".$cliente_id;

	$Layout -> setReporte1($Model -> getReporte1($desde,$hasta,$consulta_cliente,$this -> getConex()));
	$Layout -> RenderMain();    
  }


  protected function generateFile(){
  
    require_once("DetallesReporteTotalModelClass.php");
	
    $Model     = new DetallesReporteTotalModel();	

	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$cliente_id				= $_REQUEST['cliente_id'];
	$si_cliente				= $_REQUEST['si_cliente'];
	$all_oficina			= $_REQUEST['all_oficina'];


    if ($si_cliente=='' || $si_cliente=='NULL' || $si_cliente==NULL || $si_cliente=='ALL'){
    	$consulta_cliente="";
    }
    else $consulta_cliente=" AND c.cliente_id =".$cliente_id;

	$data  = $Model -> getReporte1($desde,$hasta,$consulta_cliente,$this -> getConex());
		
    $ruta  = $this -> arrayToExcel("ReporTotal","Reporte Total",$data,null);

    if($_REQUEST['download'] == 'SI'){
      $this -> ForceDownload($ruta);
	}else{
       print json_encode(array(ruta => $ruta, errores => $data[0]['validaciones']));
    }
}

  
  protected function generateFileFormato(){
  
	require_once("DetallesReporteTotalLayoutClass.php");
    require_once("DetallesReporteTotalModelClass.php");
		
	$Layout                 = new DetallesReporteTotalLayout();
    $Model                  = new DetallesReporteTotalModel();

	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$cliente_id				= $_REQUEST['cliente_id'];
	$si_cliente				= $_REQUEST['si_cliente'];
	


    if ($si_cliente=='' || $si_cliente=='NULL' || $si_cliente==NULL || $si_cliente=='ALL'){
    	$consulta_cliente="";
    }
    else $consulta_cliente=" AND c.cliente_id =".$cliente_id;

	$Layout -> setReporte1($Model -> getReporte1($desde,$hasta,$consulta_cliente,$this -> getConex()));	
	if($_REQUEST['download'] == 'SI'){
		$Layout -> exportToExcel('DetallesReporteTotal.tpl');
	}
  }


}

$DetallesReporteTotal = new DetallesReporteTotal();

?>