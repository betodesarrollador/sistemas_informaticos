<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SolicFacturasModel extends Db{

  private $Permisos;
  
  public function getSolicFacturas($proveedor_id,$Conex){
	
	if(is_numeric($proveedor_id)){		
	
		$select = "SELECT 
					f.factura_proveedor_id,
					f.valor_autorizado,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo_id,
					CASE f.fuente_servicio_cod WHEN 'OC' THEN 'Orden de Compra' WHEN 'DU' THEN 'Despacho Urbano' WHEN 'MC' THEN 'Manifiesto de Carga' ELSE (SELECT nombre_bien_servicio FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id)  END AS tipo,
					(SELECT consecutivo FROM orden_compra WHERE orden_compra_id=f.orden_compra_id) AS orden_no,
					(SELECT numero_despacho FROM liquidacion_despacho WHERE liquidacion_despacho_id=f.liquidacion_despacho_id) AS manifiesto,
					f.codfactura_proveedor,				
					f.fecha_factura_proveedor,
					f.valor_factura_proveedor,
					(SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) AS valor_neto,
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='A' )	AS abonos_nc,
					(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' )	AS abonos
				FROM factura_proveedor f
				WHERE f.proveedor_id=$proveedor_id AND f.estado_factura_proveedor='C' AND f.autoriza_pago=1
				AND ((SELECT (deb_item_factura_proveedor+cre_item_factura_proveedor) AS neto  FROM item_factura_proveedor WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
				WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' )
				OR 	(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
				WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' ) IS NULL)";
				
		  $result = $this -> DbFetchAll($select,$Conex,true); 
	  	$i=0;
	  	foreach($result as $items){
			//$saldo=floatval($items[valor_neto])-floatval($items[abonos]); 
			$saldo=intval($items[valor_neto])-intval($items[abonos]); 
			$results[$i]=array(factura_proveedor_id=>$items[factura_proveedor_id],valor_autorizado=>$items[valor_autorizado],consecutivo_id=>$items[consecutivo_id],tipo=>$items[tipo],orden_no=>$items[orden_no],manifiesto=>$items[manifiesto],codfactura_proveedor=>$items[codfactura_proveedor],fecha_factura_proveedor=>$items[fecha_factura_proveedor],valor_factura_proveedor=>$items[valor_factura_proveedor],valor_neto=>$items[valor_neto],abonos_nc=>$items[abonos_nc],abonos=>$items[abonos],saldo=>$saldo);	
			$i++;
		}
	}else{
   	    $results = array();
	 }
	
	return $results;
  }
}


?>