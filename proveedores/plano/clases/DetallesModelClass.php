<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesModel extends Db{

  private $Permisos;
  
  public function deleteFactura($Campos,$Conex){  
	  
    $this -> Begin($Conex);
   
  	$detalle_despacho_id = $this -> requestDataForQuery('detalle_despacho_id','integer');     
	
	$update = "UPDATE remesa SET estado = 'PD' WHERE remesa_id = (SELECT remesa_id FROM detalle_despacho WHERE detalle_despacho_id 
	=  $detalle_despacho_id)";
	
	$result = $this -> query($update,$Conex,true);	
	
	$delete = "DELETE FROM detalle_despacho WHERE detalle_despacho_id = $detalle_despacho_id";
	
	$result = $this -> query($delete,$Conex,true);	
	
	$this -> Commit($Conex);
	  
  }
  
  public function getReporteFP_ALL($desde,$hasta,$Conex){

		
			$dias="DATEDIFF('$hasta',f.vence_factura_proveedor) AS dias,";		
		
		$select = "SELECT 
					f.factura_proveedor_id,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo_id,
					CASE f.fuente_servicio_cod WHEN 'OC' THEN 'Orden de Compra' WHEN 'DU' THEN 'Despacho Urbano' WHEN 'MC' THEN 'Manifiesto de Carga' ELSE (SELECT nombre_bien_servicio FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id)  END AS tipo,
					(SELECT consecutivo FROM orden_compra WHERE orden_compra_id=f.orden_compra_id) AS orden_no,
					(SELECT consecutivo FROM liquidacion_reexpedido WHERE liquidacion_reexpedido_id=f.liquidacion_reexpedido_id) AS reexpedido,
					(SELECT numero_despacho FROM liquidacion_despacho WHERE liquidacion_despacho_id=f.liquidacion_despacho_id) AS manifiesto,
					IF(f.fuente_servicio_cod='MC',
						(SELECT fecha_mc FROM manifiesto WHERE manifiesto_id = (SELECT manifiesto_id FROM liquidacion_despacho WHERE liquidacion_despacho_id=f.liquidacion_despacho_id)),
						IF(f.fuente_servicio_cod='DU',
							(SELECT fecha_du FROM despachos_urbanos WHERE despachos_urbanos_id = (SELECT despachos_urbanos_id FROM liquidacion_despacho WHERE liquidacion_despacho_id=f.liquidacion_despacho_id)),
							IF(f.fuente_servicio_cod='OC',
								(SELECT fecha_orden_compra FROM orden_compra WHERE f.orden_compra_id=orden_compra_id),
								IF(f.fuente_servicio_cod='RE',
									(SELECT fecha_rxp FROM reexpedido WHERE reexpedido_id = (SELECT reexpedido_id FROM liquidacion_reexpedido WHERE liquidacion_reexpedido_id=f.liquidacion_reexpedido_id)),'')))) AS fecha_documento,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					$dias
					f.codfactura_proveedor,				
					f.fecha_factura_proveedor,
					f.proveedor_id,
					f.vence_factura_proveedor,
					f.valor_factura_proveedor,
					(SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) AS valor_neto,
					(SELECT SUM(ia.deb_item_abono_factura) AS abonos FROM item_abono_factura ia, relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' AND ia.relacion_abono_factura_id=ra.relacion_abono_factura_id  )	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS proveedor_nombre FROM proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor_nombre
				FROM factura_proveedor f
				WHERE f.estado_factura_proveedor='C' AND f.fecha_factura_proveedor BETWEEN '$desde' AND '$hasta'
				
				
				AND ((SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ia.deb_item_abono_factura) AS abonos FROM item_abono_factura ia, relacion_abono_factura ra, abono_factura_proveedor ab 
				WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' AND ia.relacion_abono_factura_id=ra.relacion_abono_factura_id  )
				OR 	(SELECT SUM(ia.deb_item_abono_factura) AS abonos FROM item_abono_factura ia, relacion_abono_factura ra, abono_factura_proveedor ab 
				WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' AND ia.relacion_abono_factura_id=ra.relacion_abono_factura_id  ) IS NULL)
				ORDER BY f.proveedor_id ASC, f.oficina_id ASC, consecutivo_id ASC";  
    	$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
			$saldo=intval($items[valor_neto])-intval($items[abonos]); 
			$result[$i]=array(factura_proveedor_id=>$items[factura_proveedor_id],consecutivo_id=>$items[consecutivo_id],tipo=>$items[tipo],orden_no=>$items[orden_no],reexpedido=>$items[reexpedido],manifiesto=>$items[manifiesto],fecha_documento=>$items[fecha_documento],codfactura_proveedor=>$items[codfactura_proveedor],fecha_factura_proveedor=>$items[fecha_factura_proveedor],vence_factura_proveedor=>$items[vence_factura_proveedor],dias=>$items[dias],oficina=>$items[oficina],proveedor_nombre=>$items[proveedor_nombre],valor_factura_proveedor=>$items[valor_factura_proveedor],valor_neto=>$items[valor_neto],abonos=>$items[abonos],saldo=>$saldo);	
			$i++;
		}

		return $result;
  
  }

  
  
}



?>