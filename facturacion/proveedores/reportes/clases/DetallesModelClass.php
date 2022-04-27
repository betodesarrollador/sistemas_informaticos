<?php


require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesModel extends Db{

  private $Permisos;
  
  public function getReporteFP1($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$proveedor_id,$saldos,$Conex){

		if($saldos!=''){
			$dias="DATEDIFF('$hasta',f.vence_factura_proveedor) AS dias,";		
		}else{
			$dias="DATEDIFF(CURDATE(),f.vence_factura_proveedor) AS dias,";
		}

	   	
		$select = "SELECT 
					f.factura_proveedor_id,
					(SELECT GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' )) FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo_id,
					CASE f.fuente_servicio_cod WHEN 'OC' THEN 'ORDEN No ' WHEN 'MC' THEN IF(f.liquidacion_despacho_sobre_id IS NOT NULL,'SOBREFLETE MANIFIESTO No', 'MANIFIESTO No')  WHEN 'DU' THEN IF(f.liquidacion_despacho_sobre_id IS NOT NULL,'SOBREFLETE DESPACHO No', 'DESPACHO No')  ELSE CONCAT_WS('-',(SELECT nombre_bien_servicio FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id),f.fecha_factura_proveedor) END  AS tipo,
					(SELECT consecutivo FROM orden_compra WHERE orden_compra_id=f.orden_compra_id) AS orden_no,
					(SELECT numero_despacho FROM liquidacion_despacho WHERE liquidacion_despacho_id=f.liquidacion_despacho_id) AS manifiesto,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					$dias
					f.codfactura_proveedor,				
					f.fecha_factura_proveedor,
					f.proveedor_id,
					f.vence_factura_proveedor,
					f.valor_factura_proveedor,
					IF(f.val_anticipos_cruzar IS NULL,IF(f.anticipos_cruzar IS NULL,0,(SELECT valor FROM anticipos_proveedor WHERE anticipos_proveedor_id IN( SUBSTR( REPLACE( f.anticipos_cruzar, '\'', '' ) , 1, (
LENGTH( REPLACE( f.anticipos_cruzar, '\'', '' ) ) ) -1
)))),(SELECT SUBSTRING( REPLACE( f.val_anticipos_cruzar, '\'', '' ) , 1, (
LENGTH( REPLACE( f.val_anticipos_cruzar, '\'', '' ) ) ) -1
)))as anticipos,
					(SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) AS valor_neto,
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f 
				WHERE f.proveedor_id=$proveedor_id AND f.estado_factura_proveedor='C'  AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id) $puc_id $tipo_documento_id 
				
				AND ((SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)
				OR 	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos) IS NULL)
				ORDER BY f.proveedor_id ASC,f.fecha_factura_proveedor  ASC,f.codfactura_proveedor ASC,  f.oficina_id ASC "; ////echo $select;
		
		$results = $this -> DbFetchAll($select,$Conex,true);
		$i=0;
		foreach($results as $items){
			$anticipos = is_numeric($items[anticipos])? intval($items[anticipos]) : 0;
			$saldo=(intval($items[valor_neto])-intval($items[abonos]))-$anticipos; 
			if($saldo>0){
			$result[$i]=array(factura_proveedor_id=>$items[factura_proveedor_id],consecutivo_id=>$items[consecutivo_id],tipo=>$items[tipo],orden_no=>$items[orden_no],manifiesto=>$items[manifiesto],codfactura_proveedor=>$items[codfactura_proveedor],fecha_factura_proveedor=>$items[fecha_factura_proveedor],vence_factura_proveedor=>$items[vence_factura_proveedor],dias=>$items[dias],oficina=>$items[oficina],proveedor_nombre=>$items[proveedor_nombre],valor_factura_proveedor=>$items[valor_factura_proveedor],valor_neto=>$items[valor_neto],abonos=>$items[abonos],saldo=>$saldo,puc_id=>$puc_id,tipo_documento_id=>$tipo_documento_id);	
			$i++;
			}
		}

		return $result;
  
  }

  public function getReporteRF1($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$proveedor_id,$saldos,$Conex){  //cambiar por tablas factura_proveedor

		if($saldos!=''){
			$dias="DATEDIFF('$hasta',f.vence_factura_proveedor) AS dias,";		
		}else{
			$dias="DATEDIFF(CURDATE(),f.vence_factura_proveedor) AS dias,";
		}

		$select = "SELECT 
					f.factura_proveedor_id,
					(SELECT GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' )) FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo_id,
					CASE f.fuente_servicio_cod WHEN 'OC' THEN 'ORDEN No ' WHEN 'MC' THEN IF(f.liquidacion_despacho_sobre_id IS NOT NULL,'SOBREFLETE MANIFIESTO No', 'MANIFIESTO No')  WHEN 'DU' THEN IF(f.liquidacion_despacho_sobre_id IS NOT NULL,'SOBREFLETE DESPACHO No', 'DESPACHO No')  ELSE CONCAT_WS('-',(SELECT nombre_bien_servicio FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id),f.fecha_factura_proveedor) END  AS tipo,
					(SELECT consecutivo FROM orden_compra WHERE orden_compra_id=f.orden_compra_id) AS orden_no,
					(SELECT numero_despacho FROM liquidacion_despacho WHERE liquidacion_despacho_id=f.liquidacion_despacho_id) AS manifiesto,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					$dias
					(SELECT codigo_centro FROM oficina WHERE oficina_id=f.oficina_id) AS centro,
					f.codfactura_proveedor,				
					f.fecha_factura_proveedor,
					f.proveedor_id,
					f.vence_factura_proveedor,
					f.valor_factura_proveedor,

					(SELECT  GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ))
					 FROM  abono_factura_proveedor ab, relacion_abono_factura ra, encabezado_de_registro er 
					 WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id) AS relacion_pago,
					 
					 (SELECT  GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ))
					 FROM  anticipos_proveedor ab, encabezado_de_registro er 
					 WHERE ab.anticipos_proveedor_id IN (SELECT SUBSTRING( REPLACE( f.anticipos_cruzar, '\'', '' ) , 1, (
LENGTH( REPLACE( f.anticipos_cruzar, '\'', '' ) ) ) -1
)) AND er.encabezado_registro_id=ab.encabezado_registro_id) AS relacion_anticipos,
					
					(SELECT SUBSTRING( REPLACE( f.anticipos_cruzar, '\'', '' ) , 1, (
LENGTH( REPLACE( f.val_anticipos_cruzar, '\'', '' ) ) ) -1
)) as ants,

					CASE f.estado_factura_proveedor WHEN 'C' THEN 'CONTABILIZADA' WHEN 'A' THEN 'EDICION' ELSE 'ANULADA' END AS estado,
					
					(SELECT (ia.deb_item_factura_proveedor+ia.cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor ia WHERE  ia.factura_proveedor_id=f.factura_proveedor_id AND ia.contra_factura_proveedor=1) AS valor_neto,
					
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					
					IF(f.val_anticipos_cruzar IS NULL,IF(f.anticipos_cruzar IS NULL,0,(SELECT valor FROM anticipos_proveedor WHERE anticipos_proveedor_id IN( SUBSTR( REPLACE( f.anticipos_cruzar, '\'', '' ) , 1, (
LENGTH( REPLACE( f.anticipos_cruzar, '\'', '' ) ) ) -1
)))),(SELECT SUBSTRING( REPLACE( f.val_anticipos_cruzar, '\'', '' ) , 1, (
LENGTH( REPLACE( f.val_anticipos_cruzar, '\'', '' ) ) ) -1
)))as anticipos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
					
				FROM factura_proveedor f
				WHERE f.proveedor_id=$proveedor_id $puc_id $tipo_documento_id AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				ORDER BY  f.fecha_factura_proveedor ASC, f.proveedor_id ASC, f.oficina_id ASC, f.codfactura_proveedor ASC "; 
//echo $select;
    	$results = $this -> DbFetchAll($select,$Conex,true);
		$i=0;
		foreach($results as $items){

			$anticipos = is_numeric($items[anticipos])? intval($items[anticipos]) : 0;
			
			$abonos = is_numeric($items[abonos])? intval($items[abonos]) : 0;
			
			$abonos_total = $abonos + $anticipos;
			//echo $anticipos."assas";
			$saldo=(intval($items[valor_neto])-intval($abonos_total)); 
			$result[$i]=array(factura_proveedor_id=>$items[factura_proveedor_id],consecutivo_id=>$items[consecutivo_id],tipo=>$items[tipo],orden_no=>$items[orden_no],manifiesto=>$items[manifiesto],codfactura_proveedor=>$items[codfactura_proveedor],fecha_factura_proveedor=>$items[fecha_factura_proveedor],vence_factura_proveedor=>$items[vence_factura_proveedor],dias=>$items[dias],oficina=>$items[oficina],proveedor_nombre=>$items[proveedor_nombre],valor_factura_proveedor=>$items[valor_factura_proveedor],valor_neto=>$items[valor_neto],abonos=>$abonos_total,saldo=>$saldo,estado=>$items[estado],centro=>$items[centro],relacion_pago=>$items[relacion_pago],relacion_anticipos=>$items[relacion_anticipos],puc_id=>$puc_id,tipo_documento_id=>$tipo_documento_id);	
			$i++;
		}

		return $result;
  
  }

public function getReporteEC1($oficina_id,$desde,$hasta,$proveedor_id,$saldos,$puc_id,$tipo_documento_id,$consulta,$Conex){
	   	
	$select="SELECT f.factura_proveedor_id,
	            (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
				FROM tercero t, proveedor c WHERE t.tercero_id = c.tercero_id AND c.proveedor_id=f.proveedor_id)AS proveedor,
				(SELECT t.numero_identificacion FROM tercero t, proveedor c WHERE t.tercero_id = c.tercero_id AND c.proveedor_id=f.proveedor_id)AS numero_identificacion,
				(SELECT t.email FROM tercero t, proveedor c WHERE t.tercero_id = c.tercero_id AND c.proveedor_id=f.proveedor_id)AS email,
				f.codfactura_proveedor,
				(SELECT 'FACTURA DE COMPRA')AS tipo_documento,
				(SELECT f.concepto_factura_proveedor)AS concepto,
				f.fecha_factura_proveedor,
				f.vence_factura_proveedor,
				DATEDIFF(CURDATE(),f.vence_factura_proveedor) AS dias,
				(CASE f.estado_factura_proveedor WHEN 'A' THEN 'EDICION' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'ANULADA' END)AS estado,
				(SELECT SUM(d.cre_item_factura_proveedor) FROM item_factura_proveedor d WHERE d.factura_proveedor_id = f.factura_proveedor_id AND d.contra_factura_proveedor=1 ORDER BY d.item_factura_proveedor_id DESC) AS valor,
				
				(SELECT IF((SELECT r.factura_proveedor_id FROM relacion_abono_factura r WHERE f.factura_proveedor_id = r.factura_proveedor_id LIMIT 1)>0,
                (IF((SELECT r.rel_valor_mayor_factura FROM relacion_abono_factura r WHERE r.factura_proveedor_id = f.factura_proveedor_id LIMIT 1 )>0,
                (SELECT (SUM(d.cre_item_factura_proveedor) - r.rel_valor_abono_factura - r.rel_valor_mayor_factura) FROM item_factura_proveedor d, relacion_abono_factura r WHERE d.factura_proveedor_id = f.factura_proveedor_id AND r.factura_proveedor_id = f.factura_proveedor_id AND d.contra_factura_proveedor=1 AND f.factura_proveedor_id IN(SELECT r.factura_proveedor_id FROM relacion_abono_factura r,abono_factura_proveedor a WHERE r.factura_proveedor_id = f.factura_proveedor_id AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id AND a.estado_abono_factura != 'I' AND (SELECT SUM(r.rel_valor_abono_factura)-(SELECT SUM(d.cre_item_factura_proveedor) FROM item_factura_proveedor d WHERE d.factura_proveedor_id = r.factura_proveedor_id AND d.contra_factura_proveedor=1) FROM relacion_abono_factura r, abono_factura_proveedor a WHERE r.factura_proveedor_id = f.factura_proveedor_id AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id AND a.estado_abono_factura != 'I') = 0 GROUP BY r.factura_proveedor_id) ORDER BY d.item_factura_proveedor_id DESC),
                (SELECT (SUM(d.cre_item_factura_proveedor) - r.rel_valor_abono_factura) FROM item_factura_proveedor d, relacion_abono_factura r WHERE d.factura_proveedor_id = f.factura_proveedor_id AND r.factura_proveedor_id = f.factura_proveedor_id AND f.factura_proveedor_id NOT IN(SELECT r.factura_proveedor_id FROM relacion_abono_factura r,abono_factura_proveedor a WHERE r.factura_proveedor_id = f.factura_proveedor_id AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id AND a.estado_abono_factura != 'I' AND (SELECT SUM(r.rel_valor_abono_factura)-(SELECT SUM(d.cre_item_factura_proveedor) FROM item_factura_proveedor d WHERE d.factura_proveedor_id = r.factura_proveedor_id AND d.contra_factura_proveedor=1) FROM relacion_abono_factura r, abono_factura_proveedor a WHERE r.factura_proveedor_id = f.factura_proveedor_id AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id AND a.estado_abono_factura != 'I') = 0 GROUP BY r.factura_proveedor_id) ORDER BY d.item_factura_proveedor_id DESC))),
                (SELECT SUM(d.cre_item_factura_proveedor) FROM item_factura_proveedor d, relacion_abono_factura r WHERE d.factura_proveedor_id = f.factura_proveedor_id AND d.contra_factura_proveedor=1 ORDER BY d.item_factura_proveedor_id DESC)))AS valor_pendiente,
				
				0 AS abonos,
				(SELECT SUM(a.valor_descu_factura) FROM abono_factura_proveedor a, relacion_abono_factura r WHERE f.factura_proveedor_id = r.factura_proveedor_id AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id GROUP BY r.factura_proveedor_id) AS descuento,
				0 AS descuento_mayor,
				(SELECT SUM(a.valor_abono_factura) FROM abono_factura_proveedor a, relacion_abono_factura r WHERE f.factura_proveedor_id = r.factura_proveedor_id AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id GROUP BY r.factura_proveedor_id) AS abono_factura,
                (SELECT SUM(a.valor_neto_factura) FROM abono_factura_proveedor a, relacion_abono_factura r WHERE f.factura_proveedor_id = r.factura_proveedor_id AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id GROUP BY r.factura_proveedor_id) AS valor_neto
                
				
	            FROM  factura_proveedor f
				WHERE f.proveedor_id = $proveedor_id AND f.oficina_id IN($oficina_id) AND (f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta') $consulta";
	           
				$result_factura  = $this -> DbFetchAll($select,$Conex,true);
				if($result_factura > 0){
                   
					for($i = 0; $i<count($result_factura); $i++){
						
						$factura_proveedor_id = $result_factura[$i]['factura_proveedor_id'];
						$arrayReporte[$i]['factura'] =$result_factura;

					    $select  = "SELECT f.abono_factura_proveedor_id,
								(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
								FROM tercero t, proveedor c WHERE t.tercero_id = c.tercero_id AND c.proveedor_id=f.proveedor_id)AS proveedor,
								(SELECT t.numero_identificacion FROM tercero t, proveedor c WHERE t.tercero_id = c.tercero_id AND c.proveedor_id=f.proveedor_id)AS numero_identificacion,
								(SELECT e.consecutivo FROM encabezado_de_registro e WHERE f.encabezado_registro_id = e.encabezado_registro_id AND e.estado = 'C')AS consecutivo,
								(SELECT e.encabezado_registro_id FROM encabezado_de_registro e WHERE f.encabezado_registro_id = e.encabezado_registro_id AND e.estado = 'C')AS encabezado_registro_id,
								(SELECT t.nombre FROM tipo_de_documento t WHERE t.tipo_documento_id=f.tipo_documento_id)AS tipo_documento,
								(SELECT CONCAT_WS(' ','CANC FACT COMPRA: ',(SELECT fv.codfactura_proveedor FROM factura_proveedor fv WHERE fv.factura_proveedor_id = r.factura_proveedor_id AND r.abono_factura_proveedor_id = f.abono_factura_proveedor_id))) AS concepto,
								f.fecha,
								'' AS vencimiento,
								(CASE f.estado_abono_factura WHEN 'A' THEN 'EDICION' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'ANULADA' END)AS estado,
								0 AS valor,
								r.rel_valor_descu_factura AS abonos_desc,
								r.rel_valor_mayor_factura AS mayor_pago,
								r.rel_valor_abono_factura AS valor_abono
								
								FROM  abono_factura_proveedor f,relacion_abono_factura r 
								WHERE f.abono_factura_proveedor_id=r.abono_factura_proveedor_id AND r.factura_proveedor_id=$factura_proveedor_id AND f.proveedor_id = $proveedor_id AND f.oficina_id IN($oficina_id) $saldos";
						        
								$result_descuento = $this -> DbFetchAll($select,$Conex,true);
								$arrayReporte[$i]['descuento'] = $result_descuento;
					}
				
				    return $arrayReporte;
			    }
}

  public function getReportePE1($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$proveedor_id,$saldos,$Conex){

	if($saldos!=''){
		$dias="DATEDIFF('$hasta',f.vence_factura_proveedor) AS dias,";		
	}else{
		$dias="DATEDIFF(CURDATE(),f.vence_factura_proveedor) AS dias,";
	}


	$select = "SELECT 
					f.factura_proveedor_id,
					(SELECT GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' )) FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo_id,
					CASE f.fuente_servicio_cod WHEN 'OC' THEN 'ORDEN No ' WHEN 'MC' THEN IF(f.liquidacion_despacho_sobre_id IS NOT NULL,'SOBREFLETE MANIFIESTO No', 'MANIFIESTO No')  WHEN 'DU' THEN IF(f.liquidacion_despacho_sobre_id IS NOT NULL,'SOBREFLETE DESPACHO No', 'DESPACHO No')  ELSE CONCAT_WS('-',(SELECT nombre_bien_servicio FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id),f.fecha_factura_proveedor) END  AS tipo,
					(SELECT consecutivo FROM orden_compra WHERE orden_compra_id=f.orden_compra_id) AS orden_no,
					(SELECT numero_despacho FROM liquidacion_despacho WHERE liquidacion_despacho_id=f.liquidacion_despacho_id) AS manifiesto,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					$dias
					f.codfactura_proveedor,				
					f.fecha_factura_proveedor,
					f.proveedor_id,
					f.vence_factura_proveedor,
					f.valor_factura_proveedor,
					(SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) AS valor_neto,
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					
					IF(f.val_anticipos_cruzar IS NULL,IF(f.anticipos_cruzar IS NULL,0,(SELECT valor FROM anticipos_proveedor WHERE anticipos_proveedor_id IN( SUBSTR( REPLACE( f.anticipos_cruzar, '\'', '' ) , 1, (
LENGTH( REPLACE( f.anticipos_cruzar, '\'', '' ) ) ) -1
)))),(SELECT SUBSTRING( REPLACE( f.val_anticipos_cruzar, '\'', '' ) , 1, (
LENGTH( REPLACE( f.val_anticipos_cruzar, '\'', '' ) ) ) -1
)))as anticipos,
					
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
			FROM factura_proveedor f
			WHERE f.proveedor_id=$proveedor_id AND  f.estado_factura_proveedor='C' AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id) $puc_id $tipo_documento_id
				AND ((SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)
				OR 	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos) IS NULL)
				ORDER BY f.proveedor_id ASC,f.fecha_factura_proveedor  ASC,f.codfactura_proveedor ASC, f.oficina_id ASC ";
////echo $select;
    	$results = $this -> DbFetchAll($select,$Conex,true);
		$i=0;
		foreach($results as $items){
			$anticipos = is_numeric($items[anticipos])? intval($items[anticipos]) : 0;
			$saldo=(intval($items[valor_neto])-intval($items[abonos]))-$anticipos; 
			if($saldo>0){
				$result[$i]=array(factura_proveedor_id=>$items[factura_proveedor_id],consecutivo_id=>$items[consecutivo_id],tipo=>$items[tipo],orden_no=>$items[orden_no],manifiesto=>$items[manifiesto],codfactura_proveedor=>$items[codfactura_proveedor],fecha_factura_proveedor=>$items[fecha_factura_proveedor],vence_factura_proveedor=>$items[vence_factura_proveedor],dias=>$items[dias],oficina=>$items[oficina],proveedor_nombre=>$items[proveedor_nombre],valor_factura_proveedor=>$items[valor_factura_proveedor],valor_neto=>$items[valor_neto],abonos=>$items[abonos],saldo=>$saldo,puc_id=>$puc_id,tipo_documento_id=>$tipo_documento_id);	
				$i++;
			}
		}

		return $result;
  
  }
  
  public function getReporteRC1($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$proveedor_id,$saldos,$Conex){  //cambiar por tablas factura_proveedor

		if($saldos!=''){
			$dias="DATEDIFF('$hasta',f.vence_factura_proveedor) AS dias,";		
		}else{
			$dias="DATEDIFF(CURDATE(),f.vence_factura_proveedor) AS dias,";
		}

		$select = "SELECT 
					f.factura_proveedor_id,
					(SELECT GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' )) FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo_id,
					CASE f.fuente_servicio_cod WHEN 'OC' THEN 'ORDEN No ' WHEN 'MC' THEN IF(f.liquidacion_despacho_sobre_id IS NOT NULL,'SOBREFLETE MANIFIESTO No', 'MANIFIESTO No')  WHEN 'DU' THEN IF(f.liquidacion_despacho_sobre_id IS NOT NULL,'SOBREFLETE DESPACHO No', 'DESPACHO No')  ELSE CONCAT_WS('-',(SELECT nombre_bien_servicio FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id),f.fecha_factura_proveedor) END  AS tipo,
					(SELECT consecutivo FROM orden_compra WHERE orden_compra_id=f.orden_compra_id) AS orden_no,
					(SELECT numero_despacho FROM liquidacion_despacho WHERE liquidacion_despacho_id=f.liquidacion_despacho_id) AS manifiesto,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					$dias
					(SELECT codigo_centro FROM oficina WHERE oficina_id=f.oficina_id) AS centro,
					f.codfactura_proveedor,				
					f.fecha_factura_proveedor,
					f.proveedor_id,
					f.vence_factura_proveedor,
					f.valor_factura_proveedor,

					(SELECT  GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ))
					 FROM  abono_factura_proveedor ab, relacion_abono_factura ra, encabezado_de_registro er 
					 WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id) AS relacion_pago,

					CASE f.estado_factura_proveedor WHEN 'C' THEN 'CONTABILIZADA' WHEN 'A' THEN 'EDICION' ELSE 'ANULADA' END AS estado,
					(SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) AS valor_neto,
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					
				IF(f.val_anticipos_cruzar IS NULL,IF(f.anticipos_cruzar IS NULL,0,(SELECT valor FROM anticipos_proveedor WHERE anticipos_proveedor_id IN( SUBSTR( REPLACE( f.anticipos_cruzar, '\'', '' ) , 1, (
LENGTH( REPLACE( f.anticipos_cruzar, '\'', '' ) ) ) -1
)))),(SELECT SUBSTRING( REPLACE( f.val_anticipos_cruzar, '\'', '' ) , 1, (
LENGTH( REPLACE( f.val_anticipos_cruzar, '\'', '' ) ) ) -1
)))as anticipos,
					
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f
				WHERE f.proveedor_id=$proveedor_id $puc_id $tipo_documento_id AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				ORDER BY f.fecha_factura_proveedor  ASC,f.proveedor_id ASC, f.oficina_id ASC, f.codfactura_proveedor ASC "; 
		////echo $select;
    	$results = $this -> DbFetchAll($select,$Conex,true);
		$i=0;
		foreach($results as $items){

			$anticipos = is_numeric($items[anticipos])? intval($items[anticipos]) : 0;
			$saldo=(intval($items[valor_neto])-intval($items[abonos]))-$anticipos; 
			$result[$i]=array(factura_proveedor_id=>$items[factura_proveedor_id],consecutivo_id=>$items[consecutivo_id],tipo=>$items[tipo],orden_no=>$items[orden_no],manifiesto=>$items[manifiesto],codfactura_proveedor=>$items[codfactura_proveedor],fecha_factura_proveedor=>$items[fecha_factura_proveedor],vence_factura_proveedor=>$items[vence_factura_proveedor],dias=>$items[dias],oficina=>$items[oficina],proveedor_nombre=>$items[proveedor_nombre],valor_factura_proveedor=>$items[valor_factura_proveedor],valor_neto=>$items[valor_neto],abonos=>$items[abonos],saldo=>$saldo,estado=>$items[estado],centro=>$items[centro],relacion_pago=>$items[relacion_pago]);	
			$i++;
		}

		return $result;
  
  }

   //*************REPORTES SOLICITUDES DE SERVICIO****************//	
	
	public function getReporteRS1($oficina_id,$desde,$hasta,$proveedor_id,$Conex){  //cambiar por tablas factura_proveedor

		$select = "SELECT 
					
					o.consecutivo,
					(SELECT nombre FROM oficina WHERE oficina_id=o.oficina_id) AS oficina,
					o.fecha_orden_compra AS fecha_orden_compra,
					(SELECT CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social)as ter FROM tercero t, proveedor p WHERE t.tercero_id=p.tercero_id AND p.proveedor_id = o.proveedor_id)AS proveedor_nombre,
					(SELECT b.nombre_bien_servicio FROM  tipo_bien_servicio b WHERE b.tipo_bien_servicio_id=o.tipo_bien_servicio_id)AS tiposervicio,
					o.descrip_orden_compra,
					(SELECT p.consecutivo FROM pre_orden_compra p, item_pre_orden_compra i WHERE p.pre_orden_compra_id = i.pre_orden_compra_id AND i.item_pre_orden_compra_id IN(o.item_pre_orden_id)) as solicitud,
					CASE o.estado_orden_compra WHEN 'A' THEN 'ACTIVO' WHEN 'C' THEN 'CAUSADA' WHEN 'L' THEN 'LIQUIDADA' ELSE 'ANULADA' END AS estado
					
					
				FROM orden_compra o
				WHERE  o.fecha_orden_compra BETWEEN '$desde' AND '$hasta' AND o.oficina_id IN ($oficina_id) AND o.proveedor_id = $proveedor_id 
				ORDER BY o.proveedor_id ASC,o.fecha_orden_compra  ASC, o.oficina_id ASC";  
		
    	$results = $this -> DbFetchAll($select,$Conex,true);
		
		$i=0;
		foreach($results as $items){

			$result[$i]=array(consecutivo=>$items[consecutivo],oficina=>$items[oficina],fecha_orden_compra=>$items[fecha_orden_compra],proveedor_nombre=>$items[proveedor_nombre],tiposervicio=>$items[tiposervicio],descrip_orden_compra=>$items[descrip_orden_compra],estado=>$items[estado]);	
			$i++;
		}
		
		return $result;
  
  }
    public function getReporteSP1($oficina_id,$desde,$hasta,$proveedor_id,$Conex){  
		$select = "SELECT i.*,o.*,
				 (SELECT nombre FROM oficina WHERE oficina_id=o.oficina_id) AS oficina,
				 (SELECT CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social)as ter FROM tercero t, proveedor p WHERE t.tercero_id=p.tercero_id AND p.proveedor_id = o.proveedor_id)AS proveedor_nombre
				 
				FROM pre_orden_compra o, item_pre_orden_compra i  
			WHERE i.estado = 'D' AND o.pre_orden_compra_id = i.pre_orden_compra_id AND o.proveedor_id = $proveedor_id
		
		";////echo $select;
    	$results = $this -> DbFetchAll($select,$Conex,true);
		$i=0;
		foreach($results as $items){
			$result[$i]=array(consecutivo=>$items[consecutivo],oficina=>$items[oficina],fecha_orden_compra=>$items[fecha_orden_compra],proveedor_nombre=>$items[proveedor_nombre],tiposervicio=>$items[tiposervicio],descrip_orden_compra=>$items[descrip_orden_compra],solicitud=>$items[solicitud],estado=>$items[estado]);	
			$i++;
		}

		return $result;
  
  }
  
    public function getReporteSP_ALL($oficina_id,$desde,$hasta,$Conex){
	   	
		$select = "SELECT i.*,o.*,
				 (SELECT nombre FROM oficina WHERE oficina_id=o.oficina_id) AS oficina,
				 (SELECT CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social)as ter FROM tercero t, proveedor p WHERE t.tercero_id=p.tercero_id AND p.proveedor_id = o.proveedor_id)AS proveedor_nombre
				 
				FROM pre_orden_compra o, item_pre_orden_compra i  
			WHERE i.estado = 'D' AND o.pre_orden_compra_id = i.pre_orden_compra_id
		
		";////echo $select;
    	$results = $this -> DbFetchAll($select,$Conex,true);
		$i=0;
		foreach($results as $items){
			$result[$i]=array(consecutivo=>$items[consecutivo],oficina=>$items[oficina],fecha_orden_compra=>$items[fecha_orden_compra],proveedor_nombre=>$items[proveedor_nombre],tiposervicio=>$items[tiposervicio],descrip_orden_compra=>$items[descrip_orden_compra],solicitud=>$items[solicitud],estado=>$items[estado]);	
			$i++;
		}

		return $result;
  
  }
    public function getReporteRS_ALL($oficina_id,$desde,$hasta,$Conex){

	$select = "SELECT 
					
					o.consecutivo,
					(SELECT nombre FROM oficina WHERE oficina_id=o.oficina_id) AS oficina,
					o.fecha_orden_compra,
					(SELECT CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social)as ter FROM tercero t, proveedor p WHERE t.tercero_id=p.tercero_id AND p.proveedor_id = o.proveedor_id)AS proveedor_nombre,
					(SELECT b.nombre_bien_servicio FROM  tipo_bien_servicio b WHERE b.tipo_bien_servicio_id=o.tipo_bien_servicio_id)AS tiposervicio,
					o.descrip_orden_compra,
					(SELECT p.consecutivo FROM pre_orden_compra p, item_pre_orden_compra i WHERE p.pre_orden_compra_id = i.pre_orden_compra_id AND i.item_pre_orden_compra_id IN(o.item_pre_orden_id)) as solicitud,
					CASE o.estado_orden_compra WHEN 'A' THEN 'ACTIVO' WHEN 'C' THEN 'CAUSADA' WHEN 'L' THEN 'LIQUIDADA' ELSE 'ANULADA' END AS estado
					
					
				FROM orden_compra o
				WHERE  o.fecha_orden_compra BETWEEN '$desde' AND '$hasta' AND o.oficina_id IN ($oficina_id) 
				ORDER BY o.proveedor_id ASC,o.fecha_orden_compra  ASC, o.oficina_id ASC"; 
		
    	$results = $this -> DbFetchAll($select,$Conex,true);
		
		$i=0;
		foreach($results as $items){

			$result[$i]=array(consecutivo=>$items[consecutivo],oficina=>$items[oficina],fecha_orden_compra=>$items[fecha_orden_compra],proveedor_nombre=>$items[proveedor_nombre],tiposervicio=>$items[tiposervicio],descrip_orden_compra=>$items[descrip_orden_compra],solicitud=>$items[solicitud],estado=>$items[estado]);	
			$i++;
		}
		
		return $result;
		
		
  }



   //*************REPORTES SOLICITUDES DE SERVICIO****************//	


  public function getReporteFP_ALL($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$saldos,$Conex){

		if($saldos!=''){
			$dias="DATEDIFF('$hasta',f.vence_factura_proveedor) AS dias,";		
		}else{
			$dias="DATEDIFF(CURDATE(),f.vence_factura_proveedor) AS dias,";
		}

	   	
		$select = "SELECT 
					f.factura_proveedor_id,
					(SELECT GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' )) FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo_id,
					CASE f.fuente_servicio_cod WHEN 'OC' THEN 'ORDEN No ' WHEN 'MC' THEN IF(f.liquidacion_despacho_sobre_id IS NOT NULL,'SOBREFLETE MANIFIESTO No', 'MANIFIESTO No')  WHEN 'DU' THEN IF(f.liquidacion_despacho_sobre_id IS NOT NULL,'SOBREFLETE DESPACHO No', 'DESPACHO No')  ELSE CONCAT_WS('-',(SELECT nombre_bien_servicio FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id),f.fecha_factura_proveedor) END  AS tipo,
					(SELECT consecutivo FROM orden_compra WHERE orden_compra_id=f.orden_compra_id) AS orden_no,
					(SELECT numero_despacho FROM liquidacion_despacho WHERE liquidacion_despacho_id=f.liquidacion_despacho_id) AS manifiesto,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					$dias
					f.codfactura_proveedor,				
					f.fecha_factura_proveedor,
					f.proveedor_id,
					f.vence_factura_proveedor,
					f.valor_factura_proveedor,
					(SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) AS valor_neto,
					
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					
					IF(f.val_anticipos_cruzar IS NULL,IF(f.anticipos_cruzar IS NULL,0,(SELECT valor FROM anticipos_proveedor WHERE anticipos_proveedor_id IN( SUBSTR( REPLACE( f.anticipos_cruzar, '\'', '' ) , 1, (
LENGTH( REPLACE( f.anticipos_cruzar, '\'', '' ) ) ) -1
)))),(SELECT SUBSTRING( REPLACE( f.val_anticipos_cruzar, '\'', '' ) , 1, (
LENGTH( REPLACE( f.val_anticipos_cruzar, '\'', '' ) ) ) -1
)))as anticipos,
					
					
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f
				WHERE f.estado_factura_proveedor='C' AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id) $puc_id $tipo_documento_id
				AND ((SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)
				OR 	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos) IS NULL )
				ORDER BY f.proveedor_id ASC, f.fecha_factura_proveedor ASC,f.vence_factura_proveedor ASC, f.oficina_id ASC ";////echo $select;
    	$results = $this -> DbFetchAll($select,$Conex,true);
		$i=0;
		foreach($results as $items){
			$anticipos = is_numeric($items[anticipos])? intval($items[anticipos]) : 0;
			$saldo=(intval($items[valor_neto])-intval($items[abonos]))-$anticipos; 
			if($saldo>0){
			$result[$i]=array(factura_proveedor_id=>$items[factura_proveedor_id],consecutivo_id=>$items[consecutivo_id],tipo=>$items[tipo],orden_no=>$items[orden_no],manifiesto=>$items[manifiesto],codfactura_proveedor=>$items[codfactura_proveedor],fecha_factura_proveedor=>$items[fecha_factura_proveedor],vence_factura_proveedor=>$items[vence_factura_proveedor],dias=>$items[dias],oficina=>$items[oficina],proveedor_nombre=>$items[proveedor_nombre],valor_factura_proveedor=>$items[valor_factura_proveedor],valor_neto=>$items[valor_neto],abonos=>$items[abonos],saldo=>$saldo,puc_id=>$puc_id,tipo_documento_id=>$tipo_documento_id);	
			$i++;
			}
		}

		return $result;
  
  }

  public function getReporteRF_ALL($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$saldos,$Conex){  //ok

		if($saldos!=''){
			$dias="DATEDIFF('$hasta',f.vence_factura_proveedor) AS dias,";		
		}else{
			$dias="DATEDIFF(CURDATE(),f.vence_factura_proveedor) AS dias,";
		}

	   	
		$select = "SELECT 
					f.factura_proveedor_id,
					(SELECT GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' )) FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo_id,
					CASE f.fuente_servicio_cod WHEN 'OC' THEN 'ORDEN No ' WHEN 'MC' THEN IF(f.liquidacion_despacho_sobre_id IS NOT NULL,'SOBREFLETE MANIFIESTO No', 'MANIFIESTO No')  WHEN 'DU' THEN IF(f.liquidacion_despacho_sobre_id IS NOT NULL,'SOBREFLETE DESPACHO No', 'DESPACHO No')  ELSE CONCAT_WS('-',(SELECT nombre_bien_servicio FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id),f.fecha_factura_proveedor) END  AS tipo,
					(SELECT consecutivo FROM orden_compra WHERE orden_compra_id=f.orden_compra_id) AS orden_no,
					(SELECT numero_despacho FROM liquidacion_despacho WHERE liquidacion_despacho_id=f.liquidacion_despacho_id) AS manifiesto,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					$dias
					(SELECT codigo_centro FROM oficina WHERE oficina_id=f.oficina_id) AS centro,
					f.codfactura_proveedor,				
					f.fecha_factura_proveedor,
					f.proveedor_id,
					f.vence_factura_proveedor,
					f.valor_factura_proveedor,

					(SELECT  GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ))
					 FROM  abono_factura_proveedor ab, relacion_abono_factura ra, encabezado_de_registro er 
					 WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id) AS relacion_pago,
					 
					 (SELECT  GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ))
					 FROM  anticipos_proveedor ab, encabezado_de_registro er 
					 WHERE ab.anticipos_proveedor_id IN (SELECT SUBSTRING( REPLACE( f.anticipos_cruzar, '\'', '' ) , 1, (
LENGTH( REPLACE( f.anticipos_cruzar, '\'', '' ) ) ) -1
)) AND er.encabezado_registro_id=ab.encabezado_registro_id) AS relacion_anticipos,

					CASE f.estado_factura_proveedor WHEN 'C' THEN 'CONTABILIZADA' WHEN 'A' THEN 'EDICION' ELSE 'ANULADA' END AS estado,
					(SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) AS valor_neto,
					
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					
					IF(f.val_anticipos_cruzar IS NULL,IF(f.anticipos_cruzar IS NULL,0,(SELECT valor FROM anticipos_proveedor WHERE anticipos_proveedor_id IN( SUBSTR( REPLACE( f.anticipos_cruzar, '\'', '' ) , 1, (
LENGTH( REPLACE( f.anticipos_cruzar, '\'', '' ) ) ) -1
)))),(SELECT SUBSTRING( REPLACE( f.val_anticipos_cruzar, '\'', '' ) , 1, (
LENGTH( REPLACE( f.val_anticipos_cruzar, '\'', '' ) ) ) -1
)))as anticipos,
					
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f
				WHERE  f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' $puc_id $tipo_documento_id AND f.oficina_id IN ($oficina_id)
				ORDER BY f.fecha_factura_proveedor  ASC,f.proveedor_id ASC, f.oficina_id ASC, f.codfactura_proveedor ASC "; //echo $select;

    	$results = $this -> DbFetchAll($select,$Conex,true);

		$i=0;
		foreach($results as $items){

			$anticipos = is_numeric($items[anticipos])? intval($items[anticipos]) : 0;
			$saldo=(intval($items[valor_neto])-intval($items[abonos]))-$anticipos; 
			$result[$i]=array(factura_proveedor_id=>$items[factura_proveedor_id],consecutivo_id=>$items[consecutivo_id],tipo=>$items[tipo],orden_no=>$items[orden_no],manifiesto=>$items[manifiesto],codfactura_proveedor=>$items[codfactura_proveedor],fecha_factura_proveedor=>$items[fecha_factura_proveedor],vence_factura_proveedor=>$items[vence_factura_proveedor],dias=>$items[dias],oficina=>$items[oficina],proveedor_nombre=>$items[proveedor_nombre],valor_factura_proveedor=>$items[valor_factura_proveedor],valor_neto=>$items[valor_neto],abonos=>$items[abonos],saldo=>$saldo,estado=>$items[estado],centro=>$items[centro],relacion_pago=>$items[relacion_pago],relacion_anticipos=>$items[relacion_anticipos],puc_id=>$puc_id,tipo_documento_id=>$tipo_documento_id);	
			$i++;
		}

		return $result;
  
  }

    public function getReporteEC_ALL($oficina_id,$desde,$hasta,$saldos,$puc_id,$tipo_documento_id,$consulta,$Conex){

		$select  = "SELECT f.factura_proveedor_id,
	            (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
				FROM tercero t, proveedor c WHERE t.tercero_id = c.tercero_id AND c.proveedor_id=f.proveedor_id)AS proveedor,
				(SELECT t.numero_identificacion FROM tercero t, proveedor c WHERE t.tercero_id = c.tercero_id AND c.proveedor_id=f.proveedor_id)AS numero_identificacion,
				f.codfactura_proveedor,
				(SELECT 'FACTURA DE COMPRA')AS tipo_documento,
				(SELECT f.concepto_factura_proveedor)AS concepto,
				f.fecha_factura_proveedor,
				f.vence_factura_proveedor,
				DATEDIFF(CURDATE(),f.vence_factura_proveedor) AS dias,
				(CASE f.estado_factura_proveedor WHEN 'A' THEN 'EDICION' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'ANULADA' END)AS estado,
				(SELECT SUM(d.cre_item_factura_proveedor) FROM item_factura_proveedor d WHERE d.factura_proveedor_id = f.factura_proveedor_id AND d.contra_factura_proveedor=1 ORDER BY d.item_factura_proveedor_id DESC) AS valor,
				
				(SELECT IF((SELECT r.factura_proveedor_id FROM relacion_abono_factura r WHERE f.factura_proveedor_id = r.factura_proveedor_id LIMIT 1)>0,
                (IF((SELECT r.rel_valor_mayor_factura FROM relacion_abono_factura r WHERE r.factura_proveedor_id = f.factura_proveedor_id LIMIT 1 )>0,
                (SELECT (SUM(d.cre_item_factura_proveedor) - r.rel_valor_abono_factura - r.rel_valor_mayor_factura) FROM item_factura_proveedor d, relacion_abono_factura r WHERE d.factura_proveedor_id = f.factura_proveedor_id AND r.factura_proveedor_id = f.factura_proveedor_id AND d.contra_factura_proveedor=1 AND f.factura_proveedor_id IN(SELECT r.factura_proveedor_id FROM relacion_abono_factura r,abono_factura_proveedor a WHERE r.factura_proveedor_id = f.factura_proveedor_id AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id AND a.estado_abono_factura != 'I' AND (SELECT SUM(r.rel_valor_abono_factura)-(SELECT SUM(d.cre_item_factura_proveedor) FROM item_factura_proveedor d WHERE d.factura_proveedor_id = r.factura_proveedor_id AND d.contra_factura_proveedor=1) FROM relacion_abono_factura r, abono_factura_proveedor a WHERE r.factura_proveedor_id = f.factura_proveedor_id AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id AND a.estado_abono_factura != 'I') = 0 GROUP BY r.factura_proveedor_id) ORDER BY d.item_factura_proveedor_id DESC),
                (SELECT (SUM(d.cre_item_factura_proveedor) - r.rel_valor_abono_factura) FROM item_factura_proveedor d, relacion_abono_factura r WHERE d.factura_proveedor_id = f.factura_proveedor_id AND r.factura_proveedor_id = f.factura_proveedor_id AND f.factura_proveedor_id NOT IN(SELECT r.factura_proveedor_id FROM relacion_abono_factura r,abono_factura_proveedor a WHERE r.factura_proveedor_id = f.factura_proveedor_id AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id AND a.estado_abono_factura != 'I' AND (SELECT SUM(r.rel_valor_abono_factura)-(SELECT SUM(d.cre_item_factura_proveedor) FROM item_factura_proveedor d WHERE d.factura_proveedor_id = r.factura_proveedor_id AND d.contra_factura_proveedor=1) FROM relacion_abono_factura r, abono_factura_proveedor a WHERE r.factura_proveedor_id = f.factura_proveedor_id AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id AND a.estado_abono_factura != 'I') = 0 GROUP BY r.factura_proveedor_id) ORDER BY d.item_factura_proveedor_id DESC))),
                (SELECT SUM(d.cre_item_factura_proveedor) FROM item_factura_proveedor d, relacion_abono_factura r WHERE d.factura_proveedor_id = f.factura_proveedor_id AND d.contra_factura_proveedor=1 ORDER BY d.item_factura_proveedor_id DESC)))AS valor_pendiente,
				
				0 AS abonos,
				(SELECT SUM(a.valor_descu_factura) FROM abono_factura_proveedor a, relacion_abono_factura r WHERE f.factura_proveedor_id = r.factura_proveedor_id AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id GROUP BY r.factura_proveedor_id) AS descuento,
				0 AS descuento_mayor,
				(SELECT SUM(a.valor_abono_factura) FROM abono_factura_proveedor a, relacion_abono_factura r WHERE f.factura_proveedor_id = r.factura_proveedor_id AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id GROUP BY r.factura_proveedor_id) AS abono_factura,
                (SELECT SUM(a.valor_neto_factura) FROM abono_factura_proveedor a, relacion_abono_factura r WHERE f.factura_proveedor_id = r.factura_proveedor_id AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id GROUP BY r.factura_proveedor_id) AS valor_neto

				
	            FROM  factura_proveedor f 
				WHERE f.oficina_id IN($oficina_id) AND (f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta') $consulta";
	
				$result_factura  = $this -> DbFetchAll($select,$Conex,true);
				if($result_factura > 0){

					for($i = 0; $i<count($result_factura); $i++){
						
						$factura_proveedor_id = $result_factura[$i]['factura_proveedor_id'];
						$arrayReporte[$i]['factura'] =$result_factura;

					    $select  = "SELECT f.abono_factura_proveedor_id,
								(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
								FROM tercero t, proveedor c WHERE t.tercero_id = c.tercero_id AND c.proveedor_id=f.proveedor_id)AS proveedor,
								(SELECT t.numero_identificacion FROM tercero t, proveedor c WHERE t.tercero_id = c.tercero_id AND c.proveedor_id=f.proveedor_id)AS numero_identificacion,
								(SELECT e.consecutivo FROM encabezado_de_registro e WHERE f.encabezado_registro_id = e.encabezado_registro_id AND e.estado = 'C')AS consecutivo,
								(SELECT e.encabezado_registro_id FROM encabezado_de_registro e WHERE f.encabezado_registro_id = e.encabezado_registro_id AND e.estado = 'C')AS encabezado_registro_id,
								(SELECT t.nombre FROM tipo_de_documento t WHERE t.tipo_documento_id=f.tipo_documento_id)AS tipo_documento,
								(SELECT CONCAT_WS(' ','CANC FACT COMPRA: ',(SELECT fv.codfactura_proveedor FROM factura_proveedor fv WHERE fv.factura_proveedor_id = r.factura_proveedor_id AND r.abono_factura_proveedor_id = f.abono_factura_proveedor_id))) AS concepto,
								f.fecha,
								'' AS vencimiento,
								(CASE f.estado_abono_factura WHEN 'A' THEN 'EDICION' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'ANULADA' END)AS estado,
								0 AS valor,
								r.rel_valor_descu_factura AS abonos_desc,
								r.rel_valor_mayor_factura AS mayor_pago,
								r.rel_valor_abono_factura AS valor_abono
								
								FROM  abono_factura_proveedor f,relacion_abono_factura r 
								WHERE f.abono_factura_proveedor_id=r.abono_factura_proveedor_id AND r.factura_proveedor_id=$factura_proveedor_id AND f.oficina_id IN($oficina_id) $saldos";
						        
								$result_descuento = $this -> DbFetchAll($select,$Conex,true);
								$arrayReporte[$i]['descuento'] = $result_descuento;
					}
				}
				return $arrayReporte;
  
    }
  
  public function getReportePE_ALL($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$saldos,$Conex){

	if($saldos!=''){
		$dias="DATEDIFF('$hasta',f.vence_factura_proveedor) AS dias,";		
	}else{
		$dias="DATEDIFF(CURDATE(),f.vence_factura_proveedor) AS dias,";
	}


	$select = "SELECT 
					f.factura_proveedor_id,
					(SELECT GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' )) FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo_id,
					CASE f.fuente_servicio_cod WHEN 'OC' THEN 'ORDEN No ' WHEN 'MC' THEN IF(f.liquidacion_despacho_sobre_id IS NOT NULL,'SOBREFLETE MANIFIESTO No', 'MANIFIESTO No')  WHEN 'DU' THEN IF(f.liquidacion_despacho_sobre_id IS NOT NULL,'SOBREFLETE DESPACHO No', 'DESPACHO No')  ELSE CONCAT_WS('-',(SELECT nombre_bien_servicio FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id),f.fecha_factura_proveedor) END  AS tipo,
					(SELECT consecutivo FROM orden_compra WHERE orden_compra_id=f.orden_compra_id) AS orden_no,
					(SELECT numero_despacho FROM liquidacion_despacho WHERE liquidacion_despacho_id=f.liquidacion_despacho_id) AS manifiesto,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					$dias
					f.codfactura_proveedor,				
					f.fecha_factura_proveedor,
					f.proveedor_id,
					f.vence_factura_proveedor,
					f.valor_factura_proveedor,
					(SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) AS valor_neto,
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					
				IF(f.val_anticipos_cruzar IS NULL,IF(f.anticipos_cruzar IS NULL,0,(SELECT valor FROM anticipos_proveedor WHERE anticipos_proveedor_id IN( SUBSTR( REPLACE( f.anticipos_cruzar, '\'', '' ) , 1, (
LENGTH( REPLACE( f.anticipos_cruzar, '\'', '' ) ) ) -1
)))),(SELECT SUBSTRING( REPLACE( f.val_anticipos_cruzar, '\'', '' ) , 1, (
LENGTH( REPLACE( f.val_anticipos_cruzar, '\'', '' ) ) ) -1
)))as anticipos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
			FROM factura_proveedor f
			WHERE  f.estado_factura_proveedor='C' AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id) $puc_id
				AND ((SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)
				OR 	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos) IS NULL)
				ORDER BY f.proveedor_id ASC,f.fecha_factura_proveedor  ASC,f.codfactura_proveedor ASC, f.oficina_id ASC ";
////echo $select;
    	$results = $this -> DbFetchAll($select,$Conex,true);
		$i=0;
		foreach($results as $items){
			$anticipos = is_numeric($items[anticipos])? intval($items[anticipos]) : 0;
			$saldo=(intval($items[valor_neto])-intval($items[abonos]))-$anticipos; 
			if($saldo>0){
				$result[$i]=array(factura_proveedor_id=>$items[factura_proveedor_id],consecutivo_id=>$items[consecutivo_id],tipo=>$items[tipo],orden_no=>$items[orden_no],manifiesto=>$items[manifiesto],codfactura_proveedor=>$items[codfactura_proveedor],fecha_factura_proveedor=>$items[fecha_factura_proveedor],vence_factura_proveedor=>$items[vence_factura_proveedor],dias=>$items[dias],oficina=>$items[oficina],proveedor_nombre=>$items[proveedor_nombre],valor_factura_proveedor=>$items[valor_factura_proveedor],valor_neto=>$items[valor_neto],abonos=>$items[abonos],saldo=>$saldo,puc_id=>$puc_id,tipo_documento_id=>$tipo_documento_id);	
				$i++;
			}
		}

		return $result;
  
  }
  
}



?>