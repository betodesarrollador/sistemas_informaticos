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
    $tipo 					= $_REQUEST['tipo'];
	$oficina_id				= $_REQUEST['oficina_id'];
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_proveedor			= $_REQUEST['si_proveedor'];
	$proveedor_id			= $_REQUEST['proveedor_id'];
	$proveedor	            = $_REQUEST['proveedor'];	
	$all_oficina			= $_REQUEST['all_oficina'];
	$tipo_documento_id		= $_REQUEST['tipo_documento_id'];
	$all_docs				= $_REQUEST['all_docs'];
	$puc_id					= $_REQUEST['puc_id'];
	$all_ctas				= $_REQUEST['all_ctas'];
	$download				= $_REQUEST['download'];
	$saldos			= $_REQUEST['saldos'];
	
	if($saldos=='S'){
		$saldos=" AND ab.fecha BETWEEN '".$desde."'  AND  '".$hasta."' ";
	}else{
		$saldos='';
	}

	if($saldo == 'S'){
        $consulta="AND f.factura_id NOT IN(SELECT r.factura_proveedor_id FROM relacion_abono_factura r,abono_factura_proveedor a
		                                   WHERE r.factura_proveedor_id=f.factura_proveedor_id AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id 
										   AND a.estado_abono_factura != 'I' 
										   AND (SELECT SUM(r.rel_valor_abono_factura)-(SELECT SUM(d.cre_item_factura_proveedor) 
										        FROM item_factura_proveedor d WHERE d.factura_proveedor_id = r.factura_proveedor_id) 
											    FROM relacion_abono_factura r, abono_factura_proveedor a WHERE r.factura_proveedor_id = f.factura_proveedor_id 
												AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id AND a.estado_abono_factura != 'I') = 0 
												GROUP BY r.factura_proveedor_id)";
	}else if($saldo == 'N'){
		$consulta="AND f.factura_id IN(SELECT r.factura_proveedor_id FROM relacion_abono_factura r, abono_factura_proveedor a
		                                WHERE r.factura_proveedor_id=f.factura_proveedor_id AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id
										AND a.estado_abono_factura != 'I'
										AND (SELECT SUM(r.rel_valor_abono_factura)-(SELECT SUM(d.cre_item_factura_proveedor) 
										        FROM item_factura_proveedor d WHERE d.factura_proveedor_id = r.factura_proveedor_id) 
											    FROM relacion_abono_factura r, abono_factura_proveedor a WHERE r.factura_proveedor_id = f.factura_proveedor_id 
												AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id AND a.estado_abono_factura != 'I') = 0 
										        GROUP BY r.factura_proveedor_id)";
	}else if($saldo == 'NULL'){
        $consulta='';
	}
	
	if($all_docs=='NO'){
		$tipo_documento_id=" AND f.encabezado_registro_id IN (SELECT encabezado_registro_id FROM encabezado_de_registro WHERE tipo_documento_id IN ($tipo_documento_id))";
	}else{
		$tipo_documento_id='';
	}
	
	if($all_ctas=='NO'){
		$puc_id=" AND f.factura_proveedor_id IN (SELECT factura_proveedor_id FROM item_factura_proveedor WHERE puc_id IN ($puc_id)) ";
	}else{
		$puc_id='';
	}


	
    $Layout -> setIncludes();
	if($tipo=='FP' && $si_proveedor==1)
    	$Layout -> setReporteFP1($Model -> getReporteFP1($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$proveedor_id,$saldos,$this -> getConex()));	
	elseif($tipo=='RF' && $si_proveedor==1)
    	$Layout -> setReporteRF1($Model -> getReporteRF1($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$proveedor_id,$saldos,$this -> getConex()));	
	elseif($tipo=='EC' && $si_proveedor==1)
		$Layout -> setReporteEC1($Model -> getReporteEC1($oficina_id,$desde,$hasta,$proveedor_id,$saldos,$puc_id,$tipo_documento_id,$consulta,$this -> getConex()));
	elseif($tipo=='PE' && $si_proveedor==1)
		$Layout -> setReportePE1($Model -> getReportePE1($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$proveedor_id,$saldos,$this -> getConex()));
	elseif($tipo=='RC' && $si_proveedor==1)
    	$Layout -> setReporteRF1($Model -> getReporteRC1($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$proveedor_id,$saldos,$this -> getConex()));	
	elseif($tipo=='SP' && $si_proveedor==1)
    	$Layout -> setReporteSP1($Model -> getReporteSP1($oficina_id,$desde,$hasta,$proveedor_id,$this -> getConex()));	
	elseif($tipo=='RS' && $si_proveedor==1)
    	$Layout -> setReporteRS1($Model -> getReporteRS1($oficina_id,$desde,$hasta,$proveedor_id,$this -> getConex()));	
	
		

	elseif($tipo=='FP' && $si_proveedor=='ALL')
    	$Layout -> setReporteFP_ALL($Model -> getReporteFP_ALL($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$saldos,$this -> getConex()));	
	elseif($tipo=='RF' && $si_proveedor=='ALL')
    	$Layout -> setReporteRF_ALL($Model -> getReporteRF_ALL($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$saldos,$this -> getConex()));	
		
	elseif($tipo=='EC' && $si_proveedor=='ALL')
		$Layout -> setReporteEC_ALL($Model -> getReporteEC_ALL($oficina_id,$desde,$hasta,$saldos,$puc_id,$tipo_documento_id,$consulta,$this -> getConex()));
	elseif($tipo=='PE' && $si_proveedor=='ALL')
		$Layout -> setReportePE_ALL($Model -> getReportePE_ALL($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$saldos,$this -> getConex()));
	elseif($tipo=='RC' && $si_proveedor=='ALL')
    	$Layout -> setReporteRC_ALL($Model -> getReporteRC_ALL($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$saldos,$this -> getConex()));	
	elseif($tipo=='RS' && $si_proveedor=='ALL')
    	$Layout -> setReporteRS_ALL($Model -> getReporteRS_ALL($oficina_id,$desde,$hasta,$this -> getConex()));	
	elseif($tipo=='SP' && $si_proveedor=='ALL')
    	$Layout -> setReporteSP_ALL($Model -> getReporteSP_ALL($oficina_id,$desde,$hasta,$this -> getConex()));	
		

		if($download == 'true'){
	    $Layout -> exportToExcel('detallesExcel.tpl'); 		
		}else{	
		  $Layout -> RenderMain();
	  }
    
    
  }
}

$Detalles = new Detalles();

?>