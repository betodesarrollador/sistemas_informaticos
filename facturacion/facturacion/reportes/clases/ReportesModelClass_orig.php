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
	$opciones=array(0 => array ( 'value' => 'FP', 'text' => 'Facturas Pendientes por Cobrar' ), 1 => array ( 'value' => 'RF', 'text' => 'Relaci&oacute;n Facturas'), 2 => array ( 'value' => 'EC', 'text' => 'Estado Cartera'), 3 => array ( 'value' => 'PE', 'text' => 'Cartera Por Edades'), 4 => array ( 'value' => 'RE', 'text' => 'Recaudos') );
	return $opciones;
   }

   public function GetSi_Pro($Conex){
	$opciones=array(0 => array ( 'value' => '1', 'text' => 'UNO' ), 1 => array ( 'value' => 'ALL', 'text' => 'TODOS') );
	return $opciones;
   }

  public function getReporteFP1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$Conex){  //ok
	   	
		$select = "SELECT 
		  (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS cliente_nombre 
		  FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre,
		  CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		  (SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		  f.consecutivo_factura, f.fecha, f.radicacion AS fecha_radicacion, f.vencimiento,
		  DATEDIFF(CURDATE(),f.vencimiento) AS dias,
		  ROUND(f.valor,0) AS valor,
		  (SELECT ROUND((deb_item_factura+cre_item_factura)) AS neto  FROM detalle_factura_puc WHERE factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
		  (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ) AS abonos,

		   ((SELECT ROUND(deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1)-
			IF((SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
			WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )>0,
			   (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
			WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ),0)) AS saldo,
			(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS comercial FROM tercero t, comercial co, cliente c WHERE f.cliente_id=c.cliente_id AND c.comercial_id=co.comercial_id AND co.tercero_id=t.tercero_id) AS comercial

		  
		  FROM factura f
		  WHERE f.cliente_id=$cliente_id AND f.estado='C' AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
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
		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre,		

		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM cliente c, tercero t, comercial co  WHERE c.cliente_id=f.cliente_id AND c.comercial_id=co.comercial_id AND co.tercero_id=t.tercero_id)  AS comercial,	
		
		CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		(SELECT d.codigo_centro_costo FROM detalle_factura_puc d WHERE d.factura_id=f.factura_id AND d.codigo_centro_costo IS NOT NULL LIMIT 0,1) AS centro,
		f.consecutivo_factura,
		f.fecha, f.radicacion AS fecha_radicacion,
		f.vencimiento,
		ROUND(f.valor) AS valor,
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
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ),0)) AS saldo
		
		FROM factura f
		WHERE f.cliente_id=$cliente_id AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
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
					(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)) AS usuario FROM tercero t, usuario u, abono_factura ab, relacion_abono ra 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND ab.usuario_id=u.usuario_id AND u.tercero_id=t.tercero_id) AS usuario,

					
					(SELECT (deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
					(SELECT SUM(ra.rel_valor_abono) AS abonos FROM  relacion_abono ra, abono_factura ab 
					WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre,
					(SELECT t.numero_identificacion AS cliente_id FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_ident					
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
				tipo=>$items[tipo],fecha=>$items[fecha],vencimiento=>$items[vencimiento],/*centro=>$items[centro],*/
				valor=>$items[valor],/*valor_neto=>$items[valor_neto],abonos=>$items[abonos],*/
				relacion_pago=>$items[relacion_pago],fecha_relacion_pago=>$items[fecha_relacion_pago],valor_relacion_pago=>$items[valor_relacion_pago],saldo=>$saldo,dias_diferencia_pago=>$items[dias_diferencia_pago],comercial=>$items[comercial],usuario=>$items[usuario]);
			$i++;
		}

		return $result;
  
  }

  public function getReporteEC1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$Conex){
	   	
	$select  = "SELECT * FROM factura_proveedor f WHERE f.factura_proveedor_id=$factura_proveedor_id AND i.orden_compra_id=f.orden_compra_id";
	$result  = $this -> DbFetchAll($select,$Conex);
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
		  WHERE f.cliente_id=$cliente_id AND f.estado='C' AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
		  AND ((SELECT ROUND(deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) >
		 (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )
		  OR (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ) IS NULL)
		  ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC"; 

    	$results = $this -> DbFetchAll($select,$Conex);
		return $results;
  
  }
  public function getReporteFP_ALL($oficina_id,$desde,$hasta,$saldos,$Conex){ //ok 
	   	
		$select = "SELECT 
					(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre,		
					CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					f.consecutivo_factura,				
					f.fecha, f.radicacion AS fecha_radicacion, 
					f.vencimiento,
					DATEDIFF(CURDATE(),f.vencimiento) AS dias,
					ROUND(f.valor) AS valor,
					(SELECT ROUND(deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
					(SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
					WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ) AS abonos,
					
				   ((SELECT ROUND(deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1)-
					IF((SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
					WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )>0,
					   (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
					WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ),0)) AS saldo,
   					(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS comercial FROM tercero t, comercial co, cliente c WHERE f.cliente_id=c.cliente_id AND c.comercial_id=co.comercial_id AND co.tercero_id=t.tercero_id) AS comercial

				FROM factura f
				WHERE  f.estado='C' AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
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
		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre,

		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM cliente c, tercero t, comercial co  WHERE c.cliente_id=f.cliente_id AND c.comercial_id=co.comercial_id AND co.tercero_id=t.tercero_id)  AS comercial,	
		
		CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		(SELECT d.codigo_centro_costo FROM   detalle_factura_puc d WHERE d.factura_id=f.factura_id AND d.codigo_centro_costo IS NOT NULL LIMIT 0,1) AS centro,
		f.consecutivo_factura,
		f.fecha, f.radicacion AS fecha_radicacion,
		f.vencimiento,
		ROUND(f.valor) AS valor,
		CASE f.estado WHEN 'I' THEN 'ANULADA' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'EDICION' END AS estado,
		
	    (SELECT nombre FROM forma_compra_venta WHERE forma_compra_venta_id=f.forma_compra_venta_id ) AS forma_venta,
	    (SELECT nombre_bien_servicio_factura FROM tipo_bien_servicio_factura WHERE tipo_bien_servicio_factura_id=f.tipo_bien_servicio_factura_id ) AS tipo_servicio,
		f.observacion AS concepto,

		(SELECT ROUND(deb_item_factura+cre_item_factura) AS neto FROM detalle_factura_puc WHERE factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
		(SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM relacion_abono ra, abono_factura ab 
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,

	   ((SELECT ROUND(deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1)-
		IF((SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )>0,
		   (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ),0)) AS saldo

		FROM factura f
		WHERE  f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
		ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC ";  

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
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre,
					(SELECT t.numero_identificacion AS cliente_id FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_ident					
				FROM factura f
				WHERE   f.fecha BETWEEN '$desde' AND '$hasta' AND f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura WHERE reporta_cartera=1 ) AND f.oficina_id IN ($oficina_id)
				AND f.factura_id IN ( SELECT ra.factura_id FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id )
				ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC "; */
				
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
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre,
					(SELECT t.numero_identificacion AS cliente_id FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_ident					
				FROM factura f
				WHERE   f.fecha BETWEEN '$desde' AND '$hasta' AND f.tipo_bien_servicio_factura_id  IN (SELECT tipo_bien_servicio_factura_id FROM tipo_bien_servicio_factura WHERE reporta_cartera=1 ) AND f.oficina_id IN ($oficina_id)
				AND f.factura_id IN ( SELECT ra.factura_id FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er 
					 WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id )
				ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC "; 
    	$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){

			$saldo=floatval($items[valor_neto])-floatval($items[abonos]); 
			$result[$i]=array(consecutivo_factura=>$items[consecutivo_factura],cliente_ident=>$items[cliente_ident],cliente_nombre=>$items[cliente_nombre],oficina=>$items[oficina],estado=>$items[estados],
				tipo=>$items[tipo],fecha=>$items[fecha],vencimiento=>$items[vencimiento],/*centro=>$items[centro],*/
				valor=>$items[valor],/*valor_neto=>$items[valor_neto],abonos=>$items[abonos],*/
				relacion_pago=>$items[relacion_pago],fecha_relacion_pago=>$items[fecha_relacion_pago],valor_relacion_pago=>$items[valor_relacion_pago],saldo=>$saldo,dias_diferencia_pago=>$items[dias_diferencia_pago],
				comercial=>$items[comercial],usuario=>$items[usuario]);	
			$i++;
		}

		return $result;
  
  }


  public function getReporteEC_ALL($oficina_id,$desde,$hasta,$saldos,$Conex){ ///haciendo
	   	
		  $select = "SELECT 
		  CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		  (SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		  IF(DATEDIFF(CURDATE(),f.vencimiento)>0,DATEDIFF(CURDATE(),f.vencimiento),0) AS dias,
		  f.consecutivo_factura,				
		  f.fecha,
		  f.vencimiento,
		  ROUND(f.valor) AS valor,
		  (SELECT ROUND(deb_item_factura+cre_item_factura) AS neto FROM detalle_factura_puc WHERE factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
		  (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos) AS abonos,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
		  FROM factura f
		  WHERE  f.estado='C' AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
		  AND ((SELECT ROUND(deb_item_factura+cre_item_factura) AS neto FROM detalle_factura_puc WHERE factura_id=f.factura_id AND contra_factura=1) >
		  (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM relacion_abono ra, abono_factura ab 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )
		  OR  (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ) IS NULL)
		  ORDER BY f.cliente_id ASC, f.oficina_id ASC";

    	$results = $this -> DbFetchAll($select,$Conex);
		return $results;  
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
		WHERE f.estado='C' AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
		AND ((SELECT ROUND(SUM(deb_item_factura+cre_item_factura)) AS neto FROM detalle_factura_puc WHERE factura_id=f.factura_id AND contra_factura=1) >	
		(SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )
		OR (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab 
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ) IS NULL)
		ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC "; 

    	$results = $this -> DbFetchAll($select,$Conex);
		return $results;  
  }

}

?>