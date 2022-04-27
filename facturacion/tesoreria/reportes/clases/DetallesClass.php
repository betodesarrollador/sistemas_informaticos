<?php

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
	$oficina_id				= $_REQUEST['oficina_id'];
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$estado					= $_REQUEST['estado'];
	$all_oficina			= $_REQUEST['all_oficina'];
	
    $Layout -> setIncludes();
	if($estado=='E')
    	$Layout -> setReporteE1($Model -> getReporteE1($oficina_id,$desde,$hasta,$estado,$this -> getConex()));	
	elseif($estado=='A')
    	$Layout -> setReporteA1($Model -> getReporteA1($oficina_id,$desde,$hasta,$estado,$this -> getConex()));	 		
	elseif($estado=='C')
		$Layout -> setReporteC1($Model -> getReporteC1($oficina_id,$desde,$hasta,$estado,$this -> getConex()));
	elseif($estado=='ALL')
		$Layout -> setReporteALL1($Model -> getReporteALL1($oficina_id,$desde,$hasta,$estado,$this -> getConex()));

	$Layout -> RenderMain();
    
  }
  protected function generateFileexcel(){
  
    require_once("DetallesModelClass.php");
	
    $Model                  = new DetallesModel();
	$oficina_id				= $_REQUEST['oficina_id'];
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$estado					= $_REQUEST['estado'];
	
	if($estado=='E')
    	$data= $Model -> getReporteE1($oficina_id,$desde,$hasta,$estado,$this -> getConex());	
	elseif($estado=='A')
    	$data= $Model -> getReporteA1($oficina_id,$desde,$hasta,$estado,$this -> getConex());	 		
	elseif($estado=='C')
		$data= $Model -> getReporteC1($oficina_id,$desde,$hasta,$estado,$this -> getConex());
	elseif($estado=='ALL')
		$data= $Model -> getReporteALL1($oficina_id,$desde,$hasta,$estado,$this -> getConex());
	
    $ruta  = $this -> arrayToExcel("Reportes","reporte",$data,null,"string");
	
    $this -> ForceDownload($ruta,'reportearqueos.xls');
	  
  }
}
$Detalles = new Detalles();

?>