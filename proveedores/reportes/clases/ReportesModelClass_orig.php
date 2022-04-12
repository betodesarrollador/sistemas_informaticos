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
	$opciones=array(0 => array ( 'value' => 'FP', 'text' => 'Facturas Pendientes' ),1 => array ( 'value' => 'RF', 'text' => 'Relacion Facturas' ), 2 => array ( 'value' => 'EC', 'text' => 'Estado Cartera'), 3 => array ( 'value' => 'PE', 'text' => 'Cartera Por Edades') );
	return $opciones;
   }

   public function GetSi_Pro($Conex){
	$opciones=array(0 => array ( 'value' => '1', 'text' => 'UNO' ), 1 => array ( 'value' => 'ALL', 'text' => 'TODOS') );
	return $opciones;
   }

  public function getReporteFP1($oficina_id,$desde,$hasta,$proveedor_id,$saldos,$Conex){

		if($saldos!=''){
			$dias="DATEDIFF('$hasta',f.vence_factura_proveedor) AS dias,";		
		}else{
			$dias="DATEDIFF(CURDATE(),f.vence_factura_proveedor) AS dias,";
		}

	   	
		$select = "SELECT 
					f.factura_proveedor_id,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo_id,
					CASE f.fuente_servicio_cod WHEN 'OC' THEN 'Orden de Compra' WHEN 'DU' THEN 'Despacho Urbano' WHEN 'MC' THEN 'Manifiesto de Carga' ELSE (SELECT nombre_bien_servicio FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id)  END AS tipo,
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
					(SELECT SUM(ia.deb_item_abono_factura) AS abonos FROM item_abono_factura ia, relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' AND ia.relacion_abono_factura_id=ra.relacion_abono_factura_id $saldos)	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f
				WHERE f.proveedor_id=$proveedor_id AND f.estado_factura_proveedor='C' AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				AND ((SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ia.deb_item_abono_factura) AS abonos FROM item_abono_factura ia, relacion_abono_factura ra, abono_factura_proveedor ab 
				WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' AND ia.relacion_abono_factura_id=ra.relacion_abono_factura_id $saldos)
				OR 	(SELECT SUM(ia.deb_item_abono_factura) AS abonos FROM item_abono_factura ia, relacion_abono_factura ra, abono_factura_proveedor ab 
				WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' AND ia.relacion_abono_factura_id=ra.relacion_abono_factura_id $saldos) IS NULL)
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC ";
    	$results = $this -> DbFetchAll($select,$Conex);

		return $results;
  
  }

  public function getReporteRF1($oficina_id,$desde,$hasta,$proveedor_id,$saldos,$Conex){  //cambiar por tablas factura_proveedor

		if($saldos!=''){
			$dias="DATEDIFF('$hasta',f.vence_factura_proveedor) AS dias,";		
		}else{
			$dias="DATEDIFF(CURDATE(),f.vence_factura_proveedor) AS dias,";
		}

	   	
		$select = "SELECT 
					f.factura_proveedor_id,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo_id,
					CASE f.fuente_servicio_cod WHEN 'OC' THEN 'Orden de Compra' WHEN 'DU' THEN 'Despacho Urbano' WHEN 'MC' THEN 'Manifiesto de Carga' ELSE (SELECT nombre_bien_servicio FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id)  END AS tipo,
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
					(SELECT SUM(ia.deb_item_abono_factura) AS abonos FROM item_abono_factura ia, relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' AND ia.relacion_abono_factura_id=ra.relacion_abono_factura_id $saldos)	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f
				WHERE f.proveedor_id=$proveedor_id AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC, f.codfactura_proveedor ASC "; 

    	$results = $this -> DbFetchAll($select,$Conex);

		return $results;
  
  }

  public function getReporteEC1($oficina_id,$desde,$hasta,$proveedor_id,$saldos,$Conex){
	   	
	$select  = "SELECT *  FROM  factura_proveedor f WHERE f.factura_proveedor_id=$factura_proveedor_id AND i.orden_compra_id=f.orden_compra_id";
	$result  = $this -> DbFetchAll($select,$Conex);

	return $result;
  
  }
  public function getReportePE1($oficina_id,$desde,$hasta,$proveedor_id,$saldos,$Conex){

	if($saldos!=''){
		$dias="DATEDIFF('$hasta',f.vence_factura_proveedor) AS dias,";		
	}else{
		$dias="DATEDIFF(CURDATE(),f.vence_factura_proveedor) AS dias,";
	}


	$select = "SELECT 
					f.factura_proveedor_id,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo_id,
					CASE f.fuente_servicio_cod WHEN 'OC' THEN 'Orden de Compra' WHEN 'DU' THEN 'Despacho Urbano' WHEN 'MC' THEN 'Manifiesto de Carga' ELSE (SELECT nombre_bien_servicio FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id)  END AS tipo,
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
					(SELECT SUM(ia.deb_item_abono_factura) AS abonos FROM item_abono_factura ia, relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' AND ia.relacion_abono_factura_id=ra.relacion_abono_factura_id $saldos)	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
			FROM factura_proveedor f
			WHERE f.proveedor_id=$proveedor_id AND  f.estado_factura_proveedor='C' AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				AND ((SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ia.deb_item_abono_factura) AS abonos FROM item_abono_factura ia, relacion_abono_factura ra, abono_factura_proveedor ab 
				WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' AND ia.relacion_abono_factura_id=ra.relacion_abono_factura_id $saldos)
				OR 	(SELECT SUM(ia.deb_item_abono_factura) AS abonos FROM item_abono_factura ia, relacion_abono_factura ra, abono_factura_proveedor ab 
				WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' AND ia.relacion_abono_factura_id=ra.relacion_abono_factura_id $saldos) IS NULL)
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC ";

    	$results = $this -> DbFetchAll($select,$Conex);

		return $results;
  
  }
  public function getReporteFP_ALL($oficina_id,$desde,$hasta,$saldos,$Conex){

		if($saldos!=''){
			$dias="DATEDIFF('$hasta',f.vence_factura_proveedor) AS dias,";		
		}else{
			$dias="DATEDIFF(CURDATE(),f.vence_factura_proveedor) AS dias,";
		}

	   	
		$select = "SELECT 
					f.factura_proveedor_id,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo_id,
					CASE f.fuente_servicio_cod WHEN 'OC' THEN 'Orden de Compra' WHEN 'DU' THEN 'Despacho Urbano' WHEN 'MC' THEN 'Manifiesto de Carga' ELSE (SELECT nombre_bien_servicio FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id)  END AS tipo,
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
					(SELECT SUM(ia.deb_item_abono_factura) AS abonos FROM item_abono_factura ia, relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' AND ia.relacion_abono_factura_id=ra.relacion_abono_factura_id $saldos)	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f
				WHERE f.estado_factura_proveedor='C' AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				AND ((SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ia.deb_item_abono_factura) AS abonos FROM item_abono_factura ia, relacion_abono_factura ra, abono_factura_proveedor ab 
				WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' AND ia.relacion_abono_factura_id=ra.relacion_abono_factura_id $saldos)
				OR 	(SELECT SUM(ia.deb_item_abono_factura) AS abonos FROM item_abono_factura ia, relacion_abono_factura ra, abono_factura_proveedor ab 
				WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' AND ia.relacion_abono_factura_id=ra.relacion_abono_factura_id $saldos) IS NULL)
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC ";
    	$results = $this -> DbFetchAll($select,$Conex);

		return $results;
  
  }

  public function getReporteRF_ALL($oficina_id,$desde,$hasta,$saldos,$Conex){  //ok

		if($saldos!=''){
			$dias="DATEDIFF('$hasta',f.vence_factura_proveedor) AS dias,";		
		}else{
			$dias="DATEDIFF(CURDATE(),f.vence_factura_proveedor) AS dias,";
		}

	   	
		$select = "SELECT 
					f.factura_proveedor_id,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo_id,
					CASE f.fuente_servicio_cod WHEN 'OC' THEN 'Orden de Compra' WHEN 'DU' THEN 'Despacho Urbano' WHEN 'MC' THEN 'Manifiesto de Carga' ELSE (SELECT nombre_bien_servicio FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id)  END AS tipo,
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
					(SELECT SUM(ia.deb_item_abono_factura) AS abonos FROM item_abono_factura ia, relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos AND ia.relacion_abono_factura_id=ra.relacion_abono_factura_id )	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f
				WHERE  f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC, f.codfactura_proveedor ASC "; 

    	$results = $this -> DbFetchAll($select,$Conex);

		return $results;
  
  }

  public function getReporteEC_ALL($oficina_id,$desde,$hasta,$saldos,$Conex){
	   	
	$select  = "SELECT *  FROM  factura_proveedor f WHERE f.factura_proveedor_id=$factura_proveedor_id AND i.orden_compra_id=f.orden_compra_id";
	$result  = $this -> DbFetchAll($select,$Conex);

	return $result;
  
  }
  public function getReportePE_ALL($oficina_id,$desde,$hasta,$saldos,$Conex){

	if($saldos!=''){
		$dias="DATEDIFF('$hasta',f.vence_factura_proveedor) AS dias,";		
	}else{
		$dias="DATEDIFF(CURDATE(),f.vence_factura_proveedor) AS dias,";
	}


	$select = "SELECT 
					f.factura_proveedor_id,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo_id,
					CASE f.fuente_servicio_cod WHEN 'OC' THEN 'Orden de Compra' WHEN 'DU' THEN 'Despacho Urbano' WHEN 'MC' THEN 'Manifiesto de Carga' ELSE (SELECT nombre_bien_servicio FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id)  END AS tipo,
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
					(SELECT SUM(ia.deb_item_abono_factura) AS abonos FROM item_abono_factura ia, relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' AND ia.relacion_abono_factura_id=ra.relacion_abono_factura_id $saldos)	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
			FROM factura_proveedor f
			WHERE  f.estado_factura_proveedor='C' AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				AND ((SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ia.deb_item_abono_factura) AS abonos FROM item_abono_factura ia, relacion_abono_factura ra, abono_factura_proveedor ab 
				WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' AND ia.relacion_abono_factura_id=ra.relacion_abono_factura_id $saldos)
				OR 	(SELECT SUM(ia.deb_item_abono_factura) AS abonos FROM item_abono_factura ia, relacion_abono_factura ra, abono_factura_proveedor ab 
				WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' AND ia.relacion_abono_factura_id=ra.relacion_abono_factura_id $saldos) IS NULL)
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC ";

    	$results = $this -> DbFetchAll($select,$Conex);

		return $results;
  
  }

}

?>