<?php
require_once("../../../framework/clases/ControlerClass.php");
final class DetallesReporteGuiasInter extends Controler{

  public function __construct(){
	parent::__construct(3);
  }
  
  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesReporteGuiasInterLayoutClass.php");
    require_once("DetallesReporteGuiasInterModelClass.php");
		
	$Layout                 		= new DetallesReporteGuiasInterLayout();
    $Model                  		= new DetallesReporteGuiasInterModel();	
	$desde							= $_REQUEST['desde'];
	$hasta							= $_REQUEST['hasta'];
	$origen  						= $_REQUEST['origen'];
	$origen_id						= $_REQUEST['origen_id'];
	$destino  						= $_REQUEST['destino'];
	$destino_id						= $_REQUEST['destino_id'];
	$estado_id						= $_REQUEST['estado_id'];
	$cliente_id						= $_REQUEST['cliente_id'];
	$tipo_servicio_mensajeria_id	= $_REQUEST['tipo_servicio_mensajeria_id'];

	$si_cliente				= $_REQUEST['si_cliente'];
	$all_estado				= $_REQUEST['all_estado'];
	$all_servicio			= $_REQUEST['all_servicio'];	

	$oficina_id				= $_REQUEST['oficina_id'];
	$all_oficina			= $_REQUEST['all_oficina'];

    $Layout -> setIncludes();
    if ($origen=='' || $origen=='NULL' || $origen==NULL){
    	$consulta_origen="";
    }
    else $consulta_origen=" AND g.origen_id=".$origen_id;

    if ($destino=='' || $destino=='NULL' || $destino==NULL){
    	$consulta_destino="";
    }
    else $consulta_destino=" AND g.destino_id=".$destino_id;

    if ($si_cliente=='' || $si_cliente=='NULL' || $si_cliente==NULL || $si_cliente=='ALL'){
    	$consulta_cliente="";
    }
    else $consulta_cliente=" AND g.cliente_id =".$cliente_id;

    if ($all_oficina=='' || $all_oficina=='NULL' || $all_oficina==NULL || $all_oficina=='SI'){
    	$consulta_oficina="";
    }
    else $consulta_oficina=" AND g.oficina_id IN (".$oficina_id.") ";

	$Layout -> setReporte1($Model -> getReporte1($desde,$hasta,$consulta_origen,$consulta_destino,$estado_id,$tipo_servicio_mensajeria_id,$consulta_cliente,$consulta_oficina,$this -> getConex()));
	$Layout -> RenderMain();    
  }

  protected function generateFotos(){
  
    require_once("DetallesReporteGuiasInterModelClass.php");
	
    $Model     = new DetallesReporteGuiasInterModel();	

	$desde							= $_REQUEST['desde'];
	$hasta							= $_REQUEST['hasta'];
	$origen  						= $_REQUEST['origen'];
	$origen_id						= $_REQUEST['origen_id'];
	$destino  						= $_REQUEST['destino'];
	$destino_id						= $_REQUEST['destino_id'];
	$estado_id						= $_REQUEST['estado_id'];
	$cliente_id						= $_REQUEST['cliente_id'];
	$tipo_servicio_mensajeria_id	= $_REQUEST['tipo_servicio_mensajeria_id'];
	

	$si_cliente				= $_REQUEST['si_cliente'];
	$all_estado				= $_REQUEST['all_estado'];
	$all_servicio			= $_REQUEST['all_servicio'];		
	$oficina_id				= $_REQUEST['oficina_id'];
	$all_oficina			= $_REQUEST['all_oficina'];


    if ($origen=='' || $origen=='NULL' || $origen==NULL){
    	$consulta_origen="";
    }
    else $consulta_origen=" AND g.origen_id=".$origen_id;

    if ($destino=='' || $destino=='NULL' || $destino==NULL){
    	$consulta_destino="";
    }
    else $consulta_destino=" AND g.destino_id=".$destino_id;

    if ($si_cliente=='' || $si_cliente=='NULL' || $si_cliente==NULL || $si_cliente=='ALL'){
    	$consulta_cliente="";
    }
    else $consulta_cliente=" AND g.cliente_id =".$cliente_id;

    if ($all_oficina=='' || $all_oficina=='NULL' || $all_oficina==NULL || $all_oficina=='SI'){
    	$consulta_oficina="";
    }
    else $consulta_oficina=" AND g.oficina_id IN (".$oficina_id.") ";

	$data  = $Model -> getReporte2($desde,$hasta,$consulta_origen,$consulta_destino,$estado_id,$tipo_servicio_mensajeria_id,$consulta_cliente,$consulta_oficina,$this -> getConex());
	$directorio=$_SERVER['DOCUMENT_ROOT']."/velotax/imagenes/mensajeria/ruta";

	if(is_dir($directorio)){
 		$objects = scandir($directorio);
     	foreach ($objects as $object) { 
       		if ($object != "." && $object != "..") {
         		if (filetype($directorio."/".$object) == "dir"){ rmdir($directorio."/".$object); }else{ unlink($directorio."/".$object);  }
			}
       	}
      
		rmdir($directorio);
		if(is_file($_SERVER['DOCUMENT_ROOT']."/velotax/imagenes/mensajeria/ruta.zip")){
			unlink($_SERVER['DOCUMENT_ROOT']."/velotax/imagenes/mensajeria/ruta.zip");
		}
	}
	mkdir($_SERVER['DOCUMENT_ROOT']."/velotax/imagenes/mensajeria/ruta", 0755);	

	$zip = new ZipArchive();
	$filename = $_SERVER['DOCUMENT_ROOT']."/velotax/imagenes/mensajeria/ruta.zip";
	if($zip->open($filename,ZIPARCHIVE::CREATE)===true) {

		for($i=1;$i<count($data);$i++){
			$replace="http://108.179.239.106/velotax/imagenes/mensajeria/interconexion/";
			
			$archivo=str_replace($replace,"",$data[$i]['foto_cumplido']);
			copy($_SERVER['DOCUMENT_ROOT']."/velotax/imagenes/mensajeria/interconexion/".$archivo,$_SERVER['DOCUMENT_ROOT']."/velotax/imagenes/mensajeria/ruta/".$archivo);
	        $zip->addFile($_SERVER['DOCUMENT_ROOT']."/velotax/imagenes/mensajeria/ruta/".$archivo,$archivo);
		}
        $zip->close();
	}	 	
    //$ruta  = $this -> arrayToExcel("ReporGuias","Guias",$data,null);

    if($_REQUEST['download'] == 'SI'){
      $this -> ForceDownload($filename);
	}
}

  protected function generateFile(){
  
    require_once("DetallesReporteGuiasInterModelClass.php");
	
    $Model     = new DetallesReporteGuiasInterModel();	

	$desde							= $_REQUEST['desde'];
	$hasta							= $_REQUEST['hasta'];
	$origen  						= $_REQUEST['origen'];
	$origen_id						= $_REQUEST['origen_id'];
	$destino  						= $_REQUEST['destino'];
	$destino_id						= $_REQUEST['destino_id'];
	$estado_id						= $_REQUEST['estado_id'];
	$cliente_id						= $_REQUEST['cliente_id'];
	$tipo_servicio_mensajeria_id	= $_REQUEST['tipo_servicio_mensajeria_id'];
	

	$si_cliente				= $_REQUEST['si_cliente'];
	$all_estado				= $_REQUEST['all_estado'];
	$all_servicio			= $_REQUEST['all_servicio'];			
	$oficina_id				= $_REQUEST['oficina_id'];
	$all_oficina			= $_REQUEST['all_oficina'];


    if ($origen=='' || $origen=='NULL' || $origen==NULL){
    	$consulta_origen="";
    }
    else $consulta_origen=" AND g.origen_id=".$origen_id;

    if ($destino=='' || $destino=='NULL' || $destino==NULL){
    	$consulta_destino="";
    }
    else $consulta_destino=" AND g.destino_id=".$destino_id;

    if ($si_cliente=='' || $si_cliente=='NULL' || $si_cliente==NULL || $si_cliente=='ALL'){
    	$consulta_cliente="";
    }
    else $consulta_cliente=" AND g.cliente_id =".$cliente_id;

    if ($all_oficina=='' || $all_oficina=='NULL' || $all_oficina==NULL || $all_oficina=='SI'){
    	$consulta_oficina="";
    }
    else $consulta_oficina=" AND g.oficina_id IN (".$oficina_id.") ";

	$data  = $Model -> getReporte1($desde,$hasta,$consulta_origen,$consulta_destino,$estado_id,$tipo_servicio_mensajeria_id,$consulta_cliente,$consulta_oficina,$this -> getConex());
		
    $ruta  = $this -> arrayToExcel("ReporGuias","Reporte Guias",$data,null);

    if($_REQUEST['download'] == 'SI'){
      $this -> ForceDownload($ruta);
	}else{
       print json_encode(array(ruta => $ruta, errores => $data[0]['validaciones']));
    }
}

  
  protected function generateFileFormato(){
  
	require_once("DetallesReporteGuiasInterLayoutClass.php");
    require_once("DetallesReporteGuiasInterModelClass.php");
		
	$Layout                 = new DetallesReporteGuiasInterLayout();
    $Model                  = new DetallesReporteGuiasInterModel();

	$desde							= $_REQUEST['desde'];
	$hasta							= $_REQUEST['hasta'];
	$origen  						= $_REQUEST['origen'];
	$origen_id						= $_REQUEST['origen_id'];
	$destino  						= $_REQUEST['destino'];
	$destino_id						= $_REQUEST['destino_id'];
	$estado_id						= $_REQUEST['estado_id'];
	$cliente_id						= $_REQUEST['cliente_id'];
	$tipo_servicio_mensajeria_id	= $_REQUEST['tipo_servicio_mensajeria_id'];
	

	$si_cliente				= $_REQUEST['si_cliente'];
	$all_estado				= $_REQUEST['all_estado'];
	$all_servicio			= $_REQUEST['all_servicio'];				
	$oficina_id				= $_REQUEST['oficina_id'];
	$all_oficina			= $_REQUEST['all_oficina'];
	

    if ($origen=='' || $origen=='NULL' || $origen==NULL){
    	$consulta_origen="";
    }
    else $consulta_origen=" AND g.origen_id=".$origen_id;

    if ($destino=='' || $destino=='NULL' || $destino==NULL){
    	$consulta_destino="";
    }
    else $consulta_destino=" AND g.destino_id=".$destino_id;

    if ($si_cliente=='' || $si_cliente=='NULL' || $si_cliente==NULL || $si_cliente=='ALL'){
    	$consulta_cliente="";
    }
    else $consulta_cliente=" AND g.cliente_id =".$cliente_id;

    if ($all_oficina=='' || $all_oficina=='NULL' || $all_oficina==NULL || $all_oficina=='SI'){
    	$consulta_oficina="";
    }
    else $consulta_oficina=" AND g.oficina_id IN (".$oficina_id.") ";

	$Layout -> setReporte1($Model -> getReporte1($desde,$hasta,$consulta_origen,$consulta_destino,$estado_id,$tipo_servicio_mensajeria_id,$consulta_cliente,$consulta_oficina,$this -> getConex()));	
	if($_REQUEST['download'] == 'SI'){
		$Layout -> exportToExcel('DetallesReporteGuiasInterExc.tpl');
	}
  }


}

$DetallesReporteGuiasInter = new DetallesReporteGuiasInter();

?>