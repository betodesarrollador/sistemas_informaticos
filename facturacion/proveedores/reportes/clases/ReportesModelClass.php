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
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex,true);
  }
  
   public function GetOficina($Conex){
	return $this -> DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina",$Conex,
	$ErrDb = false);
   }
   
   public function GetCuenta($Conex){
	return $this -> DbFetchAll("SELECT CONCAT_WS('-',c.puc_id,(SELECT p.nombre FROM puc p WHERE p.puc_id = c.puc_id)) AS text, c.puc_id AS value FROM codpuc_bien_servicio c WHERE c.contra_bien_servicio='1' GROUP BY c.puc_id",$Conex,
	$ErrDb = false);
   }

   public function GetDoc($Conex){
	return $this -> DbFetchAll("SELECT nombre AS text, tipo_documento_id AS value FROM tipo_de_documento WHERE tipo_documento_id IS NOT NULL",$Conex,
	$ErrDb = false);
   }

   public function GetTipo($Conex){
	$opciones=array(0 => array ( 'value' => 'FP', 'text' => 'Facturas Pendientes' ),1 => array ( 'value' => 'RF', 'text' => 'Relacion Facturas' ), 2 => array ( 'value' => 'EC', 'text' => 'Estado Cartera'),
					3 => array ( 'value' => 'PE', 'text' => 'Cartera Por Edades') ,4 => array ( 'value' => 'RC', 'text' => 'Relacion Causaciones'),5 => array ( 'value' => 'SP', 'text' => 'Solicitudes Pendientes'),6 => array ( 'value' => 'RS', 'text' => 'Relacion Solicitudes'));
	return $opciones;
   }

   public function GetSi_Pro($Conex){
	$opciones=array(0 => array ( 'value' => '1', 'text' => 'UNO' ), 1 => array ( 'value' => 'ALL', 'text' => 'TODOS') );
	return $opciones;
   }

  public function getReporteFP1($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$proveedor_id,$saldos,$Conex){

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
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f
				WHERE f.proveedor_id=$proveedor_id AND f.estado_factura_proveedor='C' AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				AND ((SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)
				OR 	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos) IS NULL) $puc_id $tipo_documento_id
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC "; 
				//echo $select;
				
    	$results = $this -> DbFetchAll($select,$Conex,true);

		return $results;
  
  }

  public function getReporteRF1($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$proveedor_id,$saldos,$Conex){  //cambiar por tablas factura_proveedor

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
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f
				WHERE f.proveedor_id=$proveedor_id AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC, f.codfactura_proveedor ASC "; 
		//echo $select;
    	$results = $this -> DbFetchAll($select,$Conex,true);

		return $results;
  
  }

  public function getReporteEC1($oficina_id,$desde,$hasta,$proveedor_id,$saldos,$consulta,$Conex){
	   
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
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
			FROM factura_proveedor f
			WHERE f.proveedor_id=$proveedor_id AND  f.estado_factura_proveedor='C' AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				AND ((SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)
				OR 	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos) IS NULL)
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC ";
		//echo $select;
    	$results = $this -> DbFetchAll($select,$Conex,true);
		return $results;
  
  }
  
    public function getReporteRC1($oficina_id,$desde,$hasta,$proveedor_id,$saldos,$Conex){  //cambiar por tablas factura_proveedor

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
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f
				WHERE f.proveedor_id=$proveedor_id AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC, f.codfactura_proveedor ASC "; 
		
    	$results = $this -> DbFetchAll($select,$Conex,true);

		return $results;
  
  }
  
  //*************REPORTES SOLICITUDES DE SERVICIO****************//	

  public function getReporteSP1($oficina_id,$desde,$hasta,$proveedor_id,$Conex){

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
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f
				WHERE f.proveedor_id=$proveedor_id AND f.estado_factura_proveedor='C' AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				AND ((SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)
				OR 	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos) IS NULL) $puc_id $tipo_documento_id
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC "; 
				//echo $select;
				
    	$results = $this -> DbFetchAll($select,$Conex,true);

		return $results;
  
  }
  
  public function getReporteRS1($oficina_id,$desde,$hasta,$proveedor_id,$Conex){

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
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f
				WHERE f.proveedor_id=$proveedor_id AND f.estado_factura_proveedor='C' AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				AND ((SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)
				OR 	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos) IS NULL) $puc_id $tipo_documento_id
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC "; 
				//echo $select;
				
    	$results = $this -> DbFetchAll($select,$Conex,true);

		return $results;
  
  }
  
   public function getReporteSP_ALL($oficina_id,$desde,$hasta,$Conex){

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
					
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f
				WHERE f.estado_factura_proveedor='C' AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				AND ((SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)
				OR 	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos) IS NULL ) 
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC ";//echo $select;
    	$results = $this -> DbFetchAll($select,$Conex,true);
		return $results;
  
  }
	
   public function getReporteRS_ALL($oficina_id,$desde,$hasta,$Conex){

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
					
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f
				WHERE f.estado_factura_proveedor='C' AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				AND ((SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)
				OR 	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos) IS NULL ) 
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC ";//echo $select;
    	$results = $this -> DbFetchAll($select,$Conex,true);
		return $results;
  
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
					
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f
				WHERE f.estado_factura_proveedor='C' AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				AND ((SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)
				OR 	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos) IS NULL ) 
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC ";//echo $select;
    	$results = $this -> DbFetchAll($select,$Conex,true);
		return $results;
  
  }

  public function getReporteRF_ALL($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$saldos,$Conex){  //ok

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
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f
				WHERE  f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id) $puc_id $tipo_documento_id
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC, f.codfactura_proveedor ASC "; 
		//echo $select;
    	$results = $this -> DbFetchAll($select,$Conex,true);

		return $results;
  
  }

   public function getReporteEC_ALL($oficina_id,$desde,$hasta,$saldos,$consulta,$Conex){

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
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
			FROM factura_proveedor f
			WHERE  f.estado_factura_proveedor='C' AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				AND ((SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)
				OR 	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos) IS NULL)
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC ";
		//echo $select;
    	$results = $this -> DbFetchAll($select,$Conex,true);

		return $results;
  
  }
  
  public function getReporteRC_ALL($oficina_id,$desde,$hasta,$saldos,$Conex){  //ok

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
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f
				WHERE  f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id) 
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC, f.codfactura_proveedor ASC "; 
		//echo $select;
    	$results = $this -> DbFetchAll($select,$Conex,true);

		return $results;
  
  }
  

}

?>