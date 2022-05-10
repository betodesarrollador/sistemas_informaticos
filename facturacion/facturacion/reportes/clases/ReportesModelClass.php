<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ReportesModel extends Db{
		
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
	return $this -> DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina",$Conex,
	$ErrDb = false);
   }

   public function GetTipo($Conex){
	$opciones=array(0 => array ( 'value' => 'FP', 'text' => 'Facturas Pendientes' ), 1 => array ( 'value' => 'RF', 'text' => 'Relaci&oacute;n Facturas'), 2 => array ( 'value' => 'EC', 'text' => 'Estado De Cuenta'), 3 => array ( 'value' => 'PE', 'text' => 'Cartera Por Edades'), 4 => array ( 'value' => 'RP', 'text' => 'Remesas Pendientes'),5 => array ( 'value' => 'CP', 'text' => 'Contado Pendientes') ,6 => array ( 'value' => 'CC', 'text' => 'Contado Con cierre'),7 => array ( 'value' => 'RE', 'text' => 'Recaudos'),8 => array ( 'value' => 'VE', 'text' => 'Ventas'));
	return $opciones;
   }

   public function GetSi_Pro($Conex){
	$opciones=array(0 => array ( 'value' => '1', 'text' => 'UNO' ), 1 => array ( 'value' => 'ALL', 'text' => 'TODOS') );
	return $opciones;
   }

   public function GetSi_Com($Conex){
	$opciones=array(0 => array ( 'value' => '1', 'text' => 'UNO' ), 1 => array ( 'value' => 'ALL', 'text' => 'TODOS') );
	return $opciones;
   }

   public function getReporteFP1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$Conex){  //ok
	   	
		$select = "SELECT 
		  (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS cliente_nombre 
		  FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre,(SELECT t.numero_identificacion AS cliente_id FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_ident,
		  CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		  (SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		  f.consecutivo_factura, f.fecha, f.vencimiento,
		  DATEDIFF(CURDATE(),f.vencimiento) AS dias,
		  ROUND(f.valor,0) AS valor,
		  (SELECT ROUND((deb_item_factura+cre_item_factura)) AS neto  FROM detalle_factura_puc WHERE factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
		  (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )AS abonos,

		   ((SELECT ROUND(deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1)-
			IF((SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
			WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )>0,
			   (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
			WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ),0)) AS saldo,
			(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS comercial FROM tercero t, comercial co, cliente c WHERE f.cliente_id=c.cliente_id AND c.comercial_id=co.comercial_id AND co.tercero_id=t.tercero_id) AS comercial,

		(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t, ejecutivo co  WHERE c.cliente_id=f.cliente_id AND c.ejecutivo_id=co.ejecutivo_id AND co.tercero_id=t.tercero_id)  AS ejecutivo

		  
		  FROM factura f
		  WHERE f.cliente_id=$cliente_id AND f.estado='C' AND f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura WHERE reporta_cartera=1 ) AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
		  AND ((SELECT ROUND((deb_item_factura+cre_item_factura)) AS neto  FROM detalle_factura_puc WHERE factura_id=f.factura_id AND contra_factura=1) >	
		  (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab WHERE ra.factura_id=f.factura_id 
		  AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos) OR (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM relacion_abono ra,abono_factura ab 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos) IS NULL)
		  ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC "; 
		//echo $select;
    	$results = $this -> DbFetchAll($select,$Conex);
		return $results;  
  }

	public function getReporteRF1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$Conex){  //ok
	   	
		$select = "SELECT 
		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre,(SELECT t.numero_identificacion AS cliente_id FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_ident	,	

		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM cliente c, tercero t, comercial co  WHERE c.cliente_id=f.cliente_id AND c.comercial_id=co.comercial_id AND co.tercero_id=t.tercero_id)  AS comercial,
		(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t, ejecutivo co  WHERE c.cliente_id=f.cliente_id AND c.ejecutivo_id=co.ejecutivo_id AND co.tercero_id=t.tercero_id)  AS ejecutivo,
		
		
		CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		(SELECT d.codigo_centro_costo FROM detalle_factura_puc d WHERE d.factura_id=f.factura_id AND d.codigo_centro_costo IS NOT NULL LIMIT 0,1) AS centro,
		f.consecutivo_factura,
		f.fecha,
		f.vencimiento,
		IF (f.estado!='I',ROUND(f.valor),0) AS valor,
		CASE f.estado WHEN 'I' THEN 'ANULADA' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'EDICION' END AS estado,

	    (SELECT nombre FROM forma_compra_venta WHERE forma_compra_venta_id=f.forma_compra_venta_id ) AS forma_venta,
	    (SELECT nombre_bien_servicio_factura FROM tipo_bien_servicio_factura WHERE tipo_bien_servicio_factura_id=f.tipo_bien_servicio_factura_id ) AS tipo_servicio,
		f.observacion AS concepto,

		(SELECT ROUND((deb_item_factura+cre_item_factura)) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,

		(SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )	AS abonos,
		
	   ((SELECT ROUND(deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1)-
		IF((SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )>0,
		   (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )-(SELECT SUM((deb_item_abono+cre_item_abono)) AS valor_impuestos FROM  item_abono i, relacion_abono ra, abono_factura ab 
					WHERE i.porcentaje_abono > 0 AND i.abono_factura_id = ra.abono_factura_id AND ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ),0)) AS saldo
		
		FROM factura f
		WHERE f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura WHERE reporta_cartera=1 ) AND f.cliente_id=$cliente_id AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
		ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC"; 

		$results = $this -> DbFetchAll($select,$Conex);
		return $results;  
  }
  
    public function getReporteRE1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$Conex){  //ok
	   	
		$select = "SELECT  
					CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					(SELECT d.codigo_centro_costo FROM   detalle_factura_puc d WHERE d.factura_id=f.factura_id AND d.codigo_centro_costo IS NOT NULL LIMIT 0,1) AS centro,
					f.consecutivo_factura,				
					f.fecha,
					f.cliente_id,
					f.vencimiento,
					f.valor,
					f.observacion as concepto,
					CASE f.estado WHEN 'I' THEN 'ANULADA' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'EDICION' END AS estados,
					(SELECT  GROUP_CONCAT(er.consecutivo)
					 FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id
					) AS relacion_pago,
					(SELECT  GROUP_CONCAT(er.fecha) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id
					) AS fecha_relacion_pago,
					(SELECT  SUM(ra.rel_valor_abono) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id
					) AS valor_relacion_pago,

					(SELECT DATEDIFF((SELECT er.fecha FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id LIMIT 1
					),f.fecha)) AS dias_diferencia_pago,
					
					(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS comercial FROM tercero t, comercial co, cliente c WHERE f.cliente_id=c.cliente_id AND c.comercial_id=co.comercial_id AND co.tercero_id=t.tercero_id) AS comercial,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t, ejecutivo co  WHERE c.cliente_id=f.cliente_id AND c.ejecutivo_id=co.ejecutivo_id AND co.tercero_id=t.tercero_id)  AS ejecutivo,
					
					(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)) AS usuario FROM tercero t, usuario u, abono_factura ab, relacion_abono ra 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND ab.usuario_id=u.usuario_id AND u.tercero_id=t.tercero_id) AS usuario,

					
					(SELECT (deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
					(SELECT SUM(ra.rel_valor_abono) AS abonos FROM  relacion_abono ra, abono_factura ab 
					WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre,(SELECT t.numero_identificacion AS cliente_id FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_ident
								
				FROM factura f
				WHERE f.cliente_id=$cliente_id AND f.estado='C' AND f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura WHERE reporta_cartera=1 ) AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				AND f.factura_id IN ( SELECT ra.factura_id FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id )
				
				ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC "; 
					// echo $select;
    	$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){

			$saldo=floatval($items[valor_neto])-floatval($items[abonos]); 
			$result[$i]=array(consecutivo_factura=>$items[consecutivo_factura],cliente_ident=>$items[cliente_ident],cliente_nombre=>$items[cliente_nombre],oficina=>$items[oficina],estado=>$items[estados],
				tipo=>$items[tipo],fecha=>$items[fecha],vencimiento=>$items[vencimiento],concepto=>$items[concepto],/*centro=>$items[centro],*/
				valor=>$items[valor],/*valor_neto=>$items[valor_neto],abonos=>$items[abonos],*/
				relacion_pago=>$items[relacion_pago],fecha_relacion_pago=>$items[fecha_relacion_pago],valor_relacion_pago=>$items[valor_relacion_pago],saldo=>$saldo,dias_diferencia_pago=>$items[dias_diferencia_pago],comercial=>$items[comercial],ejecutivo=>$items[ejecutivo],usuario=>$items[usuario]);
			$i++;
		}

		return $result;
  
  }

  
  public function getReportePE1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$Conex){  //ok
	   	
		$select = "SELECT 
		  CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		  (SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		  IF(DATEDIFF(CURDATE(),f.vencimiento)>0,DATEDIFF(CURDATE(),f.vencimiento),DATEDIFF(CURDATE(),f.vencimiento)) AS dias,
		  f.consecutivo_factura,				
		  f.fecha,
		  f.vencimiento,
		  ROUND(f.valor) AS valor,
		  (SELECT ROUND(deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
		  (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )	AS abonos,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
		  FROM factura f
		  WHERE f.cliente_id=$cliente_id AND f.estado='C' AND f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura WHERE reporta_cartera=1 ) AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
		  AND ((SELECT ROUND(deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) >
		 (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )
		  OR (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ) IS NULL)
		  ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC"; 

    	$results = $this -> DbFetchAll($select,$Conex);
		return $results;
  
  }
  
  //-----------FILTRO COMERCIALES

  public function getReporteEC1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$consulta,$fecha_corte,$Conex){
	   	
	$select  = "SELECT f.factura_id,
	            (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
				FROM tercero t, cliente c WHERE t.tercero_id = c.tercero_id AND c.cliente_id=f.cliente_id)AS cliente,
				(SELECT t.numero_identificacion FROM tercero t, cliente c WHERE t.tercero_id = c.tercero_id AND c.cliente_id=f.cliente_id)AS numero_identificacion,
				f.consecutivo_factura,
				(SELECT t.nombre FROM tipo_de_documento t WHERE t.tipo_documento_id=f.tipo_documento_id)AS tipo_documento,
				f.concepto,
				f.fecha,
				f.vencimiento,
				DATEDIFF(CURDATE(),f.vencimiento) AS dias,
				(CASE f.estado WHEN 'A' THEN 'EDICION' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'ANULADA' END)AS estado,
				(SELECT d.valor_liquida FROM detalle_factura_puc d WHERE d.factura_id = f.factura_id ORDER BY d.detalle_factura_puc_id DESC LIMIT 1) AS valor,
				0 AS abonos,
				(SELECT SUM(a.valor_descu_factura) FROM abono_factura a, relacion_abono r WHERE f.factura_id = r.factura_id AND r.abono_factura_id = a.abono_factura_id GROUP BY r.factura_id) AS descuento,
				(SELECT SUM(a.valor_mayor_factura) FROM abono_factura a, relacion_abono r WHERE f.factura_id = r.factura_id AND r.abono_factura_id = a.abono_factura_id GROUP BY r.factura_id) AS descuento_mayor,
				(SELECT SUM(a.valor_abono_factura) FROM abono_factura a, relacion_abono r WHERE f.factura_id = r.factura_id AND r.abono_factura_id = a.abono_factura_id GROUP BY r.factura_id) AS abono_factura,
                (SELECT SUM(a.valor_neto_factura) FROM abono_factura a, relacion_abono r WHERE f.factura_id = r.factura_id AND r.abono_factura_id = a.abono_factura_id GROUP BY r.factura_id) AS valor_neto

				
	            FROM  factura f 
				WHERE f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura WHERE reporta_cartera=1 ) AND f.cliente_id = $cliente_id AND f.oficina_id IN($oficina_id) AND f.fecha BETWEEN '$desde' AND '$hasta' $consulta";
	
				$result_factura  = $this -> DbFetchAll($select,$Conex);
				if($result_factura > 0){

					for($i = 0; $i<count($result_factura); $i++){
						
						$factura_id = $result_factura[$i]['factura_id'];
						$arrayReporte[$i]['factura'] =$result_factura;

					    $select  = "SELECT f.abono_factura_id,
								(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
								FROM tercero t, cliente c WHERE t.tercero_id = c.tercero_id AND c.cliente_id=f.cliente_id)AS cliente,
								(SELECT t.numero_identificacion FROM tercero t, cliente c WHERE t.tercero_id = c.tercero_id AND c.cliente_id=f.cliente_id)AS numero_identificacion,
								(SELECT e.consecutivo FROM encabezado_de_registro e WHERE f.encabezado_registro_id = e.encabezado_registro_id AND e.estado = 'C')AS consecutivo,
								(SELECT e.encabezado_registro_id FROM encabezado_de_registro e WHERE f.encabezado_registro_id = e.encabezado_registro_id AND e.estado = 'C')AS encabezado_registro_id,
								(SELECT t.nombre FROM tipo_de_documento t WHERE t.tipo_documento_id=f.tipo_documento_id)AS tipo_documento,
								f.concepto_abono_factura AS concepto,
								f.fecha,
								'' AS vencimiento,
								$fecha_corte
								(CASE f.estado_abono_factura WHEN 'A' THEN 'EDICION' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'ANULADA' END)AS estado,
								0 AS valor,
								r.rel_valor_descu AS abonos_desc,
								r.rel_valor_mayor AS mayor_pago,
								r.rel_valor_abono AS valor_abono
								
								FROM  abono_factura f,relacion_abono r 
								WHERE f.abono_factura_id=r.abono_factura_id AND r.factura_id=$factura_id AND f.cliente_id = $cliente_id AND f.oficina_id IN($oficina_id) $saldos";
						        
								$result_descuento = $this -> DbFetchAll($select,$Conex);
								$arrayReporte[$i]['descuento'] = $result_descuento;
					}
				}
				return $arrayReporte;  
  }
  public function getReporteCP1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$Conex){
	   	
	$select  = "SELECT IF(r.paqueteo=2,'CONTADO','CONTRAENTREGA') AS tipo_remesa,
	(SELECT nombre FROM oficina WHERE oficina_id=r.oficina_id) AS oficina_remesa, 
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
	r.*,
	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t  WHERE c.cliente_id=r.cliente_id AND c.tercero_id=t.tercero_id)  AS cliente,
	r.valor_total AS valor_facturar   FROM remesa r
		  WHERE r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.cliente_id=$cliente_id AND r.paqueteo IN(2,3) AND r.cierre=0 AND r.estado !='AN'
		  ORDER BY r.cliente_id,r.oficina_id ASC
		  ";
	$result  = $this -> DbFetchAll($select,$Conex);
	//echo $select;
	return $result;
  
  }
  public function getReporteCC1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$Conex){
	   	
	$select  = "SELECT IF(r.paqueteo=2,'CONTADO','CONTRAENTREGA') AS tipo_remesa,
	(SELECT nombre FROM oficina WHERE oficina_id=r.oficina_id) AS oficina_remesa, 
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
	r.*,
	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t  WHERE c.cliente_id=r.cliente_id AND c.tercero_id=t.tercero_id)  AS cliente,
	r.valor_total AS valor_facturar   FROM remesa r
		  WHERE r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.cliente_id=$cliente_id AND r.paqueteo IN(2,3) AND r.cierre=1 AND r.estado !='AN'
		  ORDER BY r.cliente_id,r.oficina_id ASC
		  ";
	$result  = $this -> DbFetchAll($select,$Conex);
	//echo $select;
	return $result;
  
  }
  

  public function getReporteRP1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$Conex){  //ok
	   	
		$select = "SELECT 
			r.numero_remesa AS 'No REMESA',
			(SELECT GROUP_CONCAT(m.manifiesto) FROM detalle_despacho dd, manifiesto m WHERE dd.remesa_id=r.remesa_id AND m.manifiesto_id=dd.manifiesto_id AND m.estado!='A') AS 'No. PLANILLA',
			r.fecha_remesa AS 'FECHA REMESA',
			(SELECT nombre FROM oficina WHERE oficina_id=r.oficina_id) AS OFICINA, 
			(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t  WHERE c.cliente_id=r.cliente_id AND c.tercero_id=t.tercero_id)  AS CLIENTE, 
			IF(r.paqueteo=1,'PAQUETEO','MASIVO') AS 'TIPO REMESA', 
			(CASE r.estado WHEN 'P' THEN 'PENDIENTE' WHEN 'PD' THEN 'PENDIENTE' WHEN 'PC' THEN 'PROCESANDO' WHEN 'MF' THEN 'MANIFESTADO' WHEN 'LQ' THEN 'LIQUIDADA' WHEN 'FT' THEN 'FACTURADA' WHEN 'ET' THEN 'ENTREGADA' WHEN 'AN' THEN 'ANULADA' ELSE 'PENDIENTE' END) AS ESTADO,
			IF(r.clase_remesa = 'NN','NORMAL',IF(r.clase_remesa = 'DV','DEVOLUCION',IF(r.clase_remesa = 'CP','COMPLEMENTO',IF(r.clase_remesa = 'AL','ALMACEN','SUMINISTRO')))) AS CLASE,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS ORIGEN,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS DESTINO,
			(SELECT medida FROM medida WHERE medida_id=r.medida_id) AS MEDIDA,
			r.valor_facturar AS 'A FACTURAR'
		FROM 
			remesa r
		WHERE 
			r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND 
			r.oficina_id IN($oficina_id) AND 
			r.estado NOT IN ('AN','FT') AND 
			r.clase_remesa IN ('NN','DV','CP') AND 
			r.cliente_id=$cliente_id AND 
			r.paqueteo NOT IN(2,3)
		ORDER BY 
			cliente";
		  
    	$results = $this -> DbFetchAll($select,$Conex);
		return $results;
  
  }

  public function getReporteRE_ALL($oficina_id,$desde,$hasta,$saldos,$Conex){  //ok
	   	/*
		$select = "SELECT 
					CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					(SELECT d.codigo_centro_costo FROM   detalle_factura_puc d WHERE d.factura_id=f.factura_id AND d.codigo_centro_costo IS NOT NULL LIMIT 0,1) AS centro,
					f.consecutivo_factura,				
					f.fecha,
					f.cliente_id,
					f.vencimiento,
					f.valor,
					CASE f.estado WHEN 'I' THEN 'ANULADA' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'EDICION' END AS estados,
					(SELECT  GROUP_CONCAT(er.consecutivo)
					 FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id
					) AS relacion_pago,
					(SELECT  GROUP_CONCAT(er.fecha) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id
					) AS fecha_relacion_pago,
					(SELECT  SUM(ra.rel_valor_abono) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id
					) AS valor_relacion_pago,
					
					(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS comercial FROM tercero t, comercial co, cliente c WHERE f.cliente_id=c.cliente_id AND c.comercial_id=co.comercial_id AND co.tercero_id=t.tercero_id) AS comercial,
					
					(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)) AS usuario FROM tercero t, usuario u, abono_factura ab, relacion_abono ra 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND ab.usuario_id=u.usuario_id AND u.tercero_id=t.tercero_id) AS usuario,


					(SELECT DATEDIFF((SELECT er.fecha FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id LIMIT 1
					),f.fecha)) AS dias_diferencia_pago,
					
					(SELECT (deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
					(SELECT SUM(ra.rel_valor_abono) AS abonos FROM  relacion_abono ra, abono_factura ab 
					WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre,(SELECT t.numero_identificacion AS cliente_id FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_ident
					(SELECT t.numero_identificacion AS cliente_id FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_ident					
				FROM factura f
				WHERE   f.fecha BETWEEN '$desde' AND '$hasta' AND f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura WHERE reporta_cartera=1 ) AND f.oficina_id IN ($oficina_id)
				AND f.factura_id IN ( SELECT ra.factura_id FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id )
				ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC "; */
				
		$select = "SELECT 
					af.fecha AS fecha_relacion_pago,		
					(SELECT GROUP_CONCAT(er.consecutivo) FROM encabezado_de_registro er WHERE ra.factura_id=f.factura_id AND af.abono_factura_id=ra.abono_factura_id 
					AND af.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=af.encabezado_registro_id) AS relacion_pago,
					(SELECT GROUP_CONCAT(t.nombre) FROM encabezado_de_registro er, tipo_de_documento t WHERE ra.factura_id=f.factura_id AND af.abono_factura_id=ra.abono_factura_id 
					AND af.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=af.encabezado_registro_id AND er.tipo_documento_id=t.tipo_documento_id) AS tipo_documento,
					CASE af.estado_abono_factura WHEN 'I' THEN 'ANULADO' WHEN 'C' THEN 'CONTABILIZADO' ELSE 'EDICION' END AS estado_documento,
					ra.rel_valor_abono AS valor_relacion_pago,
					CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					f.consecutivo_factura,
					f.fecha,
					f.vencimiento,
					f.valor,
					f.cliente_id,
					f.observacion as concepto,
					CASE f.estado WHEN 'I' THEN 'ANULADA' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'EDICION' END AS estados,
					(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS comercial FROM tercero t, comercial co, cliente c WHERE f.cliente_id=c.cliente_id AND c.comercial_id=co.comercial_id AND co.tercero_id=t.tercero_id) AS comercial,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t, ejecutivo co  WHERE c.cliente_id=f.cliente_id AND c.ejecutivo_id=co.ejecutivo_id AND co.tercero_id=t.tercero_id)  AS ejecutivo,					
					(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)) AS usuario FROM tercero t, usuario u 
					 WHERE ra.factura_id=f.factura_id AND af.abono_factura_id=ra.abono_factura_id AND af.estado_abono_factura='C' $saldos AND af.usuario_id=u.usuario_id AND u.tercero_id=t.tercero_id) AS usuario,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre,
					(SELECT t.numero_identificacion AS cliente_id FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_ident	
				FROM factura f, abono_factura af, relacion_abono ra
				WHERE af.fecha BETWEEN '$desde' AND '$hasta' AND ra.abono_factura_id=af.abono_factura_id AND f.factura_id=ra.factura_id AND f.estado!='I'
				ORDER BY  af.abono_factura_id ASC "; //echo $select;
    	$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){

			//$saldo=floatval($items[valor_neto])-floatval($items[abonos]); 
			$result[$i]=array(fecha_recibo_pago=>$items[fecha_relacion_pago],documento_pago=>$items[relacion_pago],tipo_documento=>$items[tipo_documento],estado_documento=>$items[estado_documento],valor_recibo_pago=>$items[valor_relacion_pago],concepto=>$items[concepto],
				tipo=>$items[tipo],oficina=>$items[oficina],consecutivo_factura=>$items[consecutivo_factura],fecha=>$items[fecha],vencimiento=>$items[vencimiento],
				valor=>$items[valor],estado=>$items[estados],ejecutivo=>$items[ejecutivo],comercial=>$items[comercial],usuario=>$items[usuario],cliente_ident=>$items[cliente_ident],cliente_nombre=>$items[cliente_nombre]);	
				
				
			$i++;
		}

		return $result;
  
  }

  public function getReporteFP_ALL($oficina_id,$desde,$hasta,$saldos,$Conex){ //ok 
	   	
		$select = "SELECT 
					CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					DATEDIFF(CURDATE(),f.vencimiento) AS dias,
					f.consecutivo_factura,				
					f.fecha,
					f.vencimiento,
					ROUND(f.valor) AS valor,
					(SELECT ROUND(deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
					(SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
					WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ) AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
				FROM factura f
				WHERE  f.estado='C' AND f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura WHERE reporta_cartera=1 ) AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				AND ((SELECT ROUND(deb_item_factura+cre_item_factura) AS neto FROM detalle_factura_puc WHERE factura_id=f.factura_id AND contra_factura=1) >
				(SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM relacion_abono ra, abono_factura ab 
				WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )
				OR (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
				WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ) IS NULL)
				ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC "; 

    	$results = $this -> DbFetchAll($select,$Conex);
		return $results;  
  }

	public function getReporteRF_ALL($oficina_id,$desde,$hasta,$saldos,$Conex){  //ok
	   	
		$select = "SELECT 
		CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		(SELECT d.codigo_centro_costo FROM   detalle_factura_puc d WHERE d.factura_id=f.factura_id AND d.codigo_centro_costo IS NOT NULL LIMIT 0,1) AS centro,
		f.consecutivo_factura,
		f.fecha,
		f.vencimiento,
		ROUND(f.valor) AS valor,
		CASE f.estado WHEN 'I' THEN 'ANULADA' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'EDICION' END AS estado,
		(SELECT GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ))
		FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id) AS relacion_pago,
		(SELECT ROUND(deb_item_factura+cre_item_factura) AS neto FROM detalle_factura_puc WHERE factura_id=f.factura_id AND contra_factura=1) AS valor_neto,

		IF((SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )>0,

		IF((SELECT SUM((i.deb_item_abono+i.cre_item_abono)) AS valor_impuestos FROM  item_abono i, relacion_abono ra, abono_factura ab 
					WHERE i.porcentaje_abono > 0 AND i.abono_factura_id = ra.abono_factura_id AND ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos)>0,(SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )-(SELECT SUM((i.deb_item_abono+i.cre_item_abono)) AS valor_impuestos FROM  item_abono i, relacion_abono ra, abono_factura ab 
					WHERE i.porcentaje_abono > 0 AND i.abono_factura_id = ra.abono_factura_id AND ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ),(SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )),
					
		0)AS abonos,

		

		(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
		FROM factura f
		WHERE f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura WHERE reporta_cartera=1 ) AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
		ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC "; 

		$results = $this -> DbFetchAll($select,$Conex);
		return $results;  
  }
  
   public function getReporteCP_ALL($oficina_id,$desde,$hasta,$saldos,$Conex){ 
   
	$select  = "SELECT IF(r.paqueteo=2,'CONTADO','CONTRAENTREGA') AS tipo_remesa,
	(SELECT nombre FROM oficina WHERE oficina_id=r.oficina_id) AS oficina_remesa, 
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,r.*  
	r.valor_total AS valor_facturar,
	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t  WHERE c.cliente_id=r.cliente_id AND c.tercero_id=t.tercero_id)  AS cliente
	FROM remesa r
		  WHERE r.fecha_remesa BETWEEN '$desde' AND '$hasta'  AND r.paqueteo IN(2,3) AND r.cierre=0 AND r.estado !='AN' AND r.oficina_id IN ($oficina_id)
		  ORDER BY r.cliente_id, r.oficina_id ASC";
	$result  = $this -> DbFetchAll($select,$Conex);
	//echo $select;
	return $result;
  
  
   
   }
    public function getReporteCC_ALL($oficina_id,$desde,$hasta,$saldos,$Conex){ 
   
	$select  = "SELECT IF(r.paqueteo=2,'CONTADO','CONTRAENTREGA') AS tipo_remesa,
	(SELECT nombre FROM oficina WHERE oficina_id=r.oficina_id) AS oficina_remesa, 
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,r.*  
	r.valor_total AS valor_facturar,
	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t  WHERE c.cliente_id=r.cliente_id AND c.tercero_id=t.tercero_id)  AS cliente
	FROM remesa r
		  WHERE r.fecha_remesa BETWEEN '$desde' AND '$hasta'  AND r.paqueteo IN(2,3) AND r.cierre=1 AND r.estado !='AN' AND r.oficina_id IN ($oficina_id)
		  ORDER BY r.cliente_id, r.oficina_id ASC";
	$result  = $this -> DbFetchAll($select,$Conex);
	//echo $select;
	return $result;
  
  
   
   }

  public function getReporteEC_ALL($oficina_id,$desde,$hasta,$saldos,$consulta,$fecha_corte,$Conex){ ///haciendo
	   	
		$select  = "SELECT f.factura_id,
	            (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
				FROM tercero t, cliente c WHERE t.tercero_id = c.tercero_id AND c.cliente_id=f.cliente_id)AS cliente,
				(SELECT t.numero_identificacion FROM tercero t, cliente c WHERE t.tercero_id = c.tercero_id AND c.cliente_id=f.cliente_id)AS numero_identificacion,
				f.consecutivo_factura,
				(SELECT t.nombre FROM tipo_de_documento t WHERE t.tipo_documento_id=f.tipo_documento_id)AS tipo_documento,
				f.concepto,
				f.fecha,
				f.vencimiento,
				DATEDIFF(CURDATE(),f.vencimiento) AS dias,
				(CASE f.estado WHEN 'A' THEN 'EDICION' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'ANULADA' END)AS estado,
				(SELECT d.valor_liquida FROM detalle_factura_puc d WHERE d.factura_id = f.factura_id ORDER BY d.detalle_factura_puc_id DESC LIMIT 1) AS valor,
				0 AS abonos,
				(SELECT SUM(a.valor_descu_factura) FROM abono_factura a, relacion_abono r WHERE f.factura_id = r.factura_id AND r.abono_factura_id = a.abono_factura_id GROUP BY r.factura_id) AS descuento,
				(SELECT SUM(a.valor_mayor_factura) FROM abono_factura a, relacion_abono r WHERE f.factura_id = r.factura_id AND r.abono_factura_id = a.abono_factura_id GROUP BY r.factura_id) AS descuento_mayor,
				(SELECT SUM(a.valor_abono_factura) FROM abono_factura a, relacion_abono r WHERE f.factura_id = r.factura_id AND r.abono_factura_id = a.abono_factura_id GROUP BY r.factura_id) AS abono_factura,
                (SELECT SUM(a.valor_neto_factura) FROM abono_factura a, relacion_abono r WHERE f.factura_id = r.factura_id AND r.abono_factura_id = a.abono_factura_id GROUP BY r.factura_id) AS valor_neto

				
	            FROM  factura f 
				WHERE f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura WHERE reporta_cartera=1 ) AND f.oficina_id IN($oficina_id) AND f.fecha BETWEEN '$desde' AND '$hasta' $consulta";
	
				$result_factura  = $this -> DbFetchAll($select,$Conex);
				if($result_factura > 0){

					for($i = 0; $i<count($result_factura); $i++){
						
						$factura_id = $result_factura[$i]['factura_id'];
						$arrayReporte[$i]['factura'] =$result_factura;

					    $select  = "SELECT f.abono_factura_id,
								(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
								FROM tercero t, cliente c WHERE t.tercero_id = c.tercero_id AND c.cliente_id=f.cliente_id)AS cliente,
								(SELECT t.numero_identificacion FROM tercero t, cliente c WHERE t.tercero_id = c.tercero_id AND c.cliente_id=f.cliente_id)AS numero_identificacion,
								(SELECT e.consecutivo FROM encabezado_de_registro e WHERE f.encabezado_registro_id = e.encabezado_registro_id AND e.estado = 'C')AS consecutivo,
								(SELECT e.encabezado_registro_id FROM encabezado_de_registro e WHERE f.encabezado_registro_id = e.encabezado_registro_id AND e.estado = 'C')AS encabezado_registro_id,
								(SELECT t.nombre FROM tipo_de_documento t WHERE t.tipo_documento_id=f.tipo_documento_id)AS tipo_documento,
								f.concepto_abono_factura AS concepto,
								f.fecha,
								'' AS vencimiento,
								$fecha_corte
								(CASE f.estado_abono_factura WHEN 'A' THEN 'EDICION' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'ANULADA' END)AS estado,
								0 AS valor,
								r.rel_valor_descu AS abonos_desc,
								r.rel_valor_mayor AS mayor_pago,
								r.rel_valor_abono AS valor_abono
								
								FROM  abono_factura f,relacion_abono r 
								WHERE f.abono_factura_id=r.abono_factura_id AND r.factura_id=$factura_id AND f.oficina_id IN($oficina_id) $saldos";
						        
								$result_descuento = $this -> DbFetchAll($select,$Conex);
								$arrayReporte[$i]['descuento'] = $result_descuento;
					}
				}
				return $arrayReporte;
  }
  
  public function getReportePE_ALL($oficina_id,$desde,$hasta,$saldos,$Conex){  //ok
	   	
		$select = "SELECT 
		CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		IF(DATEDIFF(CURDATE(),f.vencimiento)>0,DATEDIFF(CURDATE(),f.vencimiento),DATEDIFF(CURDATE(),f.vencimiento)) AS dias,
		f.consecutivo_factura,				
		f.fecha,
		f.vencimiento,
		ROUND(f.valor) AS valor,
		(SELECT ROUND(deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
		(SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ) AS abonos,
		(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
		FROM factura f
		WHERE f.estado='C' AND f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura WHERE reporta_cartera=1 ) AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
		AND ((SELECT ROUND(SUM(deb_item_factura+cre_item_factura)) AS neto FROM detalle_factura_puc WHERE factura_id=f.factura_id AND contra_factura=1) >	
		(SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )
		OR (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ) IS NULL)
		ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC "; 

    	$results = $this -> DbFetchAll($select,$Conex);
		return $results;  
  }

  public function getReporteRP_ALL($oficina_id,$desde,$hasta,$saldos,$Conex){  //ok
	   	
		$select = "SELECT 
			r.numero_remesa AS 'No REMESA',
			(SELECT GROUP_CONCAT(m.manifiesto) FROM detalle_despacho dd, manifiesto m WHERE dd.remesa_id=r.remesa_id AND m.manifiesto_id=dd.manifiesto_id AND m.estado!='A') AS 'No. PLANILLA',
			r.fecha_remesa AS 'FECHA REMESA',
			(SELECT nombre FROM oficina WHERE oficina_id=r.oficina_id) AS OFICINA, 
			(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t  WHERE c.cliente_id=r.cliente_id AND c.tercero_id=t.tercero_id)  AS CLIENTE, 
			IF(r.paqueteo=1,'PAQUETEO','MASIVO') AS 'TIPO REMESA', 
			(CASE r.estado WHEN 'P' THEN 'PENDIENTE' WHEN 'PD' THEN 'PENDIENTE' WHEN 'PC' THEN 'PROCESANDO' WHEN 'MF' THEN 'MANIFESTADO' WHEN 'LQ' THEN 'LIQUIDADA' WHEN 'FT' THEN 'FACTURADA' WHEN 'ET' THEN 'ENTREGADA' WHEN 'AN' THEN 'ANULADA' ELSE 'PENDIENTE' END) AS ESTADO,
			IF(r.clase_remesa = 'NN','NORMAL',IF(r.clase_remesa = 'DV','DEVOLUCION',IF(r.clase_remesa = 'CP','COMPLEMENTO',IF(r.clase_remesa = 'AL','ALMACEN','SUMINISTRO')))) AS CLASE,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS ORIGEN,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS DESTINO,
			(SELECT medida FROM medida WHERE medida_id=r.medida_id) AS MEDIDA,
			r.valor_facturar AS 'A FACTURAR'
		FROM 
			remesa r
		WHERE 
			r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND 
			r.oficina_id IN($oficina_id) AND 
			r.estado NOT IN ('AN','FT') AND 
			r.clase_remesa IN ('NN','DV','CP') AND 
			r.paqueteo NOT IN(2,3)
		ORDER BY 
			cliente";	

    	$results = $this -> DbFetchAll($select,$Conex,true);
		
		return $results;
  
  }


}

?>