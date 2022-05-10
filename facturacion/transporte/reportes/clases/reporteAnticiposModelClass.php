<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reporteAnticiposModel extends Db{

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
	$opciones=array(0=>array('value'=>'MC','text'=>'MANIFIESTOS DE CARGA'),1=>array('value'=>'DU','text'=>'DESPACHOS URBANOS'),/*2 =>array('value'=>'DP','text'=>'DESPACHOS PARTICULARES'),*/
					2 =>array('value'=>'AP','text'=>'ANTICIPOS POR PLACA'));
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
   
  public function getReporteMCE1DUE1APE1($tipo,$oficina_id,$desde,$hasta,$estadomc,$estadodu,$estadoap,$cons_vehm,$cons_vehd,$cons_veha,$cons_tenm,$cons_tend,$cons_tena,$cons_cor,$cons_cor1,$Conex){ 

	$select_mc = "SELECT 'MC' AS tipo_documento,m.manifiesto AS numero_documento, m.tenedor_id,		
		(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso,
		IF(am.estado='A','ANULADO',IF(am.legalizacion_manifiesto_id>0 OR am.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT nombre FROM oficina  WHERE oficina_id=am.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),DATE(am.fecha_egreso)) AS dias,		
		date(am.fecha_egreso) AS fecha_anticipo,
		m.fecha_mc AS fecha_planilla,
		CASE m.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_planilla,		
		(SELECT placa FROM vehiculo WHERE placa_id=m.placa_id) AS placa,
		am.tenedor AS tenedor, am.conductor AS conductor, m.numero_identificacion_tenedor, am.valor AS valor,
		(SELECT SUM(dl.valor) FROM detalle_liquidacion_despacho dl, liquidacion_despacho l WHERE dl.detalle_liquidacion_despacho_id=am.detalle_liquidacion_despacho_id AND l.liquidacion_despacho_id=dl.liquidacion_despacho_id AND l.estado_liquidacion='C' $cons_cor) AS abono,		
		(SELECT SUM(ra.rel_valor_abono_anticipo) FROM relacion_anticipos_abono ra, abono_factura_proveedor af WHERE ra.anticipos_manifiesto_id=am.anticipos_manifiesto_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='C' $cons_cor1) AS abono1		
		
		
		FROM anticipos_manifiesto am ,manifiesto m WHERE am.estado!='L' AND am.devolucion=0 AND am.oficina_id IN ($oficina_id) AND am.encabezado_registro_id IS NOT NULL
		AND (SELECT estado FROM encabezado_de_registro WHERE encabezado_registro_id=am.encabezado_registro_id)='C' AND am.manifiesto_id = m.manifiesto_id 
		AND DATE(am.fecha_egreso)  BETWEEN '$desde' AND '$hasta' $estadomc $cons_vehm $cons_tenm ORDER BY m.tenedor_id ASC, am.fecha_egreso ASC ";		  

	  $select_du = "SELECT 'DU' AS tipo_documento,du.despacho AS numero_documento, du.tenedor_id,
		(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, 
		IF(adu.estado='A','ANULADO',IF(adu.legalizacion_despacho_id>0 OR adu.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT nombre FROM oficina  WHERE oficina_id=adu.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),DATE(adu.fecha_egreso)) AS dias,
		date(adu.fecha_egreso) AS fecha_anticipo,
		du.fecha_du AS fecha_planilla,
		CASE du.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_planilla,		
		(SELECT placa FROM vehiculo WHERE placa_id=du.placa_id) AS placa,		
		adu.tenedor AS tenedor, adu.conductor AS conductor,du.numero_identificacion_tenedor, adu.valor AS valor,
		(SELECT SUM(dl.valor) FROM detalle_liquidacion_despacho dl, liquidacion_despacho l WHERE dl.detalle_liquidacion_despacho_id=adu.detalle_liquidacion_despacho_id AND l.liquidacion_despacho_id=dl.liquidacion_despacho_id AND l.estado_liquidacion='C' $cons_cor) AS abono,		
		(SELECT SUM(ra.rel_valor_abono_anticipo) FROM relacion_anticipos_abono ra, abono_factura_proveedor af WHERE ra.anticipos_despacho_id=adu.anticipos_despacho_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='C' $cons_cor1) AS abono1		
		
		
		FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.estado!='L' AND  adu.devolucion=0 AND  adu.oficina_id IN ($oficina_id) AND adu.encabezado_registro_id IS NOT NULL 
		AND (SELECT estado FROM encabezado_de_registro WHERE encabezado_registro_id=adu.encabezado_registro_id)='C' AND adu.despachos_urbanos_id = du.despachos_urbanos_id 
	    AND adu.fecha_egreso BETWEEN '$desde' AND '$hasta' $estadodu $cons_vehd $cons_tend ORDER BY du.tenedor_id ASC, adu.fecha_egreso ASC";

 	 $select_ap = "SELECT 'AP' AS tipo_documento, ap.consecutivo AS numero_documento, ap.tenedor_id,
	 	(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = ap.encabezado_registro_id) AS numero_egreso,
	 	CASE ap.estado WHEN 'A' THEN 'ANULADO' WHEN 'L' THEN 'LEGALIZADO' WHEN 'P' THEN 'PENDIENTE' ELSE '' END AS estado_anticipo,
	 	(SELECT nombre FROM oficina  WHERE oficina_id=ap.oficina_id) AS oficina,
	 	DATEDIFF(CURDATE(),DATE(ap.fecha)) AS dias,
	 	ap.fecha AS fecha_anticipo, 
	 	'N/A' AS fecha_planilla,
		'N/A' AS estado_planilla,
	 	(SELECT placa FROM vehiculo WHERE placa_id = ap.placa_id) AS placa, 
	  	ap.tenedor AS tenedor,	ap.conductor AS conductor,'' AS numero_identificacion_tenedor,  ap.valor AS valor,
		(SELECT SUM(ra.rel_valor_abono_anticipo) FROM relacion_anticipos_abono ra, abono_factura_proveedor af WHERE ra.anticipos_placa_id=ap.anticipos_placa_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='C') AS abono,		
		(SELECT SUM(ra.rel_valor_abono_anticipo) FROM relacion_anticipos_abono ra, abono_factura_proveedor af WHERE ra.anticipos_placa_id=ap.anticipos_placa_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='C' $cons_cor1) AS abono1		
		
		
		FROM anticipos_placa ap WHERE ap.estado!='L' AND ap.devolucion=0 AND ap.oficina_id IN ($oficina_id) AND ap.encabezado_registro_id IS NOT NULL   
		AND ap.fecha BETWEEN '$desde' AND '$hasta' $estadoap $cons_veha $cons_tena ORDER BY  ap.tenedor_id ASC, ap.fecha ASC ";
		
		if($tipo=='MC'){ $select=$select_mc; }elseif($tipo=='DU'){ $select=$select_du; }elseif($tipo=='AP'){  $select=$select_ap;  }

		if($tipo=='MC,DU,AP'){ 
			$select="(".$select_mc.") UNION ALL (".$select_du.") UNION ALL (".$select_ap.") ORDER BY tenedor_id, fecha_anticipo ASC"; 
		}elseif($tipo=='MC,DU'){ 
			$select="(".$select_mc.") UNION ALL (".$select_du.")  ORDER BY tenedor_id, fecha_anticipo ASC"; 
		}elseif($tipo=='DU,AP'){  
			$select="(".$select_du.") UNION ALL (".$select_ap.") ORDER BY tenedor_id, fecha_anticipo ASC"; 
		}elseif($tipo=='MC,AP'){  
			$select="(".$select_mc.") UNION ALL (".$select_ap.") ORDER BY tenedor_id, fecha_anticipo ASC"; 
		}

		$results = $this -> DbFetchAll($select,$Conex,true);

		return $results;
  } 

  public function getReporteTOTAL($tipo,$oficina_id,$desde,$hasta,$estadomc,$estadodu,$estadoap,$cons_vehm,$cons_vehd,$cons_veha,$cons_tenm,$cons_tend,$cons_tena,$cons_cor,$cons_cor1,$Conex){ 

	$select_mc = "SELECT 'MC' AS tipo_documento,m.manifiesto AS numero_documento, m.tenedor_id,		
		(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso,
		IF(am.estado='A','ANULADO',IF(am.legalizacion_manifiesto_id>0 OR am.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT nombre FROM oficina  WHERE oficina_id=am.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),DATE(am.fecha_egreso)) AS dias,		
		date(am.fecha_egreso) AS fecha_anticipo,
		m.fecha_mc AS fecha_planilla,
		CASE m.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_planilla,		
		(SELECT placa FROM vehiculo WHERE placa_id=m.placa_id) AS placa,
		am.tenedor AS tenedor, am.conductor AS conductor, m.numero_identificacion_tenedor, am.valor AS valor,
		
		(SELECT SUM(anm.valor) FROM anticipos_manifiesto anm WHERE anm.sub_anticipos_manifiesto_id=am.anticipos_manifiesto_id AND anm.devolucion=1 AND anm.encabezado_registro_id IS NOT NULL AND anm.estado!='A' ) AS devol,
		IF(am.legalizacion_manifiesto_id>0,(SELECT manifiesto FROM manifiesto WHERE manifiesto_id = am.manifiesto_id),IF(am.detalle_liquidacion_despacho_id>0,(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ) FROM encabezado_de_registro er,liquidacion_despacho ld, detalle_liquidacion_despacho dl  WHERE er.encabezado_registro_id = ld.encabezado_registro_id AND ld.liquidacion_despacho_id = dl.liquidacion_despacho_id AND dl.detalle_liquidacion_despacho_id = am.detalle_liquidacion_despacho_id ),'N/A'))as numero_legalizacion,
		(SELECT SUM(dl.valor) FROM detalle_liquidacion_despacho dl, liquidacion_despacho l WHERE dl.detalle_liquidacion_despacho_id=am.detalle_liquidacion_despacho_id AND l.liquidacion_despacho_id=dl.liquidacion_despacho_id AND l.estado_liquidacion='C' $cons_cor) AS abono,		
		(SELECT SUM(ra.rel_valor_abono_anticipo) FROM relacion_anticipos_abono ra, abono_factura_proveedor af WHERE ra.anticipos_manifiesto_id=am.anticipos_manifiesto_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='C' $cons_cor1) AS abono1		
		
		
		FROM anticipos_manifiesto am ,manifiesto m WHERE am.estado!='L' AND  am.devolucion=0 AND am.oficina_id IN ($oficina_id) AND am.manifiesto_id = m.manifiesto_id 
		AND DATE(m.fecha_mc)  BETWEEN '$desde' AND '$hasta' $estadomc $cons_vehm $cons_tenm ORDER BY m.tenedor_id ASC, am.fecha_egreso ASC ";		  

	  $select_du = "SELECT 'DU' AS tipo_documento,du.despacho AS numero_documento, du.tenedor_id,
		(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, 
		IF(adu.estado='A','ANULADO',IF(adu.legalizacion_despacho_id>0 OR adu.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT nombre FROM oficina  WHERE oficina_id=adu.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),DATE(adu.fecha_egreso)) AS dias,
		date(adu.fecha_egreso) AS fecha_anticipo,
		du.fecha_du AS fecha_planilla,
		CASE du.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_planilla,		
		(SELECT placa FROM vehiculo WHERE placa_id=du.placa_id) AS placa,		
		adu.tenedor AS tenedor, adu.conductor AS conductor,du.numero_identificacion_tenedor, adu.valor AS valor,
		
		(SELECT SUM(anm.valor) FROM anticipos_despacho anm WHERE anm.sub_anticipos_despacho_id=adu.anticipos_despacho_id AND anm.devolucion=1 AND anm.encabezado_registro_id IS NOT NULL AND anm.estado!='A' ) AS devol,		
		IF(adu.legalizacion_despacho_id>0,(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id = adu.despachos_urbanos_id),IF(adu.detalle_liquidacion_despacho_id>0,(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ) FROM encabezado_de_registro er,liquidacion_despacho ld, detalle_liquidacion_despacho dl  WHERE er.encabezado_registro_id = ld.encabezado_registro_id AND ld.liquidacion_despacho_id = dl.liquidacion_despacho_id AND dl.detalle_liquidacion_despacho_id = adu.detalle_liquidacion_despacho_id ),'N/A'))as numero_legalizacion,				
		(SELECT SUM(dl.valor) FROM detalle_liquidacion_despacho dl, liquidacion_despacho l WHERE dl.detalle_liquidacion_despacho_id=adu.detalle_liquidacion_despacho_id AND l.liquidacion_despacho_id=dl.liquidacion_despacho_id AND l.estado_liquidacion='C' $cons_cor) AS abono,				
		(SELECT SUM(ra.rel_valor_abono_anticipo) FROM relacion_anticipos_abono ra, abono_factura_proveedor af WHERE ra.anticipos_despacho_id=adu.anticipos_despacho_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='C' $cons_cor1) AS abono1		

		FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.estado!='L' AND  adu.devolucion=0 AND  adu.oficina_id IN ($oficina_id) AND adu.despachos_urbanos_id = du.despachos_urbanos_id 
	    AND du.fecha_du BETWEEN '$desde' AND '$hasta' $estadodu $cons_vehd $cons_tend ORDER BY du.tenedor_id ASC, adu.fecha_egreso ASC";

 	 $select_ap = "SELECT 'AP' AS tipo_documento, ap.consecutivo AS numero_documento, ap.tenedor_id,
	 	(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = ap.encabezado_registro_id) AS numero_egreso,
	 	CASE ap.estado WHEN 'A' THEN 'ANULADO' WHEN 'L' THEN 'LEGALIZADO' WHEN 'P' THEN 'PENDIENTE' ELSE '' END AS estado_anticipo,
	 	(SELECT nombre FROM oficina  WHERE oficina_id=ap.oficina_id) AS oficina,
	 	DATEDIFF(CURDATE(),DATE(ap.fecha)) AS dias,
	 	ap.fecha AS fecha_anticipo, 
	 	'N/A' AS fecha_planilla,
		'N/A' AS estado_planilla,
	 	(SELECT placa FROM vehiculo WHERE placa_id = ap.placa_id) AS placa, 
	  	ap.tenedor AS tenedor,	ap.conductor AS conductor,'' AS numero_identificacion_tenedor,  ap.valor AS valor,
		(SELECT SUM(anm.valor) FROM anticipos_placa anm WHERE anm.sub_anticipos_placa_id=ap.anticipos_placa_id AND anm.devolucion=1 AND anm.encabezado_registro_id IS NOT NULL AND anm.estado!='A' ) AS devol,
		'N/A' AS numero_legalizacion,
		(SELECT SUM(ra.rel_valor_abono_anticipo) FROM relacion_anticipos_abono ra, abono_factura_proveedor af WHERE ra.anticipos_placa_id=ap.anticipos_placa_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='C' $cons_cor) AS abono,		
		(SELECT SUM(ra.rel_valor_abono_anticipo) FROM relacion_anticipos_abono ra, abono_factura_proveedor af WHERE ra.anticipos_placa_id=ap.anticipos_placa_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='C' $cons_cor1) AS abono1		

		
		FROM anticipos_placa ap WHERE ap.estado!='L' AND  ap.devolucion=0 AND ap.oficina_id IN ($oficina_id) 
		AND ap.fecha BETWEEN '$desde' AND '$hasta' $estadoap $cons_veha $cons_tena ORDER BY  ap.tenedor_id ASC, ap.fecha ASC ";
		
		if($tipo=='MC'){ $select=$select_mc; }elseif($tipo=='DU'){ $select=$select_du; }elseif($tipo=='AP'){  $select=$select_ap;  }

		if($tipo=='MC,DU,AP'){ 
			$select="(".$select_mc.") UNION ALL (".$select_du.") UNION ALL (".$select_ap.") ORDER BY tenedor_id, fecha_anticipo ASC"; echo $select_mc;
		}elseif($tipo=='MC,DU'){ 
			$select="(".$select_mc.") UNION ALL (".$select_du.")  ORDER BY tenedor_id, fecha_anticipo ASC"; 
		}elseif($tipo=='DU,AP'){  
			$select="(".$select_du.") UNION ALL (".$select_ap.") ORDER BY tenedor_id, fecha_anticipo ASC"; 
		}elseif($tipo=='MC,AP'){  
			$select="(".$select_mc.") UNION ALL (".$select_ap.") ORDER BY tenedor_id, fecha_anticipo ASC"; 
		}

		$results = $this -> DbFetchAll($select,$Conex,true);

		return $results;
  } 

}

?>