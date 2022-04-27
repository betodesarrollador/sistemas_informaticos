<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reporteEdadesModel extends Db{

  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
   public function GetOficina($Conex){
	return $this -> DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina",$Conex,$ErrDb = false);
   }

   public function GetTipo($Conex){
	$opciones=array(0=>array('value'=>'MC','text'=>'MANIFIESTO'),1=>array('value'=>'DU','text'=>'DESPACHOS URBANOS'));
	return $opciones;
   }

   public function GetSi_Pro($Conex){
	$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
	return $opciones;
   }
   
    public function GetSi_Pro2($Conex){
	$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
	return $opciones;
   }
   
  public function getReporteMC1($oficina_id,$desde,$hasta,$estado,$Conex){ 	   	
 
    if($estado=='P'){
	  $consul_est =" AND am.estado='P' ";
    }else{
	  $consul_est ="";
    }

	$select = "SELECT 'MC' AS tipo_documento,(m.manifiesto) AS numero_documento,		
		(SELECT CONCAT_WS(encabezado_registro_id,consecutivo) FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso,
		IF(am.estado='A','ANULADO',IF(am.legalizacion_manifiesto_id>0 OR am.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT nombre FROM oficina  WHERE oficina_id=am.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),am.fecha_egreso) AS dias,		
		date(am.fecha_egreso) AS fecha_anticipo,
		(SELECT placa FROM vehiculo WHERE placa_id=m.placa_id) AS placa,
		am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor
		
		FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
		AND m.fecha_mc BETWEEN '$desde' AND '$hasta'";		  
	
	$results = $this -> DbFetchAll($select,$Conex);
	return $results;
  } 
  
  public function getReporteDU1($oficina_id,$desde,$hasta,$estado,$Conex){ 
	   	
	  $select = "SELECT 'DU' AS tipo_documento,(SELECT CONCAT_WS(du.despachos_urbanos_id,du.despacho)) AS numero_documento, 
		IF(adu.estado='A','ANULADO',IF(adu.legalizacion_despacho_id>0 OR adu.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT CONCAT_WS(encabezado_registro_id,consecutivo) FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, 
		date(adu.fecha_egreso) AS fecha_anticipo,	
		adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
		du.placa AS placa,
		(SELECT nombre FROM oficina  WHERE oficina_id=adu.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),adu.fecha_egreso) AS dias
		
		FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
	    AND du.fecha_du BETWEEN '$desde' AND '$hasta' ORDER BY du.placa_id";
	  //echo  $select;
	  $results = $this -> DbFetchAll($select,$Conex);
	  return $results;
  } 
  
  
  public function getReporteMC2($oficina_id,$desde,$hasta,$tenedor_id,$estado,$Conex){
	  		 
	  $select = "SELECT 'MC' AS tipo_documento,(m.manifiesto) AS numero_documento,		
		(SELECT CONCAT_WS(encabezado_registro_id,consecutivo) FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso,
		IF(am.estado='A','ANULADO',IF(am.legalizacion_manifiesto_id>0 OR am.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT nombre FROM oficina  WHERE oficina_id=am.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),am.fecha_egreso) AS dias,		
		date(am.fecha_egreso) AS fecha_anticipo,
		(SELECT placa FROM vehiculo WHERE placa_id=m.placa_id) AS placa,
		am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor
		
	  FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
	  AND m.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.tenedor_id IN ($tenedor_id) ORDER BY m.placa_id";	
	  //echo $select;
	  
	  $results = $this -> DbFetchAll($select,$Conex);
	  return $results;	  
   }  
   
  public function getReporteDU2($oficina_id,$desde,$hasta,$tenedor_id,$estado,$Conex){
	  		 
	  $select = "SELECT 'DU' AS tipo_documento,(SELECT CONCAT_WS(du.despachos_urbanos_id,du.despacho)) AS numero_documento, 		
		IF(adu.estado='A','ANULADO',IF(adu.legalizacion_despacho_id>0 OR adu.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT CONCAT_WS(encabezado_registro_id,consecutivo) FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, 		
		date(adu.fecha_egreso) AS fecha_anticipo,							
		 adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
		du.placa AS placa,
		(SELECT nombre FROM oficina  WHERE oficina_id=adu.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),adu.fecha_egreso) AS dias
		
		FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
	  AND du.despachos_urbanos_id = du.despachos_urbanos_id AND du.fecha_du BETWEEN '$desde' AND '$hasta' AND du.tenedor_id IN ($tenedor_id) ORDER BY du.placa_id";	
	  
	  $results = $this -> DbFetchAll($select,$Conex);
	  return $results;	  
   } 
   
 
  public function getReporteMC3($oficina_id,$desde,$hasta,$vehiculo_id,$estado,$Conex){
	 
	  $select = "SELECT 'MC' AS tipo_documento,(m.manifiesto) AS numero_documento,		
		(SELECT CONCAT_WS(encabezado_registro_id,consecutivo) FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso,
		IF(am.estado='A','ANULADO',IF(am.legalizacion_manifiesto_id>0 OR am.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT nombre FROM oficina  WHERE oficina_id=am.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),am.fecha_egreso) AS dias,		
		date(am.fecha_egreso) AS fecha_anticipo,
		(SELECT placa FROM vehiculo WHERE placa_id=m.placa_id) AS placa,
		am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor
		
		FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
	  AND m.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND am.oficina_id IN ($oficina_id) AND m.placa_id =$vehiculo_id AND am.devolucion=0 ORDER BY m.placa_id";	
	  
	  $results = $this -> DbFetchAll($select,$Conex);
	  return $results;	  
	}
	
  public function getReporteDU3($oficina_id,$desde,$hasta,$vehiculo_id,$estado,$Conex){
	 
	  $select = "SELECT 'DU' AS tipo_documento,(SELECT CONCAT_WS(du.despachos_urbanos_id,du.despacho)) AS numero_documento, 		
		IF(adu.estado='A','ANULADO',IF(adu.legalizacion_despacho_id>0 OR adu.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,		
		(SELECT CONCAT_WS(encabezado_registro_id,consecutivo) FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, 
		date(adu.fecha_egreso) AS fecha_anticipo,	
		adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
		du.placa AS placa, 
		(SELECT nombre FROM oficina  WHERE oficina_id=adu.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),adu.fecha_egreso) AS dias

		
		FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
	  AND du.despachos_urbanos_id = du.despachos_urbanos_id AND du.fecha_du BETWEEN '$desde' AND '$hasta' AND du.placa_id IN($vehiculo_id) ORDER BY du.placa_id";
	  
	  $results = $this -> DbFetchAll($select,$Conex);
	  return $results;	  
	}
	

  public function getReporteMC4($oficina_id,$desde,$hasta,$vehiculo_id,$tenedor_id,$estado,$Conex){
	 
	  $select = "SELECT 'MC' AS tipo_documento,(SELECT CONCAT_WS(m.manifiesto_id,m.manifiesto)) AS numero_documento, 
		IF(am.estado='A','ANULADO',IF(am.legalizacion_manifiesto_id>0 OR am.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
        (SELECT CONCAT_WS(encabezado_registro_id,consecutivo) FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso, 
		date(am.fecha_egreso) AS fecha_anticipo,	
		am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor, 
		m.placa AS placa,
		DATEDIFF(CURDATE(),am.fecha_egreso) AS dias,
		(SELECT nombre FROM oficina  WHERE oficina_id=am.oficina_id) AS oficina
		
	  FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
	  AND m.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.tenedor_id IN($tenedor_id) AND m.placa_id IN($vehiculo_id) ORDER BY m.placa_id";		
	  
	  $results = $this -> DbFetchAll($select,$Conex);
	  return $results;	  
	}
	
  public function getReporteDU4($oficina_id,$desde,$hasta,$vehiculo_id,$tenedor_id,$estado,$Conex){
	 
	  $select = "SELECT 'DU' AS tipo_documento,(SELECT CONCAT_WS(du.despachos_urbanos_id,du.despacho)) AS numero_documento, 		
		IF(adu.estado='A','ANULADO',IF(adu.legalizacion_despacho_id>0 OR adu.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,		
		(SELECT CONCAT_WS(encabezado_registro_id,consecutivo) FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, 
		date(adu.fecha_egreso) AS fecha_anticipo,	
		adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
		du.placa AS placa, 
		(SELECT nombre FROM oficina  WHERE oficina_id=adu.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),adu.fecha_egreso) AS dias
		
	  
	  FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
	  AND du.despachos_urbanos_id = du.despachos_urbanos_id AND du.fecha_du BETWEEN '$desde' AND '$hasta' AND du.placa_id IN($vehiculo_id) AND du.tenedor_id IN($tenedor_id) ORDER BY du.placa_id";
	  
	  $results = $this -> DbFetchAll($select,$Conex);
	  return $results;	  
	}
	

  public function getReporteALL($oficina_id,$desde,$hasta,$si_vehiculo,$vehiculo_id,$si_tenedor,$tenedor_id,$estado,$Conex){
	  if($si_vehiculo==1){
			$consul_ved=" AND adu.placa_id=$vehiculo_id ";
			$consul_vem=" AND am.placa_id=$vehiculo_id ";			
			$consul_vep=" AND ap.placa_id=$vehiculo_id ";						
		  
	  }else{
			$consul_ved="";
			$consul_vem="";			
			$consul_vep="";						
	  }

	  if($si_tenedor==1){
			$consul_ted=" AND adu.tenedor_id=$tenedor_id ";
			$consul_tem=" AND am.tenedor_id=$tenedor_id ";			
			$consul_tep=" AND ap.tenedor_id=$tenedor_id ";						
		  
	  }else{
			$consul_ted="";
			$consul_tem="";			
			$consul_tep="";						
	  }
	  if($estado=='P'){
		  $consul_estp =" AND  ap.estado='P' ";
		  $consul_estm =" AND am.estado='P' ";
		  $consul_estd =" AND adu.estado='P' ";
		  
	  }else{
		  $consul_estp ="";
		  $consul_estm ="";
		  $consul_estd ="";
		  
	  }

	  $select = "(SELECT 
	  'AP' AS tipo_documento, 
	  'N/A' AS numero_planilla, 
 	  'N/A' AS fecha_planilla, 
	  'N/A' AS   estado_planilla,
	  
	  (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = ap.encabezado_registro_id) AS numero_egreso,
	   ap.fecha AS fecha_anticipo, 
	  (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') FROM encabezado_de_registro WHERE encabezado_registro_id = ap.encabezado_registro_id) AS estado_contable,	   
	   ap.valor AS valor,
	  CASE ap.estado WHEN 'L' THEN 'LEGALIZADO' WHEN 'P' THEN 'PENDIENTE' WHEN 'A' THEN 'ANULADO' WHEN 'E' THEN 'ENTREGADO' END AS estado_anticipo,
	  (SELECT placa FROM vehiculo WHERE placa_id = ap.placa_id) AS placa, 
	  ap.conductor AS conductor, 
	  ap.tenedor AS tenedor,
	 (SELECT SUM(atp.valor) FROM  anticipos_placa atp WHERE atp.sub_anticipos_placa_id=ap.anticipos_placa_id AND atp.devolucion=1 AND atp.estado!='A' ) AS devoluciones,
	 (SELECT SUM(ra.rel_valor_abono_anticipo) FROM  relacion_anticipos_abono ra, abono_factura_proveedor af WHERE ra.anticipos_placa_id=ap.anticipos_placa_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='C') AS abonos,
	 (SELECT SUM(ra.rel_valor_abono_anticipo) FROM  relacion_anticipos_abono ra, abono_factura_proveedor af WHERE ra.anticipos_placa_id=ap.anticipos_placa_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='A') AS abonos_nocontabilizados,
	 (SELECT GROUP_CONCAT(e.consecutivo) FROM  relacion_anticipos_abono ra, abono_factura_proveedor af, encabezado_de_registro e WHERE ra.anticipos_placa_id=ap.anticipos_placa_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='C' AND e.encabezado_registro_id=af.encabezado_registro_id) AS relacion_cruces	 	 
 
	  FROM anticipos_placa ap 
	  WHERE ap.fecha BETWEEN '$desde' AND '$hasta' AND ap.oficina_id IN ($oficina_id) 
	  $consul_vep $consul_tep $consul_estp AND ap.devolucion=0 ORDER BY fecha_anticipo)
	  
	  UNION
	  
	  (SELECT 
	   'DU' AS tipo_documento, 
	   du.despacho AS numero_planilla, 
	   du.fecha_du AS fecha_planilla, 
	  CASE du.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_planilla,
	  (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, 
	   date(adu.fecha_egreso) AS fecha_anticipo,
   	  (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') AS estado_encabezado FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS estado_contable, 
	   adu.valor AS valor, 
	  CASE adu.estado WHEN 'L' THEN 'LEGALIZADO' WHEN 'P' THEN 'PENDIENTE' WHEN 'A' THEN 'ANULADO' WHEN 'E' THEN 'ENTREGADO' END AS estado_anticipo,	
	  (SELECT placa FROM vehiculo WHERE placa_id = adu.placa_id) AS placa, 
	  adu.conductor AS conductor, 	  
	  adu.tenedor AS tenedor,
	 (SELECT SUM(atp.valor) FROM  anticipos_despacho atp WHERE atp.sub_anticipos_despacho_id=adu.anticipos_despacho_id AND atp.devolucion=1 AND atp.estado!='A' ) AS devoluciones,
	 (SELECT SUM(ra.rel_valor_abono_anticipo) FROM  relacion_anticipos_abono ra, abono_factura_proveedor af WHERE ra.anticipos_despacho_id=adu.anticipos_despacho_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='C') AS abonos,
	 (SELECT SUM(ra.rel_valor_abono_anticipo) FROM  relacion_anticipos_abono ra, abono_factura_proveedor af WHERE ra.anticipos_despacho_id=adu.anticipos_despacho_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='A') AS abonos_nocontabilizados,
	 (SELECT GROUP_CONCAT(e.consecutivo) FROM  relacion_anticipos_abono ra, abono_factura_proveedor af, encabezado_de_registro e WHERE ra.anticipos_despacho_id=adu.anticipos_despacho_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='C' AND e.encabezado_registro_id=af.encabezado_registro_id) AS relacion_cruces	 	 
	 
	  FROM anticipos_despacho adu ,despachos_urbanos du 
	  WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id  AND du.despachos_urbanos_id = du.despachos_urbanos_id  AND adu.oficina_id IN ($oficina_id) 
	  AND du.fecha_du BETWEEN '$desde' AND '$hasta' $consul_ved $consul_ted $consul_estd AND adu.devolucion=0 ORDER BY fecha_anticipo)
	  
	  UNION
	  
	  (SELECT 
	   'MC' AS tipo_documento, 
	   m.manifiesto AS numero_planilla,
	   m.fecha_mc AS fecha_planilla, 
	  CASE m.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_planilla,
	  (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso,
	  date(am.fecha_egreso) AS fecha_anticipo,
	  (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') AS estado_encabezado FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS estado_contable, 
	  am.valor AS valor, 
	  CASE am.estado WHEN 'L' THEN 'LEGALIZADO' WHEN 'P' THEN 'PENDIENTE' WHEN 'A' THEN 'ANULADO' WHEN 'E' THEN 'ENTREGADO' END AS estado_anticipo,
	  m.placa AS placa, 
	  am.conductor AS conductor, 
	  am.tenedor AS tenedor,
	 (SELECT SUM(atp.valor) FROM  anticipos_manifiesto atp WHERE atp.sub_anticipos_manifiesto_id=am.anticipos_manifiesto_id AND atp.devolucion=1 AND atp.estado!='A' ) AS devoluciones,
	 (SELECT SUM(ra.rel_valor_abono_anticipo) FROM  relacion_anticipos_abono ra, abono_factura_proveedor af WHERE ra.anticipos_manifiesto_id=am.anticipos_manifiesto_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='C') AS abonos,
	 (SELECT SUM(ra.rel_valor_abono_anticipo) FROM  relacion_anticipos_abono ra, abono_factura_proveedor af WHERE ra.anticipos_manifiesto_id=am.anticipos_manifiesto_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='A') AS abonos_nocontabilizados,
	 (SELECT GROUP_CONCAT(e.consecutivo) FROM  relacion_anticipos_abono ra, abono_factura_proveedor af, encabezado_de_registro e WHERE ra.anticipos_manifiesto_id=am.anticipos_manifiesto_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='C' AND e.encabezado_registro_id=af.encabezado_registro_id) AS relacion_cruces	 
	 
	  FROM anticipos_manifiesto am ,manifiesto m 
	  WHERE am.manifiesto_id = m.manifiesto_id  AND m.manifiesto_id = m.manifiesto_id  AND am.oficina_id IN ($oficina_id) 
	  AND m.fecha_mc BETWEEN '$desde' AND '$hasta' $consul_vem $consul_tem $consul_estm AND am.devolucion=0  ORDER BY fecha_anticipo)";
	  //echo $select;
	  $results = $this -> DbFetchAll($select,$Conex);
	  return $results;
	} 	


}

?>