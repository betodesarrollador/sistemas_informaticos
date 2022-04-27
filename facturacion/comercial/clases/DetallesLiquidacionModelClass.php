<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesLiquidacionModel extends Db{

  private $Permisos;


  public function getOficina($comisiones_id,$Conex){
	  $select = "SELECT oficina_id FROM comisiones WHERE comisiones_id = $comisiones_id";
	  $result = $this -> DbFetchAll($select,$Conex,true);

	  for($i=0; $i<$result; $i++){
		  $oficina_id = $result[$i]['oficina_id'];
		  return $oficina_id;
	  }
	 
	
  }
  
  public function getReporteR1($oficina_id,$desde,$hasta,$Conex){ 	   	
 
 		/*$select="SELECT af.abono_factura_id,
						(SELECT f.consecutivo_factura FROM relacion_abono ra, factura f  WHERE ra.abono_factura_id=af.abono_factura_id AND f.factura_id = ra.factura_id )as factura,
						
						(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=af.cliente_id AND  t.tercero_id=c.tercero_id ) as cliente,
		
			FROM abono_factura af WHERE af.fecha BETWEEN '$desde' AND '$hasta' AND af.estado_abono_factura ='C' AND af.oficina_id IN($oficina_id) ";*/
 
	    $select = "SELECT 
					f.factura_id,
					f.cliente_id,
					f.observacion,
					CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS comercial_nombre FROM cliente c, tercero t, comercial co, comerciales_cliente cc WHERE c.cliente_id=f.cliente_id AND c.cliente_id = cc.cliente_id AND co.comercial_id = cc.comercial_id AND t.tercero_id=co.tercero_id AND cc.tipo_recaudo = 'R' AND cc.oficina_id=f.oficina_id) as comercial_nombre,
					(SELECT cc.comercial_id FROM comerciales_cliente cc WHERE cc.cliente_id=f.cliente_id)as comercial_id,
					
					
					
					(SELECT d.codigo_centro_costo FROM   detalle_factura_puc d WHERE d.factura_id=f.factura_id AND d.codigo_centro_costo IS NOT NULL LIMIT 0,1) AS centro,
					f.consecutivo_factura,				
					f.fecha,
					f.cliente_id,
					f.observacion,
					f.vencimiento,
					f.valor,
					CASE f.estado WHEN 'I' THEN 'ANULADA' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'EDICION' END AS estados,
					
					
					(SELECT  GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ))
					 FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  AND er.encabezado_registro_id=ab.encabezado_registro_id  AND ab.fecha BETWEEN '$desde' AND '$hasta'
					) AS relacion_pago,
					
					
					(SELECT  GROUP_CONCAT(er.fecha) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  AND er.encabezado_registro_id=ab.encabezado_registro_id AND ab.fecha BETWEEN '$desde' AND '$hasta'
					) AS fecha_relacion_pago,
					
					
					(SELECT  SUM(ra.rel_valor_abono-ra.rel_valor_descu) FROM abono_factura ab, relacion_abono ra
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  					AND ab.fecha BETWEEN '$desde' AND '$hasta'
					) AS valor_relacion_pago,

					(SELECT DATEDIFF((SELECT er.fecha FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  AND er.encabezado_registro_id=ab.encabezado_registro_id LIMIT 1
					),f.fecha)) AS diferencia_dias,
					
					(SELECT pc.rec_rango1 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango1,
					(SELECT pc.rec_rango2 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango2,
					(SELECT pc.rec_rango3 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango3,
					(SELECT pc.rec_rango4 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango4,
					(SELECT pc.fac_rango1 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango_1,
					(SELECT pc.fac_rango2 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango_2,
					(SELECT pc.fac_rango3 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango_3,
					(SELECT pc.fac_rango4 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango_4,
					
					
					(SELECT cc.tipo_variable FROM comerciales_cliente cc WHERE cc.cliente_id=f.cliente_id) AS tipo_variable,
					(SELECT cc.porcentaje_fijo FROM comerciales_cliente cc WHERE cc.cliente_id=f.cliente_id) AS porcentaje_fijo,
					
					(SELECT (deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
					(SELECT SUM(deb_item_factura+cre_item_factura) AS valor_iva  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND desc_factura LIKE '%IVA%' ) AS valor_iva,
					(SELECT SUM(deb_item_factura+cre_item_factura) AS valor_iva  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND desc_factura LIKE '%ICA%' ) AS valor_ica,
					(SELECT SUM(deb_item_factura+cre_item_factura) AS valor_rte  FROM detalle_factura_puc df, impuesto i WHERE  df.factura_id=f.factura_id AND i.puc_id=df.puc_id AND i.exentos='RT' ) AS valor_rte,					
					
					(SELECT SUM(ra.rel_valor_abono-ra.rel_valor_descu) AS abonos FROM  relacion_abono ra, abono_factura ab 
					WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  )	AS abonos,
					
					(SELECT DATEDIFF(CURDATE(),(SELECT c.fecha_ingreso FROM cliente c WHERE c.cliente_id=f.cliente_id))) as dias_cliente,
					
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
					
				FROM factura f
				WHERE   f.factura_id IN( SELECT ra.factura_id FROM relacion_abono ra, abono_factura af WHERE af.abono_factura_id=ra.abono_factura_id AND af.fecha BETWEEN '$desde' AND '$hasta' AND af.estado_abono_factura !='I' AND ra.factura_id = f.factura_id)  AND f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura ) AND f.oficina_id IN ($oficina_id) 
				
				
				
				ORDER BY comercial_nombre asc , f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC "; 
				
$results = $this -> DbFetchAll($select,$Conex,true);
		  $i=0;
		  
		  
		foreach($results as $items){
			
			if($items[dias_cliente]<365){
				$tipo_cliente='NUEVO';
			}
			else{
				$tipo_cliente='MANTENIMIENTO';
			}
		$saldo=floatval($items[valor_neto])-floatval($items[abonos]); 
		
	if($saldo<1){
			$valor_pago=$items[valor_neto];
			
		 if($items[tipo_variable]=='F'){
				
				$comision=(floatval($items[abonos])*floatval($items[porcentaje_fijo]))/100;
				$porcentaje = $items[porcentaje_fijo];
		}
		else{
			
			if ($items[diferencia_dias]<46){
				if($tipo_cliente=='NUEVO'){
					$comision=(floatval($items[abonos])*floatval($items[rango1]))/100;
					$porcentaje = $items[rango1];
				}else{
					$comision=(floatval($items[valor_neto])*floatval($items[rango_1]))/100;
					$porcentaje = $items[rango_1];
				}
				
			}elseif ($items[diferencia_dias]>45 && $items[diferencia_dias]<61){
				if($tipo_cliente=='NUEVO'){
					$comision=(floatval($items[valor_neto])*floatval($items[rango2]))/100;
					$porcentaje = $items[rango2];
				}else{
					$comision=(floatval($items[valor_neto])*floatval($items[rango_2]))/100;
					$porcentaje = $items[rango_2];
				}
			}elseif ($items[diferencia_dias]>60 && $items[diferencia_dias]<91){
				if($tipo_cliente=='NUEVO'){
					$comision=(floatval($items[valor_neto])*floatval($items[rango3]))/100;
					$porcentaje = $items[rango3];
				}else{
					$comision=(floatval($items[valor_neto])*floatval($items[rango_3]))/100;
					$porcentaje = $items[rango_3];

				}
			}else{
				if($tipo_cliente=='NUEVO'){
					$comision=(floatval($items[valor_relacion_pago])*floatval($items[rango4]))/100;
					$porcentaje = $items[rango4];
				}else{
					$comision=(floatval($items[valor_relacion_pago])*floatval($items[rango_4]))/100;
					$porcentaje = $items[rango_4];
					
				}
			}
		  }
		}else if($saldo>0){
			
			if($items[dias_cliente]<365){
				$tipo_cliente='NUEVO';
			}
			else{
				$tipo_cliente='MANTENIMIENTO';
			}
			
			$valor_pago=floatval($items[valor_neto])-floatval($saldo);
				
		 if($items[tipo_variable]=='F'){
				
				$comision=((floatval($items[abonos])-(floatval($saldo)))*floatval($items[porcentaje_fijo]))/100;
				$porcentaje = $items[porcentaje_fijo];
		}
		else{
			
			if ($items[diferencia_dias]<46){
				if($tipo_cliente=='NUEVO'){
					$comision=(floatval($items[abonos])*floatval($items[rango1]))/100;
					$porcentaje = $items[rango1];
				}else{
					$comision=(floatval($items[abonos])*floatval($items[rango_1]))/100;
					$porcentaje = $items[rango_1];
				}
				
			}elseif ($items[diferencia_dias]>45 && $items[diferencia_dias]<61){
				if($tipo_cliente=='NUEVO'){
					$comision=(floatval($items[abonos])*floatval($items[rango2]))/100;
					$porcentaje = $items[rango2];
				}else{
					$comision=(floatval($items[abonos])*floatval($items[rango_2]))/100;
					$porcentaje = $items[rango_2];
				}
			}elseif ($items[diferencia_dias]>60 && $items[diferencia_dias]<91){
				if($tipo_cliente=='NUEVO'){
					$comision=(floatval($items[abonos])*floatval($items[rango3]))/100;
					$porcentaje = $items[rango3];
				}else{
					$comision=(floatval($items[abonos])*floatval($items[rango_3]))/100;
					$porcentaje = $items[rango_3];

				}
			}else{
				if($tipo_cliente=='NUEVO'){
					$comision=(floatval($items[abonos])*floatval($items[rango4]))/100;
					$porcentaje = $items[rango4];
				}else{
					$comision=(floatval($items[abonos])*floatval($items[rango_4]))/100;
					$porcentaje = $items[rango_4];
					
				}
			}
		  }
		}
			
			$result[$i]=array(factura_id=>$items[factura_id],consecutivo_factura=>$items[consecutivo_factura],concepto=>$items[observacion],estado=>$items[estados],tipo=>$items[tipo],fecha=>$items[fecha],vencimiento=>$items[vencimiento],centro=>$items[centro],oficina=>$items[oficina],comercial_nombre=>$items[comercial_nombre],cliente_nombre=>$items[cliente_nombre],valor=>$items[valor],valor_neto=>$items[valor_neto],valor_iva=>$items[valor_iva],valor_ica=>$items[valor_ica],valor_rte=>$items[valor_rte],abonos=>$items[abonos],diferencia_dias=>$items[diferencia_dias],
				relacion_pago=>$items[relacion_pago],fecha_relacion_pago=>$items[fecha_relacion_pago],valor_relacion_pago=>$valor_pago,saldo=>$saldo,comision=>$comision,porcentaje=>$porcentaje,comercial_id=>$items[comercial_id],cliente_id=>$items[cliente_id],tipo_cliente=>$tipo_cliente);
			$i++;
		}
		  return $result;
  } 
  
  public function getReporteF1($oficina_id,$desde,$hasta,$Conex){ 
	   	
  	    $select = "SELECT 
		  f.cliente_id,
		  f.observacion,
		  CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		  (SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS comercial_nombre FROM cliente c, tercero t, comercial co WHERE c.cliente_id=f.cliente_id AND co.comercial_id = c.comercial_id AND t.tercero_id=co.tercero_id) as comercial_nombre,
		  (SELECT pc.fac_rango1 FROM porcentaje_comision_comercial pc , cliente c, tercero t, comercial co WHERE c.cliente_id=f.cliente_id AND co.comercial_id = c.comercial_id AND t.tercero_id=co.tercero_id AND pc.comercial_id=co.comercial_id) AS porc_comision,
		  (SELECT d.codigo_centro_costo FROM   detalle_factura_puc d WHERE d.factura_id=f.factura_id AND d.codigo_centro_costo IS NOT NULL LIMIT 0,1) AS centro,
		  f.consecutivo_factura,				
		  f.fecha,
		  f.vencimiento,
		  ROUND(f.valor) AS valor,
		  
		  CASE f.estado WHEN 'I' THEN 'ANULADA' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'EDICION' END AS estados,
		  (SELECT GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ))
		  FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  AND er.encabezado_registro_id=ab.encabezado_registro_id) AS relacion_pago,
		  
		(SELECT (deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
		(SELECT SUM(deb_item_factura+cre_item_factura) AS valor_iva  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND desc_factura LIKE '%IVA%' ) AS valor_iva,
		(SELECT SUM(deb_item_factura+cre_item_factura) AS valor_iva  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND desc_factura LIKE '%ICA%' ) AS valor_ica,
		(SELECT SUM(deb_item_factura+cre_item_factura) AS valor_rte  FROM detalle_factura_puc df, impuesto i WHERE  df.factura_id=f.factura_id AND i.puc_id=df.puc_id AND i.exentos='RT' ) AS valor_rte,					

		  (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM relacion_abono ra, abono_factura ab 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' )	AS abonos,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
		  FROM factura f
		  WHERE  f.fecha BETWEEN '$desde' AND '$hasta' AND f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura ) AND f.oficina_id IN ($oficina_id) AND f.estado NOT LIKE '%I%'
		  ORDER BY comercial_nombre asc,  f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC "; //echo $select;	

$results = $this -> DbFetchAll($select,$Conex);
		  $i=0;
		foreach($results as $items){

			$saldo=floatval($items[valor_neto])-floatval($items[abonos]); 
			$result[$i]=array(factura_id=>$items[factura_id],consecutivo_factura=>$items[consecutivo_factura],concepto=>$items[observacion],estado=>$items[estados],tipo=>$items[tipo],porc_comision=>$items[porc_comision],fecha=>$items[fecha],vencimiento=>$items[vencimiento],centro=>$items[centro],oficina=>$items[oficina],comercial_nombre=>$items[comercial_nombre],cliente_nombre=>$items[cliente_nombre],valor=>$items[valor],valor_neto=>$items[valor_neto],valor_iva=>$items[valor_iva],valor_ica=>$items[valor_ica],valor_rte=>$items[valor_rte],abonos=>$items[abonos],relacion_pago=>$items[relacion_pago],saldo=>$saldo);	
			$i++;
		}

		return $result;
		 
  } 
  
   
  public function getReporteF2($oficina_id,$desde,$hasta,$cliente_id,$Conex){
	  		 
	  $select = "SELECT 
	       f.cliente_id,
	       f.observacion,
		  CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		  (SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS comercial_nombre FROM cliente c, tercero t, comercial co WHERE c.cliente_id=f.cliente_id AND co.comercial_id = c.comercial_id AND t.tercero_id=co.tercero_id) as comercial_nombre,
		   (SELECT pc.fac_rango1 FROM porcentaje_comision_comercial pc , cliente c, tercero t, comercial co WHERE c.cliente_id=f.cliente_id AND co.comercial_id = c.comercial_id AND t.tercero_id=co.tercero_id AND pc.comercial_id=co.comercial_id) AS porc_comision,
		  (SELECT d.codigo_centro_costo FROM detalle_factura_puc d WHERE d.factura_id=f.factura_id AND d.codigo_centro_costo IS NOT NULL LIMIT 0,1) AS centro,
		  f.consecutivo_factura,				
		  f.fecha,
		  f.vencimiento,
		  ROUND(f.valor) AS valor,
		  
		  CASE f.estado WHEN 'I' THEN 'ANULADA' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'EDICION' END AS estados,
		  (SELECT GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ))
		  FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id) AS relacion_pago,
		  
			(SELECT (deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
			(SELECT SUM(deb_item_factura+cre_item_factura) AS valor_iva  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND desc_factura LIKE '%IVA%' ) AS valor_iva,
			(SELECT SUM(deb_item_factura+cre_item_factura) AS valor_iva  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND desc_factura LIKE '%ICA%' ) AS valor_ica,
			(SELECT SUM(deb_item_factura+cre_item_factura) AS valor_rte  FROM detalle_factura_puc df, impuesto i WHERE  df.factura_id=f.factura_id AND i.puc_id=df.puc_id AND i.exentos='RT' ) AS valor_rte,					

		  (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )	AS abonos,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
		  FROM factura f
		  WHERE f.cliente_id=$cliente_id AND f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura ) AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
		  ORDER BY comercial_nombre asc , f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC"; //echo $select;	

$results = $this -> DbFetchAll($select,$Conex,true);
		  return $results;	  
   }  
   
  public function getReporteR2($oficina_id,$desde,$hasta,$cliente_id,$Conex){
	  		
  	    $select = "SELECT 
					f.factura_id,
					f.cliente_id,
					f.observacion,
					CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS comercial_nombre FROM cliente c, tercero t, comercial co, comerciales_cliente cc WHERE c.cliente_id=f.cliente_id AND c.cliente_id = cc.cliente_id AND co.comercial_id = cc.comercial_id AND t.tercero_id=co.tercero_id AND cc.tipo_recaudo = 'R' AND cc.oficina_id=f.oficina_id) as comercial_nombre,
					(SELECT cc.comercial_id FROM comerciales_cliente cc WHERE cc.cliente_id=f.cliente_id)as comercial_id,
					
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
					
					(SELECT  SUM(ra.rel_valor_abono-ra.rel_valor_descu) FROM abono_factura ab, relacion_abono ra
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  					AND ab.fecha BETWEEN '$desde' AND '$hasta'
					) AS valor_relacion_pago,

					(SELECT DATEDIFF((SELECT er.fecha FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  AND er.encabezado_registro_id=ab.encabezado_registro_id LIMIT 1
					),f.fecha)) AS diferencia_dias,
					
					(SELECT pc.rec_rango1 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango1,
					(SELECT pc.rec_rango2 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango2,
					(SELECT pc.rec_rango3 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango3,
					(SELECT pc.rec_rango4 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango4,
					
					(SELECT DATEDIFF(CURDATE(),(SELECT c.fecha_ingreso FROM cliente c WHERE c.cliente_id=f.cliente_id))) as dias_cliente,
					
					
					(SELECT cc.tipo_variable FROM comerciales_cliente cc WHERE cc.cliente_id=f.cliente_id) AS tipo_variable,
					(SELECT cc.porcentaje_fijo FROM comerciales_cliente cc WHERE cc.cliente_id=f.cliente_id) AS porcentaje_fijo,
					
					(SELECT (deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
					(SELECT SUM(deb_item_factura+cre_item_factura) AS valor_iva  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND desc_factura LIKE '%IVA%' ) AS valor_iva,
					(SELECT SUM(deb_item_factura+cre_item_factura) AS valor_iva  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND desc_factura LIKE '%ICA%' ) AS valor_ica,
					(SELECT SUM(deb_item_factura+cre_item_factura) AS valor_rte  FROM detalle_factura_puc df, impuesto i WHERE  df.factura_id=f.factura_id AND i.puc_id=df.puc_id AND i.exentos='RT' ) AS valor_rte,					

					(SELECT SUM(ra.rel_valor_abono) AS abonos FROM  relacion_abono ra, abono_factura ab 
					WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  )	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre,
					(SELECT ra.abono_factura_id FROM relacion_abono ra WHERE ra.factura_id=f.factura_id ORDER BY ra.abono_factura_id DESC LIMIT 1)AS abono_factura_id
				FROM factura f
				WHERE f.cliente_id=$cliente_id AND f.estado='C' AND f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura ) AND f.factura_id IN( SELECT ra.factura_id FROM relacion_abono ra, abono_factura af WHERE af.abono_factura_id=ra.abono_factura_id AND af.fecha BETWEEN '$desde' AND '$hasta' AND af.estado_abono_factura !='I' AND ra.factura_id = f.factura_id) AND f.oficina_id IN ($oficina_id) AND f.factura_id IN (SELECT ra.factura_id FROM relacion_abono ra  )
				ORDER BY comercial_nombre asc ,  f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC"; 	

$results = $this -> DbFetchAll($select,$Conex,true);
		  $i=0;
		  
		foreach($results as $items){
			
			if($items[dias_cliente]<365){
				$tipo_cliente='NUEVO';
			}
			else{
				$tipo_cliente='MANTENIMIENTO';
			}
			
			
		$saldo=floatval($items[valor_neto])-floatval($items[abonos]); 
		
		if($saldo<1){
			$valor_pago=$items[valor_neto];
			
			if($items[tipo_variable]=='F'){
				
				$comision=(floatval($items[valor_neto])*floatval($items[porcentaje_fijo]))/100;
				$porcentaje = $items[porcentaje_fijo];
		}
		else{
			if ($items[diferencia_dias]<31){
				
				$comision=(floatval($items[valor_neto])*floatval($items[rango1]))/100;
				$porcentaje = $items[rango1];
				
			}elseif ($items[diferencia_dias]>30 && $items[diferencia_dias]<61){
				
				$comision=(floatval($items[valor_neto])*floatval($items[rango2]))/100;
				$porcentaje = $items[rango2];
				
			}elseif ($items[diferencia_dias]>60 && $items[diferencia_dias]<91){
				
				$comision=(floatval($items[valor_neto])*floatval($items[rango3]))/100;
				$porcentaje = $items[rango3];
				
			}else{
				
				$comision=(floatval($items[valor_relacion_pago])*floatval($items[rango4]))/100;
				$porcentaje = $items[rango4];
			}
		}
		}else if($saldo>0){
			$valor_pago=floatval($items[valor_neto])-floatval($saldo);
			
			if($items[tipo_variable]=='F'){
				
				$comision=((floatval($items[valor_neto])-(floatval($saldo)))*floatval($items[porcentaje_fijo]))/100;
				$porcentaje = $items[porcentaje_fijo];
		}
		else{
			if ($items[diferencia_dias]<31){
				
				$comision=((floatval($items[valor_neto])-(floatval($saldo)))*floatval($items[rango1]))/100;
				$porcentaje = $items[rango1];
				
			}elseif ($items[diferencia_dias]>30 && $items[diferencia_dias]<61){
				
				$comision=((floatval($items[valor_neto])-(floatval($saldo)))*floatval($items[rango2]))/100;
				$porcentaje = $items[rango2];
				
			}elseif ($items[diferencia_dias]>60 && $items[diferencia_dias]<91){
				
				$comision=((floatval($items[valor_neto])-(floatval($saldo)))*floatval($items[rango3]))/100;
				$porcentaje = $items[rango3];
				
			}else{
								
				$comision=((floatval($items[valor_neto])-(floatval($saldo)))*floatval($items[rango4]))/100;
				$porcentaje = $items[rango4];
			}
		}
		}
		
			
			$result[$i]=array(factura_id=>$items[factura_id],consecutivo_factura=>$items[consecutivo_factura],concepto=>$items[observacion],estado=>$items[estados],tipo=>$items[tipo],fecha=>$items[fecha],vencimiento=>$items[vencimiento],centro=>$items[centro],oficina=>$items[oficina],comercial_nombre=>$items[comercial_nombre],cliente_nombre=>$items[cliente_nombre],valor=>$items[valor],valor_neto=>$items[valor_neto],valor_iva=>$items[valor_iva],valor_ica=>$items[valor_ica],valor_rte=>$items[valor_rte],abonos=>$items[abonos],diferencia_dias=>$items[diferencia_dias],
				relacion_pago=>$items[relacion_pago],fecha_relacion_pago=>$items[fecha_relacion_pago],valor_relacion_pago=>$valor_pago,saldo=>$saldo,comision=>$comision,porcentaje=>$porcentaje,comercial_id=>$items[comercial_id],cliente_id=>$items[cliente_id],tipo_cliente=>$tipo_cliente,abono_factura_id=>$items[abono_factura_id]);
			$i++;
		}
	
		  return $result;
   } 
   
 
public function getReporteF3($oficina_id,$desde,$hasta,$comercial_id,$Conex){
	  		 
	  $select = "SELECT 
		  CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		  (SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS comercial_nombre FROM cliente c, tercero t, comercial co WHERE c.cliente_id=f.cliente_id AND co.comercial_id = c.comercial_id AND t.tercero_id=co.tercero_id) as comercial_nombre,
		   (SELECT pc.fac_rango1 FROM porcentaje_comision_comercial pc , cliente c, tercero t, comercial co WHERE c.cliente_id=f.cliente_id AND co.comercial_id = c.comercial_id AND t.tercero_id=co.tercero_id AND pc.comercial_id=co.comercial_id) AS porc_comision,
		  (SELECT d.codigo_centro_costo FROM detalle_factura_puc d WHERE d.factura_id=f.factura_id AND d.codigo_centro_costo IS NOT NULL LIMIT 0,1) AS centro,
		  f.consecutivo_factura,				
		  f.fecha,
		  f.vencimiento,
		  ROUND(f.valor) AS valor,
		  
		  CASE f.estado WHEN 'I' THEN 'ANULADA' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'EDICION' END AS estados,
		  (SELECT GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ))
		  FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id) AS relacion_pago,
		  
		(SELECT (deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
		(SELECT SUM(deb_item_factura+cre_item_factura) AS valor_iva  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND desc_factura LIKE '%IVA%' ) AS valor_iva,
		(SELECT SUM(deb_item_factura+cre_item_factura) AS valor_iva  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND desc_factura LIKE '%ICA%' ) AS valor_ica,
		(SELECT SUM(deb_item_factura+cre_item_factura) AS valor_rte  FROM detalle_factura_puc df, impuesto i WHERE  df.factura_id=f.factura_id AND i.puc_id=df.puc_id AND i.exentos='RT' ) AS valor_rte,					

		  (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )	AS abonos,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
		  FROM factura f
		  WHERE f.cliente_id IN (SELECT cliente_id FROM comerciales_cliente WHERE comercial_id=$comercial_id) AND f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura ) AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
		  ORDER BY comercial_nombre asc , f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC"; //echo $select;	

$results = $this -> DbFetchAll($select,$Conex,true);
		  return $results;	  
   }  
   
  public function getReporteR3($oficina_id,$desde,$hasta,$comercial_id,$Conex){

	    $select = "SELECT 
					f.factura_id,
					f.cliente_id,
					f.observacion,
					CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS comercial_nombre FROM cliente c, tercero t, comercial co, comerciales_cliente cc WHERE c.cliente_id=f.cliente_id AND c.cliente_id = cc.cliente_id AND co.comercial_id = cc.comercial_id AND cc.comercial_id=$comercial_id AND t.tercero_id=co.tercero_id AND cc.tipo_recaudo = 'R' AND cc.oficina_id=f.oficina_id) as comercial_nombre,
					(SELECT cc.comercial_id FROM comerciales_cliente cc WHERE cc.cliente_id=f.cliente_id AND cc.comercial_id=$comercial_id)as comercial_id,
					
					
					
					(SELECT d.codigo_centro_costo FROM   detalle_factura_puc d WHERE d.factura_id=f.factura_id AND d.codigo_centro_costo IS NOT NULL LIMIT 0,1) AS centro,
					f.consecutivo_factura,				
					f.fecha,
					f.cliente_id,
					f.vencimiento,
					f.valor,
					CASE f.estado WHEN 'I' THEN 'ANULADA' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'EDICION' END AS estados,
					
					
					(SELECT  GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ))
					 FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  AND er.encabezado_registro_id=ab.encabezado_registro_id  AND ab.fecha BETWEEN '$desde' AND '$hasta'
					) AS relacion_pago,
					(SELECT  GROUP_CONCAT(er.fecha) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  AND er.encabezado_registro_id=ab.encabezado_registro_id AND ab.fecha BETWEEN '$desde' AND '$hasta'
					) AS fecha_relacion_pago,
					(SELECT  SUM(ra.rel_valor_abono-ra.rel_valor_descu) FROM abono_factura ab, relacion_abono ra
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  					AND ab.fecha BETWEEN '$desde' AND '$hasta'
					) AS valor_relacion_pago,

					(SELECT DATEDIFF((SELECT er.fecha FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  AND er.encabezado_registro_id=ab.encabezado_registro_id LIMIT 1
					),f.fecha)) AS diferencia_dias,
					
					(SELECT pc.rec_rango1 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE cc.comercial_id=$comercial_id AND pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango1,
					(SELECT pc.rec_rango2 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE cc.comercial_id=$comercial_id AND pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango2,
					(SELECT pc.rec_rango3 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE cc.comercial_id=$comercial_id AND pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango3,
					(SELECT pc.rec_rango4 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE cc.comercial_id=$comercial_id AND pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango4,
					(SELECT pc.fac_rango1 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE cc.comercial_id=$comercial_id AND pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango_1,
					(SELECT pc.fac_rango2 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE cc.comercial_id=$comercial_id AND pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango_2,
					(SELECT pc.fac_rango3 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE cc.comercial_id=$comercial_id AND pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango_3,
					(SELECT pc.fac_rango4 FROM porcentaje_comision_comercial pc,comerciales_cliente cc WHERE cc.comercial_id=$comercial_id AND pc.comercial_id=cc.comercial_id AND cc.cliente_id=f.cliente_id) as rango_4,
					
					
					(SELECT cc.tipo_variable FROM comerciales_cliente cc WHERE cc.comercial_id=$comercial_id AND cc.cliente_id=f.cliente_id) AS tipo_variable,
					(SELECT cc.porcentaje_fijo FROM comerciales_cliente cc WHERE cc.comercial_id=$comercial_id AND cc.cliente_id=f.cliente_id) AS porcentaje_fijo,
					
					(SELECT (deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
					(SELECT SUM(deb_item_factura+cre_item_factura) AS valor_iva  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND desc_factura LIKE '%IVA%' ) AS valor_iva,
					(SELECT SUM(deb_item_factura+cre_item_factura) AS valor_iva  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND desc_factura LIKE '%ICA%' ) AS valor_ica,
					(SELECT SUM(deb_item_factura+cre_item_factura) AS valor_rte  FROM detalle_factura_puc df, impuesto i WHERE  df.factura_id=f.factura_id AND i.puc_id=df.puc_id AND i.exentos='RT' ) AS valor_rte,					
					
					(SELECT SUM(ra.rel_valor_abono) AS abonos FROM  relacion_abono ra, abono_factura ab 
					WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C'  )	AS abonos,
					
					(SELECT DATEDIFF(CURDATE(),(SELECT c.fecha_ingreso FROM cliente c WHERE c.cliente_id=f.cliente_id))) as dias_cliente,
					
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
				FROM factura f
				WHERE f.cliente_id IN (SELECT cliente_id FROM comerciales_cliente WHERE comercial_id=$comercial_id) AND f.estado='C' AND f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura ) AND f.factura_id IN( SELECT ra.factura_id FROM relacion_abono ra, abono_factura af WHERE af.abono_factura_id=ra.abono_factura_id AND af.fecha BETWEEN '$desde' AND '$hasta' AND af.estado_abono_factura !='I' AND ra.factura_id = f.factura_id) AND f.oficina_id IN ($oficina_id) AND f.factura_id IN (SELECT ra.factura_id FROM relacion_abono ra)
				ORDER BY comercial_nombre asc ,  f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC"; //echo $select;	

$results = $this -> DbFetchAll($select,$Conex,true);
		  $i=0;
		  
		foreach($results as $items){
			
			if($items[dias_cliente]<365){
				$tipo_cliente='NUEVO';
			}
			else{
				$tipo_cliente='MANTENIMIENTO';
			}
			
		$saldo=floatval($items[valor_neto])-floatval($items[abonos]); 
		
		if($saldo<1){
			$valor_pago=$items[valor_neto];
			
			if($items[tipo_variable]=='F'){
				
				$comision=(floatval($items[valor_neto])*floatval($items[porcentaje_fijo]))/100;
				$porcentaje = $items[porcentaje_fijo];
		}
		else{
			if ($items[diferencia_dias]<31){
				
				$comision=(floatval($items[valor_neto])*floatval($items[rango1]))/100;
				$porcentaje = $items[rango1];
				
			}elseif ($items[diferencia_dias]>30 && $items[diferencia_dias]<61){
				
				$comision=(floatval($items[valor_neto])*floatval($items[rango2]))/100;
				$porcentaje = $items[rango2];
				
			}elseif ($items[diferencia_dias]>60 && $items[diferencia_dias]<91){
				
				$comision=(floatval($items[valor_neto])*floatval($items[rango3]))/100;
				$porcentaje = $items[rango3];
				
			}else{
				
				$comision=(floatval($items[valor_relacion_pago])*floatval($items[rango4]))/100;
				$porcentaje = $items[rango4];
			}
		}
		}else if($saldo>0){
			$valor_pago=floatval($items[valor_neto])-floatval($saldo);
			
			if($items[tipo_variable]=='F'){
				
				$comision=((floatval($items[valor_neto])-(floatval($saldo)))*floatval($items[porcentaje_fijo]))/100;
				$porcentaje = $items[porcentaje_fijo];
		}
		else{
			if ($items[diferencia_dias]<31){
				
				$comision=((floatval($items[valor_neto])-(floatval($saldo)))*floatval($items[rango1]))/100;
				$porcentaje = $items[rango1];
				
			}elseif ($items[diferencia_dias]>30 && $items[diferencia_dias]<61){
				
				$comision=((floatval($items[valor_neto])-(floatval($saldo)))*floatval($items[rango2]))/100;
				$porcentaje = $items[rango2];
				
			}elseif ($items[diferencia_dias]>60 && $items[diferencia_dias]<91){
				
				$comision=((floatval($items[valor_neto])-(floatval($saldo)))*floatval($items[rango3]))/100;
				$porcentaje = $items[rango3];
				
			}else{
								
				$comision=((floatval($items[valor_neto])-(floatval($saldo)))*floatval($items[rango4]))/100;
				$porcentaje = $items[rango4];
			}
		}
		}
			
			$result[$i]=array(factura_id=>$items[factura_id],consecutivo_factura=>$items[consecutivo_factura],concepto=>$items[observacion],estado=>$items[estados],tipo=>$items[tipo],fecha=>$items[fecha],vencimiento=>$items[vencimiento],centro=>$items[centro],oficina=>$items[oficina],comercial_nombre=>$items[comercial_nombre],cliente_nombre=>$items[cliente_nombre],valor=>$items[valor],valor_neto=>$items[valor_neto],valor_iva=>$items[valor_iva],valor_ica=>$items[valor_ica],valor_rte=>$items[valor_rte],abonos=>$items[abonos],diferencia_dias=>$items[diferencia_dias],
				relacion_pago=>$items[relacion_pago],fecha_relacion_pago=>$items[fecha_relacion_pago],valor_relacion_pago=>$valor_pago,saldo=>$saldo,comision=>$comision,porcentaje=>$porcentaje,comercial_id=>$items[comercial_id],cliente_id=>$items[cliente_id],tipo_cliente=>$tipo_cliente);
			$i++;
		}
		  return $result;
   } 
   
   public function Save($cliente_id,$desde,$hasta,$comercial_id,$tipo,$valor,$porcentaje,$oficina_id,$usuario_id,$Conex){
	   
	  require_once("UtilidadesContablesModelClass.php");	
      $UtilidadesContables = new UtilidadesContablesModel();
	
		$select = "SELECT comisiones_id FROM comisiones WHERE cliente_id=$cliente_id AND comercial_id=$comercial_id AND fecha_inicio='$desde' AND fecha_final='$hasta' AND valor_comision=$valor";
		$result = $this -> DbFetchAll($select,$Conex);
		
		 if($result[0]['comisiones_id'] > 0){
			 
	  		exit("Ya se liquido esta comision! <br /> Por favor verifique");
	     }else{
		 
		 $select = "SELECT * FROM parametros_liquidacion_comisiones WHERE oficina_id = $oficina_id";
	     $result = $this  -> DbFetchAll($select,$Conex,true);		   

	  if(!count($result) > 0){
	    print "<p align='center'>No ha ingresado los parametros de liquidacion!!<br>estos parametros se asignan por Parametros Modulo -> Liquidacion</p>";
		$this -> RollBack($Conex);
		exit();
	  }else{
		  $tipo_documento_id          = $result[0]['tipo_documento_id'];
          $valor_comision_id           = $result[0]['valor_comision_id'];
		  $naturaleza_valor_comision   = $result[0]['naturaleza_valor_comision'];
		  
          $sobre_flete_id             = $result[0]['sobre_flete_id'];
		  $naturaleza_sobre_flete     = $result[0]['naturaleza_sobre_flete'];		  
		  
		  $reteica_id                = $result[0]['reteica_id'];
		  $naturaleza_reteica        = $result[0]['naturaleza_reteica'];
		  $comisiones_por_pagar_id         = $result[0]['comisiones_por_pagar_id'];
		  $naturaleza_comisiones_por_pagar = $result[0]['naturaleza_comisiones_por_pagar']; 
		 	
		  
		  if(!is_numeric($valor_comision_id))   exit("<div align='center'>Aun no ha parametrizado la cuenta contable para concepto de flete</div>
 		                                             <div align='center'><br><b>modulo de Transporte -> Parametros Modulo -> Liquidacion</b></div>");
		  if(!is_numeric($comisiones_por_pagar_id)) exit("<div align='center'><b>Aun no ha parametrizado la cuenta contable para concepto de saldo pagar</b></div>
 		                                             <div align='center'><br><b>modulo de Transporte -> Parametros Modulo -> Liquidacion</b></div>");			  
		
		$valor_comision = str_replace(",",".",$valor);	
	
		 $comisiones_id = $this	->	DbgetMaxConsecutive("comisiones","comisiones_id",$Conex,false,1);
		$insert = "INSERT INTO comisiones (comisiones_id,cliente_id,fecha_inicio,fecha_final,fecha_ingreso,comercial_id,tipo_liquidacion,estado,valor_comision,usuario_id,oficina_id,tipo_documento_id)VALUES
		($comisiones_id,$cliente_id,'$desde','$hasta',(SELECT CURDATE()),$comercial_id,'$tipo','L',$valor,$usuario_id,$oficina_id,$tipo_documento_id)";
		$this -> query($insert,$Conex,true);
		
		 	  
	  
		$select                    = "SELECT oficina_id FROM comisiones WHERE comisiones_id = $comisiones_id";
		$dataOficinaPlanillo       = $this  -> DbFetchAll($select,$Conex,true);		   	  	  
		$oficina_planillo_id       = $dataOficinaPlanillo[0]['oficina_id'];
		

		$select                    = "SELECT * FROM tercero WHERE tercero_id = (SELECT tercero_id FROM comercial WHERE comercial_id= $comercial_id)";
		$datatercero       		   = $this  -> DbFetchAll($select,$Conex,true);		   	  	  
		$tercero_id      		   = $datatercero[0]['tercero_id'];
		$numero_identificacion 	   = $datatercero[0]['numero_identificacion'];
		$digito_verificacion 	   = $datatercero[0]['digito_verificacion'] > 0 ? "'{$datatercero[0]['digito_verificacion']}'" : 'NULL';
		
		$sel_fecha				   = "SELECT CURDATE() as fecha";
		$result_fecha			   = $this  -> DbFetchAll($sel_fecha,$Conex,true);		
		$fecha					   = $result_fecha[0]['fecha'];
		
		$select = "SELECT * FROM centro_de_costo WHERE oficina_id = $oficina_id";
		  $result = $this  -> DbFetchAll($select,$Conex,true);			   
	   
		  $centro_de_costo_id  = $result[0]['centro_de_costo_id'];
		  $codigo_centro_costo = strlen(trim($result[0]['codigo'])) > 0 ? "'{$result[0]['codigo']}'" : 'NULL'; 
		
		
		
		  
		   $select = "SELECT * FROM tercero WHERE tercero_id = (SELECT tercero_id FROM comercial WHERE comercial_id = $comercial_id)";
	  	   $result = $this  -> DbFetchAll($select,$Conex,true);			
		 if($this -> GetNumError() > 0){
	          $this -> RollBack($Conex);
			  exit();
			}else{				

                $detalle_comision_puc_id = $this -> DbgetMaxConsecutive("detalle_comisiones_puc","detalle_comision_puc_id",$Conex,false,1);		        
				
				if($naturaleza_valor_comision == 'D'){
				  $debito  = $valor_comision;
				  $credito = 0;
				}else{
				    $debito  = 0;
				    $credito = $valor_comision;
				  }
				  
				$puc_id = $valor_comision_id;
				
				if($UtilidadesContables -> requiereTercero($puc_id,$Conex)){     
				  $tercero_liquidacion_id             = $tercero_id; 
				  $numero_identificacion_liquidacion  = $numero_identificacion; 
				  $digito_verificacion_liquidacion    = $digito_verificacion;
				}else{
				     $tercero_liquidacion_id             = 'NULL'; 
				     $numero_identificacion_liquidacion  = 'NULL'; 
				     $digito_verificacion_liquidacion    = 'NULL';				
				    }
				
				if($UtilidadesContables -> requiereCentroCosto($puc_id,$Conex)){ 
				    $centro_costo_liquidacion_id     = $centro_de_costo_id; 
				    $codigo_centro_costo_liquidacion = $codigo_centro_costo; 				
				}else{
				      $centro_costo_liquidacion_id     = 'NULL'; 
				      $codigo_centro_costo_liquidacion = 'NULL'; 				
				}
				$porcentaje = 'NULL';  
				$descripcion = "VALOR BASE COMISION ";
				
				$insert = "INSERT INTO detalle_comisiones_puc (detalle_comision_puc_id,comision_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_comision,porcentaje_comision,formula_comision,desc_comision,deb_item_comision,cre_item_comision)
				VALUES ($detalle_comision_puc_id,$comisiones_id,$puc_id,$tercero_liquidacion_id,
				$numero_identificacion_liquidacion,$digito_verificacion_liquidacion,$centro_costo_liquidacion_id,$codigo_centro_costo_liquidacion,$valor_comision,$porcentaje,NULL,'$descripcion',$debito,$credito);";
				$this -> query($insert,$Conex,true);												
				
				$comisiones_por_pagar = $valor_comision;
		
		if($comisiones_por_pagar > 0){	
						
					if($naturaleza_comisiones_por_pagar == 'D'){
						$debito  = $comisiones_por_pagar;
						$credito = 0;			  
					}else{
						$debito  = 0;
						$credito = $comisiones_por_pagar;			  
						}
					
					$puc_id =  $comisiones_por_pagar_id;

					if($UtilidadesContables -> requiereTercero($puc_id,$Conex)){     
					$tercero_liquidacion_id             = $tercero_id; 
					$numero_identificacion_liquidacion  = $numero_identificacion; 
					$digito_verificacion_liquidacion    = $digito_verificacion;
					}else{
						$tercero_liquidacion_id             = 'NULL'; 
						$numero_identificacion_liquidacion  = 'NULL'; 
						$digito_verificacion_liquidacion    = 'NULL';				
						}
					
					if($UtilidadesContables -> requiereCentroCosto($puc_id,$Conex)){ 
						$centro_costo_liquidacion_id     = $centro_de_costo_id; 
						$codigo_centro_costo_liquidacion = $codigo_centro_costo; 				
					}else{
						$centro_costo_liquidacion_id     = 'NULL'; 
						$codigo_centro_costo_liquidacion = 'NULL'; 				
					}		  			  
						
					$detalle_comision_puc_id = $this -> DbgetMaxConsecutive("detalle_comisiones_puc","detalle_comision_puc_id",$Conex,false,1);				
						
					$descripcion = "COMISION A PAGAR";
						
					$insert = "INSERT INTO detalle_comisiones_puc (detalle_comision_puc_id,comision_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_comision,porcentaje_comision,formula_comision,desc_comision,deb_item_comision,cre_item_comision,contra_comision,valor_liquida) VALUES 
					($detalle_comision_puc_id,$comisiones_id,$puc_id,$tercero_liquidacion_id,$numero_identificacion_liquidacion,$digito_verificacion_liquidacion,$centro_costo_liquidacion_id,$codigo_centro_costo_liquidacion,NULL,NULL,NULL,'$descripcion',$debito,$credito,1,$comisiones_por_pagar);";
										
					$this -> query($insert,$Conex,true);				
					
					$update = "UPDATE comisiones SET valor_neto_pagar = $comisiones_por_pagar WHERE comisiones_id=$comisiones_id";
					$this -> query($update,$Conex,true);	
		}
							
					}
		
		return $comisiones_id;
		
	   }
		
   }
   }
    public function SaveDetalles($detalles,$comisiones_id,$Conex){
		$i=0;
		foreach ($detalles as $items){
			$detalle_comisiones_id = $this	->	DbgetMaxConsecutive("detalle_comisiones","detalle_comisiones_id",$Conex,false,1);
			$insert = "INSERT INTO detalle_comisiones
			(detalle_comisiones_id,factura_id,comisiones_id,abono_factura_id,cliente_id) VALUES
			($detalle_comisiones_id,
			 $items[factura_id],
			 $comisiones_id,
			 $items[abono_factura_id],
			 $items[cliente_id])";
			$this -> query($insert,$Conex,true);			
		}
		return true;
	}
   
 
}

?>