<?php

require_once("../../../framework/clases/ControlerClass.php");
final class Detalles extends Controler{
	
	public function __construct(){
		parent::__construct(3);
	}
	
	
	public function Main($numero_identificacion='',$email=''){
	    
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
	$si_comercial	        = $_REQUEST['si_comercial'];
	$comercial_id	        = $_REQUEST['comercial_id'];
	$cliente	            = $_REQUEST['cliente'];
	$all_oficina			= $_REQUEST['all_oficina'];
	$saldos			        = $_REQUEST['saldos'];
	$saldo			        = $_REQUEST['saldo'];
	$fecha_corte	        = $_REQUEST['fecha_corte'];
	
	
	if($saldos=='1'){
		if($tipo == 'FP'){
			$saldos=" AND ab.fecha BETWEEN '".$desde."'  AND  '".$fecha_corte."' ";
		}else{
			$saldos=" AND f.fecha BETWEEN '".$desde."'  AND  '".$fecha_corte."' ";
		}
		$fecha_corte = "(SELECT DATEDIFF('".$fecha_corte."',f.fecha)) AS dias,";
	}else{
		$saldos='';
		$fecha_corte =" '' AS dias,";
	}

	if($saldo == '1'){
        $consulta="AND f.factura_id NOT IN(SELECT r.factura_id FROM relacion_abono r,abono_factura a
		                                   WHERE r.factura_id=f.factura_id AND r.abono_factura_id = a.abono_factura_id 
										   AND a.estado_abono_factura != 'I' 
										   AND (SELECT SUM(r.rel_valor_abono)-(SELECT SUM(d.valor_liquida) 
										        FROM detalle_factura_puc d WHERE d.factura_id = r.factura_id AND d.contra_factura=1) 
											    FROM relacion_abono r, abono_factura a WHERE r.factura_id = f.factura_id 
												AND r.abono_factura_id = a.abono_factura_id AND a.estado_abono_factura != 'I') = 0 
												GROUP BY r.factura_id)";
	}else if($saldo == '0'){
		$consulta="AND f.factura_id IN(SELECT r.factura_id FROM relacion_abono r, abono_factura a
		                                WHERE r.factura_id=f.factura_id AND r.abono_factura_id = a.abono_factura_id
										AND a.estado_abono_factura != 'I'
										AND (SELECT SUM(r.rel_valor_abono)-(SELECT SUM(d.valor_liquida) 
										        FROM detalle_factura_puc d WHERE d.factura_id = r.factura_id AND d.contra_factura=1) 
											    FROM relacion_abono r, abono_factura a WHERE r.factura_id = f.factura_id 
												AND r.abono_factura_id = a.abono_factura_id AND a.estado_abono_factura != 'I') = 0 
										        GROUP BY r.factura_id)";
	}else if($saldo == 'NULL'){
        $consulta='';
	}
	

   $data = $Model -> getReporteEC1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$fecha_corte,$consulta,$this -> getConex());
   $data = $Model -> getReporteEC_ALL($oficina_id,$desde,$hasta,$saldos,$fecha_corte,$consulta,$this -> getConex());
	
    $Layout -> setIncludes();
	if($tipo=='FP' && $si_cliente==1)
    	$Layout -> setReporteFP1($Model -> getReporteFP1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$this -> getConex()));
	elseif($tipo=='RF' && $si_cliente==1)
		$Layout -> setReporteRF1($Model -> getReporteRF1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$this -> getConex()));	
			
	elseif($tipo=='EC' && $si_cliente==1)
		$Layout -> setReporteEC1($Model -> getReporteEC1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$fecha_corte,$consulta,$this -> getConex()));
		
	elseif($tipo=='PE' && $si_cliente==1)
		$Layout -> setReportePE1($Model -> getReportePE1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$this -> getConex()));
	elseif($tipo=='RP' && $si_cliente==1) 
		$Layout -> setReporteRP1($Model -> getReporteRP1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$this -> getConex())); 		
	elseif($tipo=='CP' && $si_cliente==1) 
		$Layout -> setReporteCP1($Model -> getReporteCP1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$this -> getConex())); 		
	elseif($tipo=='CC' && $si_cliente==1) 
		$Layout -> setReporteCC1($Model -> getReporteCC1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$this -> getConex())); 		
	elseif($tipo=='RE' && $si_cliente==1)
		$Layout -> setReporteRE1($Model -> getReporteRE1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$this -> getConex()));
		
	elseif($tipo=='VE' && $si_cliente==1)
    	$Layout -> setReporteRF1($Model -> getReporteVE1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$this -> getConex()));
			//----------------------------------FILTRO COMERCIAL INICIO
	elseif($tipo=='FP' && $si_comercial==1)
    	$Layout -> setReporteFP1($Model -> getReporteFP1_COM($oficina_id,$desde,$hasta,$comercial_id,$saldos,$this -> getConex()));
	elseif($tipo=='RF' && $si_comercial==1)
    	$Layout -> setReporteRF1($Model -> getReporteRF1_COM($oficina_id,$desde,$hasta,$comercial_id,$saldos,$this -> getConex()));
	elseif($tipo=='RE' && $si_comercial==1)
    	$Layout -> setReporteRE1($Model -> getReporteRE1_COM($oficina_id,$desde,$hasta,$comercial_id,$saldos,$this -> getConex()));	
		
	elseif($tipo=='PE' && $si_comercial==1)
		$Layout -> setReportePE1($Model -> getReportePE1_COM($oficina_id,$desde,$hasta,$comercial_id,$saldos,$fecha_corte,$this -> getConex()));
	elseif($tipo=='VE' && $si_comercial==1)
    	$Layout -> setReporteRF1($Model -> getReporteVE1_COM($oficina_id,$desde,$hasta,$comercial_id,$saldos,$this -> getConex()));


//-------------------------------FILTRO COMERCIAL FIN 

	elseif($tipo=='FP' && $si_cliente=='ALL')
		$Layout -> setReporteFP_ALL($Model -> getReporteFP_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex()));	
	elseif($tipo=='RF' && $si_cliente=='ALL')
    	$Layout -> setReporteRF_ALL($Model -> getReporteRF_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex()));	
		
	elseif($tipo=='EC' && $si_cliente=='ALL')
		$Layout -> setReporteEC_ALL($Model -> getReporteEC_ALL($oficina_id,$desde,$hasta,$saldos,$fecha_corte,$consulta,$this -> getConex()));
	elseif($tipo=='PE' && $si_cliente=='ALL') 
		$Layout -> setReportePE_ALL($Model -> getReportePE_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex()));

	elseif($tipo=='RP' && $si_cliente=='ALL') 
		$Layout -> setReporteRP_ALL($Model -> getReporteRP_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex()));
		
	elseif($tipo=='CP' && $si_cliente=='ALL') 
		$Layout -> setReporteCP_ALL($Model -> getReporteCP_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex()));
		
	elseif($tipo=='CC' && $si_cliente=='ALL') 
		$Layout -> setReporteCC_ALL($Model -> getReporteCC_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex())); 
		
	elseif($tipo=='RE' && $si_cliente=='ALL')
    	$Layout -> setReporteRE_ALL($Model -> getReporteRE_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex()));	

	elseif($tipo=='VE' && $si_cliente=='ALL')
    	$Layout -> setReporteRF_ALL($Model -> getReporteVE_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex()));	

	 $download = $this -> requestData('download');
	
	if($download == 'true'){
	    $Layout -> exportToExcel('detalles.tpl',"Reporte Facturacion.xslx"); 		
	}else{	
		 if($email!='true'){
 			$Layout -> RenderMain();
		}else{
			$Layout -> RenderPdfInd($numero_identificacion);
		 }
		 
	  }
    
  }

  function enviar(){
	  
	require_once("DetallesLayoutClass.php");
    require_once("DetallesModelClass.php");

    $Model      	= new DetallesModel();	
	$Layout         = new DetallesLayout();
	
	$tipo 					= $_REQUEST['tipo'];
	$oficina_id				= $_REQUEST['oficina_id'];
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_cliente				= $_REQUEST['si_cliente'];
	$cliente_id				= $_REQUEST['cliente_id'];
	$cliente	            = $_REQUEST['cliente'];
	$all_oficina			= $_REQUEST['all_oficina'];
	$saldos			        = $_REQUEST['saldos'];
	$saldo			        = $_REQUEST['saldo'];
	$fecha_corte	        = $_REQUEST['fecha_corte'];


	if($saldos=='1'){
		$saldos=" AND f.fecha BETWEEN '".$desde."'  AND  '".$fecha_corte."' ";
		$fecha_corte = "(SELECT DATEDIFF('".$fecha_corte."',f.fecha)) AS dias,";
	}else{
		$saldos='';
		$fecha_corte =" '' AS dias,";
	}

	if($saldo == '1'){
        $consulta="AND f.factura_id NOT IN(SELECT r.factura_id FROM relacion_abono r,abono_factura a
		                                   WHERE r.factura_id=f.factura_id AND r.abono_factura_id = a.abono_factura_id 
										   AND a.estado_abono_factura != 'I' 
										   AND (SELECT SUM(r.rel_valor_abono)-(SELECT SUM(d.valor_liquida) 
										        FROM detalle_factura_puc d WHERE d.factura_id = r.factura_id AND d.contra_factura=1) 
											    FROM relacion_abono r, abono_factura a WHERE r.factura_id = f.factura_id 
												AND r.abono_factura_id = a.abono_factura_id AND a.estado_abono_factura != 'I') = 0 
												GROUP BY r.factura_id)";
	}else if($saldo == '0'){
		$consulta="AND f.factura_id IN(SELECT r.factura_id FROM relacion_abono r, abono_factura a
		                                WHERE r.factura_id=f.factura_id AND r.abono_factura_id = a.abono_factura_id
										AND a.estado_abono_factura != 'I'
										AND (SELECT SUM(r.rel_valor_abono)-(SELECT SUM(d.valor_liquida) 
										        FROM detalle_factura_puc d WHERE d.factura_id = r.factura_id AND d.contra_factura=1) 
											    FROM relacion_abono r, abono_factura a WHERE r.factura_id = f.factura_id 
												AND r.abono_factura_id = a.abono_factura_id AND a.estado_abono_factura != 'I') = 0 
										        GROUP BY r.factura_id)";
	}else if($saldo == 'NULL'){
        $consulta='';
	}

	
	
	if($tipo=='EC' && $si_cliente==1){

			$data = $Model -> getReporteEC1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$fecha_corte,$consulta,$this -> getConex());
			$dataEmpresa = $Model -> getEmpresa($this->getEmpresaId(),$this -> getConex());
	
			$numero_identificacion = $data[0]['factura'][0]['numero_identificacion'].'_'.date('Ymd_Hi');
			$correo = $data[0]['factura'][0]['email'];
			$factura_id = $data[0]['factura'][0]['factura_id'];
			$cliente = $data[0]['factura'][0]['cliente'];
			$empresa = $dataEmpresa[0]['nombre'];

			for($i=0;$i<count($data);$i++){
			   $valor_factura = $data[$i]['factura'][$i]['valor_pendiente'];
			   $valor+=$valor_factura;
			}
			
			$valor_letras = $this -> num2letras($valor);
			
            $this -> Main($numero_identificacion,$email='true');
			$email = $Model -> enviarCartas($factura_id,$cliente,$empresa,$numero_identificacion,$correo,$desde,$hasta,$fecha_corte,$valor,$valor_letras,$this -> getConex());
		    
			if($email){
			   exit("true");
		    }else{
			   exit("Error : ".$Model -> GetError());
		    }	
	}else{
		exit("¡Por favor seleccione un cliente!");
	}
  }

}

$Detalles = new Detalles();

?>