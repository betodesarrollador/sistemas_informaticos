<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class LiquidacionComercialModel extends Db{

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
	$opciones=array(0=>array('value'=>'R','text'=>'RECAUDO'),1=>array('value'=>'F','text'=>'FACTURACION'));
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
   
  public function getReporteR1($oficina_id,$desde,$hasta,$Conex){ 	   	
 
	    $select = "SELECT 
					f.factura_id,
					CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					(SELECT d.codigo_centro_costo FROM   detalle_factura_puc d WHERE d.factura_id=f.factura_id AND d.codigo_centro_costo IS NOT NULL LIMIT 0,1) AS centro,
					f.consecutivo_factura,				
					f.fecha,
					f.cliente_id,
					f.vencimiento,
					f.valor,
					CASE f.estado WHEN 'I' THEN 'ANULADA' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'EDICION' END AS estados,
					(SELECT  GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ))
					 FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  AND er.encabezado_registro_id=ab.encabezado_registro_id
					) AS relacion_pago,
					(SELECT  GROUP_CONCAT(er.fecha) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  AND er.encabezado_registro_id=ab.encabezado_registro_id
					) AS fecha_relacion_pago,
					(SELECT  SUM(er.valor) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  AND er.encabezado_registro_id=ab.encabezado_registro_id
					) AS valor_relacion_pago,

					(SELECT DATEDIFF((SELECT er.fecha FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  AND er.encabezado_registro_id=ab.encabezado_registro_id LIMIT 1
					),f.fecha)) AS diferencia_dias,
					
					(SELECT (deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
					(SELECT SUM(ra.rel_valor_abono) AS abonos FROM  relacion_abono ra, abono_factura ab 
					WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  )	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
				FROM factura f
				WHERE   f.fecha BETWEEN '$desde' AND '$hasta' AND f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura ) AND f.oficina_id IN ($oficina_id)
				ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC ";		  
		  
		 echo $select;
		  $results = $this -> DbFetchAll($select,$Conex);
		  $i=0;
		foreach($results as $items){

			$saldo=floatval($items[valor_neto])-floatval($items[abonos]); 
			$result[$i]=array(factura_id=>$items[factura_id],consecutivo_factura=>$items[consecutivo_factura],estado=>$items[estados],tipo=>$items[tipo],fecha=>$items[fecha],vencimiento=>$items[vencimiento],centro=>$items[centro],oficina=>$items[oficina],cliente_nombre=>$items[cliente_nombre],valor=>$items[valor],valor_neto=>$items[valor_neto],abonos=>$items[abonos],diferencia_dias=>$items[diferencia_dias],
				relacion_pago=>$items[relacion_pago],fecha_relacion_pago=>$items[fecha_relacion_pago],valor_relacion_pago=>$items[valor_relacion_pago],saldo=>$saldo);
			$i++;
		}
		  return $result;
  } 
  /*
  public function getReporteF1($oficina_id,$desde,$hasta,$Conex){ 
	   	
  	    $select = "SELECT 
		  CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		  (SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		  (SELECT d.codigo_centro_costo FROM   detalle_factura_puc d WHERE d.factura_id=f.factura_id AND d.codigo_centro_costo IS NOT NULL LIMIT 0,1) AS centro,
		  f.consecutivo_factura,				
		  f.fecha,
		  f.vencimiento,
		  ROUND(f.valor) AS valor,
		  CASE f.estado WHEN 'I' THEN 'ANULADA' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'EDICION' END AS estados,
		  (SELECT GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ))
		  FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id) AS relacion_pago,
		  (SELECT ROUND(deb_item_factura+cre_item_factura) AS neto FROM detalle_factura_puc WHERE factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
		  (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM relacion_abono ra, abono_factura ab 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
		  FROM factura f
		  WHERE  f.fecha BETWEEN '$desde' AND '$hasta' AND f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura WHERE reporta_cartera=1 ) AND f.oficina_id IN ($oficina_id)
		  ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC ";
		  
		   echo $select;		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  return $results;
  } */
  
  public function getReporteDP1($oficina_id,$desde,$hasta,$Conex){	   	
		  return NULL;
  }   
  
  public function getReporteF2($oficina_id,$desde,$hasta,$cliente_id,$Conex){
	  		 
	  $select = "SELECT 
		  CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		  (SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		  (SELECT d.codigo_centro_costo FROM detalle_factura_puc d WHERE d.factura_id=f.factura_id AND d.codigo_centro_costo IS NOT NULL LIMIT 0,1) AS centro,
		  f.consecutivo_factura,				
		  f.fecha,
		  f.vencimiento,
		  ROUND(f.valor) AS valor,
		  CASE f.estado WHEN 'I' THEN 'ANULADA' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'EDICION' END AS estados,
		  (SELECT GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ))
		  FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id) AS relacion_pago,
		  
		  (SELECT ROUND((deb_item_factura+cre_item_factura)) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
		  (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )	AS abonos,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
		  FROM factura f
		  WHERE f.cliente_id=$cliente_id AND f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura WHERE reporta_cartera=1 ) AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
		  ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC";	
		  
		  echo $select;		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  return $results;	  
   }  
   
  public function getReporteR2($oficina_id,$desde,$hasta,$cliente_id,$Conex){
	  		 
  	    $select = "SELECT  
					f.factura_id,
					CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					(SELECT d.codigo_centro_costo FROM   detalle_factura_puc d WHERE d.factura_id=f.factura_id AND d.codigo_centro_costo IS NOT NULL LIMIT 0,1) AS centro,
					f.consecutivo_factura,				
					f.fecha,
					f.cliente_id,
					f.vencimiento,
					f.valor,
					CASE f.estado WHEN 'I' THEN 'ANULADA' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'EDICION' END AS estados,
					(SELECT  GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ))
					 FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id
					) AS relacion_pago,
					(SELECT  GROUP_CONCAT(er.fecha) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id
					) AS fecha_relacion_pago,
					(SELECT  SUM(er.valor) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id
					) AS valor_relacion_pago,

					(SELECT DATEDIFF((SELECT er.fecha FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id LIMIT 1
					),f.fecha)) AS diferencia_dias,
					
					(SELECT (deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
					(SELECT SUM(ra.rel_valor_abono) AS abonos FROM  relacion_abono ra, abono_factura ab 
					WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
				FROM factura f
				WHERE f.cliente_id=$cliente_id AND f.estado='C' AND f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura WHERE reporta_cartera=1 ) AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC";	
		  
		 echo $select;		  
		$results = $this -> DbFetchAll($select,$Conex);
		return $results;	  
   } 
   
  public function getReporteDP2($oficina_id,$desde,$hasta,$Conex){	   	
		  return NULL;
  }   

  public function getReporteMC3($oficina_id,$desde,$hasta,$vehiculo_id,$Conex){
	 
	  $select = "SELECT 'MC' AS tipo_documento, m.manifiesto AS numero_documento, m.fecha_mc AS fecha_manifiesto, 
	  CASE m.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_manifiesto,
	  (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso, date(am.fecha_egreso) AS fecha_anticipo,		 
	  IF(am.encabezado_registro_id >= 0,'SI','NO') AS contabilizado, am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor, 
	  m.placa AS placa, (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') AS estado_encabezado FROM encabezado_de_registro 
	  WHERE encabezado_registro_id = am.encabezado_registro_id) AS estado_encabezado FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
	  AND m.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.placa_id IN($vehiculo_id) ORDER BY m.placa_id";	
		  
		   echo $select;		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  return $results;	  
	}
	
  public function getReporteDU3($oficina_id,$desde,$hasta,$vehiculo_id,$Conex){
	 
	  $select = "SELECT 'DU' AS tipo_documento, du.despacho AS numero_documento, du.fecha_du AS fecha_despacho, 
	  CASE du.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_despacho,
	  (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, date(adu.fecha_egreso) AS fecha_anticipo,		 
	  IF(adu.encabezado_registro_id >= 0,'SI','NO') AS contabilizado, adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
	  du.placa AS placa, (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') AS estado_encabezado FROM encabezado_de_registro 
	  WHERE encabezado_registro_id = adu.encabezado_registro_id) AS estado_encabezado FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
	  AND du.despachos_urbanos_id = du.despachos_urbanos_id AND du.fecha_du BETWEEN '$desde' AND '$hasta' AND du.placa_id IN($vehiculo_id) ORDER BY du.placa_id";
		  
		 echo $select;
		  $results = $this -> DbFetchAll($select,$Conex);
		  return $results;	  
	}
	
  public function getReporteDP3($oficina_id,$desde,$hasta,$Conex){ 	   	
		 return NULL;  
		 }	
 
  public function getReporteMC4($oficina_id,$desde,$hasta,$vehiculo_id,$tenedor_id,$Conex){
	 
	  $select = "SELECT 'MC' AS tipo_documento, m.manifiesto AS numero_documento, m.fecha_mc AS fecha_manifiesto, 
	  CASE m.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_manifiesto,
	  (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso, date(am.fecha_egreso) AS fecha_anticipo,		 
	  IF(am.encabezado_registro_id >= 0,'SI','NO') AS contabilizado, am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor, 
	  m.placa AS placa, (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') AS estado_encabezado FROM encabezado_de_registro 
	  WHERE encabezado_registro_id = am.encabezado_registro_id) AS estado_encabezado FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
	  AND m.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.tenedor_id IN($tenedor_id) AND m.placa_id IN($vehiculo_id) ORDER BY m.placa_id";		
		  
	 // echo $select;
	 $results = $this -> DbFetchAll($select,$Conex);
	  return $results;	  
	}
	
  public function getReporteDU4($oficina_id,$desde,$hasta,$vehiculo_id,$tenedor_id,$Conex){
	 
	  $select = "SELECT 'DU' AS tipo_documento, du.despacho AS numero_documento, du.fecha_du AS fecha_despacho, 
	  CASE du.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_despacho,
	  (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, date(adu.fecha_egreso) AS fecha_anticipo,		 
	  IF(adu.encabezado_registro_id >= 0,'SI','NO') AS contabilizado, adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
	  du.placa AS placa, (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') AS estado_encabezado FROM encabezado_de_registro 
	  WHERE encabezado_registro_id = adu.encabezado_registro_id) AS estado_encabezado FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
	  AND du.despachos_urbanos_id = du.despachos_urbanos_id AND du.fecha_du BETWEEN '$desde' AND '$hasta' AND du.placa_id IN($vehiculo_id) AND du.tenedor_id IN($tenedor_id) ORDER BY du.placa_id";
		  
		$results = $this -> DbFetchAll($select,$Conex);
		return $results;	  
	}
	
  public function getReporteDP4($oficina_id,$desde,$hasta,$Conex){	   	
		 return NULL;
  }	   

}

?>